@extends('layouts.admin')

{{-- @section('titulo', 'Nuevo Ingreso/Egreso') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between text-white text-center">
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

    <div class="card bg-light shadow mx-auto p-4 h-auto"
        style="width: 70%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <form action="{{ url('cajas') }}" method="POST">
            @csrf

            <div class="form-row m-2">
                <div class="form-group col-lg-12 col-md-12 col-xs-12 mb-4">
                    <label for="proyecto_id">PROYECTO</label>
                    <select id="proyecto_id" name="proyecto_id" class="form-control">
                        <option selected disabled>Seleccione el proyecto</option>
                        @foreach ($proyectos as $proyecto)
                            <option value="{{ $proyecto->id }}">{{ $proyecto->nombre_proyecto }}</option>
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
                            <option value="{{ $tipo_operacion->id }}">{{ $tipo_operacion->categoria_descripcion }}</option>
                        @endforeach
                    </select>
                    @error('operacion')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="tipo_select">TIPO</label>
                    <select id="tipo_select" name="tipo" class="form-control">
                        <option selected disabled>Seleccione</option>
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
                        <option selected disabled>Seleccione</option>
                    </select>
                    @error('subtipo')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="autorizado_por">AUTORIZADO POR / REALIZADO POR</label>
                    <select id="autorizado_por" name="autorizado_por" class="form-control text-uppercase">
                        <option selected disabled>Seleccione</option>
                        @foreach ($responsables as $responsable)
                            <option class="text-uppercase" value="{{ $responsable->id }}">{{ $responsable->nombres }}
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
                    <label for="realizado_a_favor">REALIZADO A FAVOR / RESPONSABLE</label>
                    <input type="text" class="form-control" id="realizado_a_favor" name="realizado_a_favor"
                        placeholder="Realizado a favor" value="{{ old('realizado_a_favor') }}">
                    @error('realizado_a_favor')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="monto">MONTO</label>
                    <input type="text" class="form-control" id="monto" name="monto" placeholder="Monto"
                        value="{{ old('monto') }}">
                    @error('monto')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-12">
                    <label for="descripcion">DESCRIPCIÓN</label>
                    <textarea class="form-control" id="descripcion" name="descripcion" rows="3" style="resize: none;"
                        value="{{ old('descripcion') }}"></textarea>
                </div>
                @error('descripcion')
                    <div class="alert alert-danger m-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-row m-2">
                <div class="form-group col-12">
                    <label for="created_at">FECHA</label>
                    <input type="date" class="form-control @error('created_at') is-invalid @enderror" id="created_at"
                        name="created_at" placeholder="Fecha"
                        max="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                        min="{{ Carbon\Carbon::now()->format('2023-01-01') }}"
                        value="{{ old('created_at') }}">
                    @error('created_at')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="text-center m-4">
                <button class="btn btn-success" type="submit">REGISTRAR</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/categorias-globales.js') }}"></script>
@endsection
