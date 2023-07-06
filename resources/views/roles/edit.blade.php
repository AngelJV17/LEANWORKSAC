@extends('layouts.admin')

{{-- @section('titulo', 'Editar Rol') --}}

@section('contenido')
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        {{-- <div class="d-flex align-items-center justify-content-between p-4">
            <div class="sidebar-brand-text m-3">
                <h4 class="font-weight-bold">EDITAR ROL</h4>
            </div>
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-fw fa-folder-plus fa-lg"></i>
            </div>
        </div> --}}

        <div class="container">
            <div class="d-flex align-items-center justify-content-between text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">EDITAR ROL</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-users-gear fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center align-items-center">
                        <a href="{{ route('roles.index') }}"
                            class="btn btn-light shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button">
                            <i class="fas fa-fw fa-angle-left"></i>
                            Atrás
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card bg-light shadow mx-auto p-4 h-auto"
        style="width: 70%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">

        {{-- {{ dd($rol) }} --}}

        <form action="{{ route('roles.update', $rol) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row m-2">
                <div class="form-group col-lg-6 col-md-12 col-xs-12 mb-4">
                    <label for="rolName">NOMBRE DEL ROL</label>
                    <input type="text" class="form-control @error('nombre') is-invalid @enderror" id="rolName"
                        placeholder="Rol" value="{{ $rol->nombre }}" name="nombre">
                    @error('nombre')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 col-md-12 col-xs-12 mb-4">
                    <label for="descripcionRol">DESCRIPCIÓN</label>
                    <input type="text" class="form-control @error('descripcion') is-invalid @enderror"
                        id="descripcionRol" placeholder="Descripción" value="{{ $rol->descripcion }}" name="descripcion">
                    @error('descripcion')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row m-2">
                <div class="form-group col-12 mb-4">
                    <label>PERMISOS DE ROL</label>
                    <!-- Permission table -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <td class="text-nowrap fw-semibold">Acceso de Administrador<i
                                            class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip" data-bs-placement="top"
                                            aria-label="Allows a full access to the system"
                                            data-bs-original-title="Allows a full access to the system"></i></td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Seleccionar
                                                todo</label>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-semibold">Gestión de Usuarios</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gestionUsuario" name="gestionUsuario"
                                                    class="custom-control-input @error('gestionUsuario') is-invalid @enderror"
                                                    value="0" {{ $rol->gestion_usuario == '0' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="gestionUsuario">Solo
                                                    Lectura</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gestionUsuario2" name="gestionUsuario"
                                                    class="custom-control-input @error('gestionUsuario') is-invalid @enderror"
                                                    value="1" {{ $rol->gestion_usuario == '1' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="gestionUsuario2">Control
                                                    Total</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-semibold">Gestión de Roles</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gestionRoles" name="gestionRoles"
                                                    class="custom-control-input @error('gestionRoles') is-invalid @enderror"
                                                    value="0" {{ $rol->gestion_roles == '0' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="gestionRoles">Solo
                                                    Lectura</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gestionRoles2" name="gestionRoles"
                                                    class="custom-control-input @error('gestionRoles') is-invalid @enderror"
                                                    value="1" {{ $rol->gestion_roles == '1' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="gestionRoles2">Control
                                                    Total</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-semibold">Gestión de Proyectos</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gestionProyectos" name="gestionProyectos"
                                                    class="custom-control-input @error('gestionProyectos') is-invalid @enderror"
                                                    value="0" {{ $rol->gestion_proyectos == '0' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="gestionProyectos">Solo
                                                    Lectura</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gestionProyectos2" name="gestionProyectos"
                                                    class="custom-control-input @error('gestionProyectos') is-invalid @enderror"
                                                    value="1" {{ $rol->gestion_proyectos == '1' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="gestionProyectos2">Control
                                                    Total</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-semibold">Gestión de Ingreso y Egreso</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gestionIngresoEgreso"
                                                    name="gestionIngresoEgreso"
                                                    class="custom-control-input @error('gestionIngresoEgreso') is-invalid @enderror"
                                                    value="0"
                                                    {{ $rol->gestion_parametros_globales == '0' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="gestionIngresoEgreso">Solo
                                                    Lectura</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="gestionIngresoEgreso2"
                                                    name="gestionIngresoEgreso"
                                                    class="custom-control-input @error('gestionIngresoEgreso') is-invalid @enderror"
                                                    value="1"
                                                    {{ $rol->gestion_parametros_globales == '1' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="gestionIngresoEgreso2">Control
                                                    Total</label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-nowrap fw-semibold">Gestión de Categorias Globales</td>
                                    <td>
                                        <div class="d-flex">
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="getionCategoriasGlobales"
                                                    name="getionCategoriasGlobales"
                                                    class="custom-control-input @error('getionCategoriasGlobales') is-invalid @enderror"value="0"
                                                    {{ $rol->gestion_parametros_globales == '0' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="getionCategoriasGlobales">
                                                    Solo Lectura
                                                </label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline">
                                                <input type="radio" id="getionCategoriasGlobales2"
                                                    name="getionCategoriasGlobales"
                                                    class="custom-control-input @error('getionCategoriasGlobales') is-invalid @enderror"value="1"
                                                    {{ $rol->gestion_parametros_globales == '1' ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="getionCategoriasGlobales2">
                                                    Control Total
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Permission table -->
                </div>
            </div>

            <div class="text-center m-4">
                <button class="btn btn-info" type="submit">ACTUALIZAR</button>
            </div>
        </form>
    </div>
@endsection
