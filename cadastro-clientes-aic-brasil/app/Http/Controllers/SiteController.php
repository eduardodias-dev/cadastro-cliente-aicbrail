<?php

namespace App\Http\Controllers;

use App\Email;
use App\Plano;
use Exception;
use App\Cliente;
use App\Veiculo;
use App\Endereco;
use App\Telefone;
use App\Assinatura;
use Illuminate\Http\Request;
use App\Adicionais_Assinatura;
use App\Services\GalaxPayService;
use Illuminate\Support\Facades\DB;
use App\Assinatura_Adicionais_Assinatura;
use Illuminate\Support\Facades\Validator;

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

    public function checkout_post(Request $request)
    {
        $data = $request->all();
        // die(json_encode($data));
        $validation = $this->validarCliente($data);
        $plano = Plano::find($data['plan_id']);
        $data['valor_calculado'] = $plano->preco;

        if($validation->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Ops... Parece que temos problemas com seus dados, por favor preencha corretamente :)',
                'errors' => json_encode($validation->errors())
                ]
            );
        }

        $savedClient = $this->adicionarCliente($data);
        if($savedClient != null){
            $savedSubscription = $this->adicionarAssinatura($data, $savedClient->id, $data['plan_id']);
            if($savedSubscription != null){
                $service = new GalaxPayService;
                $service->CreateSubscription($savedSubscription->id, $savedClient->id, 'boleto');

                return response()->json([
                    'success' => true,
                    'message' => 'Adicionado com sucesso!'
                ]);
            }
            else
                return response()->json([
                    'success' => false,
                    'message' => 'Ops... Ocorreu um erro ao salvar sua assinatura, por favor entre em contato com o suporte.',
                    ]
                );
        }
        else{
            return response()->json([
                'success' => false,
                'message' => 'Ops... Ocorreu um erro ao salvar seu cadastro, por favor entre em contato com o suporte.',
                ]
            );
        }
    }

    private function adicionarCliente($data)
    {
        DB::beginTransaction();
        try{
            $newCliente = new Cliente;

            $newCliente->id_galaxpay = 0;
            $newCliente->nome = $data['nome'];
            $newCliente->documento = $data['cpfcnpj'];
            $newCliente->status = 'active';
            $newCliente->sexo = $data['sexo'];
            $newCliente->dataNascimento = $data['datanasc'];

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
            $clienteEndereco->cep = $data['cep'];
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

            DB::commit();

            return $newCliente;
        }catch(Exception $e){

            DB::rollback();
            throw $e;
        }

        return null;
    }

    private function validarCliente($request){
        return Validator::make($request, $this->regras());
    }

    private function regras(){
        return [
            'nome' => 'required|string|max:255',
            'cpfcnpj' => 'required|regex:/^\d{3}\.\d{3}\.\d{3}-\d{2}$/',
            'email' => 'required|email',
            'logradouro' => 'required|string',
            'cidade' => 'required|string',
            'estado' => 'required|string',
            'cep' => 'regex:/^[0-9]{5}-[0-9]{3}$/'
            // 'card_number' => 'required|numeric',
            // 'expiration_month' => 'required|numeric',
            // 'expiration_year' => 'required|numeric',
            // 'cvv' => 'required|numeric',
        ];
    }

    private function adicionarAssinatura($data, $client_id, $plan_id){
        DB::beginTransaction();
        $result = 0;
        try{

            $newAssinatura = new Assinatura;
            $newAssinatura->plan_id = $plan_id;
            $newAssinatura->client_id = $client_id;
            $newAssinatura->valor = $data['valor_calculado'];
            $newAssinatura->quantidade = 1;//$data['quantidade'];
            $newAssinatura->periodicidade = 'mensal';
            $newAssinatura->status = 'pendente';
            $newAssinatura->info_adicional = '';
            $newAssinatura->adesao = date('Y-m-d H:i:s');
            $newAssinatura->cobertura_terceiros = $data['cobertura_terceiros'];
            $newAssinatura->melhor_vencimento = $data['melhor_vencimento'];
            $newAssinatura->protecao_veicular = $data['comprar_protecao_veicular'];

            $result = $newAssinatura->save();

            $beneficios = $data['club_beneficio'];
            foreach($beneficios as $item){
                $adicionalAssinatura = new Assinatura_Adicionais_Assinatura;
                $adicionalAssinatura->assinatura_id = $newAssinatura->id;
                $adicionalAssinatura->adicional_assinatura_id = $item;
                $adicionalAssinatura->deletado = false;

                $adicionalAssinatura->save();
            }

            $coberturas = $data['cobertura_24horas'];
            foreach($coberturas as $item){
                $adicionalAssinatura = new Assinatura_Adicionais_Assinatura;
                $adicionalAssinatura->assinatura_id = $newAssinatura->id;
                $adicionalAssinatura->adicional_assinatura_id = $item;
                $adicionalAssinatura->deletado = false;

                $adicionalAssinatura->save();
            }

            $seguros = $data['comprar_seguros'];
            foreach($seguros as $item){
                $adicionalAssinatura = new Assinatura_Adicionais_Assinatura;
                $adicionalAssinatura->assinatura_id = $newAssinatura->id;
                $adicionalAssinatura->adicional_assinatura_id = $item;
                $adicionalAssinatura->deletado = false;

                $adicionalAssinatura->save();
            }

            DB::commit();

            return $newAssinatura;
        }catch(Exception $e){
            $result = 0;
            DB::rollBack();

            throw $e;
        }

        return null;
    }
}
