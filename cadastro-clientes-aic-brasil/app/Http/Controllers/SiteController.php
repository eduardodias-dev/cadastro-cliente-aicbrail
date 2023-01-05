<?php

namespace App\Http\Controllers;

use App\Adicionais_Assinatura;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function home(){
        return view('site.index');
    }

    public function checkout(Request $request){
        $club_beneficio = Adicionais_Assinatura::where(['id_tipo_adicional_assinatura'=> '1', 'ativo' => '1'])->get();

        return view('site.checkout', ['club_beneficio' => $club_beneficio]);
    }
}
