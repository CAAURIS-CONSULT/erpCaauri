@extends('layouts.master')


@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@stop


@section('content')


<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h4>Dashboard des entreprises</h4>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-md">
                    <tbody>
                        <tr>
                            <th>Matricule</th>
                            <th>Nomination</th>
                            <th>Email</th>
                            <th>Responsable</th>
                            <th class="text-center">Actions</th>
                        </tr>
                        @foreach($entreprises as $entreprise)
                            <tr>
                                <td>{{ $entreprise->matricule }}</td>
                                <td>{{ $entreprise->nom }}</td>
                                <td>{{ $entreprise->email }}</td>
                                <td>
                                    {{ $entreprise->responsable}}
                                </td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-primary btnDetail" id="{{ $entreprise->id }}"
                                    data-toggle="modal" data-target="#detailModal" >Détails</a>
                                    <a href="#modificationModal" class="btn btn-warning btnModif" id="{{ $entreprise->id }}" data-toggle="modal" data-target="#modificationModal">Modifier</a>
                                    <a href="#" class="btn trigger-btn btn-danger btnDel" id="{{ $entreprise->id }}" >Supprimer</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $entreprises->links() }}

    </div>
    <!-- Modal HTML -->
</div>

<div class="modal fade" id="modificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modifier une entreprise</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
        <form action="{{ route('updtEntr') }}" method="POST" >
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
        <h5 class="modal-title" id="exampleModalLabel">Informations de l'utilisateur</h5>
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
      $('.btnDetail').click(function(event)
      {
        var idUser = $(this).attr('id'); 
        $.ajax({
            url: 'showEntr',
            method:'GET',
            data: {idEntr:idUser},
            dataType:'html',
            success:function(data)
                    {
                    $('#detailForm').html(data);
                    },
            error:function(){
                    toastr.error("Erreur ! Problème de connexion internet ");
                                            
                    }
            });
      })


      //Modifier un utilisateur
      $('.btnModif').click(function(event)
      {
        var idUser = $(this).attr('id'); 
        $.ajax({
            url: 'modifEntr',
            method:'GET',
            data: {idEntr:idUser},
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
                  text: 'Souhaitez vous réellement suprimé cette entreprise ?',
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Valider!',
                   backdrop: `rgba(240,15,83,0.4)`
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url:'delEntr',
                        method:'GET',
                        data:{idUser:idUser},
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