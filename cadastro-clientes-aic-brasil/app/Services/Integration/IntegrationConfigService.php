<?php

namespace App\Services\Integration;

class IntegrationConfigService implements IIntegrationConfigService{
    public function getSenderServiceConfig()
    {
        return array(
            'galaxID' => '2976',
            'galaxHash' => 'XlE71qUbKn1o53UnXqG4I40fIiOpWqVfFf77N5Py',
            'URL' => 'https://api.galaxpay.com.br/v2'
            // 'galaxID' => '5473',
            // 'galaxHash' => '83Mw5u8988Qj6fZqS4Z8K7LzOo1j28S706R0BeFe',
            // 'URL' => 'https://api.sandbox.cloud.galaxpay.com.br/v2'
        );
    }

    public function getReceiverServiceConfig(){
        // return array(
        //     "usuario"       => "SISTEMAAICBRASIL",
        //     "senha"         => "B84E2D4A2214E7D9",
        //     "clienteCNPJ"   => "21135451000106",
        //     "URL"           => "http://assistencia.logicasolucoes.com.br/assistme/"
        // );
        return array(
            "usuario"       => "testeIntegracao",
            "senha"         => "teste",
            "clienteCNPJ"   => "18965673000141",
            "URL"           => "http://assistencia.logicasolucoes.com.br/teste/"
        );
    }
}
