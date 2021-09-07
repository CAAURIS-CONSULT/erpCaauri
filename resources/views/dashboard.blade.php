@extends('layouts.master')


@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@stop


@if(isSuperAdmin(Auth::id()))
  @include('superAdmin')
@else
  @include('userDash')
@endif

@section('pageCustomScript')
  <script src="{{ asset('assets/js/custom.js') }}"></script>
@stop