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
                return `<button class="btn btn-outline-info ml-2" onclick="showModalNovoCodigo(this)">
                            <i class="fas fa-edit"></i>
                            Novo Código
                        </button>
                        <button class="btn btn-outline-danger ml-2" onclick="showModalRemoverAfiliado(this)">
                            <i class="fas fa-trash"></i>
                            Remover
                        </button>`;
            }}
        ]
    });
    $('#table-imoveis').DataTable();

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
        let btn = $(this);
        btn.prop("disabled", true);
        
        $.ajax({
            method: "post",
            action: "/admin/visita-imovel",
            headers: {'X-CSRF-TOKEN': token},
            data: formData
        })
        .done((result) => {
            btn.prop("disabled", false);
            if(result.success){
                $('#modal-novo-imovel').modal("hide");
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
