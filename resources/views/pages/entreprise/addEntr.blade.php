@extends('layouts.master')


@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@stop


@section('content')

<section>
      <div class="main-content">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Ajout d'entreprise</h4>
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route('insertEntr') }}">
                	@csrf
                  <div class="row">
                  <div class="form-group col-6">
                    <label for="matricule">Matricule</label>
                    <input id="matricule" type="text" class="form-control" name="matricule">
                    <div class="invalid-feedback">
                    </div>
                  </div>
                    <div class="form-group col-6">
                      <label for="name">Nom</label>
                      <input id="name" type="text" class="form-control" name="name" autofocus>
                    </div>
                    <div class="form-group col-6">
                      <label for="contact">Contact</label>
                      <input id="contact " type="text" class="form-control" name="contact">

                   </div>

                  <div class="form-group col-6">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control" name="email">
                    <div class="invalid-feedback">
                    </div>
                  </div>
                  <div class="form-group col-6">
                    <label for="adresse ">Adresse</label>
                    <input id="adresse" type="text" class="form-control" name="adresse">
                    <div class="invalid-feedback">
                    </div>
                  </div>
                  <div class="form-group col-6">
                    <label for="image">Logo de l'entreprise</label>
                    <input id="image" type="file" class="form-control" name="image">
                    <div class="invalid-feedback">
                    </div>
                  </div>
                  <div class="form-group col-6">
                      <label for="responsable">Responsable</label>
                      <input id="responsable" type="text" class="form-control" name="responsable" autofocus>
                    </div>
                    <div class="form-group col-6">
                      <label for="contactRespo">Contact du responsable</label>
                      <input id="contactRespo" type="text" class="form-control" name="contactRespo">
                    </div>
                  <div class="form-group col-12">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">
                      Enregistrer
                    </button>
                  </div>
                </form>
              </div>
              <div class="mb-4 text-muted text-center">
                Already Registered? <a href="auth-login.html">Login</a>
              </div>
            </div>
      </div>
    </section>
@endsection


@section('pageCustomScript')
  <script src="{{ asset('assets/js/custom.js') }}"></script>

@stop