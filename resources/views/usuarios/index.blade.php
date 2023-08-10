@extends('layouts.admin')

{{-- @section('titulo', 'Usuarios') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">USUARIOS</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-users fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center">
                        <a href="{{ route('usuarios.create') }}"
                            class="btn btn-outline-warning shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button">
                            Nuevo Usuario
                            <i class="fas fa-fw fa-user-plus"></i>
                        </a>
                        {{-- <button type="submit" class="btn btn-outline-warning shadow-lg text-uppercase font-weight-bold">
                            Nuevo Usuario
                            <i class="fas fa-fw fa-user-plus"></i>
                        </button> --}}
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
                            <th rowspan="2" class="align-middle">N°</th>
                            <th rowspan="2" class="align-middle">NOMBRES</th>
                            <th rowspan="2" class="align-middle">APELLIDOS</th>
                            <th rowspan="2" class="align-middle">TELÉFONO</th>
                            <th rowspan="2" class="align-middle">CORREO</th>
                            <th rowspan="2" class="align-middle">CARGO</th>
                            <th colspan="3" class="align-middle text-center">ACCIONES</th>
                        </tr>
                        <tr>
                            @can('usuarios.show')
                                <th class="align-middle text-center">VER</th>
                            @endcan
                            @can('usuarios.edit')
                                <th class="align-middle text-center">EDITAR</th>
                            @endcan
                            @can('usuarios.delete')
                                <th class="align-middle text-center">ELIMINAR</th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        @foreach ($usuarios as $usuario)
                            <tr @class(['bg-danger' => !$usuario->estado])>
                                <td>{{ $count++ }}</td>
                                <td>{{ $usuario->nombres }}</td>
                                <td>{{ $usuario->apellidos }}</td>
                                <td>{{ $usuario->celular }}</td>
                                <td>{{ $usuario->email }}</td>
                                {{-- <td>{{ $usuario->rol->nombre }}</td> --}}
                                <td>{{ $usuario->roles()->first()->name }}</td>
                                @can('usuarios.show')
                                    <td class="text-center">
                                        <a type="button" class="btn btn-outline-info btn-sm rounded-circle" title="VER"
                                            href="{{ route('usuarios.show', $usuario->id) }}">
                                            <i class="fas fa-fw fa-eye fa-sm"></i>
                                        </a>
                                    </td>
                                @endcan
                                @can('usuarios.edit')
                                    <td class="text-center">
                                        <a type="button" class="btn btn-outline-warning btn-sm rounded-circle" title="EDITAR"
                                            href="{{ route('usuarios.edit', $usuario->id) }}">
                                            <i class="fas fa-fw fa-pen fa-sm"></i>
                                        </a>
                                    </td>
                                @endcan
                                @can('usuarios.delete')
                                    <td class="text-center">
                                        <form action="{{ route('usuarios.delete', $usuario->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="ELIMINAR" @class(['btn btn-outline-danger btn-sm rounded-circle','d-none' => !$usuario->estado])
                                                data-confirm-delete="true">
                                                <i class="fas fa-fw fa-trash fa-sm"></i>
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
