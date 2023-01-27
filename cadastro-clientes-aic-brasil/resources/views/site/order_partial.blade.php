@if($error)
<div class="row">
    <div class="alert alert-info" role="info">
        Não foi encontrado nenhum pedido com esse código.
    </div>
</div>
@else
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Dados do Plano:</h4>
            </div>
            <div class="card-body">
                <b style="font-size: 20px;">Status do Pedido:</b>
                    <span class="{{getClassByStatus($subscription['status'])}}" style="font-size: 20px;">{{ucfirst($subscription['status'])}}</span>
                <br>
                <b>Plano Contratado:</b> {{$subscription['nome']}}<br>
                <b>Titular:</b> {{$subscription['nome_cliente']}}<br>
                <b>Documento:</b> {{$subscription['documento']}}<br>
                <b>Email:</b> {{$subscription['emails']}}<br>
                <b>Telefone:</b> {{$subscription['telefone']}}<br>
                <b>Valor:</b> {{$subscription['valor']}}<br>
                <b>Periodicidade:</b> {{$subscription['periodicidade']}}<br>
                <b>Quantidade:</b> {{$subscription['quantidade']}}<br>
                <b>Info Adicional:</b> {{$subscription['info_adicional']}}<br>
                <b>Forma de Pagamento:</b> {{$subscription['tipo_pagamento']}}<br>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card ">
            <div class="card-header">
                <h4>Dados de Endereço</h4>
            </div>
            <div class="card-body">
                <b>Rua:</b> {{$subscription['logradouro']}}, {{$subscription['numero']}} {{$subscription['complemento']}}<br>
                <b>Bairro:</b> {{$subscription['bairro']}}<br>
                <b>Cidade:</b> {{$subscription['cidade']}}/{{$subscription['estado']}}<br>
                <b>CEP:</b> {{$subscription['cep']}}
            </div>
        </div>
    </div>
</div>
@endif
