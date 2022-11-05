<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GalaxPay - Cliente</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    </head>
    <body>
        <main class="container">
            <h1>Cliente (Galax Pay)</h1>
            <br/>
            <a href="/clients" class="btn btn-outline-info ml-2">Voltar</a>
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
                                <td>{{$client['name']}}</td>
                                <td>{{$client['document']}}</td>
                                <td>{{date_format(date_create($client['createdAt']),"d/m/Y")}}</td>
                                <td>{{getClientStatusDescription($client['status'])}}</td>
                                <td>{{implode(', ', $client['emails'])}}</td>
                                <td>{{implode(', ', $client['phones'])}}</td>
                            </tr>
                    </table>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Informações</h4>
                    </div>
                    <div class="card-body">
                        @isset($client['ExtraFields'])
                            @foreach($client['ExtraFields'] as $field)
                                <b>{{str_replace('_',' ', str_replace('CP_', '', $field['tagName']))}}</b>: {{$field['tagValue']}}<br/>
                            @endforeach
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
        </main>
    </body>
</html>
