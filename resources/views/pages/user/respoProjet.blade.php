@extends('layouts.master')


@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@stop


@section('content')

      <!-- Main Content -->
<div class="main-content">
    <div class="card">
        <div class="card-header">
            <h4>Nos responsables projet</h4>
        </div>
        <div class="card-body p-0">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <tr>
                        <th class="text-center">
                          <div class="custom-checkbox custom-checkbox-table custom-control">
                            <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                              class="custom-control-input" id="checkbox-all">
                            <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                          </div>
                        </th>
                        <th>Responsable</th>
                        <th>Projets</th>
                        <th>Status Tache</th>
                        <th>Date Fin</th>
                        <th>Priority</th>
                        {{-- <th>Action</th> --}}
                      </tr>
                      @foreach($respos as $respo)
                          <tr>
                            <td class="p-0 text-center">
                              <div class="custom-checkbox custom-control">
                                <input type="checkbox" data-checkboxes="mygroup" class="custom-control-input"
                                  id="checkbox-1">
                                <label for="checkbox-1" class="custom-control-label">&nbsp;</label>
                              </div>
                            </td>
                            <td>{{ $respo->name }}</td>
                            <td class="text-truncate">
                              <ul class="list-unstyled order-list m-b-0 m-b-0">
                                <li class="team-member team-member-sm"><img class="rounded-circle"
                                    src="assets/img/users/user-8.png" alt="user" data-toggle="tooltip" title=""
                                    data-original-title="Wildan Ahdian"></li>
                                <li class="team-member team-member-sm"><img class="rounded-circle"
                                    src="assets/img/users/user-9.png" alt="user" data-toggle="tooltip" title=""
                                    data-original-title="John Deo"></li>
                                <li class="team-member team-member-sm"><img class="rounded-circle"
                                    src="assets/img/users/user-10.png" alt="user" data-toggle="tooltip" title=""
                                    data-original-title="Sarah Smith"></li>
                                <li class="avatar avatar-sm"><span class="badge badge-primary">+4</span></li>
                              </ul>
                            </td>
                            <td class="align-middle">
                              <div class="progress-text">50%</div>
                              <div class="progress" data-height="6">
                                <div class="progress-bar bg-success" data-width="50%"></div>
                              </div>
                            </td>
                            <td>2019-05-28</td>
                            <td>
                              <div class="badge badge-success">Low</div>
                            </td>
                           
                          </tr>
                      @endforeach
                    </table>
                  </div>
        </div>
        

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
        <form action="{{ route('updtUser') }}" method="POST" >
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
            url: 'showUser',
            method:'GET',
            data: {idUser:idUser},
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
            url: 'modifUser',
            method:'GET',
            data: {idUser:idUser},
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
                  text: 'Souhaitez vous réellement suprimé cet utilisateur',
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
                        url:'delUser',
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