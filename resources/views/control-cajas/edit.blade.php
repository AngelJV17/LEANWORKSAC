@extends('layouts.admin')

{{-- @section('titulo', 'Control Caja') --}}

@section('contenido')
    <!-- Page Heading -->
    {{-- {{dd($cajaControl)}} --}}
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">EDITAR CONTROL DE CAJA</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-users-gear fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center align-items-center">
                        <a href="{{ route('control-cajas.index') }}"
                            class="btn btn-light shadow text-uppercase font-weight-bold" role="button"
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
        style="width: 80%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        {{-- <div class="container">
            <div class="card bg-light bg-white mx-auto border-bottom-warning w-auto"
                style="border-radius: 21px 21px 21px 21px;">
                <div class="card-body">
                    <div class="d-flex justify-content-end align-items-end mb-2">
                        @if ($cajaControl->is_abierto)
                            <span class="rounded-circle bg-gradient-success shadow-sm"
                                style="width: 24px; height: 24px; border: 2px solid white;"></span>
                        @else
                            <span class="rounded-circle bg-gradient-danger shadow-sm"
                                style="width: 24px; height: 24px; border: 2px solid white;"></span>
                        @endif
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-fw fa-cash-register fa-xl mr-2 text-muted"></i>
                        @if ($cajaControl->is_abierto)
                            <div class="card-title text-muted font-weight-bold">CAJA APERTURADA</div>
                        @else
                            <div class="card-title text-muted font-weight-bold">CAJA CERRADA</div>
                        @endif
                    </div>
                    <hr>
                    <p class="card-text  mb-4 text-muted">Hay una caja
                        aperturada puedes realizar registros de
                        <strong>INGRESO</strong>
                        y <strong>EGRESO</strong>.
                    </p>
                    <div class="d-flex justify-content-end align-items-end">
                        <form action="{{ route('control-cajas.update', $cajaControl->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-danger btn-sm">
                                CERRAR CAJA
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div> --}}
        <div @class([
            'card text-center w-auto shadow-sm',
            'border-bottom-success' => $cajaControl->is_abierto,
            'border-bottom-danger' => !$cajaControl->is_abierto,
        ]) style="border-radius: 21px 21px 21px 21px; border: none;">
            <div class="card-header text-uppercase" style="border-radius: 21px 21px 0 0; border: none;">
                Control de Caja
            </div>
            <div class="card-body">
                @if ($cajaControl->is_abierto)
                    <h5 class="card-title text-uppercase text-success">Caja aperturada</h5>
                    <p class="card-text text-muted text-uppercase">{{ $cajaControl->_responsable->nombres.' '.$cajaControl->_responsable->apellidos }}</p>
                    <form action="{{ route('control-cajas.update', $cajaControl) }}" method="POST">
                        @csrf
                        @method('PUT')
                        {{ Form::hidden('volver_aperturar', 0) }}
                        <button type="submit" class="btn btn-danger text-uppercase">
                            Cerrar caja
                        </button>
                    </form>
                @else
                    <h5 class="card-title text-uppercase text-danger">Caja cerrada</h5>
                    <p class="card-text text-muted text-uppercase">{{ $cajaControl->_responsable->nombres.' '.$cajaControl->_responsable->apellidos }}</p>
                    <form action="{{ route('control-cajas.update', $cajaControl) }}" method="POST">
                        @csrf
                        @method('PUT')
                        {{ Form::hidden('volver_aperturar', 1) }}
                        <button type="submit" class="btn btn-danger text-uppercase">
                            Volver a aperturar
                        </button>
                    </form>
                @endif

            </div>
            <div class="card-footer text-muted" style="border-radius: 0 0 21px 21px; border: none;">
                <?php
                $hoy = Carbon\Carbon::now();
                $diferencia = $hoy->diff(Carbon\Carbon::parse($cajaControl->created_at));
                $dias = $diferencia->format('%a')
                ?>
                @if ($dias != 0)
                    {{ 'Aperturado hace '.$diferencia->format('%a Días') }}
                @else
                    {{ 'Aperturado hace '.$diferencia->format('%h Horas %i Minutos') }}
                @endif
            </div>
        </div>
    </div>
@endsection
