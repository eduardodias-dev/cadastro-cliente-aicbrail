<?php
namespace App\Services;

use App\Imovel;
use App\ImovelVisita;
use App\VisitaComprador;
use Illuminate\Support\Facades\Log;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Storage;
use App\Mail\EnvioEmailFichaImovel;
use Illuminate\Support\Facades\Mail;

class VisitaImovelService{

    public static function gerarArquivoFichaVisitaImovel($visita_id){
        set_time_limit(300);
        $visita = ImovelVisita::find($visita_id);
        $caminhoArquivo = null;

        if($visita != null){
            $imovel = Imovel::find($visita->imovel_id);
            $compradores = VisitaComprador::where("visita_id", $visita->id)->get();

            $caminhoArquivo = self::gerarPDF($visita, $imovel, $compradores);

            $envio = new EnvioEmailFichaImovel($visita, $imovel, $compradores, $caminhoArquivo);

            $email_compradores = [];

            foreach($compradores as $comprador){
                array_push($email_compradores, $comprador->email);
            }

            Mail::to((array)$email_compradores)
                    ->send($envio);
        }
        else{
            Log::warning("Nenhuma visita encontrada com o id: $visita_id");
        }

        return $caminhoArquivo;
    }

    private static function gerarPDF($visita, $imovel, $compradores)
    {
        $filename = 'visita'.$visita->id.$imovel->codigo_imovel.'.pdf';
        $mpdfConfig = [
            'timeout' => 300, // ajusta o tempo de timeout
        ];

        $templatePath = storage_path("app/public/template_fichaimovel.pdf");
        $mpdf = new PDF($mpdfConfig);

        $mpdf->SetDocTemplate($templatePath, true);
        $mpdf->AddPage();
        $arrCompradores = [];

        foreach($compradores as $comprador){
            array_push($arrCompradores, ["nome" => $comprador->nome, "cpf" => $comprador->cpf]);
        }

        $dataHoraVisita = getDateTimeInBRFormat($visita->data_visita, "UTC");

        $arrVisita = [
            "data" => explode(" ",$dataHoraVisita)[0],
            "hora" => explode(" ",$dataHoraVisita)[1]
        ];

        $arrImovel = [
            "nome_proprietario" => $imovel->nome_proprietario,
            "cpf_proprietario" => $imovel->cpf_proprietario,
            "street" => $imovel->street,
            "number" => $imovel->number,
            "complement" => $imovel->complement,
            "neighborhood" => $imovel->neighborhood,
            "city" => $imovel->city,
            "state" => $imovel->state
        ];

        $html = view('templates.ficha_imovel', [
            'imovel' => $arrImovel, 
            'visita' => $arrVisita,
            'compradores' => $arrCompradores
        ])->render();

        
        $mpdf->SetFooter('{PAGENO}');
        $mpdf->defaultfooterfontsize=10;
        $mpdf->defaultfooterfontstyle='B';
        $mpdf->defaultfooterline=1;
        
        $mpdf->WriteHTML($html);
        Storage::disk('public')->put($filename, $mpdf->Output($filename, 'S'));

        return $filename;
    }
}