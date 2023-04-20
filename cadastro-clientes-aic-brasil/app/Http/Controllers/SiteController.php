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
use \Mpdf\Mpdf as PDF;
use Illuminate\Http\Request;
use App\Adicionais_Assinatura;
use App\Mail\EnvioEmailApolice;
use App\Services\GalaxPayService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Assinatura_Adicionais_Assinatura;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    public function home(){
        return view('site.index');
    }

    public function checkout(Request $request, $id_plano){
        $plano = Plano::find($id_plano);
        $club_beneficio = Adicionais_Assinatura::where(['id_tipo_adicional_assinatura'=> '1', 'ativo' => '1'])->get();
        $cobertura_24horas = Adicionais_Assinatura::where(['id_tipo_adicional_assinatura'=> '2', 'ativo' => '1'])->get();
        $comprar_seguros = Adicionais_Assinatura::where(['id_tipo_adicional_assinatura'=> '3', 'ativo' => '1'])->get();
        $session_id = session()->getId();
        return view('site.checkout', [
                                        'club_beneficio' => $club_beneficio,
                                        'cobertura_24horas' => $cobertura_24horas,
                                        'comprar_seguros' => $comprar_seguros,
                                        'plano' => $plano,
                                        'session_id' => $session_id
                                    ]);
    }

    public function checkout_post(Request $request)
    {
        try{
            $data = $request->all();
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
                    $result = $service->CreateSubscription($savedSubscription->id, $savedClient->id, $data['forma_pagamento'], $this->getCardData($data));

                    if(isset($result->json()['Subscription'])){
                        try{
                            $this->enviarEmailBemVindo($result->json()['Subscription']['myId'], $data['email']);
                        }catch(Exception $ex){
                            Log::warning("Erro ao executar envio de email: ".$ex->getMessage());
                        }
                    }

                    return response()->json([
                        'success' => true,
                        'message' => 'Adicionado com sucesso!',
                        'result' => json_encode($result->json())
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
        }catch(Exception $e){
            return response()->json([
                'success' => false,
                'message' => 'Ops... Ocorreu um erro ao salvar seu cadastro, por favor entre em contato com o suporte.',
                'exception' => $e->getMessage()
                ]
            );
        }
    }

    public function view_order(Request $request){
        return view('site.vieworder');
    }

    public function view_order_post(Request $request){
        $ordercode = $request->get('search');
        $result = DB::select('SELECT * from v_assinaturas_detalhe where codigo_assinatura = ?', [$ordercode]);
        $error = count($result) <= 0;
        $data = null;
        if(!$error){
            $data = (array)$result[0];
            $adicionais = DB::select('SELECT * FROM v_adicionais_assinatura WHERE codigo_assinatura = ?', [$ordercode]);

            $transform_array = [];
            $grouped_array = array();
            foreach($adicionais as $adicional){
                array_push($transform_array, (array)$adicional);
            }

            foreach($transform_array as $element){
                $grouped_array[$element['tipo_adicional']][] = $element;
            }

            $data['adicionais_assinatura'] = $grouped_array;
            // die(json_encode($data['adicionais_assinatura']));
        }

        return view('site.order_partial', ['subscription' => $data, 'error' => $error]);
    }

    public function view_contract($ordercode, $sendEmail = 0){

        $assinatura = DB::select('SELECT * from v_assinaturas_detalhe where codigo_assinatura = ?', [$ordercode]);
        if(count($assinatura) > 0)
            $assinatura = $assinatura[0];

        $adicionais = DB::select('SELECT * FROM v_adicionais_assinatura WHERE codigo_assinatura = ?', [$ordercode]);
        $filename = 'apolice_'.$ordercode.'.pdf';
        $mpdf = new PDF();

        $pathfile = storage_path('app\public\capa_apolice.pdf');
        $mpdf->SetSourceFile($pathfile);
        $tplId = $mpdf->ImportPage(1);
        $mpdf->useTemplate($tplId);

        // Do not add page until page template set, as it is inserted at the start of each page
        $pathfile = storage_path('app\public\template_apolice.pdf');
        $mpdf->SetSourceFile($pathfile);
        $tplId = $mpdf->ImportPage(1);
        $mpdf->SetPageTemplate($tplId);
        $mpdf->AddPage('P','','','','','','','25');

        $html = view('templates.apolice', ['assinatura' => $assinatura, 'adicionais' => $adicionais])->render();

        $mpdf->WriteHTML(strtoupper($html));
        Storage::disk('public')->put($filename, $mpdf->Output($filename, 'S'));

        Mail::to('eduardo.dias092@gmail.com')
             ->send(new EnvioEmailApolice($assinatura, storage_path('app\public\\'.$filename), $adicionais));

        return 1;
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
            $newCliente->dataNascimento = date_create_from_format("d/m/Y", $data['datanasc']);

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
        return Validator::make($request, $this->regras($request["tipo_cadastro"]));
    }

    private function regras($tipoCadastro){
        $arrRegras = [
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

        if($tipoCadastro == "2"){
            $arrRegras['cpfcnpj'] = 'required|regex:/^\d{2}\.\d{3}\.\d{3}/\d{4}-\d{2}$/';
        }

        return $arrRegras;
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
            //$newAssinatura->cobertura_terceiros = $data['cobertura_terceiros'];
            $newAssinatura->melhor_vencimento = $data['melhor_vencimento'];
            $newAssinatura->tipo_pagamento = $data['forma_pagamento'];
            $newAssinatura->protecao_veicular = $data['comprar_protecao_veicular'];

            $result = $newAssinatura->save();

            $newAssinatura->codigo_assinatura = $this->getCogigoAssinatura($newAssinatura);

            $beneficios = isset($data['club_beneficio']) ? $data['club_beneficio'] : [];
            foreach($beneficios as $item){
                $adicionalAssinaturaValor = Adicionais_Assinatura::find($item);

                $adicionalAssinatura = new Assinatura_Adicionais_Assinatura;
                $adicionalAssinatura->assinatura_id = $newAssinatura->id;
                $adicionalAssinatura->adicional_assinatura_id = $item;
                $adicionalAssinatura->deletado = false;

                $newAssinatura->valor += $adicionalAssinaturaValor->valor;
                $adicionalAssinatura->save();
            }

            $coberturas = isset($data['cobertura_24horas']) ? $data['cobertura_24horas'] : [];

            foreach($coberturas as $item){
                $adicionalAssinaturaValor = Adicionais_Assinatura::find($item);

                $adicionalAssinatura = new Assinatura_Adicionais_Assinatura;
                $adicionalAssinatura->assinatura_id = $newAssinatura->id;
                $adicionalAssinatura->adicional_assinatura_id = $item;
                $adicionalAssinatura->deletado = false;

                $newAssinatura->valor += $adicionalAssinaturaValor->valor;
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

                $newAssinatura->valor += $adicionalAssinaturaValor->valor;
                $adicionalAssinatura->save();
            }

            $newAssinatura->save();

            DB::commit();

            return $newAssinatura;
        }catch(Exception $e){
            $result = 0;
            DB::rollBack();

            throw $e;
        }

        return null;
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

    private function getCogigoAssinatura($assinatura){
        return "AICBR-".date_format(date_create($assinatura->adesao), "Ydm")."".$assinatura->id;
    }

    private function enviarEmailBemvindo($ordercode, $emailCliente){

        $assinatura = DB::select('SELECT * from v_assinaturas_detalhe where codigo_assinatura = ?', [$ordercode]);
        if(count($assinatura) > 0)
            $assinatura = $assinatura[0];

        $adicionais = DB::select('SELECT * FROM v_adicionais_assinatura WHERE codigo_assinatura = ?', [$ordercode]);
        $filename = 'apolice_'.$ordercode.'.pdf';
        $mpdf = new PDF();

        $pathfile = storage_path('app\public\capa_apolice.pdf');
        $mpdf->SetSourceFile($pathfile);
        $tplId = $mpdf->ImportPage(1);
        $mpdf->useTemplate($tplId);

        // Do not add page until page template set, as it is inserted at the start of each page
        $pathfile = storage_path('app\public\template_apolice.pdf');
        $mpdf->SetSourceFile($pathfile);
        $tplId = $mpdf->ImportPage(1);
        $mpdf->SetPageTemplate($tplId);
        $mpdf->AddPage('P','','','','','','','25');

        $html = view('templates.apolice', ['assinatura' => $assinatura, 'adicionais' => $adicionais])->render();

        $mpdf->WriteHTML(strtoupper($html));
        Storage::disk('public')->put($filename, $mpdf->Output($filename, 'S'));

        Mail::to('eduardo.dias092@gmail.com')
             ->send(new EnvioEmailApolice($assinatura, storage_path('app\public\\'.$filename), $adicionais));

        return 1;
    }
}
