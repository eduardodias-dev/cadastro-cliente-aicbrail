<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Criar Conta Digital PJ - Envio de Documentos Necessários</title>
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
    <h4 class="text-center my-3">CRIAÇÃO DE CONTA PESSOA JURÍDICA - Envio dos Documentos Necessários</h4>
  <form method="post" action="{{route('mandatory.documents.post', ['type' => 'pj'])}}">
    @csrf
    <label for="monthlyIncome">Renda mensal:</label>
    <input type="number" id="monthlyIncome" name="monthlyIncome" class="form-control" required>

    <label for="about">Sobre o negócio (CNPJ):</label>
    <textarea id="about" name="about" class="form-control" required></textarea>

    <label for="socialMediaLink">Link de mídia social:</label>
    <input type="text" id="socialMediaLink" name="socialMediaLink" class="form-control" required>

    <fieldset>
        <legend>Quadro Societário</legend>

        <label for="document">Documento (CPF):</label>
        <input type="text" id="document" name="document" class="form-control" required>

        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" class="form-control" required>

        <label for="motherName">Nome da mãe:</label>
        <input type="text" id="motherName" name="motherName" class="form-control" required>

        <label for="birthDate">Data de Nascimento:</label>
        <input type="date" id="birthDate" name="birthDate" class="form-control" required>

        <label for="type">Tipo de Associado:</label>
        <select id="type" name="type" class="form-select" required>
          <option value="partner">Sócio</option>
          <option value="attorney">Procurador</option>
          <option value="personinvolved">Pessoa Envolvida</option>
        </select>

    </fieldset>

    <fieldset>
        <legend>Documentos</legend>

        <label for="lastContract">Contrato social:</label>
        <input type="file" id="lastContract" name="lastContract" class="form-control" required>

        <label for="cnpjCard">Documento CNPJ:</label>
        <input type="file" id="cnpjCard" name="cnpjCard" class="form-control" required>

        <label for="electionRecord">Ata de eleição da diretoria:</label>
        <input type="file" id="electionRecord" name="electionRecord" class="form-control" required>

        <label for="statute">Estatuto:</label>
        <input type="file" id="statute" name="statute" class="form-control" required>

    </fieldset>

    <fieldset>
        <legend>Documentos Pessoais</legend>

        <hr />
        <h4>CNH</h4>
        <label for="cnh_selfie">Selfie Segurando a CNH:</label>
        <input type="file" id="cnh_selfie" name="cnh_selfie" class="form-control" required>

        <label for="cnh_picture">Foto da CNH digital ou física aberta (frente + verso):</label>
        <input type="file" id="cnh_picture" name="cnh_picture" class="form-control" required>

        <hr />
        <h4>RG</h4>

        <label for="rg_selfie">Selfie Segurando o RG:</label>
        <input type="file" id="rg_selfie" name="rg_selfie" class="form-control" required>

        <label for="rg_front">Foto da frente do RG:</label>
        <input type="file" id="rg_front" name="rg_front" class="form-control" required>

        <label for="rg_back">Foto do verso do RG:</label>
        <input type="file" id="rg_back" name="rg_back" class="form-control" required>

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

  <!-- Template Main JS File -->
  <script src="/site/js/main1.js"></script>

</body>

</html>
