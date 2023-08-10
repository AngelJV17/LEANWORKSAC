@extends('layouts.admin')

{{-- @section('titulo', 'Editar Rol') --}}

@section('contenido')
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">
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
                        <a href="{{ route('roles.index') }}" class="btn btn-light shadow-lg text-uppercase font-weight-bold"
                            role="button" data-bs-toggle="button">
                            <i class="fas fa-fw fa-angle-left"></i>
                            Atrás
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card bg-light shadow mx-auto p-4 h-auto"
        style="width: 75%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <form action="{{ route('roles.update', $rol) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-row m-2">
                <div class="form-group col-lg-6 col-md-12 col-xs-12 mb-4">
                    <label for="rolName">NOMBRE DEL ROL</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="rolName"
                        placeholder="Rol" value="{{ $rol->name }}" name="name">
                    @error('name')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row m-2">
                <div class="form-group col-12 mb-4">
                    <label>PERMISOS DE ROL</label>
                    <!-- Permission table -->
                    <br>
                    <hr>
                    <div class="container" style="width: 100%; height: 350px; overflow: auto;">
                        <div class="row">
                            @foreach ($permisos as $permiso)
                                <div class="col-lg-3 col-sm-12">
                                    <div class="card shadow border-bottom-info mb-4" style="border-radius: 16px;">
                                        <div class="card-body text-center custom-control custom-checkbox">
                                            <span class="d-block p-2 rounded-top"><input class="form-control"
                                                    type="checkbox" name="permission[]" value="{{ $permiso->name }}"
                                                    @checked(in_array($permiso->id, $rolePermissions) ? true : false)></span>
                                            <span
                                                class="d-block bg-dark text-white p-2 rounded-bottom rounded-sm">{{ $permiso->name }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
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
