@extends('layouts.master')


@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@stop


@section('content')

      <!-- Main Content -->
<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h4>Liste des Projets</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                    <tbody>
                        <tr>
                            <th>Matricule</th>
                            <th>Nom du projet</th>
                            <th>Entrepise</th>
                            <th>Chargé d'execution</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        @foreach($projets as $projet)
                            <tr>
                                <td>{{ $projet->mat }}</td>
                                <td>{{ $projet->libelleProjet}}</td>
                                <td>{{ getEntreprise($projet->entreprises_id)->nom }}</td>
                                <td>
                                    {{ getRespoProjet($projet->id)->name.' '.getRespoProjet($projet->id)->prenoms}}
                                </td>
                                <td class="text-center">
                                    
                                    <a href="#modificationModal" class="btn btn-warning btnModif" id="{{ $projet->id }}" data-toggle="modal" data-target="#modificationModal">Modifier</a>
                                    <a href="#" class="btn trigger-btn btn-danger btnDel" id="{{ $projet->id }}" >Supprimer</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $projets->links() }}

    </div>
    <!-- Modal HTML -->
</div>

<div class="modal fade" id="modificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modification du projet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
        <form action="{{ route('updtPrj') }}" method="POST" >
            @csrf
            <span id="modifForm">
                
            </span>
        </form>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Informations du projet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="detailForm">


      </div>
      <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Retour</button>
      </div>
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


      //Modifier un utilisateur
      $('.btnModif').click(function(event)
      {
        var idUser = $(this).attr('id'); 
        $.ajax({
            url: 'modifPrj',
            method:'GET',
            data: {idPrj:idUser},
            dataType:'html',
            success:function(data)
                    {
                    $('#modifForm').html(data);
                    },
            error:function(){
                    toastr.error("Erreur ! Problème de connexion internet ");
                                            
                    }
            });
      })


      //Modifier un utilisateur
      $('.btnDel').click(function(event)
      {
        var idUser = $(this).attr('id'); 

                Swal.fire({
                  title: 'URGENT !!!',
                  text: 'Veuillez confirmer la supression !',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'Oui , suprimer!',
                   backdrop: `rgba(240,15,83,0.4)`
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url:'delPrj',
                        method:'GET',
                        data:{idPrj:idUser},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Operation Effectuer avec succès!',
                           'Opération fait avec succès',
                           'success'
                          );
                          window.location.reload();
                        },
                        error:function(){
                          Swal.fire('Problème de connexion internet');
                        }
                      });
                    }
                })
        
        })
      })
      
  </script>
@stop