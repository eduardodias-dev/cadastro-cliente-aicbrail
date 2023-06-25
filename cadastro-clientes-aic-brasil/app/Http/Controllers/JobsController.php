<?php

namespace App\Http\Controllers;

use Exception;
use App\Pacote;
use App\Assinatura;
use \Mpdf\Mpdf as PDF;
use Illuminate\Http\Request;
use App\FilaConfirmacaoPacote;
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
        $filas = FilaConfirmacaoPacote::where(['finalizado' => 0])->get();

        foreach($filas as $fila){
            $pacote = Pacote::find($fila->id_pacote);

            $response = $this->clientIntegrationService->getClientSubscriptions(0, 100, ['myIds' => $pacote->codigo_assinatura]);
            if($response->successful() == false || count($response->json()['Subscriptions']) <= 0){
                die(print_r($response->json()));
                throw new Exception("Não foi possível recuperar o pacote. \n".json_encode($response->error()));
            }
            $subs = $response->json();
            //die(print_r($subs['Subscriptions']));
            foreach($subs['Subscriptions'] as $subscription){
                $transaction = $subscription['Transactions'][0];
                if($transaction["status"] == "authorized" ||
                    $transaction["status"] == "payedBoleto" ||
                    $transaction["status"] == "payedPix")
                {
                    $this->confirmarAssinatura($pacote->codigo_assinatura);

                    $fila->finalizado = 1;
                }
                print "Assinatura processada: ".$pacote->codigo;

            }

            $fila->save();
        }

        return '<br>Executado com sucesso: '.count($filas).' processadas';
    }

    private function confirmarAssinatura($codigoPacote)
    {
        $assinaturas = DB::select('SELECT * from v_assinaturas_detalhe where codigo_pacote = ?', [$codigoPacote]);
        if(count($assinaturas) > 0){
            $assinatura_detalhe = $assinaturas[0];
            $assinatura = Assinatura::find($assinatura_detalhe->id_assinatura);

            $assinatura->status = "ativa";

            $assinatura->save();
            $this->enviarEmailBemvindo($codigoPacote, $assinatura_detalhe->emails, 1);
        }
    }

    private function enviarEmailBemvindo($ordercode, $emailCliente, $enviarApolice = 0){

        $assinatura = DB::select('SELECT * from v_assinaturas_detalhe where codigo_assinatura = ?', [$ordercode]);
        if(count($assinatura) > 0)
            $assinatura = $assinatura[0];

        $adicionais = DB::select('SELECT * FROM v_adicionais_assinatura WHERE codigo_assinatura = ?', [$ordercode]);

        $filename = $this->gerarApolice($ordercode, $assinatura, $adicionais);

        Mail::to($emailCliente)
             ->send(new EnvioEmailApolice($assinatura, storage_path('app/public/'.$filename), $adicionais, $enviarApolice));

        return 1;
    }

    private function gerarApolice($ordercode, $assinaturas, $adicionais = null ){
        $filename = 'apolice_'.$ordercode.'.pdf';
        $mpdf = new PDF();
        $pathfile = storage_path(getFilePathByArray(['app','public','capa_apolice.pdf']));

        $mpdf->SetSourceFile($pathfile);
        $tplId = $mpdf->ImportPage(1);
        $mpdf->useTemplate($tplId);

        foreach($assinaturas as $assinatura){
            // Do not add page until page template set, as it is inserted at the start of each page
            $adicionais = DB::select('SELECT * FROM v_adicionais_assinatura WHERE codigo_assinatura = ?', [$assinatura->codigo_assinatura]);

            $pathfile = storage_path(getFilePathByArray(['app','public','template_apolice.pdf']));
            $mpdf->SetSourceFile($pathfile);
            $tplId = $mpdf->ImportPage(1);
            $mpdf->SetPageTemplate($tplId);
            $mpdf->AddPage('P','','','','','','','25');

            $html = view('templates.apolice', ['assinatura' => $assinatura, 'adicionais' => $adicionais])->render();

            $mpdf->WriteHTML(strtoupper($html));
        }

        Storage::disk('public')->put($filename, $mpdf->Output($filename, 'S'));

        return $filename;
    }
}
