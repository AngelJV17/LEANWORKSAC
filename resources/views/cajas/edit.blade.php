@extends('layouts.admin')

{{-- @section('titulo', 'Editar Ingreso/Egreso') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        {{-- <div class="container">
            <div class="d-flex align-items-center justify-content-center text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">REGISTRAR INGRESO O EGRESO</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-money-bill-transfer fa-lg"></i>
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
                            <h4 class="font-weight-bold">EDITAR INGRESO O EGRESO</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-money-bill-transfer fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center align-items-center">
                        <a href="{{ route('cajas.index') }}" class="btn btn-light shadow-lg text-uppercase font-weight-bold"
                            role="button" data-bs-toggle="button">
                            <i class="fas fa-fw fa-angle-left"></i>
                            Atrás
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- {{ dd($caja) }} --}}

    <div class="card bg-light shadow mx-auto p-4 h-auto"
        style="width: 70%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <form action="{{ route('cajas.update', $caja) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row m-2">
                <div class="form-group col-lg-12 col-md-12 col-xs-12 mb-4">
                    <label for="proyecto_id">PROYECTO</label>
                    <select id="proyecto_id" name="proyecto_id" class="form-control">
                        <option selected disabled>Seleccione el proyecto</option>
                        @foreach ($proyectos as $proyecto)
                            <option value="{{ $proyecto->id }}" @selected($caja->proyecto_id == $proyecto->id)>
                                {{ $proyecto->nombre_proyecto }}</option>
                        @endforeach
                    </select>
                    @error('proyecto_id')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="operacion_select">OPERACIÓN</label>
                    <select id="operacion_select" name="operacion" class="form-control">
                        <option selected disabled>Seleccione</option>
                        @foreach ($tipo_operaciones as $tipo_operacion)
                            <option value="{{ $tipo_operacion->id }}" @selected($caja->operacion == $tipo_operacion->id)>
                                {{ $tipo_operacion->categoria_descripcion }}</option>
                        @endforeach
                    </select>
                    @error('operacion')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="tipo_select">TIPO</label>
                    <select id="tipo_select" name="tipo" class="form-control">
                        <option value="{{ $caja->tipo }}">{{ $caja->_tipo->categoria_descripcion }}</option>
                    </select>
                    @error('tipo')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="subtipo_select">SUBTIPO</label>
                    <select id="subtipo_select" name="subtipo" class="form-control">
                        <option value="{{ $caja->subtipo }}">{{ $caja->_subtipo->categoria_descripcion }}</option>
                    </select>
                    @error('subtipo')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="autorizado_por">AUTORIZADO POR</label>
                    <select id="autorizado_por" name="autorizado_por" class="form-control text-uppercase">
                        <option selected disabled>Seleccione</option>
                        @foreach ($responsables as $responsable)
                            <option class="text-uppercase" value="{{ $responsable->id }}" @selected($caja->autorizado_por == $responsable->id)>
                                {{ $responsable->nombres }}
                                {{ $responsable->apellidos }}</option>
                        @endforeach
                    </select>
                    @error('autorizado_por')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="realizado_a_favor">REALIZADO A FAVOR</label>
                    <input type="text" class="form-control" id="realizado_a_favor" name="realizado_a_favor"
                        placeholder="Realizado a favor" value="{{ $caja->realizado_a_favor }}">
                    @error('realizado_a_favor')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="monto">MONTO</label>
                    <input type="text" class="form-control" id="monto" name="monto" placeholder="Monto"
                        value="{{ $caja->monto }}">
                    @error('monto')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-12">
                    <label for="descripcion">DESCRIPCIÓN</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" style="resize: none;">{{ $caja->descripcion }}</textarea>
                </div>
                @error('descripcion')
                    <div class="alert alert-danger m-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center m-4">
                <button class="btn btn-info" type="submit">ACTUALIZAR</button>
                <a type="button" class="btn btn-danger text-white font-weight-bold m-2" title="EDITAR"
                    href="{{ route('cajas.generar-pdf', $caja->id) }}">
                    <i class="fas fa-fw fa-file-pdf"></i>
                    GENERAR PDF
                </a>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/categorias-globales.js') }}"></script>
@endsection
