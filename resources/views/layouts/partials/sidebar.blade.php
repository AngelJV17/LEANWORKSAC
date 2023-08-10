<!-- Main Sidebar Container -->
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            {{-- <i class="fas fa-laugh-wink"></i> --}}
            <img src="{{ asset('admin_assets/img/logo_icon.png') }}" alt="logo" width="50">
        </div>
        <div class="sidebar-brand-text mx-3">LEAN WORK SAC</div>
    </a>

    @can('indicadores')
        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item {{ Request::is('/') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('home') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Indicadores</span>
            </a>
        </li>
    @endcan

    @can('usuarios.index')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            USUARIOS
        </div>

        <!-- Nav Item - Proyectos -->
        <li class="nav-item nav-item {{ Request::is('usuarios', 'usuarios/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('usuarios.index') }}">
                <i class="fas fa-fw fa-user"></i>
                <span>Usuarios</span>
            </a>
        </li>
    @endcan

    @can('proyectos.index')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            PROYECTO
        </div>

        <!-- Nav Item - Proyectos -->
        <li class="nav-item {{ Request::is('proyectos', 'proyectos/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('proyectos.index') }}">
                <i class="fas fa-fw fa-list-ol"></i>
                <span>Proyectos</span>
            </a>
        </li>
    @endcan


    @can('cajas.index')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            INGRESOS / EGRESOS
        </div>
        <!-- Nav Item - Proyectos -->
        <li class="nav-item {{ Request::is('cajas', 'cajas/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('cajas.index') }}">
                <i class="fas fa-fw fa-cash-register"></i>
                <span>Caja (Ingresos y Egresos)</span>
            </a>
        </li>
    @endcan
    @can('caja-chica.index')
        <li class="nav-item {{ Request::is('caja-chica', 'caja-chica/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('caja-chica.index') }}">
                <i class="fas fa-fw fa-sack-dollar"></i>
                <span>Caja Chica</span>
            </a>
        </li>
    @endcan
    @can('viaticos.index')
        <li class="nav-item {{ Request::is('viaticos', 'viaticos/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('viaticos.index') }}">
                <i class="fas fa-fw fa-money-bills"></i>
                <span>Viáticos</span>
            </a>
        </li>
    @endcan

    @can('prestamos-internos.create')
        <li class="nav-item {{ Request::is('prestamos-internos', 'prestamos-internos/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('prestamos-internos.create') }}">
                <i class="fas fa-fw fa-hand-holding-dollar"></i>
                <span>Prestamo Interno</span>
            </a>
        </li>
    @endcan

    @can('inversiones.index')
        <li class="nav-item {{ Request::is('inversiones', 'inversiones/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('inversiones.index') }}">
                <i class="fas fa-fw fa-money-bill-trend-up"></i>
                <span>Inversiones</span>
            </a>
        </li>
    @endcan


    @can('categorias-globales.index', 'roles.index')
        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            ADMIN
        </div>

        <li class="nav-item {{ Request::is('categorias-globales', 'categorias-globales/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('categorias-globales.index') }}">
                <i class="fas fa-fw fa-folder-tree"></i>
                <span>Categorías y Subcategoría</span>
            </a>
        </li>

        <li class="nav-item {{ Request::is('roles', 'roles/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('roles.index') }}">
                <i class="fas fa-fw fa-user-gear"></i>
                <span>Roles</span>
            </a>
        </li>

        {{-- <li class="nav-item">
            <a class="nav-link" href="{{ route('roles.index') }}">
                <i class="fas fa-fw fa-user-lock"></i>
                <span>Permisos</span>
            </a>
        </li> --}}
    @endcan

    @can('control-cajas.index')
        <!-- Heading -->
        <div class="sidebar-heading">
            CONTROL DE CAJA
        </div>

        <li class="nav-item {{ Request::is('control-cajas', 'control-cajas/*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('control-cajas.index') }}">
                <i class="fas fa-fw fa-vault fa-xl"></i>
                <span>Control Caja</span>
            </a>
        </li>
    @endcan

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
