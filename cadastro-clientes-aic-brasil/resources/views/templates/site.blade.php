<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>@yield('title')</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="/site/img/LOGO-AIC-BRASIL.ico" rel="icon">
  {{-- <link href="site/img/apple-touch-icon.png" rel="apple-touch-icon"> --}}

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css" integrity="sha512-NhSC1YmyruXifcj/KFRWoC561YpHpc5Jtzgvbuzx5VozKpWvQ+4nXhPdFgmx8xqexRcpAglTj9sIBWINXa8x5w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="/site/vendor/aos/aos.css" rel="stylesheet">
  <link href="/site/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/site/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/site/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="/site/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="/site/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="/site/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="/site/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="/dist/plugins/fontawesome-free/css/fontawesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/dist/plugins/datetimepicker/jquery.datetimepicker.min.css" />
  <link href="/dist/plugins/fontawesome-free/css/fontawesome.min.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="/site/css/style1.css" rel="stylesheet">
  <!-- =======================================================
  * Template Name: OnePage - v4.9.2
  * Template URL: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<body>
    @if(isset($session_id) && !empty($session_id))
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
    @endif
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center justify-content-between">

      <h1 class="">
        <a href="/">
            <img src="/site/img/logo_nova.png" height="80"></a></h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
      @php
        $route = request()->route()->uri
      @endphp
      <nav id="navbar" class="navbar">
        <ul>
            <li><a class="nav-link scrollto active" href="{{ $route == '/' ? '#hero' : route('index') }}">Home</a></li>
            <li><a class="nav-link scrollto" href="{{ $route == '/' ? '#services' : route('index') }}">Serviços</a></li>
            <li><a class="nav-link scrollto" href="{{ $route == '/' ? '#pricing' : route('planos') }}">Planos</a></li>
            <li><a class="nav-link scrollto" href="{{ $route == '/' ? '#contact' : route('index') }}">Contato</a></li>
            <li>
                <a class="nav-link cart-link" href="{{route('cart.index')}}" title="Ver Carrinho">
                    <i class='bx bxs-cart' style="font-size: 22px;"></i>
                    {{-- <span class="badge bg-primary">5</span> --}}
                </a>
            </li>
            <li><a class="getstarted scrollto" href="{{route('view.order')}}">Acompanhe seu pedido</a></li>
            <li>
                <a class="getstarted scrollto" style="margin-left: 10px !important;" href="https://calendar.app.google/6z3LcTvPVwnE7Y6dA" target="_blank">Agendamento Área Gourmet</a>
            </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
  <!-- Content -->

  <div class="content-wrapper">
      @yield('content')
  </div>

  <!-- End Content -->

<!-- ======= Footer ======= -->
  <footer id="footer">
    <div class="container d-md-flex py-4">

      <div class="me-md-auto text-center text-md-start">
        <div class="copyright">
          &copy; Copyright <strong><span>AIC Brasil</span> CNPJ: 46.476.232|0001-11</strong>. Todos os Direitos Reservados
        </div>
        <div class="credits">
          <!-- All the links in the footer should remain intact. -->
          <!-- You can delete the links only if you purchased the pro version. -->
          <!-- Licensing information: https://bootstrapmade.com/license/ -->
          <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/ -->
          Design por <a href="https://bootstrapmade.com/">BootstrapMade</a>
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

  <div class="modal fade" tabindex="-1" id="modal-doacao">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Doação</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="text-center">
                        <a href="https://www.asaas.com/c/674960587769" class="d-block" target="_blank">
                            <i style="margin-top:10px; font-size: 50px;" class="bx bx-donate-heart"></i>
                        </a>
                    </div>
                    <p class="text-center">
                        <b>Doar pelo ASAAS</b>
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="text-center">
                        <a href="https://www.paypal.com/donate/?hosted_button_id=E7PZYWUJXQRUU" class="d-block" target="_blank">
                            <i style="margin-top:10px; font-size: 40px;" class="bi bi-paypal"></i>
                        </a>
                    </div>
                    <p class="text-center">
                        <b>Doar pelo Paypal</b>
                    </p>
                </div>
            </div>
        </div>
      </div>
    </div>
  </div>

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
  <script src="/site/vendor/siema/siema.min.js"></script>

  <!-- Template Main JS File -->
  <script src="/site/js/main1.js"></script>

</body>

</html>
