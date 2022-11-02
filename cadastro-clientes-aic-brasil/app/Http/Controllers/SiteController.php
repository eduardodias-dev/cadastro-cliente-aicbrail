<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\LogIntegracao;
use Exception;
use Illuminate\Http\Request;
use App\Services\IPlanoDBService;
use App\Services\IClienteDBService;
use App\Services\Integration\IClientSenderIntegrationService;
use App\Services\Integration\IClientReceiverIntegrationService;

class SiteController extends Controller
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

    public function customers(Request $request){
        // die(print_r($request->toArray()));
        $arrayRequest = $request->toArray();
        $response = $this->clientIntegrationService->getClientsFromSenderService(100, 'createdAt.desc', 0, $arrayRequest);

        return view('customers.index', ['clients' => $response->json()['Customers'], 'request' => $arrayRequest]);
    }

    public function customerById(int $id){
        $response = $this->clientIntegrationService->getClientFromSenderServiceById($id);
        if($response->successful() == false || count($response->json()['Customers']) <= 0){
            throw new Exception("Não foi possível recuperar o cliente. \n".json_encode($response->error()));
        }


        $customer = $response->json()['Customers'][0];
        $response = $this->clientIntegrationService->getClientSubscriptions(0, 100, ['customerGalaxPayIds' => $customer['galaxPayId']]);

        return view('customers.detail', ['client' => $customer, 'subscriptions' => $response->json()['Subscriptions']]);
    }

    public function getPlans(Request $request){
        $galaxpay_plans = $this->clientIntegrationService->getPlans(0,100,$request->toArray());
        $plans = $this->planoDBservice->getPlans([]);
        $addedPlans = [];

        foreach($plans as $plan){
            array_push($addedPlans, $plan['id_galaxpay']);
        }

        return view('plans.index', ['plans' => $plans, 'galaxPayPlans' => $galaxpay_plans->json()['Plans'], 'addedPlans' => $addedPlans]);
    }
    public function addPlan(Request $request){
        $plan = $this->clientIntegrationService->getPlans(0,1,['galaxPayIds' => $request['galaxPayId']]);

        $this->planoDBservice->addPlan($plan['Plans'][0]);

        return redirect('/plans');
    }
    public function activatePlan(Request $request){
        $this->planoDBservice->activate($request['galaxPayId']);

        return redirect('/plans');
    }
    public function deactivatePlan(Request $request){
        $this->planoDBservice->deactivate($request['galaxPayId']);

        return redirect('/plans');
    }

    public function subscriptions(Request $request){
        $plans = $this->planoDBservice->getPlans(['ativo' => 1]);
        $addedPlans = [];

        foreach($plans as $plan){
            array_push($addedPlans, $plan['id_galaxpay']);
        }

        $response = $this->clientIntegrationService->getClientSubscriptions(0, 100, ['planGalaxPayIds' => implode(',', $addedPlans)]);

        return view('subscriptions.index', ['subscriptions' => $response->json()['Subscriptions']]);
    }

    public function subscriptionById(int $id){
        $response = $this->clientIntegrationService->getClientSubscriptions(0, 100, ['galaxPayIds' => $id]);
        if($response->successful() == false || count($response->json()['Subscriptions']) <= 0){
            throw new Exception("Não foi possível recuperar a assinatura. \n".json_encode($response->error()));
        }

        $subscriptions = $response->json()['Subscriptions'];

        $clientId = $subscriptions[0]['Customer']['galaxPayId'];
        $response = $this->clientIntegrationService->getClientFromSenderServiceById($clientId);

        if($response->successful() == false || count($response->json()['Customers']) <= 0){

            throw new Exception("Não foi possível recuperar o cliente. \n".json_encode($response->error()));
        }

        $client = $response->json()['Customers'][0];

        return view('subscriptions.detail', ['client' => $client, 'subscriptions' => $subscriptions]);
    }

    public function addSubscriptionById(Request $request){
        $id = $request['id'];
        $response = $this->clientIntegrationService->getClientSubscriptions(0, 100, ['galaxPayIds' => $id]);
        if($response->successful() == false || count($response->json()['Subscriptions']) <= 0){
            die(print_r($response));
            throw new Exception("Não foi possível recuperar a assinatura. \n".json_encode($response->error()));
        }
        $subscriptions = $response->json()['Subscriptions'];

        $savedData = $this->clienteDBservice->addClientFromSubscription($subscriptions[0]);

        $response = $this->clientIntegrationService->getClientFromSenderServiceById($subscriptions[0]['Customer']['galaxPayId']);

        if($response->successful() == false || count($response->json()['Customers']) <= 0){

            throw new Exception("Não foi possível recuperar o cliente. \n".json_encode($response->error()));
        }

        $client = $response->json()['Customers'][0];

        return view('subscriptions.detail', ['client' => $client, 'subscriptions' => $subscriptions]);
    }

    public function integrateClientFromGalaxPay(Request $request){
        $galaxPayId = $request['id_galaxpay'];

        $response = $this->clientIntegrationService->getClientFromSenderServiceById($galaxPayId);
        if($response->successful() == false || count($response->json()['Customers']) <= 0){
            throw new Exception("Não foi possível recuperar o cliente. \n".json_encode($response->error()));
        }

        $customer = $response->json()['Customers'][0];
        $log = new LogIntegracao;

        if($customer['status'] == 'active'){
            $savedData = $this->clientReceiverIntegrationService->addBeneficiaryVehicle($customer);
            $log['acao'] = 'Adicionar';
        }
        else{
            $savedData = $this->clientReceiverIntegrationService->removeBeneficiaryVehicle($customer);
            $log['acao'] = 'Remover';
        }

        $client = Cliente::where(['id_galaxpay' => $galaxPayId])->first();

        $log['data_integracao'] = date_create('now');
        $log['resultado'] = json_encode($savedData);
        $log['client_id'] = $client['id'];

        $log->save();

        if(isset($savedData['codigo'])){
            $client['codigo_logica'] = $savedData['codigo'];
        }
        $client['status'] = $customer['status'];
        $client->save();

        session()->flash('dados_integracao', $savedData['retorno']);

        return redirect()->route('client.detail', ['id' => $request['id']]);
    }

}
