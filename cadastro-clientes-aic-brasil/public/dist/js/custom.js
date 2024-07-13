$(document).ready( function () {
    $('[data-toggle="tooltip"]').tooltip()
    $('#table-clientes').DataTable();
    $('#table-afiliados').DataTable();
    $('#table-pacotes').DataTable();
    $('#table-plans').DataTable();
    $('#table-visitas').DataTable({
        ajax: {
            url:'/admin/listar-visitas',
            dataSrc:''
        },
        columns:[
            {data: 'id'},
            {data: 'codigo_imovel'},
            {data: 'proprietario_imovel'},
            {data: 'data_visita'},
            {data: 'endereco_imovel'},
            {data: 'compradores_visita'},
            {data: null, render: (d) =>
            {
                return `<button class="btn btn-sm btn-outline-info ml-2" onclick="showModalNovoCodigo(this)">
                            <i class="fas fa-edit"></i>
                            Editar
                        </button>
                        <button class="btn btn-sm btn-outline-danger ml-2" onclick="showModalRemoverAfiliado(this)">
                            <i class="fas fa-trash"></i>
                            Remover
                        </button>`;
            }}
        ]
    });
    $('#table-imoveis').DataTable({
        ajax: {
            url:'/admin/listar-imoveis',
            dataSrc:'data'
        },
        columns:[
            {data: 'id'},
            {data: 'codigo_imovel'},
            {data: "descricao"},
            {data: 'nome_proprietario'},
            {data: 'email_proprietario'},
            {data: null, render: d => {
                return d.street + " " + d.number+ " " + d.complement + " - " + d.neighborhood
            }},
            {data: null, render: d =>{
                return d.city +"/"+d.state
            }},
            {data: null, render: (data, type, row, meta) =>
            {
                return `<button class="btn btn-sm btn-outline-info ml-2 btnRowEdit" data-id="${row.id}" data-index="${meta.row}" onclick="showModalEditarImovel(this)">
                            <i class="fas fa-edit"></i>
                            Editar
                        </button>
                        <button class="btn btn-sm btn-outline-danger ml-2 btnRowRemove" data-id="${row.id}" data-index="${meta.row}" onclick="showModalRemoverImovel(this)">
                            <i class="fas fa-trash"></i>
                            Remover
                        </button>`;
            }}
        ]
    });

    $('#btnSalvarNovoCodigoAfiliado').click(function(){
        $btn = $(this);
        $btn.prop('disabled', true);
        salvarNovoCodigoAfiliado(function(){
            $btn.prop('disabled', false);
        });
    });

    $('#btnSalvarRemoverAfiliado').click(function(){
        $btn = $(this);
        $btn.prop('disabled', true);
        salvarRemoverAfiliado(function(){
            $btn.prop('disabled', false);
        });
    });

    $('#btnSalvarNovoAfiliado').click(function(){
        $btn = $(this);
        $btn.prop('disabled', true);
        salvarNovoAfiliado(function(){
            $btn.prop('disabled', false);
        });
    });

    $("#btnNovoImovel").click(showModalNovoImovel);

    $("#zipCode").blur(() => buscarCep());

    $("#btnSalvarNovoImovel").click(()=>{
        let formData = $("#form-imovel").serialize();
        let token = $("[name=_token]").val();
        
        $modal = $('#modal-novo-imovel');
        let id = $modal.find("[name=id]").val()
        
        let btn = $(this);
        btn.prop("disabled", true);
        
        let url = parseInt(id) != NaN ? `/admin/imovel/${id}` : "/admin/imovel";
        let tableImovel = $('#table-imoveis').DataTable();
        $.ajax({
            method: "post",
            url: url,
            headers: {'X-CSRF-TOKEN': token},
            data: formData
        })
        .done((result) => {
            btn.prop("disabled", false);
            if(result.success){
                $modal.modal("hide");
                tableImovel.ajax.reload()
            }
            else{
                console.error(result)
            }
        })
        .fail((e)=>{
            btn.prop("disabled", false);
            console.log(e)
        })
    });
  
  function buscarCep() {
    var cep = $('#zipCode').val();
    console.log(cep != undefined && cep != '')
    if(cep != undefined && cep != ''){
      $("#spinner").show();
      $('#zipCode').prop('disabled', true);
      $('#street').prop('disabled', true);
      $('#neighborhood').prop('disabled', true);
      $('#city').prop('disabled', true);
      $('#state').prop('disabled', true);

      $.ajax({
          url: '/cep/' + cep,
          method: 'GET',
          dataType: 'json',
          success: function(data) {
              $('#zipCode').prop('disabled', false);
              $("#spinner").hide();
              if (data.error) {
                  console.log('CEP não encontrado');
            } else {
                  $('#street').val(data.logradouro).prop('disabled', false);
                  $('#neighborhood').val(data.bairro).prop('disabled', false);
                  $('#city').val(data.localidade).prop('disabled', false);
                  $('#state').val(data.uf).change().prop('disabled', false);
              }
          },
          error: function() {
              console.log('Erro ao buscar o CEP');
              $("#spinner").hide();
              $('#zipCode').prop('disabled', false);
              $('#street').val(data.logradouro).prop('disabled', false);
              $('#neighborhood').val(data.bairro).prop('disabled', false);
              $('#city').val(data.localidade).prop('disabled', false);
              $('#state').val(data.uf).change().prop('disabled', false);
          }
      });
    }
  }
} );

function filter(tableId, columnIndex){
    var table = $(tableId).DataTable();

    var filteredData = table
        .column( columnIndex )
        .data()
        .filter( function ( value, index ) {
            return value > 20 ? true : false;
        } );
}

function showModalNovoCodigo(button){
    $button = $(button);
    $modal = $('#modal-novo-codigo-afiliado').modal();
    $modal.find('input, select').val('');
    var id_afiliado = $button.closest('td').closest('tr').find('.td-id_afiliado').html();
    var codigoAtual = $button.closest('td').closest('tr').find('.td-codigo').html();
    var nomeAfiliado = $button.closest('td').closest('tr').find('.td-nome').html();

    $modal.find('#id_afiliado').val(id_afiliado);
    $modal.find('#codigoAtual').val(codigoAtual);
    $modal.find('#nomeAfiliado').val(nomeAfiliado);

    $modal.show();
}

function showModalNovoAfiliado(button){
    $button = $(button);
    $modal = $('#modal-novo-afiliado').modal();

    $modal.find('input, select').val('');
    $modal.show();
}

function showModalRemoverAfiliado(button){
    $button = $(button);
    $modal = $('#modal-remover-afiliado').modal();

    var id_afiliado = $button.closest('td').closest('tr').find('.td-id_afiliado').html();
    $modal.find('[name=id_afiliado]').val(id_afiliado);

    $modal.show();
}

function salvarNovoCodigoAfiliado(callback){
    var id_afiliado = $('#id_afiliado').val();
    var nomeAfiliado = $('#nomeAfiliado').val();
    var codigoAtual = $('#codigoAtual').val();
    var novoCodigo = $('#novoCodigo').val();

    var token = $('[name="_token"]').val();

    $.ajax({
        url: '/admin/afiliados/novo-codigo',
        data: {
            id_afiliado, nomeAfiliado, codigoAtual, novoCodigo
        },
        headers: {'X-CSRF-TOKEN': token},
        method: 'POST'
    }).done(response => {
        if(response.erro == 0){
            $('#modal-novo-codigo-afiliado').modal('hide');
            window.location.reload();
        }
        else console.log(response);
    })
    .fail( function(err) {
        console.log(err);
    })
    .always(function(){
        callback()
    });

}

function salvarRemoverAfiliado(callback){
    $modal = $('#modal-remover-afiliado').modal();

    var id_afiliado = $modal.find('[name=id_afiliado]').val();

    var token = $('[name="_token"]').val();

    $.ajax({
        url: '/admin/afiliados/remover',
        data: {
            id_afiliado
        },
        headers: {'X-CSRF-TOKEN': token},
        method: 'POST'
    }).done(response => {
        if(response.erro == 0){
            $('#modal-remover-afiliado').modal('hide');
            window.location.reload();
        }
        else console.log(response);
    })
    .fail( function(err) {
        console.log(err);
    })
    .always(function(){
        callback()
    });

}

function salvarNovoAfiliado(callback){
    $modal = $('#modal-novo-afiliado').modal();

    var nomeAfiliado = $modal.find('[name=nomeAfiliado]').val();
    var novoCodigo = $modal.find('[name=novoCodigo]').val();

    var token = $('[name="_token"]').val();

    $.ajax({
        url: '/admin/afiliados/novo',
        data: {
            nomeAfiliado, novoCodigo
        },
        headers: {'X-CSRF-TOKEN': token},
        method: 'POST'
    }).done(response => {
        if(response.erro == 0){
            $('#modal-novo-afiliado').modal('hide');
            window.location.reload();
        }
        else console.log(response);
    })
    .fail( function(err) {
        console.log(err);
    })
    .always(function(){
        callback()
    });
}

function copiarLink(button){
    $button = $(button);

    var url = $button.closest('td').closest('tr').find('.td-url>a').html();
    var tempTextarea = $('<textarea>');
    $('body').append(tempTextarea);
    tempTextarea.val(url).select();
    document.execCommand('copy');
    tempTextarea.remove();
    alert(url);
}

function showModalNovoImovel(button){
    $button = $(button);
    $modal = $('#modal-novo-imovel').modal();
    $modal.find('input, select').val('');

    $modal.show();
}

function showModalEditarImovel(btn) {
    let id = parseInt($(btn).data('id'));
    $modal = $('#modal-novo-imovel').modal();
    $modal.find('input, select').val('');

    $.ajax({
        method: "get",
        url: `/admin/obter-imovel/${id}`
    })
    .done((result) => {
        if(result.success){
            for(let obj of Object.entries(result.data)){
                let name = obj[0]
                let value = obj[1]

                $modal.find('.modal-body').find(`[name=${name}]`).val(value)
            }
        }
    })
    .fail((e)=>{
        console.log(e)
    })
    
};

function showModalRemoverImovel(button){
    $button = $(button);
    $modal = $('#modal-remover-imovel').modal();

    var id_imovel = $(button).data('id');
    $modal.find('[name=id_imovel]').val(id_imovel);

    $modal.show();
}


function salvarRemoverImovel(){
    $modal = $('#modal-remover-imovel');

    let id_imovel = $modal.find('[name=id_imovel]').val();

    let token = $('[name="_token"]').val();
    let tableImovel = $('#table-imoveis').DataTable();

    $.ajax({
        url: '/admin/imovel/remover',
        data: {
            id_imovel
        },
        headers: {'X-CSRF-TOKEN': token},
        method: 'DELETE'
    }).done(response => {
        if(response.success){
            $('#modal-remover-imovel').modal('hide');
            tableImovel.ajax.reload();
        }
        else console.log(response);
    })
    .fail( function(err) {
        console.log(err);
    });

}