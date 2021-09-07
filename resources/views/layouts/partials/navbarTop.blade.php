      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
                                    collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
            <li>
              <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </li>
          </ul>
        </div>

        <ul class="navbar-nav navbar-right">
          <li class="dropdown dropdown-list-toggle" >
            <a href="#" data-toggle="dropdown"
              class="nav-link nav-link-lg message-toggle"  >
              <i data-feather="mail"></i>
              <span class="badge headerBadge1" style="background-color:#fb1408;" >
                6 </span> 
            </a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
              <div class="dropdown-header">
                Messages
                <div class="float-right">
                  <a href="#">Tout consulter</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
                @foreach(getUserNotif(Auth::id()) as $userNotif)
                <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar
                                            text-white"> <img alt="image" src="{{ asset('assets/img/users/user-1.png') }}" class="rounded-circle">
                  </span> <span class="dropdown-item-desc"> <span class="message-user">John
                      Deo</span>
                    <span class="time messege-text">Consulter vos boite de notifications</span>
                    <span class="time">2 Min Ago</span>
                  </span>
                </a> 
                @endforeach

              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
              class="nav-link notification-toggle nav-link-lg" id="notifUser"><i data-feather="bell" class="bell"></i>
            </a>

          </li>
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="{{ asset(Auth::user()->photo) }}"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title" style="color:#fcd45d">{{ Auth::user()->name.' '.Auth::user()->prenoms }}</div>
              <a href="{{ route('profile',['id'=>Auth::id()]) }}" class="dropdown-item has-icon" style="color:#000"> <i class="far
                                        fa-user"></i> Mon Profile
{{--               </a> <a href="" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                Mes taches
              </a> <a href="#" class="dropdown-item has-icon"> <i class="fas fa-cog"></i>
                Securité
              </a> --}}
              <div class="dropdown-divider"></div>
              <a href="#" onclick="event.preventDefault(); document.getElementById('logOut').submit();"
                   class="dropdown-item has-icon text-danger"> 
                   <i class="fas fa-sign-out-alt"></i>
                    Déconnexion
                    <form method="POST" action="{{ route('logout') }}" id="logOut">@csrf</form>
              </a>
            </div>
          </li>
        </ul>
      </nav>