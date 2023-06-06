<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Acompanhar Pedido - AIC Brasil</title>
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

  <!-- Template Main CSS File -->
  <link href="/site/css/style.css" rel="stylesheet">

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

      <h1 class="logo"><a href="/">AIC Brasil</a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
            <li><a class="nav-link scrollto active" href="/">Home</a></li>
            <li><a class="getstarted scrollto" href="{{route('view.order')}}">Acompanhe seu pedido</a></li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main" style="margin-top: 70px; background: #fafafa" class="py-1">
    <div class="container py-5" style="background: white;border:">
        <h1>Detalhes do seu pedido</h1>
        <div class="main-form mt-2" style="min-height: 600px;">
            <div class="row py-3">
                @if(session()->get('assinatura_criada'))
                    <div class="row">
                        <div class="col-md-12">
                            <div class="alert alert-success" role="info">
                                Plano criado com sucesso
                            </div>
                        </div>
                    </div>
                @endif
                @if($error)
                <div class="row">
                    <div class="col-md-12">
                        <div class="alert alert-info" role="info">
                            Não foi encontrado nenhum pedido com esse código.
                        </div>
                    </div>
                </div>
                @else
                    @foreach($subscriptions as $subscription)
                        <div class="box-assinaturas card p-3 mb-3">
                            <div class="col-md-12">
                                <h2>Assinatura</h2>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h4>Dados do Plano:</h4>
                                        </div>
                                        <div class="card-body">
                                            <b style="font-size: 20px;">Status da Assinatura:</b>
                                                <span class="{{getClassByStatus($subscription['status'])}}" style="font-size: 20px;">{{ucfirst($subscription['status'])}}</span>
                                            <br>
                                            <b>Plano Contratado:</b> {{$subscription['nome']}}<br>
                                            <b>Titular:</b> {{$subscription['nome_cliente']}}<br>
                                            <b>Documento:</b> {{$subscription['documento']}}<br>
                                            <b>Email:</b> {{$subscription['emails']}}<br>
                                            <b>Telefone:</b> {{$subscription['telefone']}}<br>
                                            <b>Valor:</b> {{getValorEmReal($subscription['valor'])}}<br>
                                            <b>Periodicidade:</b> {{$subscription['periodicidade']}}<br>
                                            <b>Quantidade:</b> {{$subscription['quantidade']}}<br>
                                            <b>Info Adicional:</b> {{$subscription['info_adicional']}}<br>
                                            <b>Forma de Pagamento:</b> {{$subscription['tipo_pagamento']}}<br>
                                            @if($subscription['tipo_cadastro'] == "J")
                                                <b>Nome Representante:</b> {{$subscription['nome_representante']}}<br>
                                                <b>CPF Representante:</b> {{$subscription['cpf_representante']}}<br>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card ">
                                        <div class="card-header">
                                            <h4>Dados de Endereço</h4>
                                        </div>
                                        <div class="card-body">
                                            <b>Rua:</b> {{$subscription['logradouro']}}, {{$subscription['numero']}} {{$subscription['complemento']}}<br>
                                            <b>Bairro:</b> {{$subscription['bairro']}}<br>
                                            <b>Cidade:</b> {{$subscription['cidade']}}/{{$subscription['estado']}}<br>
                                            <b>CEP:</b> {{$subscription['cep']}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <div class="card ">
                                        <div class="card-header">
                                            <h4>Adquirido com o Plano:</h4>
                                        </div>
                                        <div class="card-body">
                                            <ul>
                                                @foreach($subscription['adicionais_assinatura'] as $grupo => $tipo)
                                                    <li>
                                                        <b>{{$grupo}}</b>
                                                        <ul>
                                                            @foreach($tipo as $adicional)
                                                                <li>{{$adicional['nome_adicional']}}</li>
                                                            @endforeach
                                                        </ul>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
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
