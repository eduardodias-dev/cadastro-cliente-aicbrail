<?php

namespace App\Http\Controllers;

use Exception;
use App\Assinatura;
use \Mpdf\Mpdf as PDF;
use Illuminate\Http\Request;
use App\Mail\EnvioEmailApolice;
use App\FilaConfirmacaoAssinatura;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Services\Integration\IClientSenderIntegrationService;

class JobsController extends Controller
{
    //
    private $clientIntegrationService = null;
    function __construct(IClientSenderIntegrationService $iClientIntegrationService)
    {
        $this->clientIntegrationService = $iClientIntegrationService;
    }

    public function verificarFilaAssinaturas(Request $request){
        $filas = FilaConfirmacaoAssinatura::where(['finalizado' => 0])->get();

        foreach($filas as $fila){
            $assinatura = Assinatura::find($fila->id_assinatura);

            $response = $this->clientIntegrationService->getClientSubscriptions(0, 100, ['myIds' => $assinatura->id]);
            if($response->successful() == false || count($response->json()['Subscriptions']) <= 0){
                throw new Exception("Não foi possível recuperar a assinatura. \n".json_encode($response->error()));
            }

            foreach($response->json() as $subscription){
                if($subscription['status'] == 'active'){
                    $transactionsResponse = $this->clientIntegrationService->getSubscriptionTransactions(0, 1, ['subscriptionGalaxPayIds' => $subscription['galaxPayId']]);
                    if($transactionsResponse->successful() == false || count($transactionsResponse->json()['Transactions']) <= 0){
                        throw new Exception("Não foi possível recuperar a assinatura. \n".json_encode($transactionsResponse->error()));
                    }
                    $transaction = $transactionsResponse->json()[0];

                    if($transaction["status"] == "authorized" ||
                        $transaction["status"] == "payedBoleto" ||
                        $transaction["status"] == "payedPix")
                    {
                        $this->confirmarAssinatura($assinatura->codigo_assinatura);
                    }
                }
            }

            $fila->finalizado = 1;
            $fila->save();
        }

        return 'Executado com sucesso: '.count($filas).' processadas';
    }

    private function confirmarAssinatura($codigoAssinatura)
    {
        $assinaturas = DB::select('SELECT * from v_assinaturas_detalhe where codigo_assinatura = ?', [$codigoAssinatura]);
        if(count($assinaturas) > 0){
            $assinatura_detalhe = $assinaturas[0];
            $assinatura = Assinatura::find($assinatura_detalhe->id_assinatura);

            $assinatura->status = "ativa";

            $assinatura->save();
            $this->enviarEmailBemvindo($codigoAssinatura, $assinatura_detalhe->emails, 1);
        }
    }

    private function enviarEmailBemvindo($ordercode, $emailCliente, $enviarApolice = 0){

        $assinatura = DB::select('SELECT * from v_assinaturas_detalhe where codigo_assinatura = ?', [$ordercode]);
        if(count($assinatura) > 0)
            $assinatura = $assinatura[0];

        $adicionais = DB::select('SELECT * FROM v_adicionais_assinatura WHERE codigo_assinatura = ?', [$ordercode]);

        $filename = $this->gerarApolice($ordercode, $assinatura, $adicionais);

        Mail::to($emailCliente)
             ->send(new EnvioEmailApolice($assinatura, storage_path('app\public\\'.$filename), $adicionais, $enviarApolice));

        return 1;
    }

    private function gerarApolice($ordercode, $assinatura, $adicionais){
        $filename = 'apolice_'.$ordercode.'.pdf';
        $mpdf = new PDF();

        $pathfile = storage_path('app\public\capa_apolice.pdf');
        $mpdf->SetSourceFile($pathfile);
        $tplId = $mpdf->ImportPage(1);
        $mpdf->useTemplate($tplId);

        // Do not add page until page template set, as it is inserted at the start of each page
        $pathfile = storage_path('app\public\template_apolice.pdf');
        $mpdf->SetSourceFile($pathfile);
        $tplId = $mpdf->ImportPage(1);
        $mpdf->SetPageTemplate($tplId);
        $mpdf->AddPage('P','','','','','','','25');

        $html = view('templates.apolice', ['assinatura' => $assinatura, 'adicionais' => $adicionais])->render();

        $mpdf->WriteHTML(strtoupper($html));
        Storage::disk('public')->put($filename, $mpdf->Output($filename, 'S'));

        return $filename;
    }
}
