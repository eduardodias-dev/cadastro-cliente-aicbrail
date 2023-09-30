$(document).ready( function () {
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
        console.log(response);
    })
    .fail( function(err) {
        console.log(err);
    })
    .always(function(){
        callback()
    });

}
