<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    </head>
    <body>
        <main class="container">
            <h1>Cliente</h1>
            <br/>
            <a href="/clients" class="btn btn-outline-info ml-2">Voltar</a>
            @if (session()->has('dados_integracao'))
                <div class="alert alert-primary">
                    Resultado da integração:
                    {{ session('dados_integracao') }}
                </div>
            @endif
            @isset($client)
                <div class="table-responsive ">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Nome</th>
                            <th>Documento</th>
                            <th>Criado em</th>
                            <th>Status</th>
                            <th>Emails</th>
                            <th>Contatos</th>
                        </tr>
                            <tr>
                                {{-- <td>{{$client['name']}}</td> --}}
                                <td>{{$client['nome']}}</td>
                                <td>{{$client['documento']}}</td>
                                <td>{{date_format(date_create($client['criadoEm']),"d/m/Y")}}</td>
                                <td>{{getClientStatusDescription($client['status'])}}</td>
                                <td>{{$client['emails']}}</td>
                                <td>{{$client['telefones']}}</td>
                                {{-- <td></td>
                                <td></td> --}}
                            </tr>
                    </table>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Informações</h4>
                    </div>
                    <div class="card-body">
                        @isset($client['endereco'])
                            <h4>Endereço:</h4>
                            <b>Rua:</b> {{$client['endereco']['rua']}}, {{$client['endereco']['numero']}} {{$client['endereco']['complemento']}}<br>
                            <b>Bairro:</b> {{$client['endereco']['bairro']}}<br>
                            <b>Cidade:</b> {{$client['endereco']['cidade']}}/{{$client['endereco']['estado']}}<br>
                            <b>CEP:</b> {{$client['endereco']['cep']}}
                        @endisset
                        @isset($client['ExtraFields'])
                            @foreach($client['ExtraFields'] as $field)
                                <b>{{str_replace('_',' ', str_replace('CP_', '', $field['tagName']))}}</b>: {{$field['tagValue']}}<br/>
                            @endforeach
                        @endisset
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Dados Veículo:</h4>
                    </div>
                    <div class="card-body">
                        @isset($client['veiculo'])
                            <b>Chassi:</b> {{$client['veiculo']['chassi']}}<br>
                            <b>Placa:</b> {{$client['veiculo']['placa']}}<br>
                            <b>Renavam:</b> {{$client['veiculo']['renavam']}}<br>
                            <b>Tipo:</b> {{$client['veiculo']['tipo']}}<br>
                            <b>Ano:</b> {{$client['veiculo']['anoFabricacao']}}/{{$client['veiculo']['anoModelo']}}<br>
                            <b>Marca:</b> {{$client['veiculo']['marca']}}<br>
                            <b>Modelo:</b> {{$client['veiculo']['modelo']}}<br>
                            <b>Cor:</b> {{$client['veiculo']['cor']}}<br>
                        @endisset
                    </div>
                </div>
            @endisset
            @isset($subscriptions)
                <h3>Assinaturas / Contratos</h3>
                <div class="table-responsive ">
                    <table class="table table-striped table-bordered">
                        <tr>
                            <th>Informações</th>
                            <th>Valor</th>
                            <th>Periodicidade</th>
                            <th>Data 1° Pagamento</th>
                            <th>Status</th>
                        </tr>
                        @foreach ($subscriptions as $subscription)
                            <tr>
                                <td>
                                    @isset($subscription['ExtraFields'])
                                        @isset($subscription['ExtraFields'])
                                            @foreach($subscription['ExtraFields'] as $field)
                                                <b>{{str_replace('_',' ', str_replace('CP_', '', $field['tagName']))}}</b>: {{$field['tagValue']}}<br/>
                                            @endforeach
                                        @endisset
                                    @endisset
                                </td>
                                <td>{{$subscription['value']}}</td>
                                <td>{{getPeriodicity($subscription['periodicity'])}}</td>
                                <td>{{$subscription['firstPayDayDate']}}</td>
                                <td>{{getSubscriptionStatusDescription($subscription['status'])}}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            @endisset
            <h4>Log Integração(Lógica):</h4>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table-clientes" class="display">
                    <thead>
                    <tr class="table-info">
                        <th>Id</th>
                        <th>Resultado Integração</th>
                        <th>Ação Realizada</th>
                        <th>Data Integração</th>
                    </tr>
                    </thead>
                    <tbody>
                        @isset($logs)
                            @foreach ($logs as $log)
                                <tr>
                                    <td>{{$log['id']}}</td>
                                    <td>{{$log['resultado']}}</td>
                                    <td>{{$log['acao']}}</td>
                                    <td>{{date_format(date_create($log['data_integracao']), 'd/m/Y H:i:s')}}</td>
                                </tr>
                            @endforeach
                        @endisset
                        @empty($logs)
                            <tr>
                                <td class="text-center" colspan="4">Nenhum registro encontrado.</td>
                            </tr>
                        @endempty
                    </tbody>
                </table>
            </div>
            <form action="{{route('client.integrate')}}" method="post" class="mt-3">
                @csrf
                <input type="hidden" name="id" value="{{$client['id']}}" />
                <input type="hidden" name="id_galaxpay" value="{{$client['id_galaxpay']}}" />

                <button type="submit" class="btn btn-warning">Enviar para Serviço</button>
            </form>
        </main>
    </body>
</html>
