<?php

namespace App\Services\Integration;

interface IClientReceiverIntegrationService {
    public function getClientsFromReceiverService(int $page, array $filter);
}
