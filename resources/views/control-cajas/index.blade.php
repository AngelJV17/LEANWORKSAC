@extends('layouts.admin')

{{-- @section('titulo', 'Control de Cajas') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold text-uppercase">CONTROL DE CAJAS</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-vault fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center">
                        <button class="btn btn-outline-warning shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button" data-toggle="modal" data-target="#formCaja">
                            Aperturar Caja
                            <i class="fas fa-fw fa-vault"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php $count = 0; ?>
    <div class="card bg-light shadow mx-auto p-4 h-auto"
        style="width: 90%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered table-dark" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="2" class="align-middle">N°</th>
                            <th rowspan="2" class="align-middle">HORA DE APERTURA</th>
                            <th rowspan="2" class="align-middle">HORA DE CIERRE</th>
                            <th rowspan="2" class="align-middle">RESPONSABLE</th>
                            <th rowspan="2" class="align-middle">FECHA</th>
                            <th colspan="3" class="align-middle text-center">ACCIONES</th>
                        </tr>
                        <tr>
                            <th class="align-middle text-center">VER</th>
                            <th class="align-middle text-center">EDITAR</th>
                            <th class="align-middle text-center">CERRAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($control_cajas as $control_caja)
                            <?php $count++; ?>
                            <tr @class(['bg-danger' => !$control_caja->is_abierto])>
                                <td>{{ $count }}</td>
                                <td>{{ date('h:i:s A', strtotime($control_caja->hora_apertura)) }}</td>
                                <td>{{ $control_caja->hora_cierre ? date('h:i:s A', strtotime($control_caja->hora_cierre)) : '' }}
                                </td>

                                <td>
                                    {{ $control_caja->_responsable->nombres . ' ' . $control_caja->_responsable->apellidos }}
                                </td>
                                <td>
                                    {{ date('d/m/Y', strtotime($control_caja->created_at)) }}</td>
                                <td class="text-center">
                                    <a type="button" class="btn btn-info btn-sm rounded-circle" title="EDITAR"
                                        href="{{ route('control-cajas.show', $control_caja->id) }}">
                                        <i class="fas fa-fw fa-eye fa-sm"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a type="button" class="btn btn-warning btn-sm rounded-circle" title="EDITAR"
                                        href="{{ route('control-cajas.edit', $control_caja->id) }}">
                                        <i class="fas fa-fw fa-pen fa-sm"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    @if ($control_caja->is_abierto)
                                        <form action="{{ route('control-cajas.update', $control_caja) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            {{ Form::hidden('volver_aperturar', 0) }}
                                            <button type="submit" class="btn btn-light btn-sm rounded-circle"
                                                title="CERRAR CAJA">
                                                <i class="fas fa-fw fa-trash fa-sm text-danger"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('layouts.modals.form-control-caja')
    <!-- /.container-fluid -->
@endsection
