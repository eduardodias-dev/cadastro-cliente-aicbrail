@extends('templates.index')
@section('title', 'Logs')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Log Integração</h3>
            </div>
            <div class="card-body">
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
            </div>
        </div>
    </div>

    <script>
        $(document).ready( function () {
            $('#table-clientes').DataTable({
                order: [[6, 'desc']]
            });
        } );
    </script>
@endsection
