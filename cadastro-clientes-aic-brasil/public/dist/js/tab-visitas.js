$(document).ready( function () {
    $('#table-visitas').DataTable({
        ajax: {
            url:'/admin/listar-visitas',
            dataSrc:'data'
        },
        columns:[
            {data: 'id'},
            {data: 'codigo_imovel'},
            {data: 'proprietario_imovel'},
            {data: 'data_visita'},
            {data: 'endereco_imovel'},
            {data: 'compradores_visita', render: (c, t)=>{
                if(!c) return ''

                return c.map(x => x.nome +" - "+ x.email).join(',');
            }},
            {data: null, render: (data, type, row, meta) =>
            {
                    return `<button class="btn btn-sm btn-outline-info ml-2 btnRowEdit" data-id="${row.id}" data-index="${meta.row}" onclick="showModalEditarVisita(this)">
                                <i class="fas fa-edit"></i>
                                Editar
                            </button>
                            <button class="btn btn-sm btn-outline-danger ml-2 btnRowRemove" data-id="${row.id}" data-index="${meta.row}" onclick="showModalRemoverVisita(this)">
                                <i class="fas fa-trash"></i>
                                Remover
                            </button>`;
            }}
        ]
    });

    $("#btnNovaVisita").click(showModalNovaVisita);

    $("#btnSalvarNovaVisita").click(()=>{
        let formData = $("#form-visita").serialize();
        let token = $("[name=_token]").val();
        
        $modal = $('#modal-nova-visita');
        let id = $modal.find("[name=id]").val()
        
        let btn = $(this);
        btn.prop("disabled", true);
        
        let url = parseInt(id) != NaN ? `/admin/visita/${id}` : "/admin/visita";
        let tableVisita = $('#table-visitas').DataTable();
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
                tableVisita.ajax.reload()
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

    $("[name=data_visita]").datetimepicker({
        format:'d/m/Y',
        lang:'pt-BR',
        i18n:{
            'pt-BR': { //Português(Brasil)
                    months: [
                    "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"
                    ],
                    dayOfWeekShort: [
                    "Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"
                    ],
                    dayOfWeek: ["Domingo", "Segunda", "Terça", "Quarta", "Quinta", "Sexta", "Sábado"]
                },
        }
      });

    $('#data_visita').inputmask('99/99/9999');
    $('[name=cpf]').inputmask('999.999.999-99');

});

function showModalNovaVisita(button){
    $button = $(button);
    $modal = $('#modal-nova-visita').modal();
    $modal.find('input, select').val('');

    carregarImoveis();

    $modal.show();
}

function showModalEditarVisita(btn) {
    let id = parseInt($(btn).data('id'));
    $modal = $('#modal-nova-visita').modal();
    $modal.find('input, select').val('');

    $.ajax({
        method: "get",
        url: `/admin/obter-visita/${id}`
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

function showModalRemoverVisita(button){
    $button = $(button);
    $modal = $('#modal-remover-visita').modal();

    var id_visita = $(button).data('id');
    $modal.find('[name=id_visita]').val(id_visita);

    $modal.show();
}

function salvarRemoverVisita(){
    $modal = $('#modal-remover-visita');

    let id_visita = $modal.find('[name=id_visita]').val();

    let token = $('[name="_token"]').val();
    let tableVisita = $('#table-visitas').DataTable();

    $.ajax({
        url: '/admin/visitas/remover',
        data: {
            id_visita
        },
        headers: {'X-CSRF-TOKEN': token},
        method: 'DELETE'
    }).done(response => {
        if(response.success){
            $('#modal-remover-visitas').modal('hide');
            tableVisita.ajax.reload();
        }
        else console.log(response);
    })
    .fail( function(err) {
        console.log(err);
    });

}

function carregarImoveis(){
    $.ajax({
        url: "/admin/listar-imoveis",
        method: "GET",
        contentType: "application/json; charset=utf-8"
    })
    .done(result => 
    {
        if(result.success){
            $select = $("#selectImoveis");
            let items = result.data;
            $select.empty();

            for(let i in items){
                $op = $('<option>');
                $op.val(result.data[i].id);
                $op.text(`${result.data[i].id} - ${result.data[i].street} ${result.data[i].number} - ${result.data[i].neighborhood} - ${result.data[i].city}/${result.data[i].state}`);

                $select.append($op)
            }
        }
    })
    .fail(e => {
        console.log(e);
    })
}