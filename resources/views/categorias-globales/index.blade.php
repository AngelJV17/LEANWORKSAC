@extends('layouts.admin')

{{-- @section('titulo', 'Categorias') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">CATEGORÍAS Y SUBCATEGORÍAS</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-folder-tree fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center">
                        <a href="{{ route('categorias-globales.create') }}"
                            class="btn btn-outline-warning shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button">
                            NUEVA CATEGORÍA/SUBCATEGORÍA
                            <i class="fas fa-fw fa-folder-tree"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card bg-light shadow mx-auto p-4 h-auto"
        style="width: 90%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        {{-- <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Proyectos</h6>
        </div> --}}
        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered table-dark" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="2" class="align-middle">N°</th>
                            <th rowspan="2" class="align-middle">CATEGORÍA</th>
                            <th rowspan="2" class="align-middle">CATEGORÍA PADRE</th>
                            <th rowspan="2" class="align-middle">MÓDULO</th>
                            <th colspan="3" class="align-middle text-center">ACCIONES</th>
                        </tr>
                        <tr>
                            <th class="align-middle text-center">VER</th>
                            <th class="align-middle text-center">EDITAR</th>
                            <th class="align-middle text-center">ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $count = 1; ?>
                        @foreach ($categorias as $categoria)
                            {{-- {{ dd($categoria->categoria_padre()) }} --}}
                            <tr>
                                <td>{{ $count++ }}</td>
                                <td>{{ $categoria->categoria_descripcion }}</td>
                                <td>{{ $categoria->categoria_padre }}</td>
                                <td>{{ $categoria->modulo }}</td>
                                <td class="text-center">
                                    <a type="button" class="btn btn-outline-info btn-sm rounded-circle"
                                        title="VER" href="{{ route('categorias-globales.show', $categoria->id) }}">
                                        <i class="fas fa-fw fa-eye fa-sm"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a type="button" class="btn btn-outline-warning btn-sm rounded-circle"
                                        title="EDITAR" href="{{ route('categorias-globales.edit', $categoria->id) }}">
                                        <i class="fas fa-fw fa-pen fa-sm"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('categorias-globales.delete', $categoria->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle"
                                            title="ELIMINAR">
                                            <i class="fas fa-fw fa-trash fa-sm"></i>
                                        </button>
                                    </form>
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
