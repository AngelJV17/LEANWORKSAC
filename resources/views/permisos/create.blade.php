@extends('layouts.admin')

{{-- @section('titulo', 'Nuevo Rol') --}}

@section('contenido')
    {{-- {{ dd($permisos) }} --}}
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">NUEVO PERMISO</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-user-lock fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center align-items-center">
                        <a href="{{ route('permisos.index') }}" class="btn btn-light shadow-lg text-uppercase font-weight-bold"
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

        <form action="{{ url('permisos') }}" method="POST">
            @csrf
            <div class="form-row m-2">
                <div class="form-group col-lg-6 col-md-12 col-xs-12 mb-4">
                    <label for="permissionName">NOMBRE DEL PERMISO</label>
                    <input type="text" class="form-control @error('permiso') is-invalid @enderror" id="permissionName"
                        placeholder="Permiso" value="{{ old('permiso') }}" name="permiso">
                    @error('permiso')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-center m-4">
                <button class="btn btn-success" type="submit">REGISTRAR</button>
            </div>
        </form>
    </div>
@endsection
