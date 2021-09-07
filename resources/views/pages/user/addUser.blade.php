@extends('layouts.master')


@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@stop


@section('content')

      <!-- Main Content -->
      <div class="main-content">


            <div class="card card-primary">
              <div class="card-header">
                <h4>Ajout d'utilisateur</h4>
              </div>
              <div class="card-body">
                <form method="POST" action=" {{ route('insertUser') }} " enctype='multipart/form-data' id="myform">
                  @csrf
                  <div class="row">

                    <div class="form-group col-3">
                      <label for="matricule">Matricule <i class="fas fa-asterisk text-caauri"></i>  </label>
                      <input id="matricule" type="text" class="form-control" name="matricule" value="{{ getNewMat() }}">
                    </div>
                    <div class="form-group col-4">
                      <label for="name">Nom <i class="fas fa-asterisk text-caauri"></i> </label>
                      <input id="name" type="text" class="form-control" name="name" autofocus>
                    </div>
                    <div class="form-group col-5">
                      <label for="prenoms">Prenoms <i class="fas fa-asterisk text-caauri"></i></label>
                      <input id="prenoms" type="text" class="form-control" name="prenoms">
                    </div>
                    <div class="form-group col-4">
                      <label for="fonction">Fonction <i class="fas fa-asterisk text-caauri"></i></label>
                      <input id="fonction" type="text" class="form-control" name="fonction">
                    </div>
                    <div class="form-group col-4">
                      <label for="fonction">Photo</label>
                      <input id="fonction" type="file" accept=".png,.jpg" class="form-control" name="photo">
                    </div>
                    <div class="form-group col-4">
                      <label>Rôle <i class="fas fa-asterisk text-caauri"></i></label>
                      <select class="form-control" name="role">
                        @foreach($roles as $role)
                        <option value="{{ $role->id}}">{{ $role->libelle}} </option>
                        @endforeach
                      </select>
                    </div>

                  </div>


                  <div class="row">
                  <div class="form-group col-4">
                    <label for="email">Email <i class="fas fa-asterisk text-caauri"></i></label>
                    <input id="email" type="email" class="form-control" name="email">
                    <div class="invalid-feedback">
                    </div>
                  </div>
                    <div class="form-group col-4">
                      <label for="password" class="d-block">Password <i class="fas fa-asterisk text-caauri"></i></label>
                      <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator"
                        name="password">
                      <div id="pwindicator" class="pwindicator">
                        <div class="bar"></div>
                        <div class="label"></div>
                      </div>
                    </div>
                    <div class="form-group col-4">
                      <label for="password2" class="d-block">Password Confirmation <i class="fas fa-asterisk text-caauri"></i></label>
                      <input id="password2" type="password" class="form-control" name="password-confirm">
                    </div>

                       <div class="form-group col-12">
                            <label for="nomTache">Description</label>
                            <textarea class="summernote" name="biographie">
                              <h5 style="text-align: center;"><b>Information relatif à l'utilisateur</b></h5>
                              <p style="text-align: center;">
                              </p>
                              <h6 style="text-align: left;"><b style="color: rgb(181, 99, 8); background-color: rgb(255, 255, 255);">Description&nbsp;</b></h6>
                              <div style="text-align: left;">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Pariatur voluptatum alias molestias minus quod dignissimos.&nbsp;<br>
                              </div>
                              <div style="text-align: left;">
                                <br>
                              </div>
                              <h6 style="text-align: left;"><b style="color: rgb(181, 99, 8); background-color: rgb(255, 255, 255);">Éducation&nbsp;</b></h6>
                              <ul>
                                <li style="text-align: left;">xxxx-xxxx : Diplome / Certificat ......</li>
                              </ul>
                              <div style="text-align: left;">
                                <b style="color: rgb(181, 99, 8); background-color: rgb(255, 255, 255);">Expérience&nbsp; professionnel&nbsp; :&nbsp;</b>
                              </div>
                              <div style="text-align: left;">
                              </div>
                              <p>
                              </p>
                              <ul style="color: rgb(33, 37, 41); text-align: center;">
                                <li style="text-align: left;"><span style="color: rgb(0, 0, 0);">xxxx-xxxx&nbsp;</span>: Stage à ......</li>
                              </ul>
                            </textarea>
                        </div>
                  
                  </div>

                  <div class="form-group">
                    <button type="submit" id="submitBtn" class="btn btn-primary btn-lg btn-block">
                      Enregistrer
                    </button>
                  </div>
                </form>
              </div>
            </div>


@endsection


@section('pageCustomScript')
    <!-- Page Specific JS File -->
  <script src="{{ asset('assets/js/page/auth-register.js') }}"></script>

  <script type="text/javascript">
    $(function()
    {
      $('#submitBtn').click(function(event)
      {
        event.preventDefault();
        var password = $('#password').val();
        var password2 = $('#password2').val();
        var matricule = $('#matricule').val();
        var name = $('#name').val();
        var prenoms = $('#prenoms').val();
        var fonction = $('#fonction').val();


        //Verifie 
        if(matricule != '')
        {
          if(name != '')
          {
            if(prenoms != '')
            {
              if(fonction != '')
              {
                  if(password2 === password)
                  {
                    $('#myform').submit();
                  }
                  else
                  {
                    Swal.fire('Erreur',
                              'Les champs mot de passe ne sont pas identiques',
                                'error');
                  }
 
              }
              else
              {
                    Swal.fire('Erreur',
                              'Le champ fonction est resté vide',
                                'error');
              }
              
            }
            else
            {
                    Swal.fire('Erreur',
                              'Le champ prénoms est obligatoire',
                                'error');

            } 
          }
          else
          {
                    Swal.fire('Erreur',
                              'Le champ nom est obligatoire',
                                'error');
          }

        }
        else
        {
          Swal.fire('Erreur',
                    'Le champs matricule est  obilgatoire',
                      'error');
        }


      })

    })
  </script>

@stop