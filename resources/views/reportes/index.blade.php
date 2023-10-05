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
                            <h4 class="font-weight-bold">REPORTES</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-list-ol fa-lg"></i>
                        </div>
                    </div>
                </div>
                {{-- <div class="p-3">
                    <div class="text-center">
                        <a href="{{ route('reportes.reporte') }}"
                            class="btn btn-outline-warning shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button">
                            Nuevo Proyecto
                            <i class="fas fa-fw fa-folder-plus"></i>
                        </a>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

    <div class="card bg-light shadow mx-auto p-4 h-auto"
        style="width: 95%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">

        <div class="container-fluid">
            <div class="row">
                <div class="card col-12 border-left-secondary">
                    <form action="{{ route('reportes.filtro') }}" method="POST">
                        @csrf
                        <div class="form-row m-2">
                            <div class="form-group mb-2 col-lg-6 col-sm-12 p-2">
                                <label for="desde">DESDE</label>
                                <input type="date" class="form-control @error('desde') is-invalid @enderror"
                                    id="desde" name="desde" placeholder="Fecha de nacimiento"
                                    max="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                    min="{{ Carbon\Carbon::now()->format('2023-01-01') }}" {{-- value="{{ old('desde') }}" --}}
                                    value="{{ isset($_POST['desde']) ? $_POST['desde'] : old('desde') }}">
                                @error('desde')
                                    <div class="alert alert-danger m-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2 col-lg-6 col-sm-12 p-2">
                                <label for="hasta">HASTA</label>
                                <input type="date" class="form-control @error('hasta') is-invalid @enderror"
                                    id="hasta" name="hasta" placeholder="Fecha de nacimiento"
                                    max="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                    min="{{ Carbon\Carbon::now()->format('2023-01-01') }}" {{-- value="{{ old('hasta') }}" --}}
                                    value="{{ isset($_POST['hasta']) ? $_POST['hasta'] : old('hasta') }}">
                                @error('hasta')
                                    <div class="alert alert-danger m-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row m-2">
                            <div class="form-group col-lg-3 col-md-6 col-sm-12 mb-2">
                                <button class="btn btn-info btn-block btn-sm" type="submit">BUSCAR</button>
                            </div>

                            @can('generar-reporte')
                                @if (!$is_empty)
                                    <div class="form-group col-lg-3 col-md-6 col-sm-12 mb-2">
                                        {{-- <a href="{{ route('reportes.pdf') }}" class="btn btn-danger btn-block btn-sm text-uppercase"
                                    id="btnPdf" type="button">
                                    GENERAR
                                    <i class="fas fa-fw fa-file-pdf"></i>
                                </a> --}}
                                        <button class="btn btn-danger btn-block btn-sm text-uppercase" id="btnPdf"
                                            type="button">
                                            GENERAR
                                            <i class="fas fa-fw fa-file-pdf"></i>
                                        </button>
                                    </div>
                                @endif
                            @endcan
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable_reporte" class="table table-striped table-bordered table-dark table-sm" width="100%"
                    cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th rowspan="2" class="align-middle">N°</th>
                            <th rowspan="2" class="align-middle">PROYECTO</th>
                            <th rowspan="2" class="align-middle">OPERACIÓN</th>
                            <th rowspan="2" class="align-middle">DESCRIPCIÓN</th>
                            <th rowspan="2" class="align-middle">REALIZADO POR</th>
                            <th rowspan="2" class="align-middle">MONTO</th>
                            <th rowspan="2" class="align-middle">FECHA</th>
                            <th colspan="3" class="align-middle text-center">FLUJO CAJA</th>
                        </tr>
                        <tr>

                            <th class="align-middle text-center">ENTRADA</th>

                            <th class="align-middle text-center">SALIDA</th>

                            <th class="align-middle text-center">SALDO</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $saldo = 0; ?>
                        @foreach ($cajas as $caja)
                            <?php
                            if ($caja->operacion == 2) {
                                $saldo = $saldo + $caja->monto;
                            }
                            if ($caja->operacion == 3) {
                                $saldo = $saldo - $caja->monto;
                            }
                            ?>

                            <tr>
                                <td>{{ $caja->id }}</td>
                                <td>{{ $caja->proyecto->nombre_proyecto }}</td>
                                <td>{{ $caja->_operacion->categoria_descripcion }}</td>
                                <td>{{ $caja->descripcion }}</td>
                                <td>{{ $caja->_autorizadoPor->nombres }} {{ $caja->_autorizadoPor->apellidos }}</td>
                                <td>S/. {{ number_format($caja->monto, 2) }}</td>
                                <td>{{ date('d-m-Y', strtotime($caja->created_at)) }}</td>
                                @if ($caja->operacion == 2)
                                    <td class="bg-success">S/. {{ number_format($caja->monto, 2) }}</td>
                                @else
                                    <td></td>
                                @endif

                                @if ($caja->operacion == 3)
                                    <td class="bg-danger">S/. {{ number_format($caja->monto, 2) }}</td>
                                @else
                                    <td></td>
                                @endif

                                <td class="bg-warning" style="color: black; font-weight: bold;">S/.
                                    {{ number_format($saldo, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/generar-pdf.js') }}"></script>
@endsection
