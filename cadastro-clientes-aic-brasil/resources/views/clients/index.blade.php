<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Lista Clientes</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    </head>
    <body>
        <main class="container px-5">
            <h1>Clientes</h1>
            {{-- <h3>Filtro</h3>
            <form method="GET" class="form-inline">
                <label class="ml-2">Email:</label>
                <input type="text" name="emails" value="" class="form-control ml-1"/>

                <label class="ml-2">Documento:</label>
                <input type="text" name="documents" value="" class="form-control ml-1"/>

                <label class="ml-2">Status:</label>
                <select name="status" class="form-control ml-1" value="">
                    <option value="">Selecione...</option>
                    <option value="active">Ativo</option>
                    <option value="inactive">Inativo</option>
                    <option value="delayed">Pagamento Atrasado</option>
                    <option value="withoutSubscriptionOrCharge">Não possui assinatura</option>
                </select>

                <label class="ml-2">Data Criação:</label>
                <input type="date" name="createdAtFrom" value="" class="form-control ml-1" />

                <br />
                <br />
                <br />
                <button type="submit" class="btn btn-outline-info ml-2">Filtrar</button> --}}
            </form><br/>
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table-clientes" class="display">
                    <thead>
                        <tr class="table-info">
                            <th>Id</th>
                            <th>Id GalaxPay</th>
                            <th>Nome</th>
                            <th>Documento</th>
                            <th>Criado em</th>
                            <th>Status</th>
                            <th>Codigo Lógica</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clients as $client)
                            <tr>
                                <td>{{$client['id']}}</td>
                                <td>{{$client['id_galaxpay']}}</td>
                                <td>{{$client['nome']}}</td>
                                <td>{{$client['documento']}}</td>
                                <td>{{$client['criadoEm']}}</td>
                                <td>{{getClientStatusDescription($client['status'])}}</td>
                                <td>{{$client['codigo_logica']}}</td>
                                {{-- <td>
                                    @isset($client['ExtraFields'])
                                        @foreach($client['ExtraFields'] as $field)
                                            <b>{{str_replace('_',' ', str_replace('CP_', '', $field['tagName']))}}</b>: {{$field['tagValue']}}<br/>
                                        @endforeach
                                    @endisset
                                </td>
                                <td>{{implode(', ', $client['emails'])}}</td>
                                <td>{{implode(', ', $client['phones'])}}</td> --}}
                                <td>
                                    <a href="{{route('client.detail', ['id' => $client['id']])}}" class="btn btn-outline-info ml-2">Detalhe</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
        <script>
            $(document).ready( function () {
                $('#table-clientes').DataTable();
            } );
        </script>
    </body>
</html>
