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
                            <h4 class="font-weight-bold">INVERSIONES</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-money-bill-trend-up fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center">
                        <a href="{{ route('inversiones.create') }}"
                            class="btn btn-outline-warning shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button">
                            Nuevo Registro de Inversión
                            <i class="fas fa-fw fa-money-bill-trend-up"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card bg-light shadow mx-auto p-4 h-auto"
        style="width: 95%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">

        <div class="container-fluid">
            <div class="card shadow mb-4">
                <form>
                    @csrf

                    <div class="form-row m-2">
                        <div class="form-group mb-2 col-lg-10 col-sm-12 p-2">
                            {{-- <label for="proyecto">PROYECTOS</label> --}}
                            <select id="proyecto" name="proyecto" class="form-control">
                                <option selected value="">Seleccione el proyecto...</option>
                                @foreach ($proyectos as $proyecto)
                                    <option value="{{ $proyecto->id }}" @selected($is_filter && $proyecto_id == $proyecto->id)>
                                        {{ $proyecto->nombre_proyecto }}
                                    </option>
                                @endforeach
                            </select>
                            @error('proyecto_id')
                                <div class="alert alert-danger m-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group mb-2 col-lg-2 col-sm-6 p-2">
                            <div class="">
                                <button class="btn btn-info btn-block" type="submit">FILTRAR</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <?php
            $colors = ['success', 'info', 'warning', 'primary', 'dark'];
            $i = 0;
            ?>

            <!-- Project Card Example -->
            <div class="row">

                @foreach ($inversiones_group as $inv_group)
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-{{ $colors[$i] }} shadow">
                            <div class="card-body px-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <div class="me-2">
                                        <div
                                            class="text-monospace font-weight-bold text-{{ $colors[$i] }} text-uppercase mb-1">
                                            {{ $inv_group->_realizadoPor->nombres }}
                                            {{ $inv_group->_realizadoPor->apellidos }}</div>
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">S/.
                                            {{ number_format($inv_group->total_invertido, 2) }}</div>
                                    </div>
                                    <div class="icon-circle bg-{{ $colors[$i] }} text-white"
                                        style="height: 5rem; width: 5rem;">
                                        <i class="fas fa-money-bill-trend-up fa-2x text-white"></i>
                                    </div>
                                </div>
                                <div class="card-text">
                                    <div class="d-inline-flex align-items-center">
                                        <i class="fas fa-arrow-trend-up text-info"></i>
                                        <div class="mb-0 ml-2 font-weight-normal text-muted">Total Invertidos</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php $i++; ?>
                @endforeach
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered table-dark" width="100%"
                    cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="2" class="align-middle">N°</th>
                            <th rowspan="2" class="align-middle">PROYECTO</th>
                            <th rowspan="2" class="align-middle">DESCRIPCIÓN</th>
                            <th rowspan="2" class="align-middle">REALIZADO POR</th>
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
                        @foreach ($inversiones as $inversion)
                            <tr>
                                <td>{{ $inversion->id }}</td>
                                <td>{{ $inversion->_proyecto->nombre_proyecto }}</td>
                                <td>{{ $inversion->descripcion }}</td>
                                <td>{{ $inversion->_realizadoPor->nombres }} {{ $inversion->_realizadoPor->apellidos }}
                                </td>
                                <td>S/. {{ number_format($inversion->monto, 2) }}</td>
                                @can('cajas.show')
                                    <td class="text-center">
                                        <a type="button" class="btn btn-outline-info btn-sm rounded-circle" title="VER"
                                            href="{{ route('inversiones.show', $inversion->id) }}">
                                            <i class="fas fa-fw fa-eye fa-sm"></i>
                                        </a>
                                    </td>
                                @endcan
                                @can('cajas.edit')
                                    <td class="text-center">
                                        <a type="button" class="btn btn-outline-warning btn-sm rounded-circle" title="EDITAR"
                                            href="{{ route('inversiones.edit', $inversion->id) }}">
                                            <i class="fas fa-fw fa-pen fa-sm"></i>
                                        </a>
                                    </td>
                                @endcan
                                @can('cajas.delete')
                                    <td class="text-center">
                                        <form action="{{ route('inversiones.delete', $inversion->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle"
                                                title="ELIMINAR">
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

    <script src="{{ asset('js/progress.js') }}"></script>
@endsection
