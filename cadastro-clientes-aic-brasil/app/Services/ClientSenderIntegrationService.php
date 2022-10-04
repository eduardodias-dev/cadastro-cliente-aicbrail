<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Services\Integration\IIntegrationConfigService;
use App\Token;

class ClientSenderIntegrationService implements IClientSenderIntegrationService{

    private $integrationService;
    public function __construct(IIntegrationConfigService $service)
    {
        $this->integrationService = $service;
    }

    public function getClientsFromSenderService(int $limit, string $orderby, int $startAt, array $filter){
        $configs = $this->integrationService->getSenderServiceConfig();

        $filter['limit'] = $limit;
        $filter['order'] = $orderby;
        $filter['startAt'] = $startAt;

        $token_object = $this->getToken("customer.read");

        $response = Http::withToken($token_object['access_token'])
                        ->get($configs['URL'].'/customers', $filter);

        return $response;
    }

    private function getToken(string $scopes){
        $token = Token::orderByDesc('expires_in')->first();

        if($token != null){
            $now = strtotime('now');

            if($now > strtotime($token['expires_in']) || !str_contains($token['scope'], $scopes)){
                $token = $this->requestTokenFromExternalService($scopes);
            }
        }else{
            $token = $this->requestTokenFromExternalService($scopes);
        }
        return $token;
    }

    private function requestTokenFromExternalService(string $scopes){
        $configs = $this->integrationService->getSenderServiceConfig();
        $request = Http::withBasicAuth($configs['galaxID'], $configs['galaxHash'])
                        ->post($configs['URL'].'/token',
                        [
                            "grant_type" => "authorization_code",
                            "scope"      => $scopes
                        ]);

        $expires_in = intval($request['expires_in']);

        $token = new Token;
        $token['access_token'] = $request['access_token'];
        $token['token_type']   = $request['token_type'];
        $token['scope']        = $request['scope'];
        $token['expires_in']   = date('Y-m-d H:i:s', $expires_in+strtotime('now'));

        $token->save();

        return $token;
    }
}
