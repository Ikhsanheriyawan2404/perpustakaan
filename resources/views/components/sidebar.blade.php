<div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
        <img src="{{ asset('asset') }}/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
        <a href="{{ route('users.index') }}" class="d-block">{{ auth()->user()->name }}</a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
                Dashboard
            </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('books.index') }}" class="nav-link {{ request()->routeIs('books.index') ? 'active' : '' }}">
            <i class="nav-icon fa fa-book "></i>
            <p>
                Buku
            </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('booklocations.index') }}" class="nav-link {{ request()->routeIs('booklocations.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-book-open"></i>
            <p>
                Lokasi Buku
            </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('members.index') }}" class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>
                Anggota
            </p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('bookloans.index') }}" class="nav-link {{ request()->routeIs('bookloans.index') ? 'active' : '' }}">
            <i class="nav-icon fa fa-book-bookmark"></i>
            <p>
                Peminjaman Buku
            </p>
            </a>
        </li>
        @can('user-list')
        <li class="nav-header">Management</li>
        @endcan
        @can('profil-module')
        <li class="nav-item">
            <a href="{{ route('profils.index') }}" class="nav-link {{ request()->routeIs('profils.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
                Profil
            </p>
            </a>
        </li>
        @endcan
        @can('fine-module')
        <li class="nav-item">
            <a href="{{ route('fine.index') }}" class="nav-link {{ request()->routeIs('fine.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-money-bill"></i>
            <p>
                Denda
            </p>
            </a>
        </li>
        @endcan
        @can('book-trash')
        <li class="nav-item">
            <a href="{{ route('books.trash') }}" class="nav-link {{ request()->routeIs('books.trash') || request()->routeIs('bookloans.trash') ? 'active' : '' }}">
            <i class="nav-icon fas fa-trash-alt"></i>
            <p>
                Sampah
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('books.trash') }}" class="nav-link {{ request()->routeIs('books.trash') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-book"></i>
                    <p>
                        Data Buku
                    </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('bookloans.trash') }}" class="nav-link {{ request()->routeIs('bookloans.trash') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-book-bookmark"></i>
                    <p>
                        Data Pinjaman Buku
                    </p>
                    </a>
                </li>
            </ul>
        </li>
        @endcan
        <li class="nav-item">
            @can('user-list')
            <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') || request()->routeIs('roles.*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user"></i>
            <p>
                Pengguna
                <i class="right fas fa-angle-left"></i>
            </p>
            </a>
            @endcan
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    @can('user-list')
                    <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Data Pengguna
                    </p>
                    </a>
                    @endcan
                </li>
                <li class="nav-item">
                    @can('role-list')
                    <a href="{{ route('roles.index') }}" class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-tag"></i>
                    <p>
                        Role Pengguna
                    </p>
                    </a>
                    @endcan
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-sign-out-alt" style="color: rgb(184, 0, 0);"></i>
            <p>
                <span>Keluar</span>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </p>
            </a>
        </li>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
