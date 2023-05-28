<?php

namespace App\Services;

use App\Email;
use Exception;
use App\Cliente;
use App\Veiculo;
use App\Endereco;
use App\Telefone;
use App\Assinatura;
use \Mpdf\Mpdf as PDF;
use App\Adicionais_Assinatura;
use App\Mail\EnvioEmailApolice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Assinatura_Adicionais_Assinatura;
use App\Pacote;

class CheckoutService
{
    public function realizarCheckout($checkoutData)
    {
        DB::beginTransaction();
        try{
            $savedClient = $this->adicionarCliente($checkoutData);

            if($savedClient != null){
                $savedSubscription = $this->adicionarAssinatura($checkoutData, $savedClient->id, $checkoutData['plan_id']);

                if($savedSubscription != null){
                    $service = new GalaxPayService;
                    $result = $service->CreateSubscription($savedSubscription->id, $savedClient->id, $checkoutData['forma_pagamento'], $this->getCardData($checkoutData));


                    if(isset($result->json()['Subscription'])){
                        try{
                            $this->enviarEmailBemVindo($result->json()['Subscription']['myId'], $checkoutData['email']);
                        }catch(Exception $ex){
                            Log::warning("Erro ao executar envio de email: ".$ex->getMessage());
                            throw $ex;
                        }
                    }else{
                        throw new Exception('Erro ao executar integração: '.json_encode($result->json()));
                    }

                    DB::commit();
                    return $result;
                }
            }
        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }

        DB::rollBack();
        return null;
    }

    public function realizarCheckoutByCart($cartData)
    {
        DB::beginTransaction();
        try{
            $cliente_pagador = $cartData['dados_pagamento']['cliente'];
            unset($cartData['dados_pagamento']);
            $savedClientPagador = $this->adicionarCliente($cliente_pagador, true);
            $pacote = new Pacote;
            $pacote->client_id = $savedClientPagador->id;
            $pacote->status = 'pendente';
            $pacote->tipo_pagamento = $cliente_pagador['forma_pagamento'];
            $pacote->adesao = date('Y-m-d H:i:s');
            $pacote->melhor_vencimento = $cliente_pagador['melhor_vencimento'];
            $pacote->save();

            $pacote->codigo = $this->getCodigoPacote($pacote);
            $valorTotalPacote = 0.0;

            foreach($cartData as $key => $cartItem){

                $savedClient = $this->adicionarCliente($cartItem, false);

                if($savedClient != null){
                    $savedSubscription = $this->adicionarAssinatura($cartItem, $savedClient->id, $key);

                    $valorTotalPacote += $savedSubscription->valor;
                }

                // if($savedSubscription != null){
                //     $service = new GalaxPayService;
                //     $result = $service->CreateSubscription($savedSubscription->id, $savedClient->id, $checkoutData['forma_pagamento'], $this->getCardData($checkoutData));


                //     if(isset($result->json()['Subscription'])){
                //         try{
                //             $this->enviarEmailBemVindo($result->json()['Subscription']['myId'], $checkoutData['email']);
                //         }catch(Exception $ex){
                //             Log::warning("Erro ao executar envio de email: ".$ex->getMessage());
                //             throw $ex;
                //         }
                //     }else{
                //         throw new Exception('Erro ao executar integração: '.json_encode($result->json()));
                //     }

                //     DB::commit();
                //     return $result;
                // }
            }
            $pacote->valor = $valorTotalPacote;
            $pacote->save();

            $service = new GalaxPayService;
            $result = $service->CreateSubscription($pacote->id, $pacote->client_id, $cliente_pagador['forma_pagamento'], $this->getCardData($cliente_pagador));

            if($result != null && isset($result->json()['Subscription'])){
                try{
                    //$this->enviarEmailBemVindo($result->json()['Subscription']['myId'], $cliente_pagador['email']);
                }catch(Exception $ex){
                    Log::warning("Erro ao executar envio de email: ".$ex->getMessage());
                    throw $ex;
                }
            }else{
                throw new Exception('Erro ao executar integração: '.json_encode($result->json()));
            }

            DB::commit();
            return $result;
        }catch(Exception $e){
            DB::rollBack();
            throw $e;
        }

        DB::rollBack();
        return null;
    }

    private function adicionarCliente($data, $somentePagamento = false)
    {
        try{
            $newCliente = new Cliente;

            $newCliente->id_galaxpay = 0;
            $newCliente->tipo_cadastro = $data['tipo_cadastro'];
            $newCliente->nome = $data['nome'];
            $newCliente->documento = $data['cpfcnpj'];
            $newCliente->status = 'active';
            $newCliente->sexo = $data['sexo'];
            $newCliente->dataNascimento = date_create_from_format("d/m/Y", $data['datanasc']);
            $newCliente->nome_representante = $data['nome_representante'];
            $newCliente->cpf_representante = $data['cpf_representante'];

            $result = $newCliente->save();

            if(!$result)
                return null;

            $data['client_id'] = $newCliente->id;

            $clienteEmail = new Email;
            $clienteEmail->client_id = $newCliente->id;
            $clienteEmail->endereco = $data['email'];
            $clienteEmail->save();

            $clienteEndereco = new Endereco;
            $clienteEndereco->client_id = $newCliente->id;
            $clienteEndereco->cep = str_replace('-','',$data['cep']);
            $clienteEndereco->rua = $data['logradouro'];
            $clienteEndereco->numero = $data['numero'];
            $clienteEndereco->complemento = $data['complemento'];
            $clienteEndereco->bairro = $data['bairro'];
            $clienteEndereco->cidade = $data['cidade'];
            $clienteEndereco->estado = $data['estado'];
            $clienteEndereco->save();

            $clienteTelefone = new Telefone;
            $clienteTelefone->client_id = $newCliente->id;
            $clienteTelefone->numero = $data['celular'];
            $clienteTelefone->save();

            if(!$somentePagamento){
                $veiculo = new Veiculo;

                $veiculo->client_id = $newCliente->id;
                $veiculo->chassi = $data['chassi'];
                $veiculo->placa = $data['placa_veiculo'];
                $veiculo->renavam = $data['renavam'];
                $veiculo->tipo = $data['tipo_veiculo'];
                $veiculo->anoFabricacao = $data['ano_fabricacao'];
                $veiculo->anoModelo = $data['ano_fabricacao'];
                $veiculo->marca = $data['marca_veiculo'];
                $veiculo->modelo = $data['modelo_veiculo'];
                $veiculo->cor = $data['cor_veiculo'];
                $veiculo->cambio = "";
                $veiculo->fipeCodigo = "";
                $veiculo->fipeValor = "";

                $veiculo->save();
            }

            return $newCliente;

        }catch(Exception $e){

            throw $e;
        }

        return null;
    }

    private function adicionarAssinatura($data, $client_id, $plan_id){
        try{

            $newAssinatura = new Assinatura;
            $newAssinatura->plan_id = $plan_id;
            $newAssinatura->client_id = $client_id;
            $newAssinatura->valor = $data['valor_calculado'];
            $newAssinatura->quantidade = 1;
            $newAssinatura->periodicidade = 'mensal';
            $newAssinatura->status = 'pendente';
            $newAssinatura->info_adicional = '';
            $newAssinatura->adesao = date('Y-m-d H:i:s');
            //$newAssinatura->melhor_vencimento = $data['melhor_vencimento'];
            //$newAssinatura->tipo_pagamento = $data['forma_pagamento'];
            $newAssinatura->protecao_veicular = $data['comprar_protecao_veicular'];

            $newAssinatura->save();

            $newAssinatura->codigo_assinatura = $this->getCodigoAssinatura($newAssinatura);

            $beneficios = isset($data['club_beneficio']) ? $data['club_beneficio'] : [];
            foreach($beneficios as $item){
                $adicionalAssinaturaValor = Adicionais_Assinatura::find($item);

                $adicionalAssinatura = new Assinatura_Adicionais_Assinatura;
                $adicionalAssinatura->assinatura_id = $newAssinatura->id;
                $adicionalAssinatura->adicional_assinatura_id = $item;
                $adicionalAssinatura->deletado = false;

                //$newAssinatura->valor += $adicionalAssinaturaValor->valor;
                $adicionalAssinatura->save();
            }

            $coberturas = isset($data['cobertura_24horas']) ? $data['cobertura_24horas'] : [];

            foreach($coberturas as $item){
                $adicionalAssinaturaValor = Adicionais_Assinatura::find($item);

                $adicionalAssinatura = new Assinatura_Adicionais_Assinatura;
                $adicionalAssinatura->assinatura_id = $newAssinatura->id;
                $adicionalAssinatura->adicional_assinatura_id = $item;
                $adicionalAssinatura->deletado = false;

                //$newAssinatura->valor += $adicionalAssinaturaValor->valor;
                $adicionalAssinatura->save();
            }

            $cobertura_24horas_incluso_plano = Adicionais_Assinatura::where('incluso_nos_planos', 'LIKE', '%'.$plan_id.'%')->get();
            foreach($cobertura_24horas_incluso_plano as $incluso){
                $adicionalAssinatura = new Assinatura_Adicionais_Assinatura;
                $adicionalAssinatura->assinatura_id = $newAssinatura->id;
                $adicionalAssinatura->adicional_assinatura_id = $incluso->id;
                $adicionalAssinatura->deletado = false;

                $adicionalAssinatura->save();
            }

            $seguros = isset($data['comprar_seguros']) ? $data['comprar_seguros'] : [];
            foreach($seguros as $item){
                $adicionalAssinaturaValor = Adicionais_Assinatura::find($item);

                $adicionalAssinatura = new Assinatura_Adicionais_Assinatura;
                $adicionalAssinatura->assinatura_id = $newAssinatura->id;
                $adicionalAssinatura->adicional_assinatura_id = $item;
                $adicionalAssinatura->deletado = false;

                //$newAssinatura->valor += $adicionalAssinaturaValor->valor;
                $adicionalAssinatura->save();
            }

            $newAssinatura->save();


            return $newAssinatura;
        }catch(Exception $e){
            throw $e;
        }

        return null;
    }

    private function enviarEmailBemvindo($ordercode, $emailCliente, $enviarApolice = 0){

        $assinatura = DB::select('SELECT * from v_assinaturas_detalhe where codigo_assinatura = ?', [$ordercode]);
        if(count($assinatura) > 0)
            $assinatura = $assinatura[0];

        $adicionais = DB::select('SELECT * FROM v_adicionais_assinatura WHERE codigo_assinatura = ?', [$ordercode]);

        $filename = $this->gerarApolice($ordercode, $assinatura, $adicionais);

        Mail::to($emailCliente)
             ->send(new EnvioEmailApolice($assinatura, storage_path(getFilePathByArray(['app','public', $filename])), $adicionais, $enviarApolice));

        return 1;
    }

    private function gerarApolice($ordercode, $assinatura, $adicionais){
        $filename = 'apolice_'.$ordercode.'.pdf';
        $mpdf = new PDF();

        $pathfile = storage_path(getFilePathByArray(['app','public','capa_apolice.pdf']));
        $mpdf->SetSourceFile($pathfile);
        $tplId = $mpdf->ImportPage(1);
        $mpdf->useTemplate($tplId);

        // Do not add page until page template set, as it is inserted at the start of each page
        $pathfile = storage_path(getFilePathByArray(['app','public','template_apolice.pdf']));
        $mpdf->SetSourceFile($pathfile);
        $tplId = $mpdf->ImportPage(1);
        $mpdf->SetPageTemplate($tplId);
        $mpdf->AddPage('P','','','','','','','25');

        $html = view('templates.apolice', ['assinatura' => $assinatura, 'adicionais' => $adicionais])->render();

        $mpdf->WriteHTML(strtoupper($html));
        Storage::disk('public')->put($filename, $mpdf->Output($filename, 'S'));

        return $filename;
    }

    private function getCodigoAssinatura($assinatura){
        return "AICBR-".date_format(date_create($assinatura->adesao), "Ydm")."".$assinatura->id;
    }

    private function getCardData($data){
        $card_data = [
            "card_number" => $data['card_number'],
            "card_holder" => $data['card_holder'],
            "card_expires_at" => $data['card_expires_at'],
            "card_cvv" => $data['card_cvv']
        ];

        return $card_data;
    }

    private function getCodigoPacote($pacote){
        return "P-AICBR-".date_format(date_create($pacote->adesao), "Ydm")."".$pacote->id;
    }
}
