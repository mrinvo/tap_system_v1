<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Tap Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/dash/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/dash/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/dash/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/dash/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dash/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/dash/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/dash/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
 <!-- BS Stepper -->
<link rel="stylesheet" href="/dash/plugins/bs-stepper/css/bs-stepper.min.css">
<link rel="icon" href="{{ asset('fav.svg') }}" type="image/x-icon">

<link rel="stylesheet" href={{ asset('/style.css') }}>

{{-- apple pay SDK --}}
<link rel="stylesheet" href="https://tap-sdks.b-cdn.net/apple-pay/build-1.1.6/main.css" />
<script src="https://tap-sdks.b-cdn.net/apple-pay/build-1.1.6/main.js"></script>

{{-- benifi pay SDK --}}
<script src="https://tap-sdks.b-cdn.net/benefit-pay/build-1.0.20/main.js"></script>

{{-- card sdk v2 --}}
<script src="https://tap-sdks.b-cdn.net/card/1.0.2/index.js"></script>

<script src="https://pay.google.com/gp/p/js/pay.js"></script>




<link rel="stylesheet" href="/dash/plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{ asset('fav.svg') }}" alt="tap" height="60" width="60">
  </div>

