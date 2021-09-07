@extends('layouts.master')


@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@stop


@section('content')

      <div class="main-content" style="padding-top:100px">
            
                  {{-- <div class="card-body"> --}}
                    <nav aria-label="breadcrumb">
                      <ol class="breadcrumb bg-primary text-white-all">
                        <li class="breadcrumb-item"><a href="#"><i class="fas fa-tachometer-alt"></i> ERP CAAURI</a></li>
                        <li class="breadcrumb-item"><a href="#"><i class="far fa-file"></i> Notifications</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><i class="fas fa-list"></i> {{ $title }}</li>
                      </ol>
                    </nav>
                  {{-- </div> --}}
                {{-- </div> --}}
        <section class="section">
          <div class="section-body">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="card">
                  <div class="body">
                    <div id="mail-nav">
                      <button type="button" class="btn btn-success waves-effect btn-compose m-b-15" id="refresh">Actualiser</button>
                      <ul class="" id="mail-folders">
                        <li @if($actif == 2)class="active"@endif>
                          <a href="{{ route('notifView',['all'=>'1']) }}" title="Inbox">Toutes les notifications
                          </a>
                        </li>
                        <li @if($actif == 1)class="active"@endif>
                          <a href="{{ route('readedNotif') }}" title="Sent">Notificatons lue</a>
                        </li>
                        <li @if($actif == 0)class="active"@endif>
                          <a href="{{ route('notReadedNotif') }}" title="Draft">Non consultées</a>
                        </li>
                      </ul>

                      <h5 class="b-b p-10 text-strong">Connectés</h5>
                      <ul class="online-user" id="online-offline">
                        <li>
                          <a href="javascript:;"> <img alt="image" src="assets/img/users/user-2.png"
                              class="rounded-circle" width="35" data-toggle="tooltip" title="Sachin Pandit">
                            Sachin Pandit
                          </a></li>
                        <li><a href="javascript:;"> <img alt="image" src="assets/img/users/user-1.png"
                              class="rounded-circle" width="35" data-toggle="tooltip" title="Sarah Smith">
                            Sarah Smith
                          </a></li>
                        
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                <div class="card">
                  <div class="boxs mail_listing">
                    <div class="inbox-center table-responsive">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                        <th class="text-left">
                            <div class="custom-checkbox custom-checkbox-table custom-control ">
                              <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad" class="custom-control-input" id="checkbox-all">
                              <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                            </div>
                        </th>
                            <th colspan="2">
                              <div class="inbox-header">
                                <div class="mail-option">
                                  <div class="email-btn-group m-l-15">
                                    <a href="#" class="col-dark-gray waves-effect m-r-20" title="back"
                                      data-toggle="tooltip">
                                      <i class="material-icons">keyboard_return</i>
                                    </a>
                                    <a href="#" class="col-dark-gray waves-effect m-r-20" title="Archive"
                                      data-toggle="tooltip">
                                      <i class="material-icons">archive</i>
                                    </a>
                                    <div class="p-r-20">|</div>
                                    <a href="#" class="col-dark-gray waves-effect m-r-20" title="Error"
                                      data-toggle="tooltip">
                                      <i class="material-icons">error</i>
                                    </a>
                                    <a href="#" class="col-dark-gray waves-effect m-r-20"  id="delNotif">
                                      <i class="material-icons" style="color: red;">delete</i>
                                    </a>
                                    <a href="#" class="col-dark-gray waves-effect m-r-20" title="Folders"
                                      data-toggle="tooltip">
                                      <i class="material-icons">folder</i>
                                    </a>
                                    <a href="#" class="col-dark-gray waves-effect m-r-20" title="Tag"
                                      data-toggle="tooltip">
                                      <i class="material-icons">local_offer</i>
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </th>
                            <th class="hidden-xs" colspan="1">
                              <div class="pull-right">
                                <div class="email-btn-group m-l-15">
                                  <a href="#" class="col-dark-gray waves-effect m-r-20" title="previous"
                                    data-toggle="tooltip">
                                    <i class="material-icons">navigate_before</i>
                                  </a>
                                  <a href="#" class="col-dark-gray waves-effect m-r-20" title="next"
                                    data-toggle="tooltip">
                                    <i class="material-icons">navigate_next</i>
                                  </a>
                                </div>
                              </div>
                            </th>
                          </tr>
                        </thead>
                        <tbody id="mesElements">

                          @foreach($notifs as $notif)
                            <tr class="unread ">
                              <td class="tbl-checkbox">
                                <div class="custom-checkbox custom-control">
                                  <input type="checkbox" name="mygroupCheck"
                                  value="{{ $notif->userHasId }}"
                                  data-checkboxes="mygroup" class="custom-control-input checkboxEl" id="{{ 'checkbox-'.$loop->iteration }}">
                                  <label for="{{ 'checkbox-'.$loop->iteration }}" class="custom-control-label">&nbsp;</label>
                                </div>
                              </td>
                              <td class="hidden-xs notifLine"
                              notifId ="{{ $notif->notifId }}" 
                              userHasNotifId ="{{ $notif->userHasId }}" 
                                data-toggle="modal" data-target="#detailModal"
                              >{{ $notif->sender }}</td>
                              <td class="max-texts notifLine" notifId ="{{ $notif->notifId }}"
                              userHasNotifId ="{{ $notif->userHasId }}"  
                                data-toggle="modal" data-target="#detailModal">
                                <a href="#" id="{{ 'statRead'.$notif->notifId }}">
                                  @if($notif->read_at != '' )
                                  <span class="badge badge-warning">Lue</span>
                                  @else
                                  <span class="badge badge-primary">Nouveau</span>
                                  @endif
                                </a>
                                {{ $notif->titre }}
                              </td>
                              
                              <td class="text-right"> {{ formatDate($notif->created_at) }} </td>
                            </tr>
                          @endforeach

                        </tbody>
                      </table>
                    </div>
                    <div class="row">
                      <div class="col-sm-7 ">
                        {{-- <p class="p-15"></p> --}}
                        {{-- {{ $notifs->link }} --}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

      </div>

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


<script type="text/javascript">

$(function()
{
  //Consulter la notification 
            $('.notifLine').click(function(event)
            {
              var idNotif = $(this).attr('notifId');
              var userHasNotifId = $(this).attr('userHasNotifId');
              //Change l'etat de lecture
                let selecto = "#statRead"+idNotif;
                let statRead = $(selecto);
              $.ajax({
                  url:"{{ route('recupNotif') }}",
                  method:'GET',
                  data:{idNotif:idNotif,userHasNotifId:userHasNotifId},
                  dataType:'html',
                  success:function(data){
                       $('#modalComment').html(data);
                       statRead.html('<span class="badge badge-secondary">Lue</span>');

                      },
                  error:function(){

                  Swal.fire('Impossible ,Probleme de connexion');
                  }
            });

            })

  //Supression des notifications
    $('#delNotif').click(function()
    {


      var elmnts = $('#mesElements').find('input:checked');
      if (elmnts.length == 0 ) 
      {
        toastr.error('Aucun elements selectionné');
        return 0;
      }
      var myArray = [];
      elmnts.each(function(index)
      {
        myArray[index] = $(this).val();

      })


      //convert to Json element
        var dataEle = JSON.stringify(myArray);
      // Del element of a componennt witih sweet alert confirm
                Swal.fire({
                  title: 'ACTION IRREVERSIBLE !!!',
                  text: 'Vous êtes sur le point de suprimer les notifications selectionnées ?',
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
                        url:"{{ route('delNotif') }}",
                        method:'GET',
                        data:{data:dataEle},
                        dataType:'json',
                        success:function(){
                          Swal.fire(
                           'Opération Effectuer avec succès!',
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




  //Actualiser les pages
      $('#refresh').click(function()
      {
        // toastr.success('encours');
       window.location.reload();
      })
})
</script>

@stop