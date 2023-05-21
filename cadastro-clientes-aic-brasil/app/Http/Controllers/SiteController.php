<?php

namespace App\Http\Controllers;

use App\Plano;
use Exception;
use App\Assinatura;
use \Mpdf\Mpdf as PDF;
use Illuminate\Http\Request;
use App\Mail\EnvioEmailApolice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\LogIntegracao;
use App\Services\CheckoutService;
use Illuminate\Support\Facades\Validator;
use App\ViewModels\CheckoutViewModel;

class SiteController extends Controller
{
    private $hash = "024c0b517d4c84afc32cc517ad1dd66e";
    public function home(){
        return view('site.index');
    }

    public function cart_add(Request $request)
    {
        $data = $request->all();
        $validation = $this->validarCliente($data);

        //implementar aparição de erros na view.
        if($validation->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Ops... Parece que temos problemas com seus dados, por favor preencha corretamente :)',
                'errors' => json_encode($validation->errors())
                ]
            );
        }
        $data['valor_calculado'] = $data['plan_price'];
        $cart = session()->get('carrinho');
        if(!$cart)
        {
            if(!isset($cart[$data['plan_id']]))
            {
                $cart[$data['plan_id']] = $data;
            }
        }else{
            $cart[$data['plan_id']] = $data;
        }

        session()->put('carrinho', $cart);

        return redirect()->route('cart.index');
    }

    public function cart(Request $request){
        $planos = Plano::where(['ativo_venda' => '1'])->get()->toArray();

        return view('site.cart', ['planos' => $planos]);
    }

    public function cart_remove(Request $request){
        return view('site.cart');
    }

    public function cart_clear(Request $request){
        return view('site.cart');
    }

    public function checkout($id_plano){
        $checkoutViewModel = CheckoutViewModel::CreateStandardCheckoutView($id_plano);
        return view('site.checkout', [
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
            $validation = $this->validarCliente($data);

            if($validation->fails()){
                return response()->json([
                    'success' => false,
                    'message' => 'Ops... Parece que temos problemas com seus dados, por favor preencha corretamente :)',
                    'errors' => json_encode($validation->errors())
                    ]
                );
            }

            $plano = Plano::find($data['plan_id']);
            $data['valor_calculado'] = $plano->preco;

            $checkoutService = new CheckoutService();
            $result = $checkoutService->realizarCheckout($data);

            return response()->json([
                'success' => true,
                'message' => 'Adicionado com sucesso!',
                'result' => json_encode($result->json())
            ]);
        }
        catch(Exception $e)
        {
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

        if($tipoCadastro == "J"){
            $arrRegras['cpfcnpj'] = 'required|regex:/^\d{2}\.\d{3}\.\d{3}\/\d{4}-\d{2}$/';
        }

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
