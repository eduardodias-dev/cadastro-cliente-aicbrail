@extends('templates.index')
@section('title', 'Clientes Galaxpay')

@section('content')
    <main class="container">
        <h1>Clientes (GalaxPay)</h1>
        <h3>Filtro</h3>
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
            <button type="submit" class="btn btn-outline-info ml-2">Filtrar</button>
        </form><br/>
        @if (isset($clients) && count($clients) > 0)
            <table class="table table-responsive table-striped table-bordered" id="table-clientes" class="display">
                <thead>
                <tr class="table-info">
                    <th>Id</th>
                    <th>Id GalaxPay</th>
                    <th>Nome</th>
                    <th>Documento</th>
                    <th>Criado em</th>
                    <th>Status</th>
                    <th>Detalhes</th>
                    <th>Emails</th>
                    <th>Contatos</th>
                    <th>Ações</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{$client['myId']}}</td>
                            <td>{{$client['galaxPayId']}}</td>
                            <td>Maria</td>
                            <td>{{$client['document']}}</td>
                            <td>{{$client['createdAt']}}</td>
                            <td>{{getClientStatusDescription($client['status'])}}</td>
                            <td>
                                @isset($client['ExtraFields'])
                                    @foreach($client['ExtraFields'] as $field)
                                        <b>{{str_replace('_',' ', str_replace('CP_', '', $field['tagName']))}}</b>: {{$field['tagValue']}}<br/>
                                    @endforeach
                                @endisset
                            </td>
                            <td>{{implode(', ', $client['emails'])}}</td>
                            <td>{{implode(', ', $client['phones'])}}</td>
                            <td>
                                <a href="{{route('customer.detail', ['id' => $client['galaxPayId']])}}" class="btn btn-outline-info ml-2">Detalhe</a>
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
            $('#table-clientes').DataTable();
        } );
    </script>
@endsection
