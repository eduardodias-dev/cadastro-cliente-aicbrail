<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GalaxPayService
{
    const QTDE_DIAS_PRIMEIRO_PAGAMENTO = 3;

    public function CreateSubscription($assinatura_id, $client_id, $type = 'card', $card_data = null)
    {
        $data = DB::select("SELECT * from V_Assinaturas_Integracao where id_assinatura = ? AND id_cliente = ?", [$assinatura_id, $client_id]);
        if(count($data) >= 1){
            $configs = GalaxPayConfigHelper::GetGalaxPayServiceConfiguration();
            $request_data = $this->BuildCreateSubscriptionRequest($data[0], $type, $card_data);

            $token_object = GalaxPayConfigHelper::getToken("subscriptions.write");

            $response = Http::withToken($token_object['access_token'])
                            ->post($configs['URL'].'/subscriptions', $request_data);

            die(print_r($response->json()));
            return $response;
        }
        else
            return null;
    }

    private function BuildCreateSubscriptionRequest($data, $type = 'creditcard', $card_data = null)
    {
        if($type=='creditcard' && $card_data == null){
            return false;
        }

        $request = [];

        $request['myId'] = $data->codigo_assinatura;
        $request['value'] = $data->valor;
        $request['periodicity'] = $data->periodicidade;
        $request['quantity'] = $data->quantidade;
        $date = intval(GalaxPayService::QTDE_DIAS_PRIMEIRO_PAGAMENTO) + strtotime($data->adesao);
        $request['firstPayDayDate'] = date('Y-m-d', $date);
        $request['additionalInfo'] = $data->info_adicional;
        $request['mainPaymentMethodId'] = $data->tipo_pagamento == null ? 'boleto' : $data->tipo_pagamento;
        $request['Customer'] = [
            "myId" => $data->id_cliente,
            "name" => $data->nome_cliente,
            "document"=>removeSpecialCharacters($data->documento),
            "emails" => [ $data->emails ],
            "phones"=> $data->telefone,
            "Address"=>[
                "zipCode" => removeSpecialCharacters($data->cep),
                "street" => $data->logradouro,
                "number" => $data->numero,
                "complement" => $data->complemento,
                "neighborhood" => $data->bairro,
                "city" => $data->cidade,
                "state" => $data->estado
            ]
        ];

        if($type == 'card')
            $request['PaymentMethodCreditCard'] = [
                "Card" => [
                    "number" =>  $data['card_number'],
                    "holder" =>  $data['card_holder'],
                    "expiresAt" =>  $data['card_expires_at'],
                    "cvv" =>  $data['card_cvv']
                ]
            ];
        // else if ($type == 'pix')
        //     $request['PaymentMethodPix'] = [
        //         "instructions" => $data->info_adicional
        //     ];

        return $request;
    }

}
