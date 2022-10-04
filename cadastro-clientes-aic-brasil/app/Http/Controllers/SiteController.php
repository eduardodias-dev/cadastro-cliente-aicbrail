<?php

namespace App\Http\Controllers;

use App\Services\IClientSenderIntegrationService;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    //
    private $clientIntegrationService = null;
    public function __construct(IClientSenderIntegrationService $iClientIntegrationService){
        $this->clientIntegrationService = $iClientIntegrationService;
    }

    public function home(Request $request){
        return view("site.home", ['message' => "AIC Brasil", "name" => $request['name']]);
    }

    public function clients(Request $request){
        $response = $this->clientIntegrationService->getClientsFromSenderService(10, 'createdAt.asc', 1, $request->toArray());

        return view('clients.index', ['clients' => $response->json()['Customers']]);
    }
}
