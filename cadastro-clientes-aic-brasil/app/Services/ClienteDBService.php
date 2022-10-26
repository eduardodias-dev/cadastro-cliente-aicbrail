<?php

namespace App\Services;

use App\Cliente;
use App\Veiculo;
use App\Endereco;
use App\Telefone;
use App\Dependente;
use App\Email;
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
        $client = Cliente::find($id);

        if(!empty($client)){
            $filter = ['client_id' => $client['id']];
            $emails = Email::where($filter)->get();

            foreach($emails as $email){
                if(!isset($client['emails']))
                    $client['emails'] = array($email->endereco);
                else
                    array_push($client['emails'], $email->endereco);
            }
            $telefones = Telefone::where($filter)->get();
            foreach($telefones as $telefone){
                if(!isset($client['telefones']))
                    $client['telefones'] = array($telefone->numero);
                else
                    array_push($client['telefones'], $telefone->numero);
            }

            $endereco = Endereco::where($filter)->first();
            $client['endereco'] = $endereco;

            $veiculo = Veiculo::where($filter)->first();

            if(!empty($veiculo)){
                $client['veiculo'] = $veiculo;
            }
        }

        return $client;
    }

    public function addClientFromSubscription($subscription){
        $customer = $subscription['Customer'];

        $newclient = new Cliente;
        $newclient['id_galaxPay'] = $customer['galaxPayId'];
        $newclient['nome'] = $customer['name'];
        $newclient['documento'] = $customer['document'];
        $newclient['status'] = $customer['status'];
        $newclient['sexo'] = 'Masculino';
        //$newclient['dataNascimento'] = $customer['dataNascimento'];
        $newclient['dataNascimento'] = date_create();
        $newclient['criadoEm'] = date_create();
        $newclient['atualizadoEm'] = date_create();

        $newclient->save();

        if(isset($customer['Address']) && !empty($customer['Address'])){
            $address = $customer['Address'];

            $newAddress = new Endereco;

            $newAddress['client_id'] = $newclient->id;
            $newAddress['cep'] = $address['zipCode'];
            $newAddress['rua'] = $address['street'];
            $newAddress['numero'] = $address['number'];
            $newAddress['complemento'] = $address['complement'];
            $newAddress['bairro'] = $address['neighborhood'];
            $newAddress['cidade'] = $address['city'];
            $newAddress['estado'] = $address['state'];

            $newAddress->save();
        }

        if(isset($customer['phones']) && !empty($customer['phones'])){
            foreach($customer['phones'] as $phone){
                $newTelefone = new Telefone;

                $newTelefone['client_id'] = $newclient->id;
                $newTelefone['numero'] = $phone;

                $newTelefone->save();
            }
        }

        if(isset($customer['emails']) && !empty($customer['emails'])){
            foreach($customer['emails'] as $email){
                $newEmail = new Email;

                $newEmail['client_id'] = $newclient->id;
                $newEmail['endereco'] = $email;

                $newEmail->save();
            }
        }

        return 1;
    }
}
