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
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->
  <div class="container">
    @php
        $cart = session('carrinho');
        $total = 0;
        if(isset($cart))
            foreach($cart as $item){
                $total += $item['valor_calculado'];
            }
        else
            $cart = [];
    @endphp
    <h1>Carrinho</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Plano</th>
                    <th>Titular</th>
                    <th>Valor total</th>
                    <th></th>
                </tr>
            </thead>
            @if(count($cart) > 0)
                <tbody>
                    @foreach($cart as $item)
                    <tr>
                        <td>{{ $planos[array_search($item['plan_id'], array_column($planos, 'id'))]['nome'] }}</td>
                        <td>{{ $item['nome'] }}</td>
                        <td>{{ getValorEmReal($item['valor_calculado']) }}</td>
                        <td>
                            <form action="{{ route('cart.remove') }}" method="POST">
                                @csrf
                                <input type="hidden" name="plan_id" value="{{ $item['plan_id'] }}">
                                <button type="submit" class="btn btn-danger">Remover</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-secondary">
                        <td colspan="2"><b>Total</b></td>
                        <td>{{ getValorEmReal($total) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            @else
                <tbody>
                    <tr>
                        <td colspan="4" class="table-secondary" align="center"><h4>Não há itens no carrinho</h4></td>
                    </tr>
                </tbody>
            @endif
        </table>
        @if(count($cart) > 0)
            <a href="{{ route('cart.clear') }}" class="btn btn-secondary">Remover Tudo</a>
        @endif
        {{-- <a href="{{ route('site.checkout') }}" class="btn btn-primary">Prosseguir ao Checkout</a> --}}

        <!-- Add your additional HTML content, such as subtotal, discounts, etc. -->
    </div>

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


