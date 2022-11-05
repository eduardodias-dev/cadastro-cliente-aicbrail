<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Lista Assinaturas</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

    </head>
    <body>
        <main class="container px-5">
            <h1>Log Integração</h1>
            @if (session()->has('dados_batch'))
                <div class="alert alert-success">
                    {{ session('dados_batch') }}
                </div>
            @endif
            @if (isset($logs) && count($logs) > 0)
                <table class="table table-responsive table-striped table-bordered" id="table-clientes" class="display">
                    <thead>
                    <tr class="table-info">
                        <th>Cliente</th>
                        <th>Documento</th>
                        <th>Status</th>
                        <th>Codigo Logica</th>
                        <th>Retorno</th>
                        <th>Ação Integração</th>
                        <th>Data Integração</th>
                        <th>Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{$log['nome']}}</td>
                                <td>{{$log['documento']}}</td>
                                <td>{{getClientStatusDescription($log['status'])}}</td>
                                <td>{{$log['codigo_logica']}}</td>
                                <td>{{json_decode($log['resultado'], true)['retorno']}}</td>
                                <td>{{$log['acao']}}</td>
                                <td>{{getDateTimeInBRFormat($log['data_integracao'])}}</td>
                                <td>
                                    <a href="{{route('client.detail', ['id' => $log['client_id']])}}" class="btn btn-outline-info ml-2">Detalhe do cliente</a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else

            @endif
        </main>
        <script>
            $(document).ready( function () {
                $('#table-clientes').DataTable({
                    order: [[6, 'desc']]
                });
            } );
        </script>
    </body>
</html>
