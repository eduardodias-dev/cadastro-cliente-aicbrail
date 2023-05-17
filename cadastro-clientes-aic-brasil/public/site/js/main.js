/**
* Template Name: OnePage - v4.9.2
* Template URL: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
*/
(function() {
  "use strict";

  /**
   * Easy selector helper function
   */
  const select = (el, all = false) => {
    el = el.trim()
    if (all) {
      return [...document.querySelectorAll(el)]
    } else {
      return document.querySelector(el)
    }
  }

  /**
   * Easy event listener function
   */
  const on = (type, el, listener, all = false) => {
    let selectEl = select(el, all)
    if (selectEl) {
      if (all) {
        selectEl.forEach(e => e.addEventListener(type, listener))
      } else {
        selectEl.addEventListener(type, listener)
      }
    }
  }

  /**
   * Easy on scroll event listener
   */
  const onscroll = (el, listener) => {
    el.addEventListener('scroll', listener)
  }

  /**
   * Navbar links active state on scroll
   */
  let navbarlinks = select('#navbar .scrollto', true)
  const navbarlinksActive = () => {
    let position = window.scrollY + 200
    navbarlinks.forEach(navbarlink => {
      if (!navbarlink.hash) return
      let section = select(navbarlink.hash)
      if (!section) return
      if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
        navbarlink.classList.add('active')
      } else {
        navbarlink.classList.remove('active')
      }
    })
  }
  window.addEventListener('load', navbarlinksActive)
  onscroll(document, navbarlinksActive)

  /**
   * Scrolls to an element with header offset
   */
  const scrollto = (el) => {
    let header = select('#header')
    let offset = header.offsetHeight

    let elementPos = select(el).offsetTop
    window.scrollTo({
      top: elementPos - offset,
      behavior: 'smooth'
    })
  }

  /**
   * Toggle .header-scrolled class to #header when page is scrolled
   */
  let selectHeader = select('#header')
  if (selectHeader) {
    const headerScrolled = () => {
      if (window.scrollY > 100) {
        selectHeader.classList.add('header-scrolled')
      } else {
        selectHeader.classList.remove('header-scrolled')
      }
    }
    window.addEventListener('load', headerScrolled)
    onscroll(document, headerScrolled)
  }

  /**
   * Back to top button
   */
  let backtotop = select('.back-to-top')
  if (backtotop) {
    const toggleBacktotop = () => {
      if (window.scrollY > 100) {
        backtotop.classList.add('active')
      } else {
        backtotop.classList.remove('active')
      }
    }
    window.addEventListener('load', toggleBacktotop)
    onscroll(document, toggleBacktotop)
  }

  /**
   * Mobile nav toggle
   */
  on('click', '.mobile-nav-toggle', function(e) {
    select('#navbar').classList.toggle('navbar-mobile')
    this.classList.toggle('bi-list')
    this.classList.toggle('bi-x')
  })

  /**
   * Mobile nav dropdowns activate
   */
  on('click', '.navbar .dropdown > a', function(e) {
    if (select('#navbar').classList.contains('navbar-mobile')) {
      e.preventDefault()
      this.nextElementSibling.classList.toggle('dropdown-active')
    }
  }, true)

  /**
   * Scrool with ofset on links with a class name .scrollto
   */
  on('click', '.scrollto', function(e) {
    if (select(this.hash)) {
      e.preventDefault()

      let navbar = select('#navbar')
      if (navbar.classList.contains('navbar-mobile')) {
        navbar.classList.remove('navbar-mobile')
        let navbarToggle = select('.mobile-nav-toggle')
        navbarToggle.classList.toggle('bi-list')
        navbarToggle.classList.toggle('bi-x')
      }
      scrollto(this.hash)
    }
  }, true)

  /**
   * Scroll with ofset on page load with hash links in the url
   */
  window.addEventListener('load', () => {
    if (window.location.hash) {
      if (select(window.location.hash)) {
        scrollto(window.location.hash)
      }
    }
  });

  /**
   * Preloader
   */
  let preloader = select('#preloader');
  if (preloader) {
    window.addEventListener('load', () => {
      preloader.remove()
    });
  }

  /**
   * Initiate glightbox
   */
  const glightbox = GLightbox({
    selector: '.glightbox'
  });

  /**
   * Testimonials slider
   */
  new Swiper('.testimonials-slider', {
    speed: 600,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    slidesPerView: 'auto',
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 20
      },

      1200: {
        slidesPerView: 3,
        spaceBetween: 20
      }
    }
  });

  /**
   * Porfolio isotope and filter
   */
  window.addEventListener('load', () => {
    let portfolioContainer = select('.portfolio-container');
    if (portfolioContainer) {
      let portfolioIsotope = new Isotope(portfolioContainer, {
        itemSelector: '.portfolio-item'
      });

      let portfolioFilters = select('#portfolio-flters li', true);

      on('click', '#portfolio-flters li', function(e) {
        e.preventDefault();
        portfolioFilters.forEach(function(el) {
          el.classList.remove('filter-active');
        });
        this.classList.add('filter-active');

        portfolioIsotope.arrange({
          filter: this.getAttribute('data-filter')
        });
        portfolioIsotope.on('arrangeComplete', function() {
          AOS.refresh()
        });
      }, true);
    }

  });

  /**
   * Initiate portfolio lightbox
   */
  const portfolioLightbox = GLightbox({
    selector: '.portfolio-lightbox'
  });

  /**
   * Portfolio details slider
   */
  new Swiper('.portfolio-details-slider', {
    speed: 400,
    loop: true,
    autoplay: {
      delay: 5000,
      disableOnInteraction: false
    },
    pagination: {
      el: '.swiper-pagination',
      type: 'bullets',
      clickable: true
    }
  });

  /**
   * Animation on scroll
   */
  window.addEventListener('load', () => {
    AOS.init({
      duration: 1000,
      easing: 'ease-in-out',
      once: true,
      mirror: false
    })
  });

  /**
   * Initiate Pure Counter
   */
  new PureCounter();

})()

var modalCheckout = new bootstrap.Modal('#modal-checkout');
var modalResult = new bootstrap.Modal('#modal-result');
var modalPesquisandoPedido = new bootstrap.Modal('#modal-pesquisando-pedido');

jQuery(function() {
    $('#box-sucesso, #box-erro').hide();

    $('#campos_cartao').hide('fast');
    $('.forma_pagamento').on('change', function(){
        var selecionada = $(this).val();
        if(selecionada == 'creditcard'){
            $('#campos_cartao').fadeIn('fast');
        }else{
            $('#campos_cartao').fadeOut('fast');
        }
    });

    /** máscaras */
    $('[name=celular]').inputmask('(99) 99999-9999');
    $('[name=telefone]').inputmask('(99) 9999-9999');
    $('[name=cpfcnpj]').inputmask('999.999.999-99');
    $('[name=cep]').inputmask('99999-999');
    $('[name=numero]').inputmask('9{1,}');
    $('[name=ano_fabricacao]').inputmask('9999');
    $('[name=placa_veiculo]').inputmask('aaa-*{4}');
    $('[name=card_number]').inputmask('9999 9999 9999 9999');
    $('[name=card_cvv]').inputmask('999');
    $('[name=card_expires_at]').inputmask('99/99');
    $('[name=cpf_representante]').inputmask('999.999.999-99');

    /**DateTime Picker */
    $('#datetimepicker').datetimepicker({
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
    $('#form-checkout').on('submit', (e) =>{
        e.preventDefault();
        var isValid = validarFormulario($(this));
        if(!isValid) return;

        var url = $(this).attr('action');
        var form_data = $('#form-checkout').serialize();
        var data = form_data;
        var token = $('[name="_token"]').val();

        $('#box-sucesso, #box-erro').hide()
        modalCheckout.show();

        $.ajax({
            url: url,
            data: data,
            headers: {'X-CSRF-TOKEN': token},
            method: 'POST'
        })
        .done(function(response) {
            if(response.success && "result" in response){
                var result = JSON.parse(response.result);
                if("error" in result)
                {
                    $('#box-erro').fadeIn('fast');
                    $('#box-erro .mensagem').html(result.error.message);
                }
                else{
                    var mensagem = montaMensagem(response);
                    $('#box-sucesso').fadeIn('fast');
                    $('#box-sucesso .mensagem').html(mensagem);

                    var dadosAssinatura = JSON.parse(response.result);
                    var forma_pagamento = $('.forma_pagamento').val();
                    var redirecionarPara = '';

                    if(forma_pagamento == 'creditcard'){
                        redirecionarPara = '/';
                    }else
                    {
                        var linkBoleto = dadosAssinatura.Subscription.Transactions[0].Boleto.pdf;
                        redirecionarPara = linkBoleto;
                    }

                    const myModalEl = document.getElementById('modal-result');
                    myModalEl.addEventListener('hidden.bs.modal', (e) => redirecionar(redirecionarPara))
                }
            }else{
                $('#box-erro').fadeIn('fast');
                $('#box-erro .mensagem').html(response.message);
            }
        })
        .fail(function(err) {
            $('#box-erro').fadeIn('fast');
            $('#box-erro .mensagem').html(result.message);
        })
        .always(function(){
            var timeout = setTimeout(() => {
                modalCheckout.hide();
            },1000);
            var timeout2 = setTimeout(() => {
                modalResult.show();
            },1000);
        });
    })

    $('#btn-search-order').click(function(){
        var token = $('[name="_token"]').val();
        modalPesquisandoPedido.show();
        $.ajax({
            url: '/vieworder',
            data: {'search': $('#search-order').val()},
            headers: {'X-CSRF-TOKEN': token},
            method: 'POST'
        }).done(response => {
            $('#resultado-pesquisa').html(response);
        })
        .fail( function(err) {
            console.log(err);
        })
        .always(function(){
            var timeout = setTimeout(() => {
                modalPesquisandoPedido.hide();
            },200);
        });
    });

    $('.adicionais_selecionados').hide();
    $('.adicionais_inclusos').hide();

    $precoTotal = parseFloat($('[name=plan_price]').val());
    $('.adicional_assinatura').on('click', function(){
        $item = $(this);

        $id = $item.val();
        $nome = $item.data('nome');
        $preco = $item.data('preco');
        $incluso_plano = $item.data('incluso-plano');

        if($item.is(':checked')){
            $('.adicionais_selecionados').append('<div class="adicional_selecionado_'+$id+'">'+$nome+' - '+formatarPreco($preco)+'</div>');
            $precoTotal += parseFloat($preco);
        }else{
            $('.adicionais_selecionados').find('.adicional_selecionado_'+$id+'').remove();
            $precoTotal -= parseFloat($preco);
        }

        if($('.adicional_assinatura:checked').length < 1){
            $('.adicionais_selecionados').hide();
            $precoTotal = parseFloat($('[name=plan_price]').val());
        }
        else
            $('.adicionais_selecionados').show();

        $('.preco_total').html(formatarPreco($precoTotal));
    });

    function visualizarAdicionaisInclusos(){
      $idPlanoSelecionado = $('[name=plan_id]').val();

      $('.adicional_assinatura').each(function(index, item){
        // console.log(item);
        var incluso_plano = $(item).data('incluso-plano');

        if(incluso_plano != undefined && incluso_plano != null && incluso_plano != ""){
            var planos = String(incluso_plano).split(',');

            if(planos.indexOf($idPlanoSelecionado) >= 0){
                $(this).prop('checked', true);
                $(this).prop('disabled', true);
                AdicionarAdicionalInclusos($(this));
            }
        }
      });
    }

    function AdicionarAdicionalInclusos($item){
        $('.adicionais_inclusos').show();

        $id = $item.val();
        $nome = $item.data('nome');
        $preco = $item.data('preco');
        $incluso_plano = $item.data('incluso-plano');

        $('.adicionais_inclusos').append('<div class="adicional_incluso_'+$id+'">'+$nome+'</div>');

    }

    function formatarPreco(price){
        var precoFormatado = (price).toLocaleString('pt-BR', {
            style: 'currency',
            currency: 'BRL'
        });

        return precoFormatado;
    }

    visualizarAdicionaisInclusos();

    function montaMensagem(response){
        var dadosAssinatura = JSON.parse(response.result);
        var forma_pagamento = $('.forma_pagamento').val();
        var mensagem = "";
        if(forma_pagamento == 'creditcard'){
            mensagem = "<h5>Seu pedido de assinatura foi recebido com sucesso. Estamos aguardando a confirmação do pagamento junto à administradora de cartão e você deve receber um email em breve.</h5>";
            mensagem += "<h5>Código do pedido: <b>"+dadosAssinatura.Subscription.myId+"</b></h5>";
            mensagem += "<h5>Plano: <b>"+dadosAssinatura.Subscription.additionalInfo+"</b></h5>";
            mensagem += "<h5>Titular: <b>"+dadosAssinatura.Subscription.Customer.name+"</b></h5>";
        }else
        {
            mensagem = "<h5>Seu pedido de assinatura foi recebido com sucesso. Ao fechar você será redirecionado para a página de pagamento do boleto</h5>";
            mensagem += "<h5>Código do pedido: <b>"+dadosAssinatura.Subscription.myId+"</b></h5>";
            mensagem += "<h5>Plano: <b>"+dadosAssinatura.Subscription.additionalInfo+"</b></h5>";
            mensagem += "<h5>Titular: <b>"+dadosAssinatura.Subscription.Customer.name+"</b></h5>";

        }

        return mensagem;
    }

    function redirecionar(url){
        window.location.href = url;
    }

    function validarFormulario($form){

        let isValid = true; // set the form's valid status to true

        // validate each input field
        $form.find("input.required").each(function() {
            if ($(this).val() === "") {
                isValid = false; // set the form's valid status to false
                $(this).addClass("error"); // add an error class to the input
                $(this).next(".error-message").text("Campo obrigatório."); // show an error message
            } else {
                $(this).removeClass("error"); // remove the error class
                $(this).next(".error-message").text(""); // remove the error message
            }
        });

        return isValid;
    }

    $('[name=tipo_cadastro]').change(function(){
        var val = $(this).val();
        alterarTipoCadastro(val);
    });

    function alterarTipoCadastro(val){
        if(val == "F"){
            $('[name=cpfcnpj]').val("");
            $("label.cpfcnpj").html("CPF");
            $("label[for=nome]").html("Nome");
            $('[name=cpfcnpj]').inputmask('999.999.999-99');

            $('[name=nome_representante]').closest('.form-group').hide();
            $('[name=nome_representante]').val("");

            $('[name=cpf_representante]').closest('.form-group').hide();
            $('[name=cpf_representante]').val("");

            $('[name=rg]').closest('.form-group').show();
        }
        else if(val == "J")
        {
            $('[name=cpfcnpj]').val("");
            $("label.cpfcnpj").html("CNPJ");
            $("label[for=nome]").html("Razão Social");
            $('[name=cpfcnpj]').inputmask('99.999.999/9999-99');

            $('[name=nome_representante]').closest('.form-group').show();
            $('[name=cpf_representante]').closest('.form-group').show();
            $('[name=rg]').closest('.form-group').hide();
        }
    }
    alterarTipoCadastro($('[name=tipo_cadastro]').val());
})
