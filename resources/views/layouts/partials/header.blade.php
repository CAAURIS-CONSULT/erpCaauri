
<!DOCTYPE html>
<html lang="fr">



<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>ERP Caauri | Dash</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-daterangepicker/daterangepicker.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <link href="{{ asset('assets/bundles/sweetalert/sweetalert2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/bundles/toastr/toastr.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/bundles/fullcalendar/fullcalendar.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/bundles/bootstrap-social/bootstrap-social.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/bundles/summernote/summernote-bs4.css') }}">

<style>
@import  url('https://fonts.googleapis.com/css2?family=Open+Sans');

.text-caauri
{
  color:#fcd45d;
}
</style>
  <!-- Custom style CSS -->
	@yield("pageCustomStyle")

  <link rel='shortcut icon' type='image/x-icon' href='{{ asset('assets/img/favicon.ico') }}' />
</head>

<body  class="light theme-black dark-sidebar" style="font-family: 'Open Sans', sans-serif;" >
  <div class="loader">
    <center >
    @for($i=0; $i<10;$i++)
  <div class="spinner-border " style="color:#fcd45d" role="status">
  <span class="sr-only">Loading...</span>
  </div>
    @endfor
    </center>

  </div>

  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
        @include('layouts/partials/navbarTop')
        @include('layouts/partials/navbarLeft')
