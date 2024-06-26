<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Criar Conta Digital PJ</title>
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
  <link href="/site/css/bankstyles.css" rel="stylesheet">
  <!-- =======================================================
  * Template Name: OnePage - v4.9.2
  * Template URL: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<body>
    <div class="flex justify-content-center text-center">
        <img src="/site/img/logo_nova.png" height="80"></a>
    </div>
    <h4 class="text-center my-3">CRIAÇÃO DE CONTA PESSOA JURÍDICA</h4>
    <form method="post" action="{{route('create.bank.account.post', ['type' => 'pj'])}}" id="form_bank_pj">
    @if ($errors->any())
      <div class="alert alert-danger">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ formatCreateAccountErrors($error) }}</li>
              @endforeach
          </ul>
      </div>
    @endif
    @csrf
    <label for="name">Razão Social:</label>
    <input type="text" id="name" name="name" class="form-control" value="{{old('name')}}" required>

    <label for="document">Documento (CNPJ):</label>
    <input type="text" id="document" name="document" class="form-control" value="{{old('document')}}" required>

    <label for="nameDisplay">Nome para Exibição:</label>
    <input type="text" id="nameDisplay" name="nameDisplay" class="form-control" value="{{old('nameDisplay')}}" required>

    <label for="phone">Telefone:</label>
    <input type="tel" id="phone" name="phone" class="form-control" value="{{old('phone')}}" required>

    <label for="emailContact">E-mail:</label>
    <input type="email" id="emailContact" name="emailContact" class="form-control" value="{{old('emailContact')}}" required>

    <label for="responsibleDocument">Documento do Responsável (CPF):</label>
    <input type="text" id="responsibleDocument" name="responsibleDocument" class="form-control" value="{{old('responsibleDocument')}}" required>

    <label for="typeCompany">Tipo de Empresa:</label>
    <select id="typeCompany" name="typeCompany" class="form-select" required>
      <option value="ltda">LTDA</option>
      <option value="eireli">EIRELI</option>
      <option value="association">Associação</option>
      <option value="individualEntrepeneur">Empresário Individual</option>
      <option value="mei">MEI</option>
      <option value="sa">SA</option>
      <option value="slu">SLU</option>
    </select>

    <fieldset>
      <legend>Endereço</legend>

      <label for="zipcode">CEP:</label>
      <input type="text" id="zipcode" name="zipcode" class="form-control" value="{{old('zipcode')}}" required>

      <label for="street">Rua:</label>
      <input type="text" id="street" name="street" class="form-control" value="{{old('street')}}" required>

      <label for="number">Número:</label>
      <input type="text" id="number" name="number" class="form-control" value="{{old('number')}}" required>

      <label for="complement">Complemento:</label>
      <input type="text" id="complement" name="complement" class="form-control" value="{{old('complement')}}" >

      <label for="neighborhood">Bairro:</label>
      <input type="text" id="neighborhood" name="neighborhood" class="form-control" value="{{old('neighborhood')}}" required>

      <label for="city">Cidade:</label>
      <input type="text" id="city" name="city" class="form-control" value="{{old('city')}}" required>

      <label for="state">Estado:</label>
      <input type="text" id="state" name="state" class="form-control" value="{{old('state')}}" required>
    </fieldset>

    <label for="softDescriptor">Nome para aparecer na fatura:</label>
    <input type="text" id="softDescriptor" name="softDescriptor" class="form-control" value="{{old('softDescriptor')}}" required>

    <label for="cnae">CNAE:</label>
    <input type="text" id="cnae" name="cnae" class="form-control" value="{{old('cnae')}}" required>

    <button type="submit" class="btn btn-primary form-control mt-2 mb-5">
        Enviar
    </button>

  </form>


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
  <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/localization/messages_pt_BR.min.js"></script>

  <!-- Template Main JS File -->
  <script src="/site/js/create_bank_pj.js"></script>

</body>

</html>
