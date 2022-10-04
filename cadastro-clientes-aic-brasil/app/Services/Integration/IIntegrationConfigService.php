<?php

namespace App\Services\Integration;

interface IIntegrationConfigService{
    public function getSenderServiceConfig();
    public function getReceiverServiceConfig();
}
