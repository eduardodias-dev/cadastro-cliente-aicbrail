<?php

namespace App\Http\Controllers;

use App\Services\Integration\IClientSenderIntegrationService;
use App\Services\IPlanoDBService;
use Exception;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    //
    private $clientIntegrationService = null;
    private $planoDBservice = null;
    public function __construct(IClientSenderIntegrationService $iClientIntegrationService,
                                IPlanoDBService $planoDBservice){
        $this->clientIntegrationService = $iClientIntegrationService;
        $this->planoDBservice = $planoDBservice;
    }

    public function home(Request $request){
        return view("site.home", ['message' => "AIC Brasil", "name" => $request['name']]);
    }

    public function clients(Request $request){
        // die(print_r($request->toArray()));
        $arrayRequest = $request->toArray();
        $response = $this->clientIntegrationService->getClientsFromSenderService(100, 'createdAt.desc', 0, $arrayRequest);

        return view('clients.index', ['clients' => $response->json()['Customers'], 'request' => $arrayRequest]);
    }

    public function clientById(int $id){
        $response = $this->clientIntegrationService->getClientFromSenderServiceById($id);
        if($response->successful() == false || count($response->json()['Customers']) <= 0){
            throw new Exception("Não foi possível recuperar o cliente. \n".json_encode($response->error()));
        }


        $client = $response->json()['Customers'][0];
        $response = $this->clientIntegrationService->getClientSubscriptions(0, 100, ['customerGalaxPayIds' => $client['galaxPayId']]);

        return view('clients.detail', ['client' => $client, 'subscriptions' => $response->json()['Subscriptions']]);
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
        $response = $this->clientIntegrationService->getClientFromSenderServiceById($id);
        if($response->successful() == false || count($response->json()['Customers']) <= 0){
            throw new Exception("Não foi possível recuperar o cliente. \n".json_encode($response->error()));
        }


        $client = $response->json()['Customers'][0];
        $response = $this->clientIntegrationService->getClientSubscriptions(0, 100, ['customerGalaxPayIds' => $client['galaxPayId']]);

        return view('clients.detail', ['client' => $client, 'subscriptions' => $response->json()['Subscriptions']]);
    }
}
