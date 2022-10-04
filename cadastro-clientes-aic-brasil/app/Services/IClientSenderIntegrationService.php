<?php

namespace App\Services;

interface IClientSenderIntegrationService{
    public function getClientsFromSenderService(int $limit, string $orderby, int $startAt, array $filter);
}
