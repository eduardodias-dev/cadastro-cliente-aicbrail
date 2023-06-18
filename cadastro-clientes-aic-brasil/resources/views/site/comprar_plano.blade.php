<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Checkout - AIC Brasil</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="/site/img/LOGO-AIC-BRASIL.ico" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/site/vendor/aos/aos.css" rel="stylesheet">
  <link href="/site/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/site/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/site/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/site/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="/site/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/site/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.14/combined/css/gijgo.min.css"> --}}
  <link rel="stylesheet" href="/dist/plugins/datetimepicker/jquery.datetimepicker.min.css" />
  <link href="/dist/plugins/fontawesome-free/css/fontawesome.min.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="/site/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: OnePage - v4.9.2
  * Template URL: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<!-- Modal -->
<div class="modal fade modal-lg" id="modal-checkout" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> --}}
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="text-center" id="box-carregando" style=" padding: 20px;">
                <i class='bx bx-loader-alt bx-spin bx-rotate-180 text-center' style="font-size: 50px; color: #1264d0" ></i>
                <h5 class="text-center">Aguarde, Estamos processando seu pedido.</h5>
            </div>
        </div>
      </div>
    </div>
</div>
  <div class="modal fade modal-lg" id="modal-result" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> --}}
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div id="box-sucesso" class="text-center" style=" padding: 20px;">
                <i class='bx bxs-check-circle ' style="font-size: 50px; color: #03a803;" ></i>
                <div class="mensagem">

                </div>
            </div>
            <div id="box-erro" class="text-center" style=" padding: 20px;">
                <i class='bx bxs-error-circle ' style="font-size: 50px; color: #a80303;" ></i>
                <div class="mensagem">

                </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade modal-lg" id="modal-pesquisando-pedido" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          {{-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> --}}
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="text-center" id="box-carregando" style=" padding: 20px;">
                <i class='bx bx-loader-alt bx-spin bx-rotate-180 text-center' style="font-size: 50px; color: #1264d0" ></i>
                <h5 class="text-center">Aguarde, Estamos pesquisando seu pedido.</h5>
            </div>
        </div>
      </div>
    </div>
    </div>
<body>
    <input type="hidden" id="session_id" value="{{$session_id}}" />
    <script type="text/javascript">
        (function (a, b, c, d, e, f, g) {

            a['CsdpObject'] = e; a[e] = a[e] || function () {

            (a[e].q = a[e].q || []).push(arguments)

            }, a[e].l = 1 * new Date(); f = b.createElement(c),

            g = b.getElementsByTagName(c)[0]; f.async = 1; f.src = d; g.parentNode.insertBefore(f, g)

        })(window, document, 'script', '//device.clearsale.com.br/p/fp.js', 'csdp');

        csdp('app', 'GalaxPay');
        var input = document.getElementById('session_id');
        csdp('sessionid', input.value);
    </script>
  <!-- ======= Header ======= -->
  <header id="header" class="">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="/">AIC Brasil</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
            <li><a class="nav-link scrollto active" href="/">Home</a></li>
            <li><a class="getstarted scrollto" href="{{route('view.order')}}">Acompanhe seu pedido</a></li>
            <li>
                <a class="nav-link cart-link" href="{{route('cart.index')}}" title="Ver Carrinho">
                    <i class='bx bxs-cart' style="font-size: 22px;"></i>
                    <span class="badge badge-primary">5</span>
                </a>
            </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main" style="margin-top: 0px; background: #fafafa" class="py-1">
    <div class="container py-5" >
        <h1>Comprar Plano</h1>

        <div class="main-form mt-2">
            @if(session()->has('erros'))
                <div class="row" >
                    <div class="alert alert-danger alert-dismissible">
                        Ops... Parece que temos problemas com seus dados, por favor preencha corretamente :)
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif
            <div class="row align-items-start">
                <div class="col-md-6 p-5" style="background: white;">
                    <form id="form-checkout" method="POST" action="{{route('cart.add')}}">
                        @csrf
                        <input type="hidden" value="{{$plano->id}}" name="plan_id" />
                        <input type="hidden" value="{{$plano->preco}}" name="plan_price" />
                        <div class="form-group">
                            <div class="mb-1">
                                <label class="">Tipo de cadastro</label>
                            </div>
                            <div class="mb-1">
                                <input type="radio" name="tipo_cadastro" value="F" id="" checked="true"> Pessoa Física
                                <input type="radio" name="tipo_cadastro" value="J" id=""> Pessoa Jurídica
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="cpfcnpj" class="cpfcnpj required">CPF</label>
                                <input type="text" name="cpfcnpj" id="" class="form-control required" value="{{old('cpfcnpj')}}">
                            </div>

                            <div class="form-group col-md-6">
                                <label for="nome" class="required">Nome</label>
                                <input type="text" name="nome" id="" class="form-control required" required  value="{{old('nome')}}">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-12">
                                <label for="email" class="required">E-mail</label>
                                <input type="email" name="email" id="" class="form-control required" required  value="{{old('email')}}">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="celular" class="required">Celular</label>
                                <input type="text" name="celular" id="" class="form-control required" required value="{{old('celular')}}">
                            </div>
                        </div>
                        <h4 class="mt-2">Endereço</h4>
                        <div class="row mt-2">
                            <div class="form-group col-md-3">
                                <label for="cep" class="required">CEP</label>
                                <input type="text" name="cep" id="" class="form-control required" required value="{{old('cep')}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="logradouro" class="required">Logradouro</label>
                                <input type="text" name="logradouro" id="" class="form-control required" required value="{{old('logradouro')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="numero" class="required">Número</label>
                                <input type="text" name="numero" id="" class="form-control required" required value="{{old('numero')}}">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-4">
                                <label for="complemento" class="required">Complemento</label>
                                <input type="text" name="complemento" id="" class="form-control required" value="{{old('complemento')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="bairro" class="required">Bairro</label>
                                <input type="text" name="bairro" id="" class="form-control required" required value="{{old('bairro')}}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cidade" class="required">Cidade</label>
                                <input type="text" name="cidade" id="" class="form-control required" required value="{{old('cidade')}}">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-4">
                                <label for="estado" class="required">Estado</label>
                                <select name="estado" class="form-control required" required value="{{old('estado')}}">
                                    <option value="" class="">Selecione</option>
                                    {{printEstadosAsOptions()}}
                                </select>
                            </div>
                        </div>
                        <h4 class="mt-2">Informações Adicionais</h4>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="rg">RG</label>
                                <input type="rg" name="rg" id="" class="form-control" value="{{old('rg')}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nome_representante">Nome Representante</label>
                                <input type="text" name="nome_representante" id="" class="form-control" value="{{old('nome_representante')}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cpf_representante">CPF Representante</label>
                                <input type="text" name="cpf_representante" id="" class="form-control" value="{{old('cpf_representante')}}">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="alfabetizado" class="required">Alfabetizada</label>
                                <select name="alfabetizado" class="form-control required" value="{{old('alfabetizado')}}">
                                    <option value="" class="">Selecione</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="sexo">Sexo</label>
                                <select name="sexo" class="form-control" value="{{old('sexo')}}">
                                    <option value="" class="">Selecione</option>
                                    <option value="M">Masculino</option>
                                    <option value="F">Feminino</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="datanasc" class="required">Data de Nascimento</label>
                                <input type="text" name="datanasc" id="datetimepicker" class="form-control required" required value="{{old('datanasc')}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="estado_civil" class="required">Estado Civil</label>
                                <select name="estado_civil" class="form-control required" required value="{{old('estado_civil')}}">
                                    <option value="" class="">Selecione</option>
                                    <option value="1">Solteiro</option>
                                    <option value="2">Casado</option>
                                    <option value="3">Divorciado</option>
                                    <option value="3">União Estável</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="cutis">Cútis - Cor</label>
                                <select name="cutis" class="form-control" value="{{old('cutis')}}">
                                    <option value="" class="">Selecione</option>
                                    <option value="1">Afro</option>
                                    <option value="2">Branca</option>
                                    <option value="3">Indígena</option>
                                    <option value="4">Mestiça</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ocupacao">Ocupação - Profissão</label>
                                <input type="text" name="ocupacao" class="form-control" value="{{old('ocupacao')}}">
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <h5>Club de Benefício</h5>
                                @isset($club_beneficio)
                                    @foreach ($club_beneficio as $item)
                                        <div>
                                            <input type="checkbox" class="adicional_assinatura" name="club_beneficio[]" value="{{$item->id}}" data-nome="{{$item->nome}}" data-preco="{{$item->valor}}" data-incluso-plano="{{$item->incluso_nos_planos}}">
                                            <label for="club_beneficio[]">{{$item->nome}}</label>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                            <div class="form-group col-md-6">
                                <h5>COBERTURA 24h (365 DIAS)</h5>
                                @isset($cobertura_24horas)
                                    @foreach($cobertura_24horas as $item)
                                        <div>
                                            <input type="checkbox" class="adicional_assinatura" name="cobertura_24horas[]" value="{{$item->id}}" data-nome="{{$item->nome}}" data-preco="{{$item->valor}}" data-incluso-plano="{{$item->incluso_nos_planos}}">
                                            <label for="cobertura_24horas[]">{{$item->nome}}</label>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <h5>COMPRAR SEGURO(S)</h5>
                                @isset($comprar_seguros)
                                    @foreach($comprar_seguros as $item)
                                        <div>
                                            <input type="checkbox" class="adicional_assinatura" name="comprar_seguros[]" value="{{$item->id}}" data-nome="{{$item->nome}}" data-preco="{{$item->valor}}" data-incluso-plano="{{$item->incluso_nos_planos}}">
                                            <label for="comprar_seguros[]">{{$item->nome}}</label>
                                        </div>
                                    @endforeach
                                @endisset
                            </div>
                            <div class="form-group col-md-6">
                                <h5 for="comprar_protecao_veicular">COMPRAR PROTEÇÃO VEICULAR</h5>
                                <select name="comprar_protecao_veicular" class="form-control" value="{{old('comprar_protecao_veicular')}}">
                                    <option value="" class="">Selecione</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="tipo_veiculo" class="required">TIPO DO VEÍCULO</label>
                                <select name="tipo_veiculo" class="form-control required" required value="{{old('tipo_veiculo')}}">
                                    <option value="" class="">Selecione</option>
                                    <option value="AUTOMOVEL">AUTOMOVEL</option>
                                    <option value="MOTOCICLETA">MOTOCICLETA</option>
                                    <option value="CAMINHÃO">CAMINHÃO</option>
                                    <option value="VAN_SUV">VAN - SUV</option>
                                    <option value="PICKUP">PICK-UP</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="modelo_veiculo" class="required">MODELO DO VEÍCULO</label>
                                <input type="text" name="modelo_veiculo" id="" class="form-control required" required value="{{old('modelo_veiculo')}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="marca_veiculo" class="required">MARCA DO VEÍCULO</label>
                                <input type="text" name="marca_veiculo" id="" class="form-control required" required value="{{old('marca_veiculo')}}">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="ano_fabricacao" class="required">ANO DE FABRICAÇÃO</label>
                                <input type="text" name="ano_fabricacao" id="" class="form-control required" required value="{{old('ano_fabricacao')}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="placa_veiculo" class="required">PLACA</label>
                                <input type="text" name="placa_veiculo" id="" class="form-control required" required value="{{old('placa_veiculo')}}">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="chassi" class="required">CHASSI</label>
                                <input type="text" name="chassi" id="" class="form-control required" required value="{{old('chassi')}}">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="renavam" class="required">RENAVAM</label>
                                <input type="text" name="renavam" id="" class="form-control required" required value="{{old('renavam')}}">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="cor_veiculo" class="required">COR DO VEÍCULO</label>
                                <input type="text" name="cor_veiculo" id="" class="form-control required" required value="{{old('cor_veiculo')}}">
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success">Confirmar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 p-5 sticky-top" style="background: white;">
                    <h5>Plano Selecionado:</h5>
                    <h3>{{$plano->nome}}</h3>
                    <h2>R$ {{format_number($plano->preco)}} / Mês</h2>
                    <small>*no Boleto/PIX</small><br>
                    <hr>
                    <div class="adicionais_inclusos mb-3 pb-3" style="border-bottom: .5px solid #ccc;">
                        <h5>Incluso no Plano:</h5>

                    </div>

                    <div class="adicionais_selecionados mb-3 pb-3" style="border-bottom: .5px solid #ccc;">
                        <h5>Adicionais Selecionados:</h5>

                    </div>
                    <div class="row total">
                        <h5>Total (Plano + Adicionais): <b>R$ <span class="preco_total">{{format_number($plano->preco)}}</span> / Mês</b></h5>

                    </div>
                </div>
            </div>
        </div>
    </div>
  </main><!-- End #main -->



  <!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container d-md-flex py-4">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span>AIC Brasil</span></strong>. Todos os Direitos Reservados
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/ -->
          Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
      </div>
      <div class="social-links text-center text-md-right pt-3 pt-md-0">
        <a href="https://www.facebook.com/AiCBrasilCARs/" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="https://www.instagram.com/aic_brasil/" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="/site/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="/site/vendor/aos/aos.js"></script>
  <script src="/site/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="/site/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="/site/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="/site/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="/site/vendor/php-email-form/validate.js"></script>
  <script src="/dist/js/jquery.min.js"></script>
  <script src="/dist/plugins/inputmask/jquery.inputmask.min.js"></script>
  <script src="/dist/plugins/datetimepicker/jquery.datetimepicker.full.js"></script>
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.14/combined/js/gijgo.min.js"></script> --}}

  <!-- Template Main JS File -->
  <script src="/site/js/main.js"></script>


</body>

</html>
