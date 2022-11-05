<?php

namespace App\Services\Integration;

use Exception;
use App\Cliente;
use App\Veiculo;
use App\Endereco;
use Illuminate\Support\Facades\Http;

class ClientReceiverIntegrationService implements IClientReceiverIntegrationService {
    private $integrationConfigService;
    private const PLANO_CODIGO = 'TST01';
    private const PLANO_TIPO_VEICULO = 'VEICULO';

    public function __construct(IIntegrationConfigService $iIntegrationConfigService)
    {
        $this->integrationConfigService = $iIntegrationConfigService;
    }

    public function getClientsFromReceiverService(int $page, array $filter){
        $configs = $this->integrationConfigService->getReceiverServiceConfig();
        $filter["usuario"] = $configs["usuario"];
        $filter["senha"] = $configs["senha"];
        $filter["clienteCNPJ"] = $configs["clienteCNPJ"];
        $filter["pagina"] = $page;

        $response = Http::post($configs["URL"], $filter);

        return $response;
    }

    public function addBeneficiaryVehicle($client){
        $clientDB = Cliente::where(['id_galaxpay' => $client['galaxPayId']])->first();
        $enderecoClientDB = Endereco::where(['client_id' => $clientDB['id']])->first();
        $veiculoClientDB = Veiculo::where(['client_id' => $clientDB['id']])->first();

        $requestClient['planoCodigo'] = self::PLANO_CODIGO;
        $requestClient['beneficiarioCpf'] = $clientDB['documento'];
        $requestClient['beneficiarioNome'] = $clientDB['nome'];
        $requestClient['beneficiarioDataNascimento'] = $clientDB['dataNascimento'];
        $requestClient['beneficiarioSexo'] = $clientDB['sexo'];
        $requestClient['beneficiarioCep'] = $clientDB['documento'];
        $requestClient['beneficiarioEnderecoCep'] = $enderecoClientDB['cep'];
        $requestClient['beneficiarioEnderecoEndereco'] = $enderecoClientDB['rua'];
        $requestClient['beneficiarioEnderecoNumero'] = $enderecoClientDB['numero'];
        $requestClient['beneficiarioEnderecoComplemento'] = $enderecoClientDB['complemento'];
        $requestClient['beneficiarioEnderecoBairro'] = $enderecoClientDB['bairro'];
        $requestClient['beneficiarioEnderecoCidade'] = $enderecoClientDB['cidade'];
        $requestClient['beneficiarioEnderecoEstado'] = $enderecoClientDB['estado'];
        $requestClient['tipo'] = self::PLANO_TIPO_VEICULO;
        $requestClient['veiculoChassi'] = $veiculoClientDB['chassi'];
        $requestClient['veiculoPlaca'] = $veiculoClientDB['placa'];
        $requestClient['veiculoRenavam'] = $veiculoClientDB['renavam'];
        $requestClient['veiculoTipo'] = $veiculoClientDB['tipo'];
        $requestClient['veiculoAnoFabricacao'] = $veiculoClientDB['anoFabricacao'];
        $requestClient['veiculoAnoModelo'] = $veiculoClientDB['anoModelo'];
        $requestClient['veiculoMarca'] = $veiculoClientDB['marca'];
        $requestClient['veiculoModelo'] = $veiculoClientDB['modelo'];
        $requestClient['veiculoCor'] = $veiculoClientDB['cor'];

        $configs = $this->integrationConfigService->getReceiverServiceConfig();

        $requestClient["usuario"] = $configs["usuario"];
        $requestClient["senha"] = $configs["senha"];
        $requestClient["clienteCNPJ"] = $configs["clienteCNPJ"];

        $response = Http::asForm()->post($configs['URL'].'cadastroService/incluir', $requestClient);

        if($response->failed())
            throw new Exception($response->json());

        return $response->json();
    }

    public function removeBeneficiaryVehicle($client){
        $clientDB = Cliente::where(['id_galaxpay' => $client['galaxPayId']])->first();

        $requestClient['codigo'] = $clientDB['codigo_logica'];
        $configs = $this->integrationConfigService->getReceiverServiceConfig();

        $requestClient["usuario"] = $configs["usuario"];
        $requestClient["senha"] = $configs["senha"];
        $requestClient["clienteCNPJ"] = $configs["clienteCNPJ"];

        // die(print_r($requestClient));
        $response = Http::asForm()->post($configs['URL'].'cadastroService/remover', $requestClient);

        if($response->failed())
            throw new Exception($response->json());

        return $response->json();
    }
}
