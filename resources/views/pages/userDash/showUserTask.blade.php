@extends('layouts.master')


@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

  <link rel="stylesheet" href="{{ asset('assets/bundles/summernote/summernote-bs4.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/bundles/codemirror/theme/duotone-dark.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/bundles/jquery-selectric/selectric.css') }}">
@stop


@section('content')
@php
  $taskInfo= getUserTaskInfo(Auth::id(),$tache->id);
@endphp

<section>
      <div class="main-content">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Informations de la tache </h4>
                    <div class="card-header-action">
                      <a data-collapse="#tacheCard" class="btn btn-icon btn-primary" href="#tacheCard"><i
                          class="fas fa-minus"></i>
                      </a>
                    </div>
              </div>
              <div class="collapse show " id="tacheCard">
              <div class="card-body d-flex" style="padding-top: 5px;" >
                  <div class="row col-8">

                       <div class=" col-8">
                          <p>
                            <strong>Entreprise : 
                              <span>{{ getEntreprise($tache->entreprises_id)->nom }}</span>
                            </strong>
                          </p>
                          <p>
                            <strong>Projet /Dossier : 
                              <span>{{ getPrj($tache->projets_id)->libelleProjet }}</span>
                            </strong>
                          </p>
                          <p>
                            <strong>Nom de la tache : 
                              <span>{{ $tache->nomTache  }}</span>
                            </strong>
                          </p>
                        
                        </div>
                    <div class="form-group col-12">
                      <center><strong>Description de la tache</strong></center>
                      <div>
                      <blockquote class="blockquote">
                        <p class="mb-0">
                          {{ $tache->description }}
                        </p>
                      <footer class="blockquote-footer"> M. Abdoulatif 
                      </footer>
                    </blockquote>
                      </div>
                    </div>
                  </div>   
                  <div class="row col-4">
                  <div class="card-body" style="padding-top: 2px;">
                    <ul class="list-group">
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Attribué le
                        <span class="badge badge-primary badge-pill">
                         {{ formatDate($taskInfo->attributed_at) }} 
                       </span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Deadline
                        <span class="badge badge-danger badge-pill">
                          {{ formatDate($tache->delaisExec) }}  
                       </span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Vue le
                        <span class="badge badge-primary badge-pill"> 
                          @if($taskInfo->read_at)
                          {{ formatDate($taskInfo->read_at) }}
                          @else
                          Non lue
                          @endif
                           </span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Niveau évolution
                        <span class="badge badge-warning badge-pill"> {{ getLevelExc($tache->niveau_evolutions_id)->libelle  }} </span>
                      </li>
                      <li class="list-group-item d-flex justify-content-between align-items-center">
                        Dernière modif 
                        <span class="badge badge-primary badge-pill">  
                          {{ formatDate($taskInfo->last_modif) }} 
                        </span>
                      </li>
                    </ul>
                  </div>
                  </div> 
              </div>  

    
            </div>
      </div>
      <div class="card card-warning">
              <div class="card-header">
                <h4>Ressources de la Taches</h4>
                    <div class="card-header-action">
                      <a data-collapse="#tacheFiles" class="btn btn-icon btn-warning" href="#tacheFiles"><i
                          class="fas fa-plus"></i>
                      </a>
                    </div>
              </div>
              <div class="collapse " id="tacheFiles">
              <div class="card-body row" >
                {{-- {{ dd($ressources) }} --}}
                      @foreach($ressources as $ressource)
                        <div class="col-2 user-item mb-5">
                          <img alt="image" src="{{ asset($ressource->lienSvg) }}" class="img-fluid">
                          <div class="user-details">
                            <div class="user-name">{{ $ressource->nom }}</div>
                            {{-- <div class="text-job text-muted">IT Support</div> --}}
                            <div class="user-cta">
                              <a href="{{ asset($ressource->lien) }}" 
                                download="{{ createLibele($ressource->nom,50).'.'.fileExtension($ressource->lien)}}" class="btn btn-primary ">
                                Télécharger
                              </a>
                            </div>
                          </div>
                        </div>
                      @endforeach
              </div>    
              </div>  
      </div>
      <div class="card card-primary">
              <div class="card-header">
                <h4>Evolution de l'éxécution</h4>
                    <div class="card-header-action">
                      <a data-collapse="#tacheExecEv" class="btn btn-icon btn-primary" href="#tacheExecEv"><i
                          class="fas fa-plus"></i>
                      </a>
                    </div>
              </div>
              <div class="collapse " id="tacheExecEv">
    
                  <div class="card-body" >
               
                  <div class="boxs mail_listing">
                    <div class="inbox-center table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>

                            <th >
                              <div class="inbox-header">
                                <div class="mail-option">
                                  AUTEUR
                                </div>
                              </div>
                            </th>
                            <th >
                              <div class="inbox-header">
                                <div class="mail-option">
                                  TITRE DU COMMENTAIRE
                                </div>
                              </div>
                            </th>
                            <th >
                              <div class="inbox-header">
                                <div class="mail-option">
                                  EXECUTION
                                </div>
                              </div>
                            </th>
                            <th >
                              <div class="inbox-header">
                                <div class="mail-option">
                                  DATE
                                </div>
                              </div>
                            </th>

                          </tr>
                        </thead>
                        <tbody>
                          @foreach($comments as $comment)
                            <tr class="unread commentLine"
                              commentId ="{{ $comment->id }}" 
                              data-toggle="modal" data-target="#detailModal">
                              <td class="hidden-xs">
                                  <span class="badge badge-primary">{{ getUser($comment->user_id)->name.' '.getUser($comment->user_id)->prenoms }}</span>

                                </td>
                              <td class="max-texts">
                                <a href="#">
                                  {{ $comment->titre }}
                                </a>
                              </td>
                              <td class="text-right"> 
                                {{ getLevelExc($comment->niveau_evolutions_id)->libelle  }} </td>
                              <td class="text-right"> {{ $comment->created_at }} </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                    </div>
                    
                  </div>
                </div> 
              </div>  
      </div>
      <div class="card card-warning">
              <div class="card-header">
                <h4>Commenté la tache</h4>
                    <div class="card-header-action">
                      <a data-collapse="#tacheComment" class="btn btn-icon btn-warning" href="#tacheComment"><i
                          class="fas fa-plus"></i>
                      </a>
                    </div>
              </div>
              <div class="collapse " id="tacheComment">

                  <form class="card-body" action="storeTaskComment" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="idTask" value="{{ $tache->id }}">
                  <div class="row">
                       <div class="form-group col-6">
                            <label for="titre">Titre Commentaire</label>
                            <input id="titre" type="text" class="form-control" name="titre"  >
                        </div>

                       <div class="form-group col-3">
                            <label for="nomTache">Auteur</label>
                            <input id="nomTache" type="text" class="form-control" name="nomTache"  value="{{ getUser(Auth::id())->name}}" readonly="">
                        </div>
                        @php
                            $niveaux = getAllNiveau();
                            $niveauTask = $tache->niveau_evolutions_id;
                        @endphp

                    <div class='form-group col-3'>
                      <label for='niveau'>Niveau de la tache</label>
                            <select class='form-control' name='niveau' id="niveau">";
                                @foreach($niveaux as $level)
                                    <option
                                      @if($level->id == $niveauTask ) selected='' @endif
                                       value="{{ $level->id }}" >{{ $level->libelle }}
                                     </option>';
                                @endforeach  
                      </select>
                    </div>



                  </div>

                  <div class="row">
                       <div class="form-group col-12">
                            <label for="nomTache">Commentaire</label>
                            <textarea class="summernote" name="description"></textarea>
                        </div>
                    </div>

                <div class="row">
                  <fieldset class="col-4">
                    <div class="form-group">
                      <label>Nom du fichier 1</label>
                      <input type="text" name="file1Name" class="form-control" >
                    </div> 
                    <div class="form-group">
                      
                      <input type="file" name="file1" class="form-control">
                    </div>
                  </fieldset>
                  <fieldset class="col-4">
                    <div class="form-group">
                      <label>Nom du fichier 2</label>
                      <input type="text" name="file2Name" class="form-control">
                    </div> 
                    <div class="form-group">
                      
                      <input type="file" name="file2" class="form-control">
                    </div>
                  </fieldset>
                  <fieldset class="col-4">
                    <div class="form-group">
                      <label>Nom du fichier 3</label>
                      <input type="text" name="file3Name" class="form-control">
                    </div> 
                    <div class="form-group">
                      
                      <input type="file" name="file3" class="form-control">
                    </div>
                  </fieldset>
                </div>

                  <div class="form-group col-12 ">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="sendForm" style="font-size:20px" >
                      Enregistrer
                    </button>
                  </div>
                  </form> 



              </div>  
      </div>
</section>

        <div class="modal fade " id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true">
          <div class="modal-dialog ">
            <div class="modal-content">
              <div class="modal-header">
                <input type="hidden" name="" id="idTask">
                <h5 class="modal-title" id="myLargeModalLabel">Commentaire de la tache
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" id="modalComment">
                {{-- CARD TABLEAU EXECUTANT --}}
                    <div class="card-body">
                      
                    </div>
                {{-- CARD TABLEAU EXECUTANT --}}
            </div>
            </div>
          </div>
        </div>
@endsection







@section('pageCustomScript')
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  <script src="{{ asset('assets/bundles/summernote/summernote-bs4.js') }}"></script>
  <script src="{{ asset('assets/bundles/codemirror/mode/javascript/javascript.js') }}"></script>

  <script src="{{ asset('assets/bundles/jquery-selectric/jquery.selectric.min.js') }}"></script>




<script type="text/javascript">

$(function()
{


        //Au clic de envoyer
            $('.commentLine').click(function(event)
            {
              var idComment = $(this).attr('commentId');
              $.ajax({
                  url:"{{ route('recupComment') }}",
                  method:'GET',
                  data:{idComment:idComment},
                  dataType:'html',
                  success:function(data){
                       $('#modalComment').html(data);            
                      },
                  error:function(){
                  Swal.fire('Impossible ,Probleme de connexion');
                  }
              });

            })
})
</script>

@stop