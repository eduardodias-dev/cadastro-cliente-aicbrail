<?php

namespace ViewModels;

use App\Plano;
use App\Assinatura;
use App\Adicionais_Assinatura;

class CheckoutViewModel{
    public $adicionais_club_beneficio = [];
    public $adicionais_cobertura_24horas = [];
    public $adicionais_comprar_seguros = [];
    public $plano;
    public $session_id;

    public function __construct($plano, $adicionais_club_beneficio, $adicionais_cobertura_24horas, $adicionais_comprar_seguros, $session_id = null)
    {
        $this->adicionais_club_beneficio = $adicionais_club_beneficio;
        $this->adicionais_cobertura_24horas = $adicionais_cobertura_24horas;
        $this->adicionais_comprar_seguros = $adicionais_comprar_seguros;
        $this->plano = $plano;
        $this->session_id = $session_id;
    }

    public static function CreateStandardCheckoutView($id_plano)
    {
        $plano = Plano::find($id_plano);
        $club_beneficio = Adicionais_Assinatura::where(['id_tipo_adicional_assinatura'=> '1', 'ativo' => '1'])->get();
        $cobertura_24horas = Adicionais_Assinatura::where(['id_tipo_adicional_assinatura'=> '2', 'ativo' => '1'])->get();
        $comprar_seguros = Adicionais_Assinatura::where(['id_tipo_adicional_assinatura'=> '3', 'ativo' => '1'])->get();
        $session_id = session()->getId();

        $obj = new CheckoutViewModel($plano, $club_beneficio, $cobertura_24horas, $comprar_seguros, $session_id);
        return $obj;
    }
}
