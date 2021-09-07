@extends('layouts.master')

@section('pageCustomStyle')
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
@stop

@section('content')
      <div class="main-content">
        <section class="section">
          <div class="section-body">
            <div class="row mt-sm-4">
              <div class="col-12 col-md-12 col-lg-4">
                <div class="card author-box">
                  <div class="card-body">
                    <div class="author-box-center">
                      <img alt="image" src="{{ asset($userInfo->photo) }}" class="rounded-circle author-box-picture">
                      <div class="clearfix"></div>
                      <div class="author-box-name">
                        <a href="#" style="color:#fcd45d">{{ $userInfo->name.' '.$userInfo->prenoms  }}</a>
                      </div>
                      <div class="author-box-job">{{ $userInfo->fonction  }}</div>
                      <div class="author-box-job">{{ $userInfo->email }}</div>

                    </div>
                    <div class="text-center">
                      <div class="author-box-description">
                        <p>
                          {{ $userInfo->description  }}
                        </p>
                      </div>
                      <div class="mb-2 mt-3">
                        <div class="text-small font-weight-bold">Réseaux sociaux</div>
                      </div>
                  
                      @foreach($socials as $social)
                      <a href="{{ $social->socialLink }}" class="btn btn-social-icon mr-1 {{ $social->btnClass  }}">
                        <i class="{{ $social->lien_icone }}"></i>
                      </a>

                      @endforeach
                      <div class="w-100 d-sm-none"></div>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Information personnelles</h4>
                  </div>
                  <div class="card-body">
                    <div class="">
                      <p class="clearfix">
                        <span class="float-left">
                          Naissance
                        </span>
                        <span class="float-right text-muted">
                          {{ formatDate($userInfo->dateNaissance) }}
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Numero
                        </span>
                        <span class="float-right text-muted">
                          {{ $userInfo->telephone }}
                          
                        </span>
                      </p>
                      <p class="clearfix">
                        <span class="float-left">
                          Enregistré le
                        </span>
                        <span class="float-right text-caauri"><b>
                          {{ formatDate($userInfo->created_at) }}
                          </b>
                        </span>
                      </p>
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-header">
                    <h4>Compétence</h4>
                  </div>
                  <div class="card-body">
                    <ul class="list-unstyled user-progress list-unstyled-border list-unstyled-noborder">
                      <li class="media">
                        <div class="media-body">
                          <div class="media-title">Angular</div>
                        </div>
                        <div class="media-progressbar p-t-10">
                          <div class="progress" data-height="6">
                            <div class="progress-bar bg-primary" data-width="70%"></div>
                          </div>
                        </div>
                      </li>
                      <li class="media">
                        <div class="media-body">
                          <div class="media-title">NodeJs</div>
                        </div>
                        <div class="media-progressbar p-t-10">
                          <div class="progress" data-height="6">
                            <div class="progress-bar bg-warning" data-width="80%"></div>
                          </div>
                        </div>
                      </li>
                      <li class="media">
                        <div class="media-body">
                          <div class="media-title">React Js</div>
                        </div>
                        <div class="media-progressbar p-t-10">
                          <div class="progress" data-height="6">
                            <div class="progress-bar bg-green" data-width="48%"></div>
                          </div>
                        </div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-12 col-md-12 col-lg-8">
                <div class="card">
                  <div class="padding-20">
                    <ul class="nav nav-tabs" id="myTab2" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#about" role="tab"
                          aria-selected="true">Dossier </a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="profile-tab2" data-toggle="tab" href="#settings" role="tab"
                          aria-selected="false">Paramètres</a>
                      </li>
                    </ul>
                    <div class="tab-content tab-bordered" id="myTab3Content">
                      <div class="tab-pane fade show active" id="about" role="tabpanel" aria-labelledby="home-tab2">
                        <div class="container mt-30">

                            {!! $userInfo->biographie !!}
                           
                        </div>
                      </div>
                      <div class="tab-pane fade" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                        <form method="POST" class="needs-validation" action="{{ route('settingUser') }}" id="myform" >
                          <div class="card-header">
                            <h4>Paramètres de sécurité</h4>
                          </div>
                          <div class="card-body">
                            <div class="row">
                            <div class="form-group col-md-6 col-12">
                              <label for="telephone">Contact</label>
                              <input id="telephone" value="{{ $userInfo->telephone }}" type="text" class="form-control" name="telephone">
                            </div>
                                <div class="form-group col-md-6 col-12">
                                  <label for="dateNaissance">Date Naissance</label>

                                  <input id="dateNaissance" type="date" class="form-control" name="dateNaissance" value="{{ $userInfo->dateNaissance }}">
                                </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>Mot de passe</label>
                                <input type="password" class="form-control"id="password" name="password">
                               
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Confirmation</label>
                                <input type="password" class="form-control" id="password2">
                              </div>
                            </div>

                            <div class="row">
                             @php
                             $facebook = objectStat(getUserSocial(1,$userInfo->id)->first(),'socialLink');
                             $linkedIn = objectStat(getUserSocial(2,$userInfo->id)->first(),'socialLink');
                             $github = objectStat(getUserSocial(3,$userInfo->id)->first(),'socialLink');
                             $insta = objectStat(getUserSocial(4,$userInfo->id)->first(),'socialLink');
                             @endphp
                              <div class="form-group col-md-6 col-12">
                                <label>Adresse facebook</label>
                                <input type="url" class="form-control" id="facebook" name="facebook" value="{{ $facebook}}" >
                               
                              </div>
                              <div class="form-group col-md-6 col-12">
                                <label>Adresse LinkedIn</label>
                                <input type="url" class="form-control" id="LinkedIn" id="linkedIn" name="linkedIn" value="{{ $linkedIn }}" >
                              </div>
                            </div>
                            <div class="row">
                              <div class="form-group col-md-6 col-12">
                                <label>Github</label>
                                <input type="url" class="form-control" id="github" name="github" value="{{ $github }}">
                              </div>
                               
                              <div class="form-group col-md-6 col-12">
                                <label>Instagram</label>
                                <input type="text" name="instagram" class="form-control" id="instagram" value="{{ $insta }}">
                              </div>
                            </div>
                            @csrf
                            <input type="hidden"  name="user" value="{{ $userInfo->id }}">
                            @if(isSuperAdmin(Auth::id()))
                            <div class="row">
                              <div class="form-group col-12">
                                <label>Biographie</label>
                                <textarea name="biographie" 
                                  class="form-control summernote-simple">
                                    {!! $userInfo->biographie !!}
                                  </textarea>
                              </div>
                            </div> 
                            @endif         
                          </div>
                          <div class="card-footer text-right">
                            <button class="btn btn-primary" id="submitBtn">Enregistrer</button>
                          </div>
                        </form>
                      </div>
                    </div>
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
<script type="text/javascript">

      $('#submitBtn').click(function(event)
      {
        event.preventDefault();
        var password = $('#password').val();
        var password2 = $('#password2').val();
        var telephone = $('#telephone').val();
        var dateNaissance = $('#dateNaissance').val();

        //Verifie 
            if(dateNaissance != '')
            {
              if(telephone != '')
              {
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
 
              }
              else
              {
                    Swal.fire('Erreur',
                              'Le champ téléphone est resté vide',
                                'error');
              }
              
            }
            else
            {
                    Swal.fire('Erreur',
                              'Le champ date de naissance est obligatoire',
                                'error');

            }


      })
</script>


@stop

