<?php

namespace App\Services\Integration;

class IntegrationConfigService implements IIntegrationConfigService{
    public function getSenderServiceConfig()
    {
        return array(
            'galaxID' => '5473',
            'galaxHash' => '83Mw5u8988Qj6fZqS4Z8K7LzOo1j28S706R0BeFe',
            'URL' => 'https://api.sandbox.cloud.galaxpay.com.br/v2'
        );
    }

    public function getReceiverServiceConfig(){
        return array(
            "usuario"   => "SISTEMAAICBRASIL",
            "senha"     => "B84E2D4A2214E7D9",
            "URL"       => "http://assistencia.logicasolucoes.com.br/assistme/"
        );
    }
}
