$(document).ready(function(){
    $('#birthDate').inputmask('99/99/9999');

    $('#birthDate').datetimepicker({
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
    $('.file-input').change(function(evt) {
        const fileName = evt.target.files[0]?.name || "Nenhum Arquivo selecionado";
        $(this).parent().find('.file-label-text').html(`<span class="text-muted">Arquivo selecionado:</span> ${fileName} <i class="fas fa-check-circle"></i>`)
    });
});
