@extends('layouts.admin')

{{-- @section('titulo', 'Editar Préstamo Interno') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">EDITAR PRÉSTAMO INTERNO</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-hand-holding-dollar fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center align-items-center">
                        <a href="{{ route('cajas.index') }}"
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
        <form action="{{ route('prestamos-internos.update', $prestamoInterno) }}"  method="POST">
            @csrf
            @method('PUT')

            <div class="form-row m-2">
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="proyecto_emisor">PROYECTO EMISOR</label>
                    <select id="proyecto_emisor" name="proyecto_emisor" class="form-control">
                        <option selected disabled>Seleccione el proyecto</option>
                        @foreach ($proyectos as $proyecto)
                            <option value="{{ $proyecto->id }}" @selected($prestamoInterno->proyecto_prestador == $proyecto->id)>
                                {{ $proyecto->nombre_proyecto }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="proyecto_receptor">PROYECTO RECEPTOR</label>
                    <select id="proyecto_receptor" name="proyecto_receptor" class="form-control">
                        <option selected value="{{ $prestamoInterno->proyecto_acreedor }}">
                            {{ $prestamoInterno->_proyectoAcreedor->nombre_proyecto }}</option>
                    </select>
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="autorizado_por">AUTORIZADO POR</label>
                    <select id="autorizado_por" name="autorizado_por" class="form-control text-uppercase">
                        <option selected disabled>Seleccione</option>
                        @foreach ($responsables as $responsable)
                            <option class="text-uppercase" value="{{ $responsable->id }}" @selected($prestamoInterno->autorizado_por == $responsable->id)>
                                {{ $responsable->nombres }}
                                {{ $responsable->apellidos }}</option>
                        @endforeach
                    </select>
                    @error('autorizado_por')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="monto">MONTO</label>
                    <input type="text" class="form-control" id="monto" name="monto" placeholder="Monto"
                        value="{{ $prestamoInterno->monto }}">
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-12">
                    <label for="descripcion">DESCRIPCIÓN</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" style="resize: none;">{{ $prestamoInterno->descripcion }}</textarea>
                </div>
            </div>
            <div class="text-center m-4">
                <button class="btn btn-info" type="submit">ACTUALIZAR</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/proyectos-prestamo.js') }}"></script>
@endsection
