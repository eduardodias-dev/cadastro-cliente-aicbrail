@extends('templates.index')
@section('title', 'Clientes')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Clientes</h3>
            </div>
            <div class="card-body">
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
                            {{-- @if(isset($clients) && count($clients) > 0)
                            <tr>
                                <td><input type="text" class="input-filter" onchange="filter('#table-clientes', 0)"/></td>
                                <td><input type="text" class="input-filter" onchange="filter('#table-clientes', 1)"/></td>
                                <td><input type="text" class="input-filter" onchange="filter('#table-clientes', 2)"/></td>
                                <td><input type="text" class="input-filter" onchange="filter('#table-clientes', 3)"/></td>
                                <td><input type="text" class="input-filter" onchange="filter('#table-clientes', 4)"/></td>
                                <td><input type="text" class="input-filter" onchange="filter('#table-clientes', 5)"/></td>
                                <td><input type="text" class="input-filter" onchange="filter('#table-clientes', 6)"/></td>
                                <td></td>
                            </tr>
                            @endif --}}
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
@endsection
