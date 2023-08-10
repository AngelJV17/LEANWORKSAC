@extends('layouts.admin')

{{-- @section('titulo', 'Préstamo Interno') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">EDITAR INVERSIÓN</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-money-bill-trend-up fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center align-items-center">
                        <a href="{{ route('inversiones.index') }}"
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
        <form action="{{ route('inversiones.update', $inversion) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row m-2">
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="proyecto">PROYECTO</label>
                    <select id="proyecto" name="proyecto" class="form-control @error('proyecto') is-invalid @enderror">
                        <option selected disabled>Seleccione el proyecto</option>
                        @foreach ($proyectos as $proyecto)
                            <option value="{{ $proyecto->id }}" @selected($proyecto->id == $inversion->proyecto_id)>
                                {{ $proyecto->nombre_proyecto }}</option>
                        @endforeach
                    </select>
                    @error('proyecto')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="realizado_por">REALIZADO POR</label>
                    <select id="realizado_por" name="realizado_por" class="form-control text-uppercase @error('realizado_por') is-invalid @enderror">
                        <option selected disabled>Seleccione</option>
                        @foreach ($responsables as $responsable)
                            <option class="text-uppercase" value="{{ $responsable->id }}" @selected($responsable->id == $inversion->realizado_por)>
                                {{ $responsable->nombres }}
                                {{ $responsable->apellidos }}</option>
                        @endforeach
                    </select>
                    @error('realizado_por')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 col-md-6 col-xs-6 mb-4">
                    <label for="monto">MONTO</label>
                    <input type="text" class="form-control @error('monto') is-invalid @enderror" id="monto" name="monto" placeholder="Monto"
                        value="{{ $inversion->monto }}">
                    @error('monto')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-12">
                    <label for="descripcion">DESCRIPCIÓN</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" rows="3" style="resize: none;">{{ $inversion->descripcion }}</textarea>
                </div>
                @error('descripcion')
                    <div class="alert alert-danger m-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="text-center m-4">
                <button class="btn btn-info" type="submit">ACTUALIZAR</button>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/proyectos-prestamo.js') }}"></script>
@endsection
