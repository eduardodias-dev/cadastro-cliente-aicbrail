<?php

namespace App\Services;

use App\Cliente;
use App\Veiculo;
use App\Dependente;
use App\Residencia;
use App\Services\IClienteDBService;

class ClienteDBService implements IClienteDBService{
    public function addClient($client){
        $newclient = new Cliente;

        $newclient['id_galaxPay'] = $client['id_galaxPay'];
        $newclient['nome'] = $client['nome'];
        $newclient['documento'] = $client['documento'];
        $newclient['status'] = $client['status'];
        $newclient['sexo'] = $client['sexo'];
        $newclient['dataNascimento'] = $client['dataNascimento'];

        $newclient->save();

    }

    public function addClientDependente($client, $dependente){
        $newdependente = new Dependente;

        $newdependente['parentesco'] = $dependente['dependenteParentesco'];
        $newdependente['cpf'] = $dependente['dependenteCpf'];
        $newdependente['nome'] = $dependente['dependenteNome'];
        $newdependente['dataNascimento'] = $dependente['dependenteDataNascimento'];
        $newdependente['sexo'] = $dependente['dependenteSexo'];
        $newdependente['cep'] = $dependente['dependenteCep'];
        $newdependente['endereco'] = $dependente['dependenteEndereco'];
        $newdependente['numero'] = $dependente['dependenteNumero'];
        $newdependente['complemento'] = $dependente['dependenteComplemento'];
        $newdependente['bairro'] = $dependente['dependenteBairro'];
        $newdependente['cidade'] = $dependente['dependenteCidade'];
        $newdependente['estado'] = $dependente['dependenteEstado'];
        $newdependente['cliente_id'] = $client['cliente_id'];

        $newdependente->save();
    }
    public function addClientResidencia($client, $residencia){
        $newResidencia = new Residencia();

        $newResidencia['cep'] = $residencia['residenciaCep'];
        $newResidencia['zona'] = $residencia['residenciaCpf'];
        $newResidencia['endereco'] = $residencia['residenciaNome'];
        $newResidencia['numero'] = $residencia['residenciaDataNascimento'];
        $newResidencia['complemento'] = $residencia['residenciaSexo'];
        $newResidencia['bairro'] = $residencia['residenciaBairro'];
        $newResidencia['cidade'] = $residencia['residenciaCidade'];
        $newResidencia['estado'] = $residencia['residenciaEstado'];
        $newResidencia['contatoNome'] = $residencia['residenciaContatoNome'];
        $newResidencia['contatoTelefone'] = $residencia['residenciaContatoTelefone'];
        $newResidencia['tipo'] = $residencia['residenciaTipo'];
        $newResidencia['cliente_id'] = $client['cliente_id'];

        $newResidencia->save();
    }
    public function addClientVeiculo($client, $veiculo){
        $newVeiculo = new Veiculo();

        $newVeiculo['chassi'] = $veiculo['veiculoChassi'];
        $newVeiculo['placa'] = $veiculo['veiculoPlaca'];
        $newVeiculo['renavam'] = $veiculo['veiculoRenavam'];
        $newVeiculo['tipo'] = $veiculo['veiculoTipo'];
        $newVeiculo['anoFabricacao'] = $veiculo['veiculoAnoFabricacao'];
        $newVeiculo['anoModelo'] = $veiculo['veiculoAnoModelo'];
        $newVeiculo['marca'] = $veiculo['veiculoMarca'];
        $newVeiculo['modelo'] = $veiculo['veiculoModelo'];
        $newVeiculo['cor'] = $veiculo['veiculoCor'];
        $newVeiculo['cambio'] = $veiculo['veiculoCambio'];
        $newVeiculo['fipeCodigo'] = $veiculo['veiculoFipeCodigo'];
        $newVeiculo['fipeValor'] = $veiculo['veiculoFipeValor'];
        $newVeiculo['cliente_id'] = $client['cliente_id'];

        $newVeiculo->save();
    }
    public function getClients(array $filter){
        return Cliente::where($filter)->get();
    }
    public function updateClient($client){
        $newclient = Cliente::find($client['id']);

        $newclient['id_galaxPay'] = $client['id_galaxPay'];
        $newclient['nome'] = $client['nome'];
        $newclient['documento'] = $client['documento'];
        $newclient['status'] = $client['status'];
        $newclient['sexo'] = $client['sexo'];
        $newclient['dataNascimento'] = $client['dataNascimento'];

        return $newclient->save();
    }
    public function deleteCliente(int $id){
        $client = Cliente::Find($id);

        return $client->delete();
    }
    public function getClientById(int $id){
        return Cliente::find($id);
    }
}
