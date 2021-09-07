@extends('layouts.master')


@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@stop


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
                        <th class="text-center">Action</th>
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
                                    <a href="#" class=" btn btn-icon icon-left btn-primary btnDetail" id="{{ $tache->idTask }}"
                                    data-toggle="modal" data-target="#detailModal" >
                                      <i class="fas fa-users"></i>Team</a>

                                    <a href="{{ route('showUserTask',['task'=>$tache->idTask]) }}" 
                                      target="_blank" class="btn btn-icon icon-left btn-warning " style="color: #000; background-color: #f8940a"  id="{{ $tache->idTask }}" style="color: ;">
                                      <i class="fas fa-eye"></i>Voir
                                    </a>
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




        <div class="modal fade " id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true">
          <div class="modal-dialog ">
            <div class="modal-content">
              <div class="modal-header">
                <input type="hidden" name="" id="idTask">
                <h5 class="modal-title" id="myLargeModalLabel">Vos collaborateurs sur la tâche
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                {{-- CARD TABLEAU EXECUTANT --}}
                    <div class="card-body">
                         <div class="table-responsive">
                        <table class="table table-striped" id="tableContent">

                      </table>
                      </div>
                    </div>
                {{-- CARD TABLEAU EXECUTANT --}}
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

      })
      
  </script>
@stop