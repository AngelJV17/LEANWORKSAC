@extends('layouts.admin')

{{-- @section('titulo', 'Nuevo Proyecto') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        {{-- <div class="container">
            <div class="d-flex align-items-center justify-content-center text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">NUEVO PROYECTO</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-folder-plus fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}


        <div class="container">
            <div class="d-flex align-items-center justify-content-between text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">NUEVO PROYECTO</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-folder-plus fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center align-items-center">
                        <a href="{{ route('proyectos.index') }}"
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
        <form action="{{ url('proyectos') }}" method="POST">
            @csrf

            <div class="form-row m-2">
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="codigo_proyecto">CÓDIGO</label>
                    <input type="text" class="form-control" id="codigo_proyecto" name="codigo_proyecto"
                        placeholder="Código" value="{{ old('codigo_proyecto') }}">
                    @error('codigo_proyecto')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="nombre_proyecto">NOMBRE DEL PROYECTO</label>
                    <input type="text" class="form-control" id="nombre_proyecto" name="nombre_proyecto"
                        placeholder="Nombre del proyecto" value="{{ old('nombre_proyecto') }}">
                    @error('nombre_proyecto')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="monto_proyectado">MONTO PROYECTADO</label>
                    <input type="text" class="form-control" id="monto_proyectado" name="monto_proyectado"
                        placeholder="Monto proyectado" value="{{ old('monto_proyectado') }}">
                    @error('monto_proyectado')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="departamento_select">DEPARTAMENTO</label>
                    <select id="departamento_select" class="form-control" name="departamento_select">
                        <option selected disabled>Seleccione ...</option>
                        @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id }}">{{ $departamento->nombre_departamento }}</option>
                        @endforeach
                    </select>
                    @error('departamento_select')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-md-6 mb-4">
                    <label for="provincias_select">PROVINCIA</label>
                    <select id="provincias_select" class="form-control" name="provincias_select">
                        <option selected disabled>Seleccione ...</option>
                    </select>
                    @error('provincias_select')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="distritos_select">DISTRITO</label>
                    <select id="distritos_select" class="form-control" name="distritos_select">
                        <option selected disabled>Seleccione ...</option>
                    </select>
                    @error('distritos_select')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="text-center m-4">
                <button class="btn btn-success" type="submit">REGISTRAR</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/ubigeo.js') }}"></script>
@endsection

{{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14"></script> --}}
