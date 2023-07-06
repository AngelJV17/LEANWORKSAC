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
                            <h4 class="font-weight-bold">CATEGORÍAS Y SUBCATEGORÍA</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-folder-tree fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center">
                        <a href="{{ route('parametros-globales.subcategoria') }}"
                            class="btn btn-outline-warning shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button">
                            Nueva Subcategoría
                            <i class="fas fa-fw fa-folder-tree"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card bg-light shadow mx-auto p-4 h-auto"
        style="width: 90%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <div class="card-header py-3">
            {{-- <h6 class="m-0 font-weight-bold text-primary">Proyectos</h6> --}}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                {{-- <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> --}}
                <table {{-- id="dataTable" --}} class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>CATEGORÍA</th>
                            <th>SUBCATEGORÍA</th>
                            <th>SEGMENTO</th>
                            <th>SUBSEGMENTO</th>
                            <th>MÓDULO</th>
                            <th colspan="3" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>CATEGORIA</th>
                            <th>SUBCATEGORÍA</th>
                            <th>SEGMENTO</th>
                            <th>SUBSEGMENTO</th>
                            <th>MÓDULO</th>
                            <th colspan="3" class="text-center">Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach ($parametros as $parametro)
                            <tr>
                                <td>{{ $parametro->categoria_padre }}</td>
                                <td>{{ $parametro->categoria_hijo }}</td>
                                <td>{{ $parametro->subcategoria_padre }}</td>
                                <td>{{ $parametro->subcategoria_hijo }}</td>
                                <td>{{ $parametro->modulo }}</td>
                                <td class="text-center">
                                    <a type="button" class="btn btn-outline-info btn-sm btn-sm rounded-circle"
                                        title="VER">
                                        <i class="fas fa-fw fa-eye fa-sm"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a type="button" class="btn btn-outline-warning btn-sm btn-sm rounded-circle"
                                        title="EDITAR" href="{{ route('parametros-globales.edit', $parametro->id) }}">
                                        <i class="fas fa-fw fa-pen fa-sm"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('parametros-globales.delete', $parametro->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm btn-sm rounded-circle"
                                            title="ELIMINAR">
                                            <i class="fas fa-fw fa-trash fa-sm"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        {{-- <tr>
                            <td>EGRESO</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>INGRESO Y EGRESO</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-info btn-sm btn-sm rounded-circle" title="VER">
                                    <i class="fas fa-fw fa-eye fa-sm"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-warning btn-sm btn-sm rounded-circle" title="EDITAR">
                                    <i class="fas fa-fw fa-pen fa-sm"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-sm rounded-circle" title="ELIMINAR">
                                    <i class="fas fa-fw fa-trash fa-sm"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>INGRESO</td>
                            <td>INVERSIÓN</td>
                            <td></td>
                            <td></td>
                            <td>INGRESO Y EGRESO</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-info btn-sm btn-sm rounded-circle" title="VER">
                                    <i class="fas fa-fw fa-eye fa-sm"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-warning btn-sm btn-sm rounded-circle" title="EDITAR">
                                    <i class="fas fa-fw fa-pen fa-sm"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-sm rounded-circle" title="ELIMINAR">
                                    <i class="fas fa-fw fa-trash fa-sm"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>INGRESO</td>
                            <td>VENTAS</td>
                            <td></td>
                            <td></td>
                            <td>INGRESO Y EGRESO</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-info btn-sm btn-sm rounded-circle" title="VER">
                                    <i class="fas fa-fw fa-eye fa-sm"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-warning btn-sm btn-sm rounded-circle" title="EDITAR">
                                    <i class="fas fa-fw fa-pen fa-sm"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-sm rounded-circle" title="ELIMINAR">
                                    <i class="fas fa-fw fa-trash fa-sm"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>EGRESO</td>
                            <td>OBRA</td>
                            <td></td>
                            <td></td>
                            <td>INGRESO Y EGRESO</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-info btn-sm btn-sm rounded-circle" title="VER">
                                    <i class="fas fa-fw fa-eye fa-sm"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-warning btn-sm btn-sm rounded-circle" title="EDITAR">
                                    <i class="fas fa-fw fa-pen fa-sm"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-sm rounded-circle" title="ELIMINAR">
                                    <i class="fas fa-fw fa-trash fa-sm"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>EGRESO</td>
                            <td>OBRA</td>
                            <td>COMPRA DE MATERIALES</td>
                            <td></td>
                            <td>INGRESO Y EGRESO</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-info btn-sm btn-sm rounded-circle" title="VER">
                                    <i class="fas fa-fw fa-eye fa-sm"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-warning btn-sm btn-sm rounded-circle" title="EDITAR">
                                    <i class="fas fa-fw fa-pen fa-sm"></i>
                                </button>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm btn-sm rounded-circle" title="ELIMINAR">
                                    <i class="fas fa-fw fa-trash fa-sm"></i>
                                </button>
                            </td>
                            <tr>
                                <td>EGRESO</td>
                                <td>OBRA</td>
                                <td>COMPRA DE HERRAMIENTAS</td>
                                <td></td>
                                <td>INGRESO Y EGRESO</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-info btn-sm btn-sm rounded-circle" title="VER">
                                        <i class="fas fa-fw fa-eye fa-sm"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-warning btn-sm btn-sm rounded-circle" title="EDITAR">
                                        <i class="fas fa-fw fa-pen fa-sm"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-sm rounded-circle" title="ELIMINAR">
                                        <i class="fas fa-fw fa-trash fa-sm"></i>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>EGRESO</td>
                                <td>OBRA</td>
                                <td>COMPRA DE INSUMOS</td>
                                <td></td>
                                <td>INGRESO Y EGRESO</td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-info btn-sm btn-sm rounded-circle" title="VER">
                                        <i class="fas fa-fw fa-eye fa-sm"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-warning btn-sm btn-sm rounded-circle" title="EDITAR">
                                        <i class="fas fa-fw fa-pen fa-sm"></i>
                                    </button>
                                </td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-outline-danger btn-sm btn-sm rounded-circle" title="ELIMINAR">
                                        <i class="fas fa-fw fa-trash fa-sm"></i>
                                    </button>
                                </td>
                            </tr>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- /.container-fluid -->
@endsection
