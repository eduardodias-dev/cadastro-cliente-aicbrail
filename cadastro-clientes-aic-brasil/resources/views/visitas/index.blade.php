@extends('templates.index')
@section('title', 'Visitas')

@section('content')
    <div class="container-fluid">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="tab-visitas" data-toggle="tab" data-target="#pane-visitas" type="button" role="tab" aria-controls="pane-visitas" aria-selected="true">Visitas</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="tab-imoveis" data-toggle="tab" data-target="#pane-imoveis" type="button" role="tab" aria-controls="pane-imoveis" aria-selected="true">Imóveis</button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="pane-visitas" role="tabpanel" aria-labelledby="home-tab">
                <div class="card">
                    <div class="card-body">
                        <h2>Visitas</h2>
                        <div class="row mb-2">
                            <button class="btn btn-outline-primary ml-2 mb-2">
                                <i class="fas fa-plus"></i>
                                Nova Visita
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="table-visitas" class="display">
                                <thead>
                                    <tr class="table-info">
                                        <th>Id</th>
                                        <th>Codigo Imóvel</th>
                                        <th>Proprietário</th>
                                        <th>Data</th>
                                        <th>Endereço</th>
                                        <th>Compradores</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($visita))
                                        @foreach ($visitas as $visita)
                                            <tr>
                                                <td class="td-id_imovel">{{$visita->id_imovel}}</td>
                                                <td class="td-codigo_imovel">{{$visita->codigo_imovel}}</td>
                                                <td class="td-proprietario_imovel">{{$visita->proprietario_imovel}}</td>
                                                <td class="td-data_visita">{{$visita->data_visita}}</td>
                                                <td class="td-endereco_imovel">{{$visita->endereco_imovel}}</td>
                                                <td class="td-visita_compradores">{{$visita->visita_compradores}}</td>
                                                <td class="">
                                                    <button class="btn btn-outline-info ml-2">
                                                        <i class="fas fa-edit"></i>
                                                        Editar
                                                    </button>
                                                    <button class="btn btn-outline-danger ml-2">
                                                        <i class="fas fa-trash"></i>
                                                        Remover
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="pane-imoveis" role="tabpanel" aria-labelledby="profile-tab">
                <div class="card">
                    <div class="card-body">
                        <h2>Imóveis</h2>
                        <div class="row mb-2">
                            <button class="btn btn-outline-primary ml-2 mb-2">
                                <i class="fas fa-plus"></i>
                                Novo Imóvel
                            </button>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="table-imoveis" class="display">
                                <thead>
                                    <tr class="table-info">
                                        <th>Id</th>
                                        <th>Codigo Imóvel</th>
                                        <th>Proprietário</th>
                                        <th>Endereço</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-novo-afiliado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Novo Afiliado</h1>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="form-group col-md-12">
                        Nome
                        <input type="text" class="form-control" name="nomeAfiliado">
                    </div>
                    <div class="form-group col-md-12">
                        Código
                        <input type="text" class="form-control" name="novoCodigo">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarNovoAfiliado">Salvar</button>
            </div>
          </div>
        </div>
    </div>
    <div class="modal fade" id="modal-remover-afiliado" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="staticBackdropLabel">Remover Afiliado</h1>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" name="id_afiliado" />
                    <h5>Confirma a exclusão do afiliado?</h5>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarRemoverAfiliado">Salvar</button>
            </div>
          </div>
        </div>
    </div>
@endsection
