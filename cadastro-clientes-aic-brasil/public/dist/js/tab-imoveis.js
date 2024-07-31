$(document).ready( function () {
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
                return d.street + " " + d.number+ " " + (d.complement ? d.complement : "") + " - " + d.neighborhood
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

    $("#btnNovoImovel").click(showModalNovoImovel);

    $("#zipCode").blur(() => buscarCep());

    $("#btnSalvarNovoImovel").click(()=>{
        let formData = $("#form-imovel").serialize();
        let token = $("[name=_token]").val();
        
        $modal = $('#modal-novo-imovel');
        let id = $modal.find("[name=id]").val()
        
        let btn = $(this);
        btn.prop("disabled", true);
        
        let url = parseInt(id) != NaN && parseInt(id) > 0
            ? `/admin/editar-imovel/${id}` : "/admin/criar-imovel";
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

    $('[name=cpf_proprietario]').inputmask('999.999.999-99');
    $('[name=zipCode]').inputmask('99999-999');

});

function showModalNovoImovel(button){
    $button = $(button);
    $modal = $('#modal-novo-imovel').modal();
    $modal.find('.modal-title').text('Novo Imóvel');
    $modal.find('input, select').val('');

    $modal.find('input[name=codigo_imovel]').prop("disabled", true);
    $modal.find('input[name=codigo_imovel]').closest('.form-group').hide();
    $modal.show();
}

function showModalEditarImovel(btn) {
    let id = parseInt($(btn).data('id'));
    $modal = $('#modal-novo-imovel').modal();
    $modal.find('.modal-title').text('Editar Imóvel');
    $modal.find('input, select').val('');

    $modal.find('input[name=codigo_imovel]').prop("disabled", true);
    $modal.find('input[name=codigo_imovel]').closest('.form-group').show();

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
        url: '/admin/remover-imovel',
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