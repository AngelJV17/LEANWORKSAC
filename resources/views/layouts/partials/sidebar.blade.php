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

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Indicadores</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        USUARIOS
    </div>

    <!-- Nav Item - Proyectos -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('usuarios.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>Usuarios</span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('userCreate') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Nuevo Usuario</span>
        </a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        PROYECTO
    </div>

    <!-- Nav Item - Proyectos -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('proyectos.index') }}">
            <i class="fas fa-fw fa-list-ol"></i>
            <span>Proyectos</span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('createProject') }}">
            <i class="fas fa-fw fa-folder"></i>
            <span>Nuevo Proyecto</span>
        </a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        INGRESOS / EGRESOS
    </div>

    <!-- Nav Item - Proyectos -->
    <li class="nav-item">
        <a class="nav-link" href="{{ route('cajas.index') }}">
            <i class="fas fa-fw fa-money-bill-transfer"></i>
            <span>Caja (Ingresos y Egresos)</span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('createProject') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Tabla Ingresos/Egresos</span>
        </a>
    </li> --}}

    <li class="nav-item">
        <a class="nav-link" href="{{ route('cajas.prestamo-interno') }}">
            <i class="fas fa-fw fa-hand-holding-dollar"></i>
            <span>Prestamo Interno</span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('createProject') }}">
            <i class="fas fa-fw fa-receipt"></i>
            <span>Pago de Adelantos</span>
        </a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        ADMIN
    </div>

    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('parametros-globales.create') }}">
            <i class="fas fa-fw fa-database"></i>
            <span>Registrar Categorías</span>
        </a>
    </li> --}}

    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('categorias-globales.create') }}">
            <i class="fas fa-fw fa-database"></i>
            <span>Registrar Categorías</span>
        </a>
    </li> --}}

    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('parametros-globales.index') }}">
            <i class="fas fa-fw fa-folder-tree"></i>
            <span>Categorías y Subcategoría</span>
        </a>
    </li> --}}

    <li class="nav-item">
        <a class="nav-link" href="{{ route('categorias-globales.index') }}">
            <i class="fas fa-fw fa-folder-tree"></i>
            <span>Categorías y Subcategoría</span>
        </a>
    </li>

    {{-- <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Registro Categorias</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Registro Ingreso:</h6>
                <a class="collapse-item font-weight-bold text-gray-800" href="#">Categoria de Ingreso</a>
                <a class="collapse-item font-weight-bold text-gray-800" href="#">Subategoria de Ingreso </a>
                <h6 class="collapse-header">Registro Egreso:</h6>
                <a class="collapse-item font-weight-bold text-gray-800" href="#">Categoria de Egreso</a>
                <a class="collapse-item font-weight-bold text-gray-800" href="#">Subategoria de Egreso </a>
            </div>
        </div>
    </li> --}}

    <li class="nav-item">
        <a class="nav-link" href="{{ route('roles.index') }}">
            <i class="fas fa-fw fa-user-gear"></i>
            <span>Roles</span>
        </a>
    </li>

    {{-- <li class="nav-item">
        <a class="nav-link" href="{{ route('listaUsuarios') }}">
            <i class="fas fa-fw fa-users-gear"></i>
            <span>Lista de Cargos/Roles</span>
        </a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
