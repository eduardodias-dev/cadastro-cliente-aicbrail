<div class="card">
  <div class="card-body">
      <h2>Visitas</h2>
      <div class="row mb-2">
          <button class="btn btn-outline-primary ml-2 mb-2" id="btnNovaVisita">
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
              </tbody>
          </table>
      </div>
  </div>
</div>

<div class="modal fade" id="modal-nova-visita" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Nova Visita</h1>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="form-visita">
            @csrf
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="">Imóvel:</label>
                  <select name="imovel_id" id="selectImoveis" class="form-control">
                    <option value="">Selecione...</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <input type="hidden" name="id" />
              <div class="col-md-4">
                  <div class="form-group">
                      <label>Comprador</label>
                      <input type="text" name="nome" id="" class="form-control">
                  </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <label>CPF</label>
                    <input type="text" name="cpf" id="" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                    <label>RG</label>
                    <input type="text" name="rg" id="" class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email" id="" class="form-control">
                </div>        
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label>Data da Visita</label>
                    <input type="text" name="data_visita" id="data_visita" class="form-control">
                </div>        
              </div>
            </div>
          </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btnSalvarNovaVisita">Salvar</button>
          </div>
        </div>
      </div>
  </div>
  <div class="modal fade" id="modal-remover-visita" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Remover Visita</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <input type="hidden" name="id_visita" />
                  <h5>Confirma a exclusão da visita?</h5>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btnSalvarRemoverVisita" onclick="salvarRemoverVisita()">Confirmar</button>
          </div>
        </div>
      </div>
  </div>

  @push('scripts')
    <script src="/dist/js/tab-visitas.js"></script>
  @endpush