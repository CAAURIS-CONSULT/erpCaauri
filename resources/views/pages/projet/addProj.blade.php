@extends('layouts.master')


@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@stop


@section('content')


<div class="main-content">
 
        <div class="card card-success">
            <div class="card-header">
                <h4>Ajout d'un nouveau projet</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('insertPrj') }}">
                  @csrf

                    <div class="row">
                        <div class="form-group col-6">
                            <label for="libelleProjet">Identification</label>
                            <input id="libelleProjet" type="text" class="form-control" name="mat"  placeholder="{{ $projet }}">
                        </div>
                        <div class="form-group col-6">
                            <label for="libelleProjet">Désignation du projet</label>
                            <input id="libelleProjet" type="text" class="form-control" name="libelleProjet" placeholder="App Mobile Caauri" >
                        </div>
                        <div class="form-group col-6">
                          <label>Entrepries</label>
                          <select class="form-control" name="entreprises_id">
                            @foreach($entreprises as $entr)
                            <option value="{{ $entr->id}}">{{ $entr->nom}} </option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-6">
                            <label>Responsable du projet</label>
                            <select class="form-control" name="user_id">
                            @foreach($users as $user)
                            <option value="{{ $user->id}}">{{ $user->name.''.$user->prenom}}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row justify-content-around">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                    <button type="reset" class="btn btn-danger">Reinitialiser les champs</button>
                    </div>
                    
                </form>
            </div>
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

      })

    })
  </script>

@stop