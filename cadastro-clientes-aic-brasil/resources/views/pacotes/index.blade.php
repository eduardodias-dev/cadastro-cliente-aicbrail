@extends('templates.index')
@section('title', 'Pacotes')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title h2">Pacotes</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="table-pacotes" class="display">
                        <thead>
                            <tr class="table-info">
                                <th>Id</th>
                                <th>Valor</th>
                                <th>Adesão</th>
                                <th>Nome Cliente</th>
                                <th>Telefone</th>
                                <th>Código</th>
                                <th>Afiliado</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pacotes as $pacote)
                                <tr>
                                    <td>{{$pacote->id_pacote}}</td>
                                    <td>R$ {{format_number($pacote->valor_view)}}</td>
                                    <td>{{getDateTimeInBRFormat($pacote->adesao)}}</td>
                                    <td>{{$pacote->nome_cliente}}</td>
                                    <td>{{$pacote->telefone}}</td>
                                    <td>{{$pacote->codigo}}</td>
                                    <td>{{$pacote->nome_afiliado}}</td>
                                    <td>
                                        <a href="{{route('pacotes.detail', ['id' => $pacote->id_pacote])}}" class="btn btn-outline-info ml-2">Detalhe</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function () {
            $('#table-pacotes').DataTable();
        } );
    </script>
@endsection
