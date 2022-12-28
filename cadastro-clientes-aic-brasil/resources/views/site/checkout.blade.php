<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Checkout - AIC Brasil</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="site/img/favicon.png" rel="icon">
  <link href="site/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="site/vendor/aos/aos.css" rel="stylesheet">
  <link href="site/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="site/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="site/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="site/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="site/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="site/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="site/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: OnePage - v4.9.2
  * Template URL: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="logo"><a href="index.html">AIC Brasil</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="#services">Serviços</a></li>
          <li><a class="nav-link scrollto" href="#pricing">Planos</a></li>
          <li><a class="nav-link scrollto" href="#contact">Contato</a></li>
          <li><a class="getstarted scrollto" href="#about">Get Started</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main" style="margin-top: 70px; background: #fafafa" class="py-1">
    <div class="container py-5" style="background: white;border:">
        <h1>CHECKOUT</h1>

        <div class="main-form mt-2">
            <div class="row">
                <div class="col-md-6">
                    <form id="form-checkout" method="POST">
                        <div class="form-group">
                            <div class="mb-1">
                                <label class="">Tipo de cadastro</label>
                            </div>
                            <div class="mb-1">
                                <input type="radio" name="tipo_cadastro" value="1" id=""> Pessoa Física
                                <input type="radio" name="tipo_cadastro" value="2" id=""> Pessoa Jurídica
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="email">E-mail</label>
                                <input type="email" name="email" id="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="nome">Nome</label>
                                <input type="nome" name="nome" id="" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-8">
                                <label for="cpf">CPF</label>
                                <input type="cpf" name="cpf" id="" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="telefone">Telefone</label>
                                <input type="telefone" name="telefone" id="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="celular">Celular</label>
                                <input type="celular" name="celular" id="" class="form-control">
                            </div>
                        </div>
                        <h4 class="mt-2">Endereço</h4>
                        <div class="row mt-2">
                            <div class="form-group col-md-3">
                                <label for="cep">CEP</label>
                                <input type="cep" name="cep" id="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="logradouro">Logradouro</label>
                                <input type="logradouro" name="logradouro" id="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="numero">Número</label>
                                <input type="numero" name="numero" id="" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-4">
                                <label for="complemento">Complemento</label>
                                <input type="complemento" name="complemento" id="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="bairro">Bairro</label>
                                <input type="bairro" name="bairro" id="" class="form-control">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="cidade">Cidade</label>
                                <input type="cidade" name="cidade" id="" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-4">
                                <label for="estado">Estado</label>
                                <select name="estado" class="form-control">
                                    <option value="" class="">Selecione</option>
                                    {{printEstadosAsOptions()}}
                                </select>
                            </div>
                        </div>
                        <h4 class="mt-2">Informações Adicionais</h4>
                        <div class="row mt-2">
                            <div class="form-group col-md-3">
                                <label for="alfabetizado">Alfabetizada</label>
                                <select name="alfabetizado" class="form-control">
                                    <option value="" class="">Selecione</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="rg">RG</label>
                                <input type="rg" name="rg" id="" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="sexo">Sexo</label>
                                <select name="sexo" class="form-control">
                                    <option value="" class="">Selecione</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="datanasc">Data de Nascimento</label>
                                <input type="datanasc" name="datanasc" id="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="estado_civil">Estado Civil</label>
                                <select name="estado_civil" class="form-control">
                                    <option value="" class="">Selecione</option>
                                    <option value="1">Solteiro</option>
                                    <option value="2">Casado</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="cutis">Cútis - Cor</label>
                                <select name="cutis" class="form-control">
                                    <option value="" class="">Selecione</option>
                                    <option value="1">Afro</option>
                                    <option value="2">Branca</option>
                                    <option value="3">Indígena</option>
                                    <option value="4">Mestiça</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="ocupacao">Ocupação - Profissão</label>
                                <input type="text" name="ocupacao" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <h5>Club de Benefício</h5>
                                <input type="checkbox" name="anti_multas" id="">
                                <label for="anti_multas">ANTI-MULTAS (RECURSO)</label><br>
                                <input type="checkbox" name="auxilio_cesta_basica" id="">
                                <label for="auxilio_cesta_basica">AUXÍLIO CESTA BÁSICA</label><br>
                                <input type="checkbox" name="emergencia_residencial" id="">
                                <label for="emergencia_residencial">EMERGÊNCIA RESIDENCIAL</label><br>
                                <input type="checkbox" name="funeral_completo" id="">
                                <label for="funeral_completo">FUNERAL COMPLETO</label><br>
                                <input type="checkbox" name="corretor_imob" id="">
                                <label for="corretor_imob">CORRETOR iMoB.</label><br>
                                <input type="checkbox" name="despachante_detran" id="">
                                <label for="despachante_detran">DESPACHANTE DETRAN</label><br>
                                <input type="checkbox" name="despachante_porte_arma" id="">
                                <label for="despachante_porte_arma">DESPACHANTE PORTE ARMA</label><br>
                                <input type="checkbox" name="sindico_prof_trainee" id="">
                                <label for="sindico_prof_trainee">SINDICO(A) PROF. TRAINEE</label><br>
                                <input type="checkbox" name="escola_faculdade" id="">
                                <label for="escola_faculdade">ESCOLA & FACULDADE</label><br>
                                <input type="checkbox" name="consultor_contabil" id="">
                                <label for="consultor_contabil">CONSULTOR CONTÁBIL</label><br>
                                <input type="checkbox" name="consultor_jurídico" id="">
                                <label for="consultor_jurídico">CONSULTOR JURÍDICO</label><br>
                            </div>
                            <div class="form-group col-md-6">
                                <h5>COBERTURA 24h (365 DIAS)</h5>
                                <input type="checkbox" name="alagamento" id="">
                                <label for="alagamento">ALAGAMENTO | ENCHENTE</label><br>
                                <input type="checkbox" name="chaveiro" id="">
                                <label for="chaveiro">CHAVEIRO AUTO | RESIDENCIAL</label><br>
                                <input type="checkbox" name="furto_roubo_incendio" id="">
                                <label for="furto_roubo_incendio">FURTO | ROUBO | INCÊNDIO</label><br>
                                <input type="checkbox" name="guincho" id="">
                                <label for="guincho">GUINCHO - REBOQUE.24h</label><br>
                                <input type="checkbox" name="guarda" id="">
                                <label for="guarda">GUARDA DO VEÍCULO</label><br>
                                <input type="checkbox" name="pane_seca_eletrica" id="">
                                <label for="pane_seca_eletrica">PANE SECA | ELÉTRICA</label><br>
                                <input type="checkbox" name="pane_mecanica" id="">
                                <label for="pane_mecanica">PANE MECÂNICA</label><br>
                                <input type="checkbox" name="troca_pneus" id="">
                                <label for="troca_pneus">TROCA DE PNEU(S)</label><br>
                                <input type="checkbox" name="hospedagem_hotel" id="">
                                <label for="hospedagem_hotel">HOSPEDAGEM: HOSTEL | HOTEL</label><br>
                                <input type="checkbox" name="remocao_hospitalar" id="">
                                <label for="remocao_hospitalar">REMOÇÃO HOSPITALAR</label><br>
                                <input type="checkbox" name="translado_obito" id="">
                                <label for="translado_obito">TRASLADO DE ÓBTO</label><br>
                                <input type="checkbox" name="taxi_mobile" id="">
                                <label for="taxi_mobile">TÁXI MOBILE</label><br>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <h5>COMPRAR SEGURO(S)</h5>
                                <input type="checkbox" name="seguro_vida" id="">
                                <label for="seguro_vida">ACIDENTE - VIDA</label><br>
                                <input type="checkbox" name="seguro_auto" id="">
                                <label for="seguro_auto">AUTO - VEÍCULOS</label><br>
                                <input type="checkbox" name="seguro_comercial" id="">
                                <label for="furto_roubo_incendio">COMERCIAL</label><br>
                                <input type="checkbox" name="seguro_residencial" id="">
                                <label for="seguro_residencial">RESIDENCIAL</label><br>
                                <input type="checkbox" name="seguro_pbgl" id="">
                                <label for="seguro_pbgl">PGBL - VGBL</label><br>
                                <input type="checkbox" name="seguro_viagem" id="">
                                <label for="seguro_viagem">FÉRIAS - VIAGEM</label><br>
                            </div>
                            <div class="form-group col-md-6">
                                <h5 for="comprar_protecao_veicular">COMPRAR PROTEÇÃO VEICULAR</h5>
                                <select name="comprar_protecao_veicular" class="form-control">
                                    <option value="" class="">Selecione</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="cobertura_terceiros">COBERTURA DE 3º- TERCEIRO(S)</label>
                                <select name="cobertura_terceiros" class="form-control">
                                    <option value="" class="">Selecione</option>
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="tipo_veiculo">TIPO DO VEÍCULO</label>
                                <select name="tipo_veiculo" class="form-control">
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
                                <label for="modelo_veiculo">MODELO DO VEÍCULO</label>
                                <input type="text" name="modelo_veiculo" id="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="marca_veiculo">MARCA DO VEÍCULO</label>
                                <input type="text" name="marca_veiculo" id="" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="ano_fabricacao">ANO DE FABRICAÇÃO</label>
                                <input type="text" name="ano_fabricacao" id="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="placa_veiculo">PLACA</label>
                                <input type="text" name="placa_veiculo" id="" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="chassi">CHASSI</label>
                                <input type="text" name="chassi" id="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="renavam">RENAVAM</label>
                                <input type="text" name="renavam" id="" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="cor_veiculo">COR DO VEÍCULO</label>
                                <input type="text" name="cor_veiculo" id="" class="form-control">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="forma_pagamento">FORMA DE PAGAMENTO</label>
                                <select name="forma_pagamento" class="form-control">
                                    <option value="" class="">Selecione</option>
                                    <option value="1">CARTÃO DE CRÉDITO</option>
                                    <option value="2">BOLETO [PIX] BANCÁRIO</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="form-group col-md-6">
                                <label for="melhor_vencimento">MELHOR VENCIMENTO</label>
                                <select name="melhor_vencimento" class="form-control">
                                    <option value="" class="">Selecione</option>
                                    <option value="5">Dia 05</option>
                                    <option value="7">Dia 07</option>
                                    <option value="10">Dia 10</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="consultor_vendas">CONSULTOR(A) VENDA(S)</label>
                                <select name="consultor_vendas" class="form-control">
                                    <option value="" class="">Selecione</option>
                                    <option value="1">ADEMIR L. B. SILVA</option>
                                    <option value="2">JADSON SANTOS</option>
                                    <option value="3">LUDMILA SANTOS</option>
                                    <option value="4">JOYCE KELLY</option>
                                    <option value="5">MONIQUE F. SANTOS</option>
                                    <option value="6">RAFAEL ELIAS</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success">Avançar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 px-5">
                    <h5>Plano Selecionado:</h5>
                    <h3>GPS BLOCK + REBOQ.24h</h3>
                    <h2>R$ 99,99 / Mês</h2>
                    <small>*no Boleto/PIX</small><br>
                    <a href="#">Mais formas de pagamento</a>
                    <hr>
                </div>
            </div>
        </div>
    </div>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer">

    <div class="footer-top">
      <div class="container">
        <div class="row">

          <div class="col-lg-3 col-md-6 footer-contact">
            <h3>AIC Brasil</h3>
            <p>
              Rua das Sempre-Vivas 181,  <br>
              Sapucaia, Contagem/MG - CEP 32071-128<br>
              Brasil <br><br>
              <strong>Tel:</strong> (31) 97348-2342<br>
              <strong>Email:</strong> contato@aicbrasil-ies.com.br<br>
            </p>
          </div>

          <div class="col-lg-2 col-md-6 footer-links">
            <h4>Links úteis</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Home</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Sobre Nós</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Serviços</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Termos de Serviço</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Política de privacidade</a></li>
            </ul>
          </div>

          <div class="col-lg-3 col-md-6 footer-links">
            <h4>Nossos Serviços</h4>
            <ul>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Proteção Veicular</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Seguros</a></li>
              <li><i class="bx bx-chevron-right"></i> <a href="#">Faculdade EAD</a></li>
            </ul>
          </div>

          <div class="col-lg-4 col-md-6 footer-newsletter">
            <h4>Receba nossa Newsletter</h4>
            <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
            <form action="" method="post">
              <input type="email" name="email"><input type="submit" value="Subscribe">
            </form>
          </div>

        </div>
      </div>
    </div>

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
        <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
        <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
        <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
        <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
        <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
      </div>
    </div>
  </footer><!-- End Footer -->

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="site/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="site/vendor/aos/aos.js"></script>
  <script src="site/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="site/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="site/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="site/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="site/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="site/js/main.js"></script>

</body>

</html>
