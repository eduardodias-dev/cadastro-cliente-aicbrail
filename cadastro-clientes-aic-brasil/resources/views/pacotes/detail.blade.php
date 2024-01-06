@extends('templates.index')
@section('title', 'Pacote')

@section('content')
    @if (session()->has('message'))
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        {{ session('message') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
    @endif
    <div class="container-fluid px-3" style="background: white;">
        <div class="main-form mt-2" style="min-height: 600px;">
            <hr>
            <div class="row py-3">
                <div class="col-md">
                    <h2>Pedido: {{$pacote->codigo}}</h2>

                    @if(strtoupper($pacote->status) == "ATIVO")
                        <button class="btn btn-outline-success" type="button" disabled>
                            Assinaturas Ativas
                            <i class="fa fa-check"></i>
                        </button>
                    @else
                        <form action="{{route("pacotes.aprovar")}}" method="post" style="display: inline-block">
                            @csrf
                            <input type="hidden" name="id_pacote" value="{{$pacote->id_pacote}}">
                            <input type="hidden" name="enviarApolice" value="0">
                                <button class="btn btn-outline-success" type="submit" title="Confirmar Pagamento e ativar Assinaturas">
                                    Ativar Assinaturas
                                    <i class="fa fa-check"></i>
                                </button>
                        </form>
                    @endif
                    @if(strtoupper($pacote->status) == "ATIVO")
                        <form action="{{route("pacotes.envio.email")}}" method="post" style="display: inline-block">
                            @csrf
                            <input type="hidden" name="id_pacote" value="{{$pacote->id_pacote}}">
                            <button class="btn btn-outline-info" type="submit" title="Enviar Apólice por Email" target="_blank">
                                Enviar Apólice por Email
                                <i class="fa fa-envelope"></i>
                            </button>
                        </form>
                    @endif
                    <a class="btn btn-outline-primary" href="{{$pacote->link_boleto}}" title="Ver Boleto" target="_blank">
                        Ver Boleto
                        <i class="fa fa-file"></i>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4>Dados do Pedido:</h4>
                        </div>
                        <div class="card-body">
                            <b style="font-size: 20px;">Status do Pedido:</b>
                                <span class="{{getClassByStatus($pacote->status)}}" style="font-size: 20px;">{{ucfirst($pacote->status)}}</span>
                            <br>
                            <b>Titular:</b> {{$pacote->nome_cliente}}<br>
                            <b>Documento:</b> {{$pacote->documento}}<br>
                            <b>Email:</b> {{$pacote->emails}}<br>
                            <b>Telefone:</b> {{$pacote->telefone}}<br>
                            <b>Valor:</b> {{getValorEmReal($pacote->valor / 100)}}<br>
                            <b>Periodicidade:</b> {{$pacote->periodicidade}}<br>
                            <b>Quantidade:</b> {{$pacote->quantidade}}<br>
                            <b>Info Adicional:</b> {{$pacote->info_adicional}}<br>
                            <b>Forma de Pagamento:</b> {{$pacote->tipo_pagamento}}<br>
                            @if($pacote->tipo_cadastro == "J")
                                <b>Nome Representante:</b> {{$pacote->nome_representante}}<br>
                                <b>CPF Representante:</b> {{$pacote->cpf_representante}}<br>
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
                            <b>Rua:</b> {{$pacote->logradouro}}, {{$pacote->numero}} {{$pacote->complemento}}<br>
                            <b>Bairro:</b> {{$pacote->bairro}}<br>
                            <b>Cidade:</b> {{$pacote->cidade}}/{{$pacote->estado}}<br>
                            <b>CEP:</b> {{$pacote->cep}}
                        </div>
                    </div>
                </div>
            </div>
                @if($error)
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info" role="info">
                            Não foi encontrado nenhuma assinatura com esse código.
                        </div>
                    </div>
                </div>
                @else
                    @for($i = 0; $i < count($subscriptions); $i++)
                        <div class="row">
                            <div class="col-md-12 ml-2">
                                <h2>Assinatura #{{$i + 1}}</h2>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Dados da Assinatura:</h4>
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
                        @if(count($subscriptions[$i]['adicionais_assinatura']) > 0)
                            <div class="row">
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
                        @endif
                    @endfor
                @endif
        </div>
    </div>
@endsection
