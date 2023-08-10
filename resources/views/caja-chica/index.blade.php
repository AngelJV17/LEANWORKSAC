@extends('layouts.admin')

{{-- @section('titulo', 'Ingreso/Egreso') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">CAJA CHICA</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-sack-dollar fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center">
                        <a href="{{ route('caja-chica.create') }}"
                            class="btn btn-outline-warning shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button">
                            Nuevo Registro de Caja Chica
                            <i class="fas fa-fw fa-sack-dollar"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card bg-light shadow mx-auto p-4 h-auto"
        style="width: 95%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered table-dark" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="2" class="align-middle">N°</th>
                            <th rowspan="2" class="align-middle">PROYECTO</th>
                            <th rowspan="2" class="align-middle">DESCRIPCIÓN</th>
                            <th rowspan="2" class="align-middle">AUTORIZADO POR</th>
                            <th rowspan="2" class="align-middle">RESPONSABLE</th>
                            <th rowspan="2" class="align-middle">MONTO</th>
                            <th colspan="3" class="align-middle text-center">ACCIONES</th>
                        </tr>
                        <tr>
                            @can('caja-chica.show')
                                <th class="align-middle text-center">VER</th>
                            @endcan
                            @can('caja-chica.edit')
                                <th class="align-middle text-center">EDITAR</th>
                            @endcan
                            @can('caja-chica.delete')
                                <th class="align-middle text-center">ELIMINAR</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cajaChicas as $cajaChica)
                            <tr @class(['bg-danger' => $cajaChica->sustentado])>
                                <td>{{ $cajaChica->id }}</td>
                                <td>{{ $cajaChica->_proyecto->nombre_proyecto }}</td>
                                <td>{{ $cajaChica->descripcion }}</td>
                                <td>{{ $cajaChica->_autorizado_por->nombres }} {{ $cajaChica->_autorizado_por->apellidos }}
                                </td>
                                <td>{{ $cajaChica->_responsable->nombres }} {{ $cajaChica->_responsable->apellidos }}
                                </td>
                                <td>S/. {{ number_format($cajaChica->monto, 2) }}</td>
                                @can('caja-chica.show')
                                    <td class="text-center">
                                        <a type="button" class="btn btn-info btn-sm rounded-circle" title="VER"
                                            href="{{ route('caja-chica.show', $cajaChica->id) }}">
                                            <i class="fas fa-fw fa-eye fa-sm"></i>
                                        </a>
                                    </td>
                                @endcan
                                @can('caja-chica.edit')
                                    <td class="text-center">
                                        @if (!$cajaChica->sustentado)
                                            <a type="button" class="btn btn-warning btn-sm rounded-circle"
                                                title="EDITAR" href="{{ route('caja-chica.edit', $cajaChica->id) }}">
                                                <i class="fas fa-fw fa-pen fa-sm"></i>
                                            </a>
                                        @endif
                                    </td>
                                @endcan
                                @can('caja-chica.delete')
                                    <td class="text-center">
                                        <form action="{{ route('caja-chica.delete', $cajaChica->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-light btn-sm rounded-circle"
                                                title="ELIMINAR">
                                                <i class="fas fa-fw fa-trash fa-sm text-danger"></i>
                                            </button>
                                        </form>
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
