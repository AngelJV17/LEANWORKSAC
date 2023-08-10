@extends('layouts.admin')

{{-- @section('titulo', 'Caja Chica') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">SUSTENTAR CAJA CHICA</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-sack-dollar fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center align-items-center">
                        <a href="{{ route('caja-chica.index') }}"
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

        <div class="form-row m-2">
            <div class="form-group col-md-6 col-xs-12 mb-4">
                <label>PROYECTO:</label>
                <h5 class="border-2">{{ $cajaChica->_proyecto->nombre_proyecto }}</h5>
            </div>
            <div class="form-group col-md-6 col-xs-12 mb-4">
                <label>AUTORIZADO POR:</label>
                <h5 class="border-2">{{ $cajaChica->_autorizado_por->nombres . ' ' . $cajaChica->_autorizado_por->apellidos }}
                </h5>
            </div>
            <div class="form-group col-md-6 col-xs-12 mb-4">
                <label>RESPONSABLE:</label>
                <h5 class="border-2">{{ $cajaChica->_responsable->nombres . ' ' . $cajaChica->_responsable->apellidos }}</h5>
            </div>
            <div class="form-group col-md-6 col-xs-12 mb-4">
                <label>MONTO:</label>
                <h5 class="border-2">{{ $cajaChica->monto }}</h5>
            </div>
        </div>

        <form action="{{ route('caja-chica.update', $cajaChica) }}" method="POST">
            @csrf
            @method('PUT')
            {{ Form::hidden('sustentar', true) }}
            <div class="form-row m-2">
                <div class="form-group col-12">
                    <label for="descripcion">DESCRIPCIÓN</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion"
                        rows="3" style="resize: none;">{{ $cajaChica->descripcion }}</textarea>
                </div>
                @error('descripcion')
                    <div class="alert alert-danger m-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center m-4">
                <button class="btn btn-info" type="submit">SUSTENTAR</button>
            </div>
        </form>
    </div>
@endsection
