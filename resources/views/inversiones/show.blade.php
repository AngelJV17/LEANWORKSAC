@extends('layouts.admin')

{{-- @section('titulo', 'Editar Ingreso/Egreso') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">VER INVERSIÓN</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-money-bill-trend-up fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center align-items-center">
                        <a href="{{ route('inversiones.index') }}" class="btn btn-light shadow-lg text-uppercase font-weight-bold"
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
        style="width: 70%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <div class="form-row m-2">
            <div class="form-group col-lg-12 col-md-12 col-xs-12 mb-4">
                <label for="proyecto_id">PROYECTO:</label>
                <h5>{{ $caja->proyecto->nombre_proyecto }}</h5 class="border-2">
            </div>
        </div>
        <div class="form-row m-2">
            <div class="form-group col-md-6 col-xs-12 mb-4">
                <label for="proyecto_id">OPERACIÓN:</label>
                <h5>{{ $caja->_operacion->categoria_descripcion }}</h5 class="border-2">
            </div>
            <div class="form-group col-md-6 col-xs-12 mb-4">
                <label for="proyecto_id">TIPO:</label>
                <h5>{{ $caja->_tipo->categoria_descripcion }}</h5 class="border-2">
            </div>
        </div>
        <div class="form-row m-2">
            <div class="form-group col-md-6 col-xs-12 mb-4">
                <label for="proyecto_id">SUBTIPO:</label>
                <h5>{{ $caja->_subtipo->categoria_descripcion }}</h5 class="border-2">
            </div>
            <div class="form-group col-md-6 col-xs-12 mb-4">
                <label for="proyecto_id">AUTORIZADO POR:</label>
                <h5>{{ $caja->_autorizadoPor->nombres }} {{ $caja->_autorizadoPor->apellidos }}</h5 class="border-2">
            </div>
        </div>
        <div class="form-row m-2">
            <div class="form-group col-md-6 col-xs-12 mb-4">
                <label for="proyecto_id">REALIZADO A FAVOR:</label>
                <h5>{{ $caja->realizado_a_favor }}</h5 class="border-2">
            </div>
            <div class="form-group col-md-6 col-xs-12 mb-4">
                <label for="proyecto_id">MONTO:</label>
                <h5>S/. {{ number_format($caja->monto, 2) }}</h5 class="border-2">
            </div>
        </div>
        <div class="form-row m-2">
            <div class="form-group col-md-6 col-xs-12 mb-4">
                <label for="proyecto_id">DESCRIPCIÓN:</label>
                <h5>{{ $caja->descripcion }}</h5 class="border-2">
            </div>
            <div class="form-group col-md-6 col-xs-12 mb-4">
                <label for="proyecto_id">FECHA:</label>
                <h5>{{ date('d-m-Y', strtotime($caja->created_at)) }}</h5 class="border-2">
            </div>
        </div>
        <div class="text-center m-4">
            <a type="button" class="btn btn-warning text-white font-weight-bold m-2" title="EDITAR"
                href="{{ route('inversiones.edit', $caja->id_inversiones) }}">
                <i class="fas fa-fw fa-pen fa-sm"></i>
                EDITAR
            </a>
            <a type="button" class="btn btn-danger text-white font-weight-bold m-2" title="EDITAR"
                href="{{ route('cajas.generar-pdf', $caja->id) }}">
                <i class="fas fa-fw fa-file-pdf"></i>
                GENERAR PDF
            </a>
        </div>
    </div>

    <script src="{{ asset('js/categorias-globales.js') }}"></script>
@endsection
