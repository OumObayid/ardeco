<aside class="main-sidebar  elevation-4 ">
    {{-- Contenu de la sidebar --}}
    <div class="sidebar ">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                {{-- Lien Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>&nbsp;&nbsp;Dashboard
                    </a>
                </li>
                {{-- Lien Catégories --}}
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}"
                        class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tags"></i>&nbsp;&nbsp;Catégories
                    </a>
                </li>
                {{-- Lien Produits --}}
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}"
                        class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>&nbsp;&nbsp;Produits
                    </a>
                </li>
                {{-- Lien Produits --}}
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        &nbsp;&nbsp;Utilisateurs
                    </a>
                </li>


                {{-- Lien Commandes --}}
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}"
                        class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-receipt"></i>&nbsp;&nbsp;Commandes
                    </a>
                </li>

                {{-- Lien Profile --}}
                <li class="nav-item">
                    <a href="{{ route('admin.profile.index') }}"
                        class="nav-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>&nbsp;&nbsp;Profil
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>