@extends('templates.index')
@section('title', 'Clientes')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Clientes</h3>
            </div>
            <div class="card-body">
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
                {{-- </form><br/> --}}
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
            </div>
        </div>
    </div>
    <script>
        $(document).ready( function () {
            $('#table-clientes').DataTable();
        } );
    </script>
@endsection
