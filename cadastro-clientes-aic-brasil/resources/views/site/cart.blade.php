<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Carrinho - AIC Brasil</title>
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
  <link href="/site/css/style1.css" rel="stylesheet">
</head>
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

      <h1 class="">
        <a href="/">
            <img src="/site/img/logo_nova.png" height="80">
            </a>
      </h1>
      <!-- Uncomment below if you prefer to use an image logo -->
      <!-- <a href="index.html" class="logo"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->

      <nav id="navbar" class="navbar">
        <ul>
            <li><a class="nav-link scrollto active" href="/">Home</a></li>
            <li><a class="getstarted scrollto" href="{{route('view.order')}}">Acompanhe seu pedido</a></li>
            <li>
                <a class="getstarted scrollto" style="margin-left: 10px !important;" href="https://calendar.app.google/6z3LcTvPVwnE7Y6dA" target="_blank">Agendamento Área Gourmet</a>
            </li>
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
                        <td colspan="4" class="table-secondary"><h4>Não há itens no carrinho</h4></td>
                    </tr>
                </tbody>
            @endif
        </table>
        @if(count($cart) > 0)
            <a href="{{ route('cart.clear') }}" class="btn btn-secondary">Remover Tudo</a>
            <form action="{{ route('checkout.confirm') }}" method="GET" style="display: inline-block">
                @csrf
                <button type="submit" class="btn btn-primary">Prosseguir ao Checkout</button>
            </form>
            <a href="{{ route('planos') }}" class="btn btn-success">Continuar comprando</a>
        @else
            <a href="{{ route('planos') }}" class="btn btn-success">Comprar um plano</a>
        @endif
    </div>

    <a href="https://wa.me/5508003482342?text=Quero%20saber%20mais%20sobre%20a%20AIC%20Brasil%20Assistência%2024h" data-bs-toggle="tooltip" data-bs-placement="top" id="botao_whatsapp" title="Contato no Whatsapp" target="_blank" >
        <i style="margin-top:10px; font-size: 40px;" class="bx bxl-whatsapp"></i>
    </a>
    <button id="botao_doacao" data-bs-toggle="tooltip" data-bs-placement="top" title="Faça uma doação">
        <i style="margin-top:10px; font-size: 40px;" class="bx bx-donate-heart"></i>
    </button>
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
  {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/gijgo/1.9.14/combined/js/gijgo.min.js"></script> --}}

  <!-- Template Main JS File -->
  <script src="/site/js/main1.js"></script>


</body>

</html>


