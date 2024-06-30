$(document).ready(function(){
    $('#birthDate').inputmask('99/99/9999');

    // Adicionando um método de validação personalizado
    $.validator.addMethod("regex", function(value, element, regexp) {
        return this.optional(element) || regexp.test(value);
    }, "Por favor, insira um formato válido.");

    $('#form_bank_pj').validate({
        submitHandler: function(){
            $('#form_bank_pj').submit();
        },
        rules: {
            name: {
                required: true,
                maxLength: 255
            },
            nameDisplay: {
                required: true,
                maxLength: 255
            },
            emailContact: {
              required: true,
              email: true
            },
            phone: {
                regex: /^\(?\d{2}\)?[\s-]?\d{4,5}-?\d{4}$/
            },
            document:{
                regex: /([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})/g
            },
            responsibleDocument:{
                regex: /([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})/g
            },
            zipcode: "required",
            street: "required",
            number: "required",
            neighborhood: "required",
            city: "required",
            state: "required",
            internalName: "required",
            inscription: {
                required: true,
                digits: true
            },
            typeCompany: "required",
            cnae:{
                required: true,
                digits: true
            }
        },
        messages: {
          name: {
            maxLength: "Máximo de 255 caracteres excedido."
            },
          emailContact: {
            email: "Email com formato inválido."
          },
          phone: {
            digits:'Por favor insira um telefone válido'
          }
        },
        errorClass: "invalid text-danger"
    });

    /** máscaras */
    $('[name=phone]').inputmask('(99) 99999-9999');
    $('[name=document]').inputmask('99.999.999/9999-99');
    $('[name=responsibleDocument]').inputmask('999.999.999-99');
    $('[name=zipcode]').inputmask('99999-999');

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

    $("#zipcode").blur(() => buscarCep());
  
  function buscarCep() {
    var cep = $('#zipcode').val();
    console.log(cep != undefined && cep != '')
    if(cep != undefined && cep != ''){
      $("#spinner").show();
      $('#zipcode').prop('disabled', true);
      $('#street').prop('disabled', true);
      $('#neighborhood').prop('disabled', true);
      $('#city').prop('disabled', true);
      $('#state').prop('disabled', true);

      $.ajax({
          url: '/cep/' + cep,
          method: 'GET',
          dataType: 'json',
          success: function(data) {
              $('#zipcode').prop('disabled', false);
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
              $('#zipcode').prop('disabled', false);
              $('#street').val(data.logradouro).prop('disabled', false);
              $('#neighborhood').val(data.bairro).prop('disabled', false);
              $('#city').val(data.localidade).prop('disabled', false);
              $('#state').val(data.uf).change().prop('disabled', false);
          }
      });
    }
  }
});
