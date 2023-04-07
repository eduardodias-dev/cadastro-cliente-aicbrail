<?php

namespace App\Http\Controllers;

use App\Mail\EnvioEmailApolice;
use \Mpdf\Mpdf as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function pdf($ordercode, $sendEmail = 0){

        $assinatura = DB::select('SELECT * from v_assinaturas_detalhe where codigo_assinatura = ?', [$ordercode]);
        if(count($assinatura) > 0)
            $assinatura = $assinatura[0];

        $adicionais = DB::select('SELECT * FROM v_adicionais_assinatura WHERE codigo_assinatura = ?', [$ordercode]);
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

        Mail::to('eduardo.dias092@gmail.com')
             ->send(new EnvioEmailApolice($assinatura, storage_path('app\public\\'.$filename), $adicionais));

        return 1;

    }
}
