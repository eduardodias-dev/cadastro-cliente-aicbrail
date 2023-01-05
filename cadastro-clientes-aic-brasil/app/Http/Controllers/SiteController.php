<?php

namespace App\Http\Controllers;

use App\Plano;
use Illuminate\Http\Request;
use App\Adicionais_Assinatura;

class SiteController extends Controller
{
    public function home(){
        return view('site.index');
    }

    public function checkout(Request $request, $id_plano){
        $plano = Plano::find($id_plano);
        // die(print_r($id_plano));
        $club_beneficio = Adicionais_Assinatura::where(['id_tipo_adicional_assinatura'=> '1', 'ativo' => '1'])->get();
        $cobertura_24horas = Adicionais_Assinatura::where(['id_tipo_adicional_assinatura'=> '2', 'ativo' => '1'])->get();
        $comprar_seguros = Adicionais_Assinatura::where(['id_tipo_adicional_assinatura'=> '3', 'ativo' => '1'])->get();

        return view('site.checkout', [
                                        'club_beneficio' => $club_beneficio,
                                        'cobertura_24horas' => $cobertura_24horas,
                                        'comprar_seguros' => $comprar_seguros,
                                        'plano' => $plano
                                    ]);
    }
}
