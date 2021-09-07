@section('content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          @include('layouts/menuDash')


          <div class="row">
            <div class="col-12">
              <div class="card">
              <div class="card-header">
                    <h4>Mes derniers  taches</h4>
                    <div class="card-header-action">
                      <a href="{{ route('userListTask') }}" class="btn btn-primary">Voir plus</a>
                    </div>
                  </div>
                <div class="card-body p-0">
                  <div class="table-responsive">
                  <table class="table table-striped" >
                      <tr>
                        <th>Tache</th>
                        <th>Deadline</th>
                        <th>Execution</th>
                        <th>Action</th>
                      </tr>
                      @php
                        $taches = getUserTask(Auth::id());
                      @endphp
                      @foreach($taches as $tache)
                          <tr style="font-weight: 100;">
                            
                            <td class="align-middle">
                              {{ $tache->nomTache }}
                            </td>

                            <td>{{ formatDate($tache->delaisExec) }}</td>
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
                                    <a href="{{ route('showTask',['task'=>$tache->id]) }}" 
                                      target="_blank" class="btn btn-icon icon-left btn-warning " id="{{ $tache->idTask }}" >
                                      <i class="fas fa-eye" style="font-size:1rem"></i>
                                    </a>                                    
                                </td>
                          </tr>
                        @endforeach
                    </tbody>
                </table>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </section>
@endsection
