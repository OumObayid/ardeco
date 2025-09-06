<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
    {{-- Gauche : Lien vers Dashboard --}}
    <ul class="navbar-nav d-felx align-items-center">
        <li>
            <!-- Bouton hamburger -->
            <i class="fa-solid fa-bars btn-toggle me-3 fs-5"></i>

        </li>
        <li class="nav-item" >         
            <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="fas fa-home"></i> Accueil
            </a>
      
        </li>
    </ul>

    {{-- Droite : Profil + Déconnexion --}}
    <ul class="navbar-nav ms-auto align-items-center">
        @if(Auth::check())
            <li class="nav-item d-flex align-items-center">
                {{-- Nom utilisateur : masqué sur mobile --}}
                <span class="nav-link mb-0 d-none d-md-inline">{{ Auth::user()->firstname }}</span>

                {{-- Photo (optionnel) --}}
                @if(Auth::user()->photo)
                    <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profil" class="rounded-circle mx-2" width="32"
                        height="32">
                @endif

                {{-- Déconnexion --}}
                <form action="{{ route('logout') }}" method="POST" class="d-inline ms-2">
                    @csrf
                    <button class="btn btn-sm btn-outline-danger" type="submit">
                        <i class="fas fa-sign-out-alt"></i> <span class="d-none d-md-inline">Déconnexion</span>
                    </button>
                </form>
            </li>
        @endif
    </ul>
</nav>