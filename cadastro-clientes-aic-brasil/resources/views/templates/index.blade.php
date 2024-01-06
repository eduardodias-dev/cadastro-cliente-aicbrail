<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AIC Brasil - @yield('title')</title>

  <link href="/site/img/LOGO-AIC-BRASIL.ico" rel="icon">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/dist/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="/dist/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="/dist/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="/dist/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="/dist/css/custom.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/dist/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="/dist/plugins/datetimepicker/jquery.datetimepicker.min.css" />
</head>
<body class="hold-transition sidebar-mini layout-fixed" data-panel-auto-height-mode="height">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item">
        <form method="post" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-default nav-link" type="submit" title="Sair do sistema">
                <i class="fas fa-sign-out"></i> Sair do sistema
            </button>
        </form>

      </li>

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin/" class="brand-link">
      <img src="/site/img/LOGO-AIC-BRASIL.ico" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">AIC Brasil</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/dist/img/avatar2.png" class="img-circle elevation-2 bg-light" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      {{-- <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">MENU</li>
          <li class="nav-item ">
            <a href="{{route('client.list')}}" class="nav-link {{ request()->is('clients') ? 'active' : '' }}">
              <i class="nav-icon far fa-users-alt"></i>
              <p>
                Clientes
              </p>
            </a>
          </li>
          {{-- <li class="nav-item ">
            <a href="{{route('logs.list')}}" class="nav-link {{ request()->is('logs') ? 'active' : '' }}">
              <i class="nav-icon far fa-users-alt"></i>
              <p>
                Log Integração
              </p>
            </a>
          </li> --}}
          {{-- <li class="nav-item ">
            <a href="{{route('subscriptions.list')}}" class="nav-link {{ request()->is('subscriptions') ? 'active' : '' }}">
              <i class="nav-icon far fa-users-alt"></i>
              <p>
                Assinaturas
              </p>
            </a>
          </li> --}}
            <li class="nav-item ">
                <a href="{{route('pacotes.list')}}" class="nav-link {{ request()->is('pacotes') ? 'active' : '' }}">
                    <i class="nav-icon far fa-users-alt"></i>
                    <p>
                        Pacotes
                    </p>
                </a>
            </li>
            {{-- <li class="nav-item ">
                <a href="{{route('plans.list')}}" class="nav-link {{ request()->is('plans') ? 'active' : '' }}">
                    <i class="nav-icon far fa-users-alt"></i>
                    <p>
                        Planos
                    </p>
                </a>
            </li> --}}
            <li class="nav-item ">
                <a href="{{route('afiliados.list')}}" class="nav-link {{ request()->is('afiliados') ? 'active' : '' }}">
                    <i class="nav-icon far fa-users-alt"></i>
                    <p>
                        Afiliados
                    </p>
                </a>
            </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
    @yield('content')
  </div>
  <!-- /.content-wrapper -->
    <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/dist/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="/dist/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<!-- Bootstrap 4 -->
<script src="/dist/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="/dist/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<script src="/dist/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/dist/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/dist/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="/dist/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="/dist/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="/dist/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="/dist/plugins/jszip/jszip.min.js"></script>
<script src="/dist/plugins/pdfmake/pdfmake.min.js"></script>
<script src="/dist/plugins/pdfmake/vfs_fonts.js"></script>
<script src="/dist/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="/dist/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="/dist/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script src="/dist/plugins/datetimepicker/jquery.datetimepicker.full.min.js"></script>
{{-- <script src="/dist/plugins/jspdf/jspdf.min.js"></script> --}}
<script src="/dist/plugins/html2pdf/html2pdf.js"></script>
<script src="/dist/js/custom.js"></script>
{{--
@stack('script_pagina') --}}

</body>
</html>
