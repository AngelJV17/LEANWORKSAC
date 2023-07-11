@extends('layouts.admin')

{{-- @section('titulo', 'Proyectos') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">PROYECTOS</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-list-ol fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center">
                        <a href="{{ route('proyectos.create') }}"
                            class="btn btn-outline-warning shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button">
                            Nuevo Proyecto
                            <i class="fas fa-fw fa-folder-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card bg-light shadow mx-auto p-4 h-auto"
        style="width: 90%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered table-dark" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="2" class="align-middle">CÓDIGO</th>
                            <th rowspan="2" class="align-middle">NOMBRE</th>
                            <th rowspan="2" class="align-middle">UBICACIÓN</th>
                            <th rowspan="2" class="align-middle">GASTO PROYECTADO</th>
                            <th colspan="3" class="align-middle text-center">ACCIONES</th>
                        </tr>
                        <tr>
                            <th class="align-middle text-center">VER</th>
                            <th class="align-middle text-center">EDITAR</th>
                            <th class="align-middle text-center">ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($proyectos as $proyecto)
                            <tr>
                                <td>{{ $proyecto->codigo_proyecto }}</td>
                                <td>{{ $proyecto->nombre_proyecto }}</td>
                                <td>
                                    {{ $proyecto->departamento->nombre_departamento }} - 
                                    {{ $proyecto->provincia->nombre_provincia }} - 
                                    {{ $proyecto->distrito->nombre_distrito }}
                                </td>
                                <td>S/. {{ number_format($proyecto->monto_proyectado, 2) }}</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-info btn-sm rounded-circle"
                                        title="VER">
                                        <i class="fas fa-fw fa-eye fa-sm"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <a type="button" class="btn btn-outline-warning btn-sm rounded-circle"
                                        title="EDITAR" href="{{route('proyectos.edit', $proyecto->id)}}">
                                        <i class="fas fa-fw fa-pen fa-sm"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm rounded-circle"
                                        title="ELIMINAR">
                                        <i class="fas fa-fw fa-trash fa-sm"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->
@endsection
