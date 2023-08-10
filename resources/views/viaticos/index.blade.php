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
                            <h4 class="font-weight-bold">VIÁTICOS</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-money-bill-trend-up fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center">
                        <a href="{{ route('viaticos.create') }}"
                            class="btn btn-outline-warning shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button">
                            Nuevo Registro de Viático
                            <i class="fas fa-fw fa-money-bill-trend-up"></i>
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
                            @can('cajas.show')
                                <th class="align-middle text-center">VER</th>
                            @endcan
                            @can('cajas.edit')
                                <th class="align-middle text-center">EDITAR</th>
                            @endcan
                            @can('cajas.delete')
                                <th class="align-middle text-center">ELIMINAR</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($viaticos as $viatico)
                            <tr @class(['bg-danger' => $viatico->sustentado])>
                                <td>{{ $viatico->id }}</td>
                                <td>{{ $viatico->_proyecto->nombre_proyecto }}</td>
                                <td>{{ $viatico->descripcion }}</td>
                                <td>{{ $viatico->_autorizado_por->nombres }} {{ $viatico->_autorizado_por->apellidos }}
                                </td>
                                <td>{{ $viatico->_responsable->nombres }} {{ $viatico->_responsable->apellidos }}
                                </td>
                                <td>S/. {{ number_format($viatico->monto, 2) }}</td>
                                @can('cajas.show')
                                    <td class="text-center">
                                        <a type="button" class="btn btn-info btn-sm rounded-circle" title="VER"
                                            href="{{ route('viaticos.show', $viatico->id) }}">
                                            <i class="fas fa-fw fa-eye fa-sm"></i>
                                        </a>
                                    </td>
                                @endcan
                                @can('cajas.edit')
                                    <td class="text-center">
                                        @if (!$viatico->sustentado)
                                            <a type="button" class="btn btn-warning btn-sm rounded-circle"
                                                title="EDITAR" href="{{ route('viaticos.edit', $viatico->id) }}">
                                                <i class="fas fa-fw fa-pen fa-sm"></i>
                                            </a>
                                        @endif
                                    </td>
                                @endcan
                                @can('cajas.delete')
                                    <td class="text-center">
                                        <form action="{{ route('viaticos.delete', $viatico->id) }}" method="POST">
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
