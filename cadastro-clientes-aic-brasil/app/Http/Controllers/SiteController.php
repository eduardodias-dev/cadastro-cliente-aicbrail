<?php

namespace App\Http\Controllers;

use App\Plano;
use Exception;
use App\Pacote;
use App\Assinatura;
use \Mpdf\Mpdf as PDF;
use App\LogIntegracao;
use App\Services\CartHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Mail\EnvioEmailApolice;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\ViewModels\CheckoutViewModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SiteController extends Controller
{
    private $hash = "024c0b517d4c84afc32cc517ad1dd66e";
    private $minutesCookie = 7*24*60;

    public function home(Request $request){
        $affiliateId = $request->cookie('aid');

        if($request->input('aid') && ($affiliateId == '' || $affiliateId == null)){
            $affiliateId = $request->input('aid');
        }

        $response = response()->view('site.index');
        $response->cookie('aid', $affiliateId, $this->minutesCookie);
        return $response;
    }

    public function cart_add(Request $request)
    {
        $affiliateId = $request->cookie('aid');
        if($request->input('aid') && ($affiliateId == '' || $affiliateId == null)){
            $affiliateId = $request->input('aid');
        }

        session()->remove('erros');
        $data = $request->all();
        $validation = $this->validarCliente($data);

        //implementar aparição de erros na view.
        if($validation->fails()){
            // return response()->json([
            //     'success' => false,
            //     'message' => 'Ops... Parece que temos problemas com seus dados, por favor preencha corretamente :)',
            //     'errors' => json_encode($validation->errors())
            //     ]
            // );
            session()->flash('erros', $validation->errors());

            return redirect()->route('site.comprar_plano', ['id_plano' => $data['plan_id']])
                            ->withInput();
        }

        $data['valor_calculado'] = CartHelper::getValorCalculado($data, $data['plan_price']);

        $cart = session()->get('carrinho');
        $dados_cliente = session()->get('dados_cliente');
        if(!$cart)
        {
            if(!isset($cart[$data['plan_id']]))
            {
                $cart[$data['plan_id']] = $data;
            }
        }else{
            $cart[$data['plan_id']] = $data;
        }

        if(!$dados_cliente){
            session()->put('dados_cliente', $data);
        }

        session()->put('carrinho', $cart);

        $response = new Response('Redirecting ...',301);
        $response->cookie('aid', $affiliateId, $this->minutesCookie);

        return $response->withHeaders(['Location' => '/carrinho']);
    }

    public function cart(){
        $planos = Plano::where(['ativo_venda' => '1'])->get()->toArray();

        return view('site.cart', ['planos' => $planos]);
    }

    public function cart_remove(Request $request){
        $planId = $request->input('plan_id');
        $cart = session()->get('carrinho');

        if(isset($cart) && isset($cart[$planId]))
        {
            unset($cart[$planId]);
            if(count($cart) >= 1)
                session()->put('carrinho', $cart);
            else
                session()->remove('carrinho');
        }

        return redirect()->route('cart.index');
    }

    public function cart_clear(){
        $cart = session()->get('carrinho');
        if(isset($cart))
            session()->remove('carrinho');

        return redirect()->route('cart.index');
    }

    public function comprar_plano($id_plano){
        $checkoutViewModel = CheckoutViewModel::CreateStandardCheckoutView($id_plano);
        return view('site.comprar_plano', [
                                        'club_beneficio' => $checkoutViewModel->adicionais_club_beneficio,
                                        'cobertura_24horas' => $checkoutViewModel->adicionais_cobertura_24horas,
                                        'comprar_seguros' => $checkoutViewModel->adicionais_comprar_seguros,
                                        'plano' => $checkoutViewModel->plano,
                                        'session_id' => $checkoutViewModel->session_id
                                    ]);
    }

    public function checkout_post(Request $request)
    {
        try{
            $data = $request->all();
            $validation = $this->validarCliente($data, 1);

            if($validation->fails()){
                // return response()->json([
                //     'success' => false,
                //     'message' => 'Ops... Parece que temos problemas com seus dados, por favor preencha corretamente :)',
                //     'errors' => json_encode($validation->errors())
                //     ]
                // );
                session()->flash('erros', $validation->errors());
                Log::Debug(print_r($validation->errors));

                return redirect()->route('checkout.confirm')
                            ->withInput();
            }

            $cart = session()->get('carrinho');
            if(!isset($cart)){
                return redirect()->to('/');
            }

            $cart['dados_pagamento'] = ['cliente' => $data];
            $cart['codigo_afiliado'] = $request->cookie('aid');
            session()->flash('assinatura_criada', 1);

            $checkoutService = new CheckoutService();
            $result = $checkoutService->realizarCheckoutByCart($cart);

            session()->remove('carrinho');

            return redirect()->route('view.order', ['codigo_pacote' => $result['Subscription']['myId']]);
        }
        catch(Exception $e)
        {
            session()->flash('erros', $e->getMessage());

            throw $e;
            Log::Debug(print_r($e->getMessage()));

            return redirect()
                ->route('checkout.confirm')
                ->withInput();
        }
    }

    public function checkout_confirm(Request $request){
        $planos = Plano::where(['ativo_venda' => '1'])->get()->toArray();
        $session_id = session()->getId();

        $aid = $request->cookie('aid');

        return view('site.checkout_confirm',['session_id' => $session_id, 'planos' => $planos, 'aid' => $aid]);
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

        return view('site.order_partial', ['subscriptions' => $data, 'error' => $error]);
    }

    public function view_pacote(Request $request){
        $ordercode = $request->get('codigo_pacote');
        $result = DB::select('SELECT * from v_assinaturas_detalhe where codigo_pacote = ?', [$ordercode]);
        $pacote = Pacote::where(['codigo'=>$ordercode])->first();
        $error = (count($result) <= 0);
        $subscriptions = array();
        if(!$error){
            $data = (array)$result;
            foreach($data as $assinatura){
                $assinatura = (array)$assinatura;
                $adicionais = DB::select('SELECT * FROM v_adicionais_assinatura WHERE codigo_assinatura = ?', [$assinatura['codigo_assinatura']]);

                $transform_array = [];
                $grouped_array = array();
                foreach($adicionais as $adicional){
                    array_push($transform_array, (array)$adicional);
                }

                foreach($transform_array as $element){
                    $grouped_array[$element['tipo_adicional']][] = $element;
                }

                $assinatura['adicionais_assinatura'] = $grouped_array;
                array_push($subscriptions, $assinatura);
            }
            // die(json_encode($data['adicionais_assinatura']));
        }

        return view('site.vieworder', ['codigo_pacote' => $ordercode, 'subscriptions' => $subscriptions, 'error' => $error, 'pacote' => $pacote]);
    }

    public function download_apolice(Request $request){
        $codigo_pacote = $request->get('codigo_pacote');

        $checkoutService = new CheckoutService();
        $nomeArquivo = $checkoutService->gerarApolicePeloPacote($codigo_pacote);

        $arquivo = storage_path(getFilePathByArray(['app','public',$nomeArquivo]));

        return response()->file($arquivo, ['Content-disposition:attachment; filename="'.$nomeArquivo.'"']);
    }

    public function updateTransaction(Request $request)
    {
        $confirmHash = $request->get("confirmHash");

        if(!isset($confirmHash) || $confirmHash == "" || $confirmHash != $this->hash){
            return response()->json(['error' => 'Falha na autenticacao.'], 401);
        }

        $transaction = $request->get("Transaction");
        $subscriptionMyId = $transaction["subscriptionMyId"];
        $data = DB::select("SELECT * from v_assinaturas_integracao where codigo_assinatura = ?;", [$subscriptionMyId]);

        if(count($data) <= 0)
            return response()->json(['error' => 'Assinatura Nao encontrada.'], 404);

        if($transaction["status"] == "authorized" ||
            $transaction["status"] == "payedBoleto" ||
            $transaction["status"] == "payedPix")
            {
                $this->confirmarAssinatura($subscriptionMyId, $transaction);
            }

        $log = new LogIntegracao();
        $log->resultado = json_encode($request->all());
        $log->acao = 'Atualizar Status Pagamento';
        $log->data_integracao = date('Y-m-d H:i:s');
        $log->client_id = $data[0]->id_cliente;

        $log->save();

        return response()->json(['message' => 'Operacao executada com sucesso.'], 200);
    }

    public function list_plans(){
        $planos = Plano::where(['ativo_venda' => '1', 'juridico' => null])->orderBy('preco','asc')->get();
        $planosJuridicos = Plano::where(['ativo_venda' => '1', 'juridico' => '1'])->orderBy('preco','asc')->get();

        return view('site.list_plan', ['planos' => $planos, 'planosJuridicos' => $planosJuridicos]);
    }



    //Private methods

    private function validarCliente($request, $checkout = 0){
        return Validator::make($request, $this->regras($request["tipo_cadastro"], $checkout));
    }

    private function regras($tipoCadastro, $checkout){
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

        if($tipoCadastro == "J"){
            $arrRegras['cpfcnpj'] = 'required|regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/';
        }
        // if($checkout != 1){
        //     $arrRegras['tipo_veiculo'] = 'required|string';
        // }
        return $arrRegras;
    }

    private function enviarEmailBemvindo($ordercode, $emailCliente, $enviarApolice = 0){

        $assinatura = DB::select('SELECT * from v_assinaturas_detalhe where codigo_assinatura = ?', [$ordercode]);
        if(count($assinatura) > 0)
            $assinatura = $assinatura[0];

        $adicionais = DB::select('SELECT * FROM v_adicionais_assinatura WHERE codigo_assinatura = ?', [$ordercode]);

        $filename = $this->gerarApolice($ordercode, $assinatura, $adicionais);

        Mail::to($emailCliente)
             ->send(new EnvioEmailApolice($assinatura, storage_path('app/public/'.$filename), $adicionais, $enviarApolice));

        return 1;
    }

    private function gerarApolice($ordercode, $assinatura, $adicionais){
        $filename = 'apolice_'.$ordercode.'.pdf';
        $mpdf = new PDF();

        $pathfile = storage_path('app/public/capa_apolice.pdf');
        $mpdf->SetSourceFile($pathfile);
        $tplId = $mpdf->ImportPage(1);
        $mpdf->useTemplate($tplId);

        // Do not add page until page template set, as it is inserted at the start of each page
        $pathfile = storage_path('app/public/template_apolice.pdf');
        $mpdf->SetSourceFile($pathfile);
        $tplId = $mpdf->ImportPage(1);
        $mpdf->SetPageTemplate($tplId);
        $mpdf->AddPage('P','','','','','','','25');

        $html = view('templates.apolice', ['assinatura' => $assinatura, 'adicionais' => $adicionais])->render();

        $mpdf->WriteHTML(strtoupper($html));
        Storage::disk('public')->put($filename, $mpdf->Output($filename, 'S'));

        return $filename;
    }

    private function confirmarAssinatura($codigoAssinatura, $transactionPayload)
    {
        $assinaturas = DB::select('SELECT * from v_assinaturas_detalhe where codigo_assinatura = ?', [$codigoAssinatura]);
        if(count($assinaturas) > 0){
            $assinatura_detalhe = $assinaturas[0];

            $assinatura = Assinatura::find($assinatura_detalhe->id_assinatura);
            $assinatura->status = "ativa";

            $assinatura->save();
            $this->enviarEmailBemvindo($codigoAssinatura, $assinatura_detalhe->emails, 1);
        }
    }

}
