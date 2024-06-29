<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Criar Conta Digital PF - Envio de Documentos Necessários</title>
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
  <link href="/dist/plugins/fontawesome-free/css/all.min.css" rel="stylesheet">
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
    <h4 class="text-center my-3">CRIAÇÃO DE CONTA PESSOA FÍSICA - Envio dos Documentos Necessários</h4>
    @if ($errors->any())
      <div class="alert alert-danger" style="max-width: 600px; margin: 0 auto;">
          <ul>
              @foreach ($errors->all() as $error)
                  <li>{{ formatCreateAccountErrors($error) }}</li>
              @endforeach
          </ul>
      </div>
    @endif
  <form method="post" action="{{route('mandatory.documents.post', ['type' => 'pf'])}}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="subconta_id" value="{{$subconta_id}}" readonly="readonly" />
    <fieldset>
        <legend>Dados Pessoais</legend>

        <div class="row">
          <div class="col-md-6">
            <label for="motherName">Nome da mãe:</label>
            <input type="text" id="motherName" name="motherName" class="form-control" required value="{{old("motherName")}}">
          </div>
          <div class="col-md-6">
            <label for="birthDate">Data de Nascimento:</label>
            <input type="text" id="birthDate" name="birthDate" class="form-control" required value="{{old("birthDate")}}">
          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            <label for="monthlyIncome">Renda mensal:</label>
            <input type="number" id="monthlyIncome" name="monthlyIncome" class="form-control" required value="{{old("monthlyIncome")}}">
          </div>
          <div class="col-md-6">
            <label for="socialMediaLink">Rede Social (Instagram, Tiktok, etc.):</label>
            <input type="text" id="socialMediaLink" name="socialMediaLink" class="form-control" required value="{{old("socialMediaLink")}}">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <label for="about">Sobre o negócio:</label>
            <textarea id="about" name="about" class="form-control">{{old("about")}}</textarea>
          </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>Documentos Pessoais</legend>
        <hr />
        <h4>CNH</h4>
        <div class="row">
          <div class="col-md-12">
            <label for="cnh_selfie">Selfie Segurando a CNH:</label>
            <div class="form-group file-upload-wrapper">
              <input type="file" id="cnh_selfie" name="cnh_selfie" class="file-input">
              <label for="file-input" class="file-label">
                <span class="file-label-text"><i class="fas fa-file-upload"></i> Escolha um arquivo...</span>
              </label>
            </div>
            {{-- <input type="file" id="cnh_selfie" name="cnh_selfie" class="form-control" > --}}
          </div>
          <div class="col-md-12">
            <label for="cnh_picture">Foto da CNH digital ou física aberta (frente + verso):</label>
            <div class="form-group file-upload-wrapper">
              <input type="file" id="cnh_picture" name="cnh_picture" class="file-input">
              <label for="file-input" class="file-label">
                <span class="file-label-text"><i class="fas fa-file-upload"></i> Escolha um arquivo...</span>
              </label>
            </div>
            {{-- <input type="file" id="cnh_picture" name="cnh_picture" class="form-control" > --}}
          </div>
          <div class="col-md-12">
            <label for="cnh_address">Foto do comprovante de endereço:</label>
            <div class="form-group file-upload-wrapper">
              <input type="file" id="cnh_address" name="cnh_address" class="file-input">
              <label for="file-input" class="file-label">
                <span class="file-label-text"><i class="fas fa-file-upload"></i> Escolha um arquivo...</span>
              </label>
            </div>
            {{-- <input type="file" id="cnh_address" name="cnh_address" class="form-control" > --}}
          </div>
        </div>
        <hr />
        <h4>RG</h4>
        <div class="row">
          <div class="col-md-12">
            <label for="rg_selfie">Selfie Segurando o RG:</label>
            <div class="form-group file-upload-wrapper">
              <input type="file" id="rg_selfie" name="rg_selfie" class="file-input">
              <label for="file-input" class="file-label">
                <span class="file-label-text"><i class="fas fa-file-upload"></i> Escolha um arquivo...</span>
              </label>
            </div>
            {{-- <input type="file" id="rg_selfie" name="rg_selfie" class="form-control" > --}}
          </div>
          <div class="col-md-12">
            <label for="rg_front">Foto da frente do RG:</label>
            <div class="form-group file-upload-wrapper">
              <input type="file" id="rg_front" name="rg_front" class="file-input">
              <label for="file-input" class="file-label">
                <span class="file-label-text"><i class="fas fa-file-upload"></i> Escolha um arquivo...</span>
              </label>
            </div>
            {{-- <input type="file" id="rg_front" name="rg_front" class="form-control" > --}}
          </div>
          <div class="col-md-12">
            <label for="rg_back">Foto do verso do RG:</label>
            <div class="form-group file-upload-wrapper">
              <input type="file" id="rg_back" name="rg_back" class="file-input">
              <label for="file-input" class="file-label">
                <span class="file-label-text"><i class="fas fa-file-upload"></i> Escolha um arquivo...</span>
              </label>
            </div>
            {{-- <input type="file" id="rg_back" name="rg_back" class="form-control" > --}}
          </div>
          <div class="col-md-12">
            <div class="form-group file-upload-wrapper">
              <label for="rg_address">Foto do comprovante de endereço:</label>
              <input type="file" id="rg_address" name="rg_address" class="file-input">
              <label for="file-input" class="file-label">
                <span class="file-label-text"><i class="fas fa-file-upload"></i> Escolha um arquivo...</span>
              </label>
            </div>
            {{-- <input type="file" id="rg_address" name="rg_address" class="form-control" > --}}
          </div>
        </div>
    </fieldset>
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

  <!-- Template Main JS File -->
  <script src="/site/js/form_mandatory_docs_pf.js"></script>
</body>

</html>
