      <div class="main-sidebar sidebar-style-2" style="background-color: #30353e;">
        <aside id="sidebar-wrapper" >
          <div class="sidebar-brand">

            <a href="/app"> 
              <img alt="image" src="{{ asset('assets/img/logoNavB.png') }}" style="height: 100%;" class="header-logo" /> 
            <span
                class="logo-name" style="color: #fff;">CAAURI</span>
            </a>
            
             
          </div>


          @if(isSuperAdmin(Auth::id()))
            <ul class="sidebar-menu" >
              <li class="menu-header">MENU-ADMIN</li>
              <li class="dropdown active" >
                <a href="/" class="nav-link" style='color: #fcd45d;'><i data-feather="monitor"></i>
                  <span >TABLEAU DE BORD</span></a>
              </li>

              <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                    data-feather="user-check"></i><span>Utilisateurs</span></a>
                <ul class="dropdown-menu">
                  <li><a href="{{ route('addUser') }}">Nouveau</a></li>
                  <li><a href="{{ route('listUser') }}">Liste</a></li>
                  <li><a href="{{ route('respoProjet') }}">Responsable Projet</a></li>
                  <li><a href="{{ route('listeRole') }}">Liste Roles</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                    data-feather="briefcase"></i><span>Entreprises</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{ route('addEntr') }}">Ajouter</a></li>
                  <li><a class="nav-link" href="{{ route('listEntr') }}">Listes Entreprise</a></li>
                </ul>
              </li>

              <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="grid"></i><span>Projets</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{ route('addProj') }}">Nouveau</a></li>
                  <li><a class="nav-link" href="{{ route('listProj') }}">Liste</a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                    data-feather="pie-chart"></i><span>Taches</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{ route('addTask') }}">Ajouter</a></li>
                  <li><a class="nav-link" href="{{ route('listTask') }}">Liste</a></li>
                </ul>
              </li>


              <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i
                    data-feather="database"></i><span> Drive </span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{ route('addFile') }}">Ajout de fichier</a></li>
                  <li><a class="nav-link" href="{{ route('showFiles') }}">Mes fichiers</a></li>
                  <li><a class="nav-link" href="{{ route('showSauv') }}">Ressources </a></li>
                </ul>
              </li>
              <li class="dropdown">
                <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Notifications</span></a>
                <ul class="dropdown-menu">
                  <li><a class="nav-link" href="{{ route('notifView') }}">Consulter</a></li>
                </ul>
              </li>
            </ul>
          @else
          <ul class="sidebar-menu" >
            <li class="menu-header">MENU- USER</li>
            <li class="dropdown active">
              <a href="/" class="nav-link" style='color: #fcd45d;'><i data-feather="monitor"></i>
                <span>TABLEAU DE BORD</span></a>
            </li>

            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i
                  data-feather="user-check"></i><span>Mes taches</span></a>
              <ul class="dropdown-menu">
                <li><a href="{{ route('userListTask') }}">Liste</a></li>
                <li><a href="{{ route('showAgenda') }}">Mon agenda</a></li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="#" class="menu-toggle nav-link has-dropdown"><i data-feather="mail"></i><span>Notifications</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="{{ route('notifView') }}">Consulter</a></li>
              </ul>
            </li>
          </ul>
          @endif
        </aside>
      </div>
