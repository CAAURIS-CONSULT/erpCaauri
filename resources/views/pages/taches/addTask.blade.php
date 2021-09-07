@extends('layouts.master')


@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@stop


@section('content')

<section>
      <div class="main-content">
            <div class="card card-primary">
              <div class="card-header">
                <h4>Ajout des tâches</h4>
              </div>    
              <div class="card-body">
                <form method="POST" action="{{ route('insertTask') }}" id="taskForm"> 
                  @csrf
                  <div class="row">
                        <div class="form-group col-6">
                            <label>Entreprise</label>
                            <select class="form-control" name="entreprises_id" id="entreprises_id">
                                  <option value="0">--- Nos entreprise ---</option>
                                  @foreach(allEntre() as $entre)
                                  <option value="{{ $entre->id}}">{{ $entre->nom}}</option>
                                  @endforeach
                            </select>
                        </div>
                        <div class="form-group col-6">
                            <label>Projet - Responsable d'execution</label>
                            <select class="form-control" name="projets_id" id="projets_id">
                                {{--   @foreach(getAllPrj() as $proj)
                                  <option value="{{ $proj->id}}">{{ $proj->libelleProjet}} - {{ getRespoProjet($proj->id)->name }}  </option>
                                  @endforeach --}}
                                  <option value="0">Veuillez choisir une entreprise</option>
                            </select>
                        </div>
                       <div class="form-group col-6">
                            <label for="nomTache">Nom de la tâche</label>
                            <input id="nomTache" type="text" class="form-control" name="nomTache"  placeholder="">
                        </div>

                    <div class="form-group col-3">
                      <label for="delaisExec">Deadline de la tache</label>

                      <input id="delaisExec" type="date" class="form-control" name="delaisExec">
                    </div>
                    <div class="form-group col-3">
                      <label for="niveau_evolutions_id">Niveau d'evolution</label>
                            <select class="form-control" name="niveau_evolutions_id">
                                  @foreach(getAllNiveau() as $level)
                                  <option value="{{ $level->id}}">{{ $level->libelle}}</option>
                                  @endforeach
                            </select>
                    </div>
                    <div class="form-group col-12">
                      <label>Description de la tache</label>
                      <textarea class="form-control" name="description"></textarea>
                    </div>

                  <div class="form-group col-12 ">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" id="sendForm" style="font-size:20px" >
                      Enregistrer
                    </button>
                  </div>
                </form>
              </div>
    
            </div>
      </div>
    </section>
@endsection


@section('pageCustomScript')
  <script src="{{ asset('assets/js/custom.js') }}"></script>


<script type="text/javascript">

$(function()
{
          //Au choix de la entreprise 
            $('#entreprises_id').change(function()
            {

                var entreprises_id = $('#entreprises_id').val();

                if (entreprises_id == '0') 
                {
                 $('#entreprises_id').attr('class','form-control is-invalid'); 
                }else{$('#entreprises_id').attr('class','form-control is-valid');}
                  
                $('#projets_id').html('<option value="0"> --  Listes des projets --</option>');
                if (entreprises_id != 0) 
                {
                  ajaxRecupProj(entreprises_id);        
                }

            })

        //Au clic de envoyer
            $('#sendForm').click(function(event)
            {
                event.preventDefault();

                if ($('#entreprises_id').val() !='0') 
                {   
                    $('#entreprises_id').attr('class','form-control is-valid');
                    if ($('#projets_id').val() !='0') 
                    {
                               //Soumission du formulaire 
                               $('#taskForm').submit();         
                    }
                    else
                    {
                        $('#projets_id').attr('class','form-control is-invalid');
                        Swal.fire('Champ projet incorrect');
                    }  
                }
                else
                {
                $('#entreprises_id').attr('class','form-control is-invalid');
                Swal.fire('Veuillez choisir une entreprise');
                }
            })


        //Recup module 
        function ajaxRecupProj(idEntr)
        {
            $.ajax({
                url:'getProjet',
                method:'GET',
                data:{idEntr:idEntr},
                dataType:'html',
                success:function(data){
                     $('#projets_id').html(data);
                            
                },
                error:function(){

                Swal.fire('Impossible ,Probleme de connexion');
                }
            });
            }
})
</script>

@stop