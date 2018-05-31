<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>@yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap and Fontawesome -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <!--Admin Theme-->
  <link rel="stylesheet"  href="{{ asset('adminlte/css/AdminLTE.min.css') }}">
  <!-- AdminLTE Skin -->
  <link rel="stylesheet" href="{{ asset('adminlte/css/skins/skin-green.min.css') }}">

</head>
<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  @include('admin.includes.main-header')
  
  @include('admin.includes.superadmin-main-sidebar')

  @yield('content')

  @include('admin.includes.footer')

</div>
<!-- ./wrapper -->

<script src="{{ asset('js/app.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('adminlte/js/adminlte.min.js') }}"></script>
</body>
</html>
