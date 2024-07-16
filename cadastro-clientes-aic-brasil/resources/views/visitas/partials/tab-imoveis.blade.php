<div class="card">
    <div class="card-body">
        <h2>Imóveis</h2>
        <div class="row mb-2">
            <button class="btn btn-outline-primary ml-2 mb-2" id="btnNovoImovel">
                <i class="fas fa-plus"></i>
                Novo Imóvel
            </button>
        </div>
        <div class="table-responsive w-100">
            <table class="table table-striped table-bordered" id="table-imoveis" class="display">
                <thead>
                    <tr class="table-info">
                        <th>Id</th>
                        <th>Codigo Imóvel</th>
                        <th>Descrição</th>
                        <th>Proprietário</th>
                        <th>E-Mail</th>
                        <th>Endereço</th>
                        <th>Cidade</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-novo-imovel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Novo Imóvel</h1>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form method="POST" id="form-imovel">
            @csrf
            <div class="row">
              <input type="hidden" name="id" />
              <div class="col-md-6">
                  <div class="form-group">
                      <label>Proprietário</label>
                      <input type="text" name="nome_proprietario" id="" class="form-control">
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label>CPF</label>
                      <input type="text" name="cpf_proprietario" id="" class="form-control">
                  </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" name="email_proprietario" id="" class="form-control">
                </div>        
              </div>
              <div class="col-md-6">
                <div class="form-group">
                    <label>Código</label>
                    <input type="text" name="codigo_imovel" id="" class="form-control">
                </div>        
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                    <label>Descrição</label>
                    <input type="text" name="descricao" id="" class="form-control">
                </div>        
              </div>
            </div>
            <fieldset>
              <legend>Endereço</legend>
              <div class="row">
                <div class="col-md-4 input-container">
                  <label for="zipCode">CEP:</label>
                  <input type="text" id="zipCode" name="zipCode" class="form-control" value="" required>
                </div>
                <div class="col-md-8 form-group d-flex align-items-end" style="padding-left: 0;">
                  <span style="padding: 0 10px 7px 0;">
                    <i class="fas fa-spinner fa-spin spinner" id="spinner" style="display:none;"></i>
                  </span>
                  <a href="https://buscacepinter.correios.com.br/app/endereco/index.php" target="_blank" class="btn btn-outline-secondary">
                    <i class="fa fa-question-circle"></i>
                    Não sei meu CEP
                  </a>
                </div>
              </div>
              <div class="row">
                <div class="col-md-8 form-group">
                  <label for="street">Rua:</label>
                  <input type="text" id="street" name="street" class="form-control" value="" required>
                </div>
                <div class="col-md-4 form-group">
                  <label for="number">Número:</label>
                  <input type="text" id="number" name="number" class="form-control" value="" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="complement">Complemento:</label>
                  <input type="text" id="complement" name="complement" class="form-control" value="">
                </div>
                <div class="col-md-6 form-group">
                  <label for="neighborhood">Bairro:</label>
                  <input type="text" id="neighborhood" name="neighborhood" class="form-control" value="" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
        
                  <label for="city">Cidade:</label>
                  <input type="text" id="city" name="city" class="form-control" value="" required>
                </div>
                <div class="col-md-6">
                  <label for="state">Estado:</label>
                  {{-- <input type="text" id="state" name="state" class="form-control" value="{{}}" required> --}}
                  <select name="state" id="state" class="form-control">
                    <option value=""></option>
                    {{printEstadosAsOptions()}}
                  </select>
                </div>
              </div>
              </fieldset>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary" id="btnSalvarNovoImovel">Salvar</button>
          </div>
        </div>
      </div>
  </div>
  <div class="modal fade" id="modal-remover-imovel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h1 class="modal-title fs-5" id="staticBackdropLabel">Remover Imóvel</h1>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="row">
                  <input type="hidden" name="id_imovel" />
                  <h5>Confirma a exclusão do imóvel?</h5>
              </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
              <button type="button" class="btn btn-primary" id="btnSalvarRemoverImovel" onclick="salvarRemoverImovel()">Confirmar</button>
          </div>
        </div>
      </div>
  </div>

  @push('scripts')
    <script src="/dist/js/tab-imoveis.js"></script>
  @endpush