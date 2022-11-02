<?php

namespace App\Services\Integration;

interface IClientReceiverIntegrationService {
    public function getClientsFromReceiverService(int $page, array $filter);
    public function addBeneficiaryVehicle($client);
    public function removeBeneficiaryVehicle($client);
}
