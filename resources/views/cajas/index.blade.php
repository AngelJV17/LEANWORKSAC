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
                            <h4 class="font-weight-bold">Ingresos y Egresos</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-money-bill-transfer fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center">
                        <a href="{{ route('cajas.create') }}"
                            class="btn btn-outline-warning shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button">
                            Nuevo Ingreso/Egreso
                            <i class="fas fa-fw fa-money-bill-transfer"></i>
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
                    {{-- {{ Form::hidden('is_filtro', true) }} --}}
                    <div class="form-row m-2">
                        <div class="form-group mb-2 col-12">
                            <label for="proyecto">PROYECTOS</label>
                            <select id="proyecto" name="proyecto" class="form-control">
                                <option selected disabled>Seleccione</option>
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
                    </div>
                    <div class="text-right m-4">
                        <button class="btn btn-info" type="submit">FILTRAR</button>
                    </div>
                </form>
            </div>

            <!-- Project Card Example -->
            @if ($is_filter)
                <div class="row">

                    <!-- Total Ingresos -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total
                                            Ingresos
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">S/.
                                                    {{ number_format($total_ingresos, 2) }}</div>
                                            </div>
                                            <div class="col">
                                                <div class="progress progress-sm mr-2">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        @if ($total_egresos > 0)
                                                        style="width: 100%"
                                                        aria-valuenow="100"
                                                        @else
                                                        style="width: 0%"
                                                        aria-valuenow="0"
                                                        @endif  aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-coins fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Egresos -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-danger shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Egresos
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">S/.
                                                    {{ number_format($total_egresos, 2) }}</div>
                                            </div>
                                            <div class="col">
                                                <?php $porcentaje = ($total_egresos > 0 || $total_ingresos > 0 ) ? ($total_egresos * 100) / $total_ingresos : 0 ; ?>
                                                <div class="progress progress-sm mr-2">
                                                    <div class="progress-bar bg-danger" role="progressbar"
                                                        style="width: {{ number_format($porcentaje,2) }}%"
                                                        aria-valuenow="{{ number_format($porcentaje,2) }}" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-coins fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Saldo Total -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Saldo
                                        </div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">S/.
                                                    {{ number_format($saldo, 2) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-coins fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Porcentaje de Gasto -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Porcentaje de Gasto</div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">{{ number_format($porcentaje,2) }} %</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-percent fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered table-dark" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="2" class="align-middle">N°</th>
                            <th rowspan="2" class="align-middle">PROYECTO</th>
                            <th rowspan="2" class="align-middle">OPERACIÓN</th>
                            <th rowspan="2" class="align-middle">TIPO</th>
                            <th rowspan="2" class="align-middle">SUBTIPO</th>
                            <th rowspan="2" class="align-middle">DESCRIPCIÓN</th>
                            <th rowspan="2" class="align-middle">AUTORIZADO POR</th>
                            <th rowspan="2" class="align-middle">REALIZADO A FAVOR</th>
                            <th rowspan="2" class="align-middle">MONTO</th>
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
                        @foreach ($cajas as $caja)
                            <tr>
                                <td>{{ $caja->id }}</td>
                                <td>{{ $caja->proyecto->nombre_proyecto }}</td>
                                <td>{{ $caja->_operacion->categoria_descripcion }}</td>
                                <td>{{ $caja->_tipo->categoria_descripcion }}</td>
                                <td>{{ $caja->_subtipo->categoria_descripcion }}</td>
                                <td>{{ $caja->descripcion }}</td>
                                <td>{{ $caja->_autorizadoPor->nombres }} {{ $caja->_autorizadoPor->apellidos }}</td>
                                <td>{{ $caja->realizado_a_favor }}</td>
                                <td>S/. {{ number_format($caja->monto, 2) }}</td>
                                <td class="text-center">
                                    <a type="button" class="btn btn-outline-info btn-sm rounded-circle" title="VER"
                                        href="{{ route('cajas.show', $caja->id) }}">
                                        <i class="fas fa-fw fa-eye fa-sm"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <a type="button" class="btn btn-outline-warning btn-sm rounded-circle"
                                        title="EDITAR"
                                        @if ($caja->is_prestamo) href="{{ route('prestamos-internos.edit', $caja->id_prestamos_internos) }}" @else
                                        href="{{ route('cajas.edit', $caja->id) }}" @endif>
                                        <i class="fas fa-fw fa-pen fa-sm"></i>
                                    </a>
                                </td>
                                <td class="text-center">
                                    <form action="{{ route('cajas.delete', $caja->id) }}" method="POST">
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

    <script src="{{ asset('js/progress.js') }}"></script>
@endsection
