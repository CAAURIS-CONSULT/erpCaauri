@extends('layouts.master')

@section('pageCustomStyle')
  <link rel="stylesheet" href="assets/bundles/dropzonejs/dropzone.css">
@stop

@section('content')
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Ajouter des fichiers</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('saveFile') }}" method="POST" class="dropzone" id="mydropzone" enctype="multipart/form-data">
                      @csrf
                      <div class="fallback">
                        <input name="file" type="file" multiple />
                      </div>

                    </form>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12">
                <div class="card mb-0">
                  <div class="card-body d-flex justify-content-around">
                      <button id="resetBtn" class="btn btn-icon icon-left btn-primary col-3">
                        <i class="fas fa-redo-alt"></i> Rénitialiser</button>
                      <button id="submitBtn" class="btn btn-icon icon-left btn-warning col-3">
                        <i class="fas fa-save"></i>Enregistrer</button>
                      <a href="{{ route('showFiles') }}" class="btn btn-icon icon-left btn-primary col-3">
                        <i class="fas fa-server"></i>Voir Drive</a>
                   
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

      </div>
@endsection

@section('pageCustomScript')
    <!-- Page Specific JS File -->
  <script src="assets/bundles/dropzonejs/min/dropzone.min.js"></script>
  <!-- Page Specific JS File -->
@include('multiple-upload')
<script type="text/javascript">

      //Variable global 
    window.element = 0; 
  $(function()
  {
    //Soumission du form
    $('#submitBtn').click(function()
    {
      $.ajax({
        url:'{{ route("confirmSavedFile") }}',
        method:'POST',
        data:{'_token':'{{ csrf_token() }}', action : 1 },
        dataType:'json',
        success:function(){

                          Swal.fire(
                           'Enregistrement terminé!',
                           'Votre drive a été mis à jour',
                           'success'
                          );
                          element.remove();

        },
        error:function(){
          toastr.error('Problème de connexion, Veuillez réessayer');
        }
      });
    })
    //Renitialisation du form
    $('#resetBtn').click(function()
    {
      $.ajax({
        url:'{{ route("resetSavedFile") }}',
        method:'POST',
        data:{'_token':'{{ csrf_token() }}', action : 1 },
        dataType:'json',
        success:function(){

                          Swal.fire(
                           'Rénitialisation',
                           'Fichier surpimé',
                           'success'
                          );
                          element.remove();

        },
        error:function(){
          toastr.error('Problème de connexion, Veuillez réessayer');
        }
      });
 
    })
  })


// MI OWN SCRPTI OF MUTATION OBSERVER

    //Noeud a observer
    var targetEl = document.getElementById('mydropzone');

    //List des attribut a surveille
    var declencheur = {childList : true};

    //Function a executer au declechement
    var callback = function()
    {
      //initialisation des element du form
      element  = $('.dz-preview');

    element.click(function()
    {
      var pict  = $(this);
      var img  = pict.find('img');
      deleUploadImg(img,pict);
      console.log("Function");

    })
    }
    //Create mutation observer 
    var observer = new MutationObserver(callback);
    //Lancer l'observation
    observer.observe(targetEl,declencheur);

    //define function of delete uploadded picture

    function deleUploadImg(myImg,pict)
      {
        var name = myImg.attr('alt');

        Swal.fire({
                    title: 'Attention !!!',
                    text: 'Souhaitez-vous retirer cet élément ?',
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
                          url:'{{ route("delUploadImg") }}',
                          method:'POST',
                          data:{'_token':'{{ csrf_token() }}', filename : name },
                          dataType:'json',
                          success:function(){

                          toastr.success('Supprimé avec succès');
                            pict.remove();


                          },
                          error:function(){
                            toastr.error('Problème de connexion, Veuillez réessayer');
                          }
                        });
                      }
        })
      }

  </script>

@stop

