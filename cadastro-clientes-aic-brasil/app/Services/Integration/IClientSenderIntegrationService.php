<?php

namespace App\Services\Integration;

interface IClientSenderIntegrationService{
    public function getClientsFromSenderService(int $limit, string $orderby, int $startAt, array $filter);
    public function getClientSubscriptions(int $startAt, int $limit, array $filter);
    public function getClientFromSenderServiceById(int $galaxPayId);
    public function getPlans(int $startAt, int $limit, array $filter);
    public function getSubscriptionTransactions(int $startAt, int $limit, array $filter);
}
