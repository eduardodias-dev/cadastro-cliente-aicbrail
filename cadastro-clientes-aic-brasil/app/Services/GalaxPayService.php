<?php

namespace App\Services;

use Exception;
use App\Pacote;
use App\LogIntegracao;
use App\FilaConfirmacaoPacote;
use App\FilaConfirmacaoAssinatura;
use App\ViewModels\BankAccountViewModel;
use App\ViewModels\ResponseViewModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class GalaxPayService
{
    const QTDE_DIAS_PRIMEIRO_PAGAMENTO = 3;

    public function CreateSubscription($pacote_id, $client_id, $type = 'card', $card_data = null)
    {
        $data = DB::select("SELECT * from v_pacote_integracao where id_pacote = ? AND id_cliente = ?", [$pacote_id, $client_id]);
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

            $filaAssinatura = new FilaConfirmacaoPacote();
            $filaAssinatura->id_pacote = $data[0]->id_pacote;
            $filaAssinatura->acao = 'Confirmar pagamento';
            $filaAssinatura->finalizado = 0;

            $filaAssinatura->save();

            $pacote = Pacote::find($data[0]->id_pacote);
            $pacote->link_boleto = $this->pegarLinkBoleto($response);

            $pacote->save();

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

        $request['myId'] = $data->codigo;
        $request['value'] = $data->valor;
        $request['periodicity'] = $data->periodicidade;
        $request['quantity'] = 0;
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
        $request['PaymentMethodBoleto'] = [
            "deadlineDays" => self::QTDE_DIAS_PRIMEIRO_PAGAMENTO,
            "instructions" => "ASSISTÊNCIA 24h\n PROTESTO AUTOMÁTICO APÓS O VENCIMENTO - LEI nº 23.204|2018 (ALTERA A LEI nº.15.424|2004)"
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
                "instructions" => "ASSISTÊNCIA 24h\n PROTESTO AUTOMÁTICO APÓS O VENCIMENTO - LEI nº 23.204|2018 (ALTERA A LEI nº.15.424|2004)"
            ];

        return $request;
    }

    private function pegarLinkBoleto($jsonResposta){
        try{
            //Subscription.Transactions[0].Boleto.pdf

            if(isset($jsonResposta['Subscription'])){
                if(isset($jsonResposta['Subscription']['Transactions'])){
                    return $jsonResposta['Subscription']['Transactions'][0]['Boleto']['pdf'];
                }
            }
        }catch(Exception $e){
            Log::warning("Não foi possível recuperar o link: ".$e->getMessage());
        }
        return null;
    }

    public function CreateBankSubAccount(BankAccountViewModel $data){
        $configs = GalaxPayConfigHelper::GetGalaxPayServiceConfiguration();
        $tokenObject = GalaxPayConfigHelper::getToken("company.write");

        $response = Http::withToken($tokenObject['access_token'])
                    ->post($configs['URL']."/company/subaccount", (array) $data);

        $responseViewModel = new ResponseViewModel();

        if($response->successful()){
            $responseViewModel->sucesso = 1;
            $responseViewModel->mensagem = "Conta criada com sucesso!";
        }
        else{
            $status_code = $response->status();
            $responseViewModel->sucesso = 0;

            if($status_code == 400){
                $responseViewModel->mensagem = $response->json()['error']['message'];
            }
            else
            {
                $responseViewModel->mensagem = "Ocorreu um erro inesperado ao criar a subconta, por favor entre em contato com o suporte.";
            }
        }

        $log_integracao = new LogIntegracao();
        $log_integracao->acao = "Criação de subconta";
        $log_integracao->data_integracao = date('Y-m-d H:i:s');
        $log_integracao->resultado = json_encode(["status" => $response->status(), "dados" => $response->json()]);

        $log_integracao->save();

        return $responseViewModel;
    }

}
