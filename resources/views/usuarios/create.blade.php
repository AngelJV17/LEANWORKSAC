@extends('layouts.admin')

{{-- @section('titulo', 'Nuevo Usuario') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">NUEVO USUARIO</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-user-plus fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center align-items-center">
                        <a href="{{ route('usuarios.index') }}"
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

    <div class="card bg-light shadow mx-auto p-4 h-auto p-3"
        style="width: 70%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <form action="{{ url('usuarios') }}" method="POST">
            @csrf
            <div class="form-row m-2">
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="dni_ce">DNI</label>
                    <input type="text" class="form-control @error('dni_ce') is-invalid @enderror" id="dni_ce" name="dni_ce" placeholder="DNI"
                        value="{{ old('dni_ce') }}">
                    @error('dni_ce')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="nombres">NOMBRES</label>
                    <input type="text" class="form-control @error('nombres') is-invalid @enderror" id="nombres" name="nombres" placeholder="Nombres"
                        value="{{ old('nombres') }}">
                    @error('nombres')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="apellidos">APELLIDOS</label>
                    <input type="text" class="form-control @error('apellidos') is-invalid @enderror" id="apellidos" name="apellidos" placeholder="Apellidos"
                        value="{{ old('apellidos') }}">
                    @error('apellidos')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-3 mb-4">
                    <label for="sexo">SEXO</label>
                    <select id="sexo" name="sexo" class="form-control @error('sexo') is-invalid @enderror">
                        <option selected disabled>Seleccione</option>
                        @foreach ($sexos as $sexo)
                            <option value="{{ $sexo->id }}" @selected( old('sexo') == $sexo->id )>{{ $sexo->categoria_descripcion }}</option>
                        @endforeach
                    </select>
                    @error('sexo')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-3 mb-4">
                    <label for="fecha_nacimiento">FECHA DE NACIMIENTO</label>
                    <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento"
                        placeholder="Fecha de nacimiento" max="{{ Carbon\Carbon::now()->format('2005-12-31') }}"
                        min="{{ Carbon\Carbon::now()->format('1960-01-01') }}" value="{{ old('fecha_nacimiento') }}">
                    @error('fecha_nacimiento')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            {{-- {{ dd($sexos) }} --}}
            <div class="form-row m-2">
                <div class="form-group col-md-6 mb-4">
                    <label for="celular">CELULAR</label>
                    <input type="tel" class="form-control @error('celular') is-invalid @enderror" id="celular" name="celular" placeholder="Celular"
                        value="{{ old('celular') }}">
                    @error('celular')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="direccion">DIRECCIÓN</label>
                    <input type="text" class="form-control @error('direccion') is-invalid @enderror" id="direccion" name="direccion" placeholder="Dirección"
                        value="{{ old('direccion') }}">
                    @error('direccion')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-md-6 mb-4">
                    <label for="email">CORREO</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Correo"
                        value="{{ old('email') }}">
                    @error('email')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-md-6 mb-4">
                    <label for="rol">CARGO</label>
                    <select id="rol" name="rol" class="form-control @error('rol') is-invalid @enderror">
                        <option selected disabled>Seleccione</option>
                        @foreach ($roles as $rol)
                            <option value="{{ $rol->name }}" @selected( old('rol') == $rol->name )>{{ $rol->name }}</option>
                        @endforeach
                    </select>
                    @error('rol')
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
