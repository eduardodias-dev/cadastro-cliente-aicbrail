$(document).ready( function () {
    $('[data-toggle="tooltip"]').tooltip()
    $('#table-clientes').DataTable();
    $('#table-afiliados').DataTable();
    $('#table-pacotes').DataTable();
    $('#table-plans').DataTable();

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
