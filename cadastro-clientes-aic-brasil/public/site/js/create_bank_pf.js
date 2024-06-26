$(document).ready(function(){
    // Adicionando um método de validação personalizado
    $.validator.addMethod("regex", function(value, element, regexp) {
        return this.optional(element) || regexp.test(value);
    }, "Por favor, insira um formato válido.");

    $('#form_bank_pf').validate({
        submitHandler: function(){
            $('#form_bank_pf').submit();
        },
        rules: {
            // simple rule, converted to {required:true}
            name: {
                required: true,
                maxLength: 255
            },
            // compound rule
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
    $('[name=document]').inputmask('999.999.999-99');
    $('[name=zipcode]').inputmask('99999-999');
});