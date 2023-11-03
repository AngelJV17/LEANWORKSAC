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
                    <form>
                        @csrf

                        <div class="form-row m-2">
                            <div class="form-group mb-2 col-lg-6 col-sm-12 p-2">
                                <label for="proyecto">PROYECTOS</label>
                                <select id="proyecto" name="proyecto" class="form-control">
                                    <option selected value="">Seleccione el proyecto...</option>
                                    @foreach ($proyectos as $proyecto)
                                        <option value="{{ $proyecto->id }}" @selected($is_filter && $id_proyecto == $proyecto->id)>
                                            {{ $proyecto->nombre_proyecto }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('proyecto_id')
                                    <div class="alert alert-danger m-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-2 col-lg-6 col-sm-12 p-2">
                                <label for="user">RESPONSABLE</label>
                                <select id="user" name="user" class="form-control">
                                    <option selected value="">Seleccione el responsable...</option>
                                    @foreach ($users as $user)
                                        <option class="text-uppercase" value="{{ $user->id }}"
                                            @selected($is_filter && $id_user == $user->id)>{{ $user->nombres }}
                                            {{ $user->apellidos }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('user')
                                    <div class="alert alert-danger m-2">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-row m-2">
                            <div class="form-group mb-2 col-lg-2 col-sm-6 p-2">
                                <div class="">
                                    <button class="btn btn-info btn-block" type="submit">FILTRAR</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="dataTable_dev" class="table table-striped table-bordered table-dark table-sm" width="100%"
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
                            <th colspan="3" class="align-middle text-center">FLUJO</th>
                        </tr>
                        <tr>

                            <th class="align-middle text-center">INVERSIÓN</th>

                            <th class="align-middle text-center">DEVOLUCIÓN</th>

                            <th class="align-middle text-center">SALDO</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $saldo = 0; ?>
                        @foreach ($cajas as $caja)
                            <?php
                            if ($caja->subtipo == 7) {
                                $saldo = $saldo + $caja->monto;
                            }
                            if ($caja->subtipo == 53) {
                                $saldo = $saldo - $caja->monto;
                            }
                            ?>

                            <tr>
                                <td>{{ $caja->id }}</td>
                                <td>{{ $caja->proyecto->nombre_proyecto }}</td>
                                <td>{{ $caja->_subtipo->categoria_descripcion }}</td>
                                <td>{{ $caja->descripcion }}</td>
                                <td>{{ $caja->_autorizadoPor->nombres }} {{ $caja->_autorizadoPor->apellidos }}</td>
                                <td>S/. {{ number_format($caja->monto, 2) }}</td>
                                <td>{{ date('d-m-Y', strtotime($caja->created_at)) }}</td>
                                @if ($caja->subtipo == 7)
                                    <td class="bg-success">S/. {{ number_format($caja->monto, 2) }}</td>
                                @else
                                    <td></td>
                                @endif

                                @if ($caja->subtipo == 53)
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
