@extends('layouts.master')


@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@stop

{{-- {{ dd($taches) }} --}}
@section('content')

      <!-- Main Content -->
<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h4>Taches crées</h4>
        </div>
        <div class="card-body p-0">
              <div class="table-responsive">
                  <table class="table table-striped">
                      <tr>
                        <th>Projets</th>
                        <th>Tache</th>
                        <th>Deadline</th>
                        <th>Execution</th>
                        <th>Action</th>
                      </tr>
                      @foreach($taches as $tache)
                          <tr>
                            <td class="text-wrap text-center" style="width:180px">
                               {{  getPrj($tache->projets_id)->libelleProjet }} 
                               <small ><strong>
                                 {{  getEntreprise($tache->entreprises_id)->nom }}</strong>
                               </small>
                            </td>
                            <td class="align-middle">
                              {{ $tache->nomTache }}
                            </td>

                            <td>{{ $tache->delaisExec }}</td>
                            <td id="niveauEx" class="text-center">

                              @php
                              // Formatter le niveau dexec voir helper.php
                              $tab = formatLevel($tache->niveau_evolutions_id);
                              $color = $tab['color'];
                              $icone = $tab['icone'];
                              $text = $tab['text'];
                              @endphp
                              <button type="button" class="btn  btn-icon icon-left {{ $color   }}">
                              <i class="{{ $icone }}"></i>{{ $text }}</button>
                           
                            </td>
                                <td class="text-center text-nowrap">
                                    <a href="#" class=" btn btn-icon icon-left btn-primary btnDetail" id="{{ $tache->id }}"
                                    data-toggle="modal" data-target="#detailModal" >
                                      <i class="fas fa-users" style="font-size:1rem"></i>
                                    </a>

                                    <a href="#modificationModal" class="btn btn-icon btn-warning icon-left btn-warning btnModif" id="{{ $tache->id }}" data-toggle="modal" data-target="#modificationModal" > 
                                      <i class="fas fa-edit" style="font-size:1rem"></i>
                                    </a>

                                    <a href="{{ route('showTask',['task'=>$tache->id]) }}" 
                                      target="_blank" class="btn btn-icon icon-left btn-warning " id="{{ $tache->idTask }}" >
                                      <i class="fas fa-eye" style="font-size:1rem"></i>
                                    </a>
                                   
                                    <a href="#" class="btn btn-icon icon-left btn-danger btnDel" id="{{ $tache->id }}">
                                      <i class="fas fa-trash" style="font-size:1rem" ></i></a>
                                </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
              </div>
        </div>
        {{ $taches->links() }}

    </div>
    <!-- Modal HTML -->
</div>

<div class="modal fade" id="modificationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modification de l'utilisateur</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
        <form action="{{ route('updtTask') }}" method="POST" >
            @csrf 
            <input type='hidden' name='idTask' id="myHiddenTask" >
            <span id="modifForm">
                
            </span>
        </form>
      </div>
    </div>
  </div>
</div>




        <div class="modal fade bd-example-modal-lg" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <input type="hidden" name="" id="idTask">
                <h5 class="modal-title" id="myLargeModalLabel">Equipe chargé d'exécution</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                {{-- CARD TABLEAU EXECUTANT --}}
                  <div class="card">
                    <div class="card-header">
                      <h4>Liste des executants</h4>
                    </div>
                    <div class="card-body">
                         <div class="table-responsive">
                        <table class="table table-striped" id="tableContent">

                      </table>
                      </div>
                    </div>
                  </div>
                {{-- CARD TABLEAU EXECUTANT --}}

                {{-- CARD AJOUT EXECUTANT --}}
                  <div class="card">
                    <div class="card-header">
                      <h4>Card Title</h4>
                    </div>
                    <div class="card-body">
                      <form action="#" method="POST">
                          @csrf
                        <div class="row">
                          <div class="form-group col-6">
                            <label for="role" class="col-form-label">Utilisateur (Nom & prénoms)</label>
                            <select class="form-control " name="user" id="user">
                              @foreach(getAllUser() as $user)
                                <option value="{{ $user->id }}" value="1">{{ $user->name.' '.$user->prenoms   }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group col-3">
                            <label for="dateTache" class="col-form-label">Date d'attribution</label>
                            <input type="text"  class="form-control datepicker" id="dateTache" value="" name="dateTache">
                          </div>
                          <div class="form-group col-3">
                            <label for="dateTache" class="col-form-label">Validation</label>

                            <button type="submit" class="btn btn-success btn-icon icon-left" id="btnAddExc"><i class="fas fa-user-plus "></i> Ajouter</button>
                                       
                          </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                          <button type="button" class="btn  btn-info" data-dismiss="modal"> Fermer le modal</button>
                        </div>
                      </form>   
                    </div>
                  </div>
                {{-- CARD AJOUT EXECUTANT --}}

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

      //Clic detail
      $('.btnDetail').click(function(event)
      {
        
        var idTask = $(this).attr('id');
        $('#idTask').val(idTask); 
   
        $.ajax({
                url: 'showExc',
                method:'GET',
                data: {idTask:idTask},
                dataType:'html',
                success:function(data)
                        {
                        $('#tableContent').html(data);
                        },
                error:function(){
                        toastr.error("Erreur ! Problème de connexion internet ");
                                                
                        }
            });
      })


      //Clic  Suprimer executant
        //Voir controller des taches => showListExec
      

      //Add eecutant on clic 
            $('#btnAddExc').click(function(event)
            {
              event.preventDefault();
              var user = $('#user').val();
              var dateTache =$('#dateTache').val();
              var idTask =$('#idTask').val();

              $.ajax({
                  url: 'addExec',
                  method:'GET',
                  data: {user : user,dateTache : dateTache ,idTask:idTask},
                  dataType:'html',
                  success:function(data)
                          {
                            $('#tableContent').html(data);
                          },
                  error:function(){
                          toastr.error("Erreur ! Problème de connexion internet ");
                                                  
                          }
                  });
            })

      //Modifier un utilisateur
      $('.btnModif').click(function(event)
      {
        var idTask = $(this).attr('id');
        $('#myHiddenTask').val(idTask); 
        $.ajax({
            url: 'modifTask',
            method:'GET',
            data: {idTask:idTask},
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
        var idTask = $(this).attr('id'); 

                Swal.fire({
                  title: 'URGENT !!!',
                  text: 'Souhaitez-vous réellement suprimé cette tache ?',
                  icon: 'danger',
                  showCancelButton: true,
                  confirmButtonColor: '#d33',
                  cancelButtonColor: '#3085d6',
                  cancelButtonText: 'Annuler',
                  confirmButtonText: 'oui , Valider!',
                   backdrop: `rgba(240,15,83,0.4)`
                }).then((result) => {
                    if (result.value) {
                      $.ajax({
                        url:'delTask',
                        method:'GET',
                        data:{idTask:idTask},
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