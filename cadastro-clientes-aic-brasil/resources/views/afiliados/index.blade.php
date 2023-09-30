@extends('templates.index')
@section('title', 'Afiliados')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title h2">Afiliados</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="table-afiliados" class="display">
                        <thead>
                            <tr class="table-info">
                                <th>Id Afiliado</th>
                                <th>Nome</th>
                                <th>Status</th>
                                <th>Código</th>
                                <th>Data Criação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($afiliados as $afiliado)
                                <tr>
                                    <td class="td-id_afiliado">{{$afiliado->id_afiliado}}</td>
                                    <td class="td-nome">{{$afiliado->nome}}</td>
                                    <td class="td-afiliado_ativo">{{$afiliado->afiliado_ativo == 1 ? 'Ativo' : 'Inativo'}}</td>
                                    <td class="td-codigo">{{$afiliado->codigo}}</td>
                                    <td class="td-criado_em">{{getDateTimeInBRFormat($afiliado->criado_em)}}</td>
                                    <td class="">
                                        <button class="btn btn-outline-info ml-2" onclick="showModalNovoCodigo(this)">Novo Código</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-novo-codigo-afiliado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Novo Código</h1>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        Afiliado
                        <input type="text" class="form-control" name="nomeAfiliado" id="nomeAfiliado" readonly>
                        <input type="hidden" name="id_afiliado" id="id_afiliado" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        Código Atual
                        <input type="text" class="form-control" name="codigoAtual" id="codigoAtual" readonly>
                    </div>
                    <div class="form-group col-md-12">
                        Novo Código
                        <input type="text" class="form-control" name="novoCodigo" id="novoCodigo">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarNovoCodigoAfiliado">Salvar</button>
            </div>
          </div>
        </div>
    </div>
@endsection
