<?php

namespace App\Services\Integration;

use Illuminate\Support\Facades\Http;

class ClientReceiverIntegrationService implements IClientReceiverIntegrationService {
    private $integrationConfigService;
    public function __construct(IIntegrationConfigService $iIntegrationConfigService)
    {
        $this->integrationConfigService = $iIntegrationConfigService;
    }

    public function getClientsFromReceiverService(int $page, array $filter){
        $configs = $this->integrationConfigService->getReceiverServiceConfig();
        $filter["usuario"] = $configs["usuario"];
        $filter["senha"] = $configs["senha"];
        $filter["clienteCNPJ"] = $configs["clienteCNPJ"];
        $filter["pagina"] = $page;

        $response = Http::post($configs["URL"], $filter);

        return $response;
    }
}
