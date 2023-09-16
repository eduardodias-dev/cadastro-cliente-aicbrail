<?php

namespace App\Services;

use App\Email;
use App\Plano;
use Exception;
use App\Pacote;
use App\Cliente;
use App\Veiculo;
use App\Endereco;
use App\Telefone;
use App\Assinatura;
use \Mpdf\Mpdf as PDF;
use App\Mail\EmailBoasVindas;
use App\Adicionais_Assinatura;
use App\Mail\EnvioEmailApolice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Assinatura_Adicionais_Assinatura;

class CheckoutService
{
    public function realizarCheckout($checkoutData)
    {
        DB::beginTransaction();
        try{
            $savedClient = $this->adicionarCliente($checkoutData,$checkoutData['plan_id']);

            if($savedClient != null){
                $savedSubscription = $this->adicionarAssinatura($checkoutData, $savedClient->id, $checkoutData['plan_id'], 0);

                if($savedSubscription != null){
                    $service = new GalaxPayService;
                    $result = $service->CreateSubscription($savedSubscription->id, $savedClient->id, $checkoutData['forma_pagamento'], $this->getCardData($checkoutData));


                    if(isset($result->json()['Subscription'])){
                        try{
                            //$this->enviarEmailBemVindo($result->json()['Subscription']['myId'], $checkoutData['email']);
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
            $savedClientPagador = $this->adicionarCliente($cliente_pagador, 1, true);
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
                if(is_array($cartItem)){
                    $savedClient = $this->adicionarCliente($cartItem, $key, false);

                    if($savedClient != null){
                        $savedSubscription = $this->adicionarAssinatura($cartItem, $savedClient->id, $key, $pacote->id);

                        $valorTotalPacote += $savedSubscription->valor;
                    }
                }
            }

            $pacote->valor = $valorTotalPacote;
            if(isset($cartData['codigo_afiliado']) && !empty($cartData['codigo_afiliado'])){
                $dados_afiliado = DB::select("SELECT * FROM v_codigo_afiliados WHERE codigo = ?", [$cartData['codigo_afiliado']]);

                if(!empty($dados_afiliado) && count($dados_afiliado)>0){
                    $dado_afiliado = $dados_afiliado[0];

                    $pacote->id_afiliado = $dado_afiliado->id_afiliado;
                }
            }

            $pacote->save();

            $service = new GalaxPayService;
            $result = $service->CreateSubscription($pacote->id, $pacote->client_id, $cliente_pagador['forma_pagamento'], $this->getCardData($cliente_pagador));

            if($result != null && isset($result->json()['Subscription'])){
                try{
                    $this->enviarEmailBemvindo($result->json()['Subscription']['myId'], $cliente_pagador['email']);
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

    private function adicionarCliente($data, $plan_id, $somentePagamento = false)
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

            $plano = Plano::find($plan_id);
            if(!$somentePagamento && $plano->juridico != 1){
                //die('somentePag'.$somentePagamento.' '.$plano->juridico.' data:'.print_r($data));
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

    private function adicionarAssinatura($data, $client_id, $plan_id, $pacote_id){
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
            $newAssinatura->protecao_veicular = isset($data['comprar_protecao_veicular']) ? $data['comprar_protecao_veicular'] : '0';
            $newAssinatura->pacote_id = $pacote_id;
            $newAssinatura->save();

            $newAssinatura->codigo_assinatura = $this->getCodigoAssinatura($newAssinatura);

            $plano = Plano::find($plan_id);
            if($plano->juridico != 1){
                $beneficios = isset($data['club_beneficio']) ? $data['club_beneficio'] : [];
                foreach($beneficios as $item){

                    $adicionalAssinatura = new Assinatura_Adicionais_Assinatura;
                    $adicionalAssinatura->assinatura_id = $newAssinatura->id;
                    $adicionalAssinatura->adicional_assinatura_id = $item;
                    $adicionalAssinatura->deletado = false;

                    //$newAssinatura->valor += $adicionalAssinaturaValor->valor;
                    $adicionalAssinatura->save();
                }

                $coberturas = isset($data['cobertura_24horas']) ? $data['cobertura_24horas'] : [];

                foreach($coberturas as $item){

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
                    $adicionalAssinatura = new Assinatura_Adicionais_Assinatura;
                    $adicionalAssinatura->assinatura_id = $newAssinatura->id;
                    $adicionalAssinatura->adicional_assinatura_id = $item;
                    $adicionalAssinatura->deletado = false;

                    //$newAssinatura->valor += $adicionalAssinaturaValor->valor;
                    $adicionalAssinatura->save();
                }

            }

            $newAssinatura->save();


            return $newAssinatura;
        }catch(Exception $e){
            throw $e;
        }

        return null;
    }

    private function enviarEmailBemvindo($codigo_pacote, $emailCliente){

        $pacote = DB::select('SELECT * FROM v_pacote_integracao WHERE codigo = ?', [$codigo_pacote]);
        if(count($pacote) <= 0)
            return 0;

         Mail::to($emailCliente)
              ->send(new EmailBoasVindas($pacote[0]));

        return 1;
    }

    public function gerarApolicePeloPacote($codigo_pacote){
        $assinaturas = DB::select('SELECT * from v_assinaturas_detalhe where codigo_pacote = ?', [$codigo_pacote]);
        if(count($assinaturas) <= 0)
            return;

        $filename = $this->gerarApolice($codigo_pacote, $assinaturas);

        // Mail::to($emailCliente)
        //      ->send(new EnvioEmailApolice($assinatura, storage_path(getFilePathByArray(['app','public', $filename])), $enviarApolice));

        return $filename;
    }

    private function gerarApolice($ordercode, $assinaturas, $adicionais = null ){
        $filename = 'apolice_'.$ordercode.'.pdf';
        $mpdf = new PDF();
        $pathfile = storage_path(getFilePathByArray(['app','public','capa_apolice.pdf']));


        $mpdf->SetSourceFile($pathfile);
        $tplId = $mpdf->ImportPage(1);
        $mpdf->useTemplate($tplId);

        foreach($assinaturas as $assinatura){
            // Do not add page until page template set, as it is inserted at the start of each page
            $adicionais = DB::select('SELECT * FROM v_adicionais_assinatura WHERE codigo_assinatura = ?', [$assinatura->codigo_assinatura]);

            $pathfile = storage_path(getFilePathByArray(['app','public','template_apolice.pdf']));
            $mpdf->SetSourceFile($pathfile);
            $tplId = $mpdf->ImportPage(1);
            $mpdf->SetPageTemplate($tplId);
            $mpdf->AddPage('P','','','','','','','25');

            $html = view('templates.apolice', ['assinatura' => $assinatura, 'adicionais' => $adicionais])->render();

            $mpdf->WriteHTML(strtoupper($html));
        }

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
