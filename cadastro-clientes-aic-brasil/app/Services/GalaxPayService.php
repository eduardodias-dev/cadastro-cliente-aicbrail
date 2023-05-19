<?php

namespace App\Services;

use App\FilaConfirmacaoAssinatura;
use App\LogIntegracao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class GalaxPayService
{
    const QTDE_DIAS_PRIMEIRO_PAGAMENTO = 3;

    public function CreateSubscription($assinatura_id, $client_id, $type = 'card', $card_data = null)
    {
        $data = DB::select("SELECT * from v_assinaturas_integracao where id_assinatura = ? AND id_cliente = ?", [$assinatura_id, $client_id]);
        if(count($data) >= 1){
            $configs = GalaxPayConfigHelper::GetGalaxPayServiceConfiguration();
            $request_data = $this->BuildCreateSubscriptionRequest($data[0], $type, $card_data);

            $token_object = GalaxPayConfigHelper::getToken("subscriptions.write");

            $response = Http::withToken($token_object['access_token'])
                            ->post($configs['URL'].'/subscriptions', $request_data);

            $log = new LogIntegracao;
            $log->resultado = json_encode($response->json());
            $log->acao = 'Adicionar Assinatura';
            $log->data_integracao = date('Y-m-d H:i:s');
            $log->client_id = $data[0]->id_cliente;

            $log->save();

            $filaAssinatura = new FilaConfirmacaoAssinatura();
            $filaAssinatura->id_assinatura = $data[0]->id_assinatura;
            $filaAssinatura->acao = 'Confirmar pagamento';
            $filaAssinatura->finalizado = 0;

            $filaAssinatura->save();

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
            "phones"=> array( clean($data->telefone) ),
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
                    "number" =>  str_replace(' ', '', $data['card_number']),
                    "holder" =>  $data['card_holder'],
                    "expiresAt" =>  getExpiresAt($data['card_expires_at']),
                    "cvv" =>  $data['card_cvv']
                ]
            ];
        else if ($type == 'pix')
            $request['PaymentMethodBoleto'] = [
                "deadlineDays" => self::QTDE_DIAS_PRIMEIRO_PAGAMENTO,
                "instructions" => "ASSISTÊNCIA 24h"
            ];

        return $request;
    }

}
