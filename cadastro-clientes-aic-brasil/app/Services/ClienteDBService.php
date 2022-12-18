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
        $newResidencia['complemento'] = isset($residencia['residenciaSexo']) && !empty($residencia['residenciaSexo']) ? $residencia['residenciaSexo'] : "-";
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
        $newVeiculo['client_id'] = isset($client['cliente_id']) ? $client['cliente_id'] : $client['id'];

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
            if(!isset($client['emails']) && count($emails) > 0)
                $client['emails'] = $emails[0]->endereco;

            // foreach($emails as $email){
            //     if(!isset($client['emails']))
            //         $client['emails'] = array($email->endereco);
            //     else
            //         array_push($client['emails'], $email->endereco);
            // }

            $telefones = Telefone::where($filter)->get();
            if(!isset($client['telefones']) && count($telefones) > 0)
                $client['telefones'] = $telefones[0]->numero;


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

        $newclient = Cliente::where(['id_galaxpay' => $customer['galaxPayId']])->first();
        if($newclient == null)
            $newclient = new Cliente;

        $newclient['id_galaxPay'] = $customer['galaxPayId'];
        $newclient['nome'] = $customer['name'];
        $newclient['documento'] = $customer['document'];
        $newclient['status'] = isset($subscription['status']) ? $subscription['status'] : 'unknown';
        $newclient['sexo'] = $this->getValueFromExtraFields("CP_SEXO", $subscription);
        $newclient['dataNascimento'] = date_create_from_format('d/m/Y', $this->getValueFromExtraFields("CP_DATA_DE_NASCIMENTO", $subscription));
        $newclient['criadoEm'] = date_create();
        $newclient['atualizadoEm'] = date_create();

        $newclient->save();

        if(isset($customer['Address']) && !empty($customer['Address'])){
            $address = $customer['Address'];

            $newAddress = Endereco::where(['client_id' => $newclient->id])->first();
            if($newAddress == null)
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

                $telefoneExistent = Telefone::where(['client_id' => $newclient->id, 'numero' => $phone])->first();
                if($telefoneExistent == null){
                    $newTelefone = new Telefone;

                    $newTelefone['client_id'] = $newclient->id;
                    $newTelefone['numero'] = $phone;

                    $newTelefone->save();
                }
            }
        }

        if(isset($customer['emails']) && !empty($customer['emails'])){
            foreach($customer['emails'] as $email){

                $emailExistent = Email::where(['client_id' => $newclient->id, 'endereco' => $email])->first();
                if($emailExistent == null){
                    $newEmail = new Email;

                    $newEmail['client_id'] = $newclient->id;
                    $newEmail['endereco'] = $email;

                    $newEmail->save();
                }
            }
        }

        $placa_chassi_renavam = $this->getValueFromExtraFields('CP_PLACA_CHASSI_E_RENAVAM', $subscription);

        $veiculoExistent = Veiculo::where(['placa' => explode(' ', $placa_chassi_renavam)])->first();
        if($veiculoExistent == null){
            $veiculo = $this->getVehicleFromExtraFields($subscription);
            $this->addClientVeiculo($newclient, $veiculo);
        }


        return 1;
    }

    protected function getValueFromExtraFields($tagName, $subscription){
        $value = "";
        foreach($subscription['Customer']['ExtraFields'] as $extrafield)
        {
            if($extrafield['tagName'] == $tagName){
                $value = $extrafield['tagValue'];
            }
        }

        return $value;
    }
    protected function getVehicleFromExtraFields($subscription){
        $extrafields = array();

        foreach($subscription['Customer']['ExtraFields'] as $extrafield)
        {
            $extrafields[$extrafield['tagName']] = $extrafield['tagValue'];
        }

        $placa_chassi_renavam = explode(' ', isset($extrafields['CP_PLACA_CHASSI_E_RENAVAM'])?$extrafields['CP_PLACA_CHASSI_E_RENAVAM'] : "");
        $ano_fabricacao_modelo = explode('/', isset($extrafields['CP_ANO_DE_FABRICACAO'])?$extrafields['CP_ANO_DE_FABRICACAO'] : "");

        $veiculo['veiculoChassi'] = isset($extrafields['CP_CHASSI']) ? $extrafields['CP_CHASSI'] : 'Não Informado';;
        $veiculo['veiculoPlaca'] = isset($placa_chassi_renavam[0]) && !empty($placa_chassi_renavam[0]) ? $placa_chassi_renavam[0] : 'Não Informado';
        $veiculo['veiculoRenavam'] = isset($placa_chassi_renavam[1]) && !empty($placa_chassi_renavam[1]) ? $placa_chassi_renavam[1] : 'Não Informado';
        $veiculo['veiculoTipo'] = isset($extrafields['CP_TIPO_DO_VEICULO']) ? $extrafields['CP_TIPO_DO_VEICULO'] : 'Não Informado';
        $veiculo['veiculoAnoFabricacao'] = isset($ano_fabricacao_modelo[0]) && !empty($ano_fabricacao_modelo[0]) ? $ano_fabricacao_modelo[0] : 0;
        $veiculo['veiculoAnoModelo'] = isset($ano_fabricacao_modelo[1]) && !empty($ano_fabricacao_modelo[1]) ? $ano_fabricacao_modelo[1] : 0;
        $veiculo['veiculoMarca'] = isset($extrafields['CP_MARCA_TIPO']) ? $extrafields['CP_MARCA_TIPO'] : 'Não Informado';
        $veiculo['veiculoModelo'] = isset($extrafields['CP_ANO_MODELO']) ? $extrafields['CP_ANO_MODELO'] : 'Não Informado';
        $veiculo['veiculoCor'] = isset($extrafields['CP_COR']) ? $extrafields['CP_COR'] : 'Não Informado';
        $veiculo['veiculoCambio'] = isset($extrafields['CP_CAMBIO']) ? $extrafields['CP_CAMBIO'] : 'Não Informado';
        $veiculo['veiculoFipeCodigo'] = isset($extrafields['CP_FIPE_CODIGO']) ? $extrafields['CP_FIPE_CODIGO'] : 'Não Informado';
        $veiculo['veiculoFipeValor'] = isset($extrafields['CP_FIPE_VALOR']) ? $extrafields['CP_FIPE_VALOR'] : 'Não Informado';

        return $veiculo;
    }
}
