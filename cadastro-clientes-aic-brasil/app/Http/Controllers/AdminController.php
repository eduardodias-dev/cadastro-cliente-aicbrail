<?php

namespace App\Http\Controllers;

use Exception;
use App\Pacote;
use App\Cliente;
use App\LogIntegracao;
use Illuminate\Http\Request;
use App\Services\IPlanoDBService;
use Illuminate\Support\Facades\DB;
use App\Services\IClienteDBService;
use App\Services\Integration\IClientSenderIntegrationService;
use App\Services\Integration\IClientReceiverIntegrationService;

class AdminController extends Controller
{
    //
    private $clientIntegrationService = null;
    private $planoDBservice = null;
    private $clienteDBservice = null;
    private $clientReceiverIntegrationService;
    public function __construct(IClientSenderIntegrationService $iClientIntegrationService,
                                IPlanoDBService $planoDBservice,
                                IClienteDBService $clienteDBservice,
                                IClientReceiverIntegrationService $iClientReceiverIntegrationService){
        $this->clientIntegrationService = $iClientIntegrationService;
        $this->planoDBservice = $planoDBservice;
        $this->clienteDBservice = $clienteDBservice;
        $this->clientReceiverIntegrationService = $iClientReceiverIntegrationService;
    }

    public function home(Request $request){
        return view("site.home", ['message' => "AIC Brasil", "name" => $request['name']]);
    }

    public function clients(Request $request){
        $arrayRequest = $request->toArray();
        $clients = $this->clienteDBservice->getClients($arrayRequest);

        return view('clients.index', ['clients' => $clients, 'request' => $arrayRequest]);
    }

    public function clientById(int $id){
        $client = $this->clienteDBservice->getClientById($id);

        if(!isset($client) || empty($client)){
            throw new Exception("Não foi possível recuperar o cliente. \n");
        }
        $logs = LogIntegracao::where(['client_id'=> $client['id']])->orderBy('id', 'desc')->get();

        return view('clients.detail', ['client' => $client, 'logs'=>$logs]);
    }

    public function getPlans(Request $request){
        //$galaxpay_plans = $this->clientIntegrationService->getPlans(0,100,$request->toArray());
        $plans = $this->planoDBservice->getPlans([]);
        $addedPlans = [];

        foreach($plans as $plan){
            array_push($addedPlans, $plan['id_galaxpay']);
        }

        return view('plans.index', ['plans' => $plans, 'addedPlans' => $addedPlans]);
    }

    public function getLogs(){
        $list = DB::select("SELECT i.id, c.id `client_id`, c.nome, c.documento, c.`status`, c.codigo_logica, i.resultado,i.acao,"
        ." data_integracao"
        ." FROM cliente c "
        ." INNER JOIN log_integracao i ON i.client_id = c.id"
        ." ORDER BY i.id DESC");

        $logs = array_map(function($obj){
            return (array)$obj;
        }, $list);

        return view('logs.index', ['logs' => $logs]);

    }

    public function pacotes(Request $request){
        $pacotes = DB::select("select * from v_pacote_integracao");

        return view('pacotes.index', ['pacotes' => $pacotes]);
    }

    public function pacotesById(int $id){
        $pacote = DB::select("SELECT * from v_pacote_integracao where id_pacote = ?", [$id])[0];
        $result = DB::select("SELECT * from v_assinaturas_detalhe where codigo_pacote = ?", [$pacote->codigo]);
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

        return view('pacotes.detail', ['pacote' => $pacote, 'subscriptions' => $subscriptions, 'error' => $error]);
    }

    public function afiliados(){
        $afiliados = DB::select("select * from v_codigo_afiliados");

        return view('afiliados.index', ['afiliados'=>$afiliados]);
    }

    public function novoAfiliado(Request $request){
        $id_afiliado = $request->input('id_afiliado');
        $nomeAfiliado = $request->input('nomeAfiliado');
        $codigoAtual = $request->input('codigoAtual');
        $novoCodigo = $request->input('novoCodigo');

        die(json_encode([
                'id_afiliado' => $id_afiliado,
                'nomeAfiliado' => $nomeAfiliado,
                'codigoAtual' => $codigoAtual,
                'novoCodigo' => $novoCodigo
            ]
        ));
    }
}
