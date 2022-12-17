@extends('templates.index')
@section('title', 'Assinaturas')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Assinaturas</h3>
            </div>
            <div class="card-body">
                {{-- <h3>Filtro</h3>
                <form method="GET" class="form-inline">
                    <label class="ml-2">Id GalaxPay:</label>
                    <input type="text" name="documents" value="" class="form-control ml-1"/>

                    <label class="ml-2">Status:</label>
                    <select name="status" class="form-control ml-1" value="">
                        <option value="">Selecione...</option>
                        <option value="active">Ativo</option>
                        <option value="inactive">Inativo</option>
                        <option value="delayed">Pagamento Atrasado</option>
                        <option value="withoutSubscriptionOrCharge">Não possui assinatura</option>
                    </select>

                    <label class="ml-2">Plano:</label>
                    <select name="planGalaxPayIds" class="form-control ml-1" value="" multiple>
                        <option value="">Selecione...</option>
                        @foreach($plans as $plan)
                            <option value="{{$plan['id_galaxpay']}}">{{$plan['nome']}}</option>
                        @endforeach
                    </select>

                    <label class="ml-2">Data Criação:</label>
                    <input type="date" name="createdAtFrom" value="" class="form-control ml-1" />

                    <button type="submit" class="btn btn-outline-info ml-2">Filtrar</button>
                </form><br/> --}}
                @if (isset($subscriptions) && count($subscriptions) > 0)
                    <table class="table table-responsive table-striped table-bordered" id="table-clientes" class="display">
                        <thead>
                        <tr class="table-info">
                            <th>Id GalaxPay</th>
                            <th>Cliente</th>
                            <th>Documento</th>
                            <th>Criado em</th>
                            <th>Status Assinatura</th>
                            <th>Status Cliente</th>
                            <th>Emails</th>
                            <th>Ações</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($subscriptions as $subscription)
                                <tr>
                                    <td>{{$subscription['galaxPayId']}}</td>
                                    <td>{{$subscription['Customer']['name']}}</td>
                                    <td>{{$subscription['Customer']['document']}}</td>
                                    <td>{{$subscription['createdAt']}}</td>
                                    <td>{{getSubscriptionStatusDescription($subscription['status'])}}</td>
                                    <td>Preencher</td>
                                    <td>{{implode(', ', $subscription['Customer']['emails'])}}</td>
                                    <td>
                                        <a href="{{route('subscription.detail', ['id' => $subscription['galaxPayId']])}}" class="btn btn-outline-info ml-2">Detalhe</a>
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
            $('#table-clientes').DataTable();
        } );
    </script>
@endsection
