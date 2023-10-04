@extends('layouts.admin')

{{-- @section('titulo', 'Reportes') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">PERMISOS</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-user-lock fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center">
                        @can('permisos.create')
                            <a href="{{ route('permisos.create') }}"
                                class="btn btn-outline-warning shadow-lg text-uppercase font-weight-bold" role="button"
                                data-bs-toggle="button">
                                Nuevo Permiso
                                <i class="fas fa-fw fa-user-lock"></i>
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card bg-light shadow mx-auto p-4 h-auto"
        style="width: 80%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">

        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered table-dark table-sm" width="100%"
                    cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th class="align-middle">N°</th>
                            <th class="align-middle">NOMBRE</th>
                            <th class="align-middle">FECHA</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($permisos as $permiso)
                            <tr>
                                <td>{{ $permiso->id }}</td>
                                <td>{{ $permiso->name }}</td>
                                <td>{{ date('d-m-Y', strtotime($permiso->created_at)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
