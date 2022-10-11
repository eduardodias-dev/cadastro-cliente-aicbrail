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
        $response = $this->clientIntegrationService->getPlans(0,100,$request->toArray());

        return view('plans.index', ['plans' => $response->json()['Plans']]);
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
}
