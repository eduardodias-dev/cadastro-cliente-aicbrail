<?php

namespace App\Services;

interface IClienteDBService {
    public function addClient($client);
    public function addClientDependente($client, $dependente);
    public function addClientResidencia($client, $residencia);
    public function addClientVeiculo($client, $veiculo);
    public function getClients(array $filter);
    public function updateClient($client);
    public function deleteCliente(int $id);
    public function getClientById(int $id);
}
