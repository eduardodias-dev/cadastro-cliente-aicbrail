<?php

namespace App\Services;

use App\Adicionais_Assinatura;

class CartHelper
{
    public static function getValorCalculado($data, $valorInicial){
        $valor = $valorInicial;
        $beneficios = isset($data['club_beneficio']) ? $data['club_beneficio'] : [];
        foreach($beneficios as $item){
            $adicionalAssinaturaValor = Adicionais_Assinatura::find($item);

            $valor += $adicionalAssinaturaValor->valor;
            //$adicionalAssinatura->save();
        }

        $coberturas = isset($data['cobertura_24horas']) ? $data['cobertura_24horas'] : [];

        foreach($coberturas as $item){
            $adicionalAssinaturaValor = Adicionais_Assinatura::find($item);
            $valor += $adicionalAssinaturaValor->valor;
        }

        $seguros = isset($data['comprar_seguros']) ? $data['comprar_seguros'] : [];
        foreach($seguros as $item){
            $adicionalAssinaturaValor = Adicionais_Assinatura::find($item);

            $valor += $adicionalAssinaturaValor->valor;
        }

        return $valor;
    }

}
