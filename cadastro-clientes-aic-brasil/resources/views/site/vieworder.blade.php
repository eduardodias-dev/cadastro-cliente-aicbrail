@extends('templates.site')
@section('title', 'AIC Brasil - Acompanhar Pedido')

@section('content')
  <main id="main" style="margin-top: 70px; background: #fafafa; min-height: 600px;" class="py-1">
    <div class="container py-5" style="background: white;">
        <h1>Detalhes do seu pedido</h1>
        <form method="get" class="row">
            <div class="form-inline col-md-6">
                <label for="search-order">Código do seu pedido:</label>
                <input type="search" id="search-order" name="codigo_pacote" class="form-control" value="{{$codigo_pacote}}">
                <button type="submit" id="btn-search-order" class="btn btn-success mt-2">
                    Buscar
                    <i class='bx bx-search'></i>
                </button>
            </div>
        </form>
        @if(isset($codigo_pacote) && !empty($codigo_pacote))
            @if(isset($pacote) && !empty($pacote))
            <div class="main-form mt-2" style="min-height: 600px;">
                <hr>
                <div class="row py-3">
                    <div class="col-md">
                        <h2>Pedido: {{$codigo_pacote}}</h2>
                        <a class="btn btn-primary" href="{{$pacote->link_boleto}}" target="_blank">
                            Clique aqui para ver seu Boleto
                            <i class='bx bx-money-withdraw'></i>
                        </a>
                    </div>
                </div>
                <div class="row py-3">
                    @if(session()->has('assinatura_criada'))
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-success" role="info">
                                    Plano criado com sucesso!
                                </div>
                            </div>
                        </div>
                    @endif
                    @if($error)
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-info" role="info">
                                Não foi encontrado nenhum pedido com esse código.
                            </div>
                        </div>
                    </div>
                    @else
                        @for($i = 0; $i < count($subscriptions); $i++)
                            <div class="box-assinaturas card p-3 mb-3">
                                <div class="col-md-12">
                                    <h2>Assinatura #{{$i + 1}}</h2>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Dados do Plano:</h4>
                                            </div>
                                            <div class="card-body">
                                                <b style="font-size: 20px;">Status da Assinatura:</b>
                                                    <span class="{{getClassByStatus($subscriptions[$i]['status'])}}" style="font-size: 20px;">{{ucfirst($subscriptions[$i]['status'])}}</span>
                                                <br>
                                                <b>Plano Contratado:</b> {{$subscriptions[$i]['nome']}}<br>
                                                <b>Titular:</b> {{$subscriptions[$i]['nome_cliente']}}<br>
                                                <b>Documento:</b> {{$subscriptions[$i]['documento']}}<br>
                                                <b>Email:</b> {{$subscriptions[$i]['emails']}}<br>
                                                <b>Telefone:</b> {{$subscriptions[$i]['telefone']}}<br>
                                                <b>Valor:</b> {{getValorEmReal($subscriptions[$i]['valor'])}}<br>
                                                <b>Periodicidade:</b> {{$subscriptions[$i]['periodicidade']}}<br>
                                                <b>Quantidade:</b> {{$subscriptions[$i]['quantidade']}}<br>
                                                <b>Info Adicional:</b> {{$subscriptions[$i]['info_adicional']}}<br>
                                                <b>Forma de Pagamento:</b> {{$subscriptions[$i]['tipo_pagamento']}}<br>
                                                @if($subscriptions[$i]['tipo_cadastro'] == "J")
                                                    <b>Nome Representante:</b> {{$subscriptions[$i]['nome_representante']}}<br>
                                                    <b>CPF Representante:</b> {{$subscriptions[$i]['cpf_representante']}}<br>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card ">
                                            <div class="card-header">
                                                <h4>Dados de Endereço</h4>
                                            </div>
                                            <div class="card-body">
                                                <b>Rua:</b> {{$subscriptions[$i]['logradouro']}}, {{$subscriptions[$i]['numero']}} {{$subscriptions[$i]['complemento']}}<br>
                                                <b>Bairro:</b> {{$subscriptions[$i]['bairro']}}<br>
                                                <b>Cidade:</b> {{$subscriptions[$i]['cidade']}}/{{$subscriptions[$i]['estado']}}<br>
                                                <b>CEP:</b> {{$subscriptions[$i]['cep']}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="card ">
                                            <div class="card-header">
                                                <h4>Adquirido com o Plano:</h4>
                                            </div>
                                            <div class="card-body">
                                                <ul>
                                                    @foreach($subscriptions[$i]['adicionais_assinatura'] as $grupo => $tipo)
                                                        <li>
                                                            <b>{{$grupo}}</b>
                                                            <ul>
                                                                @foreach($tipo as $adicional)
                                                                    <li>{{$adicional['nome_adicional']}}</li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @endif
                </div>
            </div>
            @else
                <div class="main-form mt-2" style="min-height: 600px;">
                    <p>Pedido não encontrado</p>
                </div>
            @endif
        @endif
    </div>
    <a href="https://wa.me/5508003482342?text=Quero%20saber%20mais%20sobre%20a%20AIC%20Brasil%20Assistência%2024h" data-bs-toggle="tooltip" data-bs-placement="top" id="botao_whatsapp" title="Contato no Whatsapp" target="_blank" >
        <i style="margin-top:10px; font-size: 40px;" class="bx bxl-whatsapp"></i>
    </a>
    <button id="botao_doacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Faça uma doação">
        <i style="margin-top:10px; font-size: 40px;" class="bx bx-donate-heart"></i>
    </button>
  </main><!-- End #main -->

@endsection
