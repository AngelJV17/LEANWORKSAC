<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<style>
    body {
        font-family: "Gill Sans", sans-serif;
        font-size: 8px;
        position: relative;
    }

    .centro {
        position: absolute;
        top: 50%;
        height: 10em;
        margin-top: -5em
    }

    td {
        border: 1px solid rgb(75, 75, 75);
    }
</style>

<body>
    <div class="centradoo">
        <table id="dataTable" class="table table-striped table-bordered table-dark" width="100%" cellspacing="0">
            <thead class="thead-light">
                <tr>
                    <th rowspan="2" colspan="3" class="align-middle"
                        style="border: 1px solid rgb(75, 75, 75); height: 55px;">
                        <img src="admin_assets/img/logo_lws.png" alt="" height="20">
                        <div style="margin-top: 5px; font-size: 12px;">
                            RUC: 20601724597
                        </div>
                    </th>
                    <th colspan="3" class="align-middle"
                        style="border: 1px solid rgb(75, 75, 75); font-weight: 400;">
                        FICHA DE CONSTANCIA DE FLUJO DE CAJA</th>
                    <th colspan="4" class="align-middle"
                        style="border: 1px solid rgb(75, 75, 75); font-weight: 400;">Fecha de
                        emisión: {{ date('d-m-Y h:i:s') }}
                    </th>

                </tr>
                <tr>
                    <th colspan="3" class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75); font-weight: 400;">ÁREA DE TESORERÍA
                    </th>

                    <th colspan="4" class="align-middle"
                        style="border: 1px solid rgb(75, 75, 75); font-weight: 400;">
                        @if (isset($desde) && isset($desde))
                        Fecha de reporte: {{ date('d-m-Y', strtotime($desde))." al ".date('d-m-Y', strtotime($hasta))}}
                        @else
                        Reporte completo de caja
                        @endif
                    </th>
                </tr>
            </thead>

            <thead class="thead-light">
                <tr>
                    <th rowspan="2" class="align-middle" style="border: 1px solid rgb(75, 75, 75);">N°</th>
                    <th rowspan="2" class="align-middle" style="border: 1px solid rgb(75, 75, 75);">PROYECTO</th>
                    <th rowspan="2" class="align-middle" style="border: 1px solid rgb(75, 75, 75);">OPERACIÓN</th>
                    <th rowspan="2" class="align-middle" style="border: 1px solid rgb(75, 75, 75);">DESCRIPCIÓN</th>
                    <th rowspan="2" class="align-middle" style="border: 1px solid rgb(75, 75, 75);">REALIZADO POR
                    </th>
                    {{-- <th rowspan="2" class="align-middle" style="border: 1px solid rgb(75, 75, 75);">MONTO</th> --}}
                    <th rowspan="2" class="align-middle" style="border: 1px solid rgb(75, 75, 75);">FECHA</th>
                    <th colspan="3" class="align-middle text-center" style="border: 1px solid rgb(75, 75, 75);">FLUJO
                        CAJA</th>
                </tr>
                <tr>

                    <th class="align-middle text-center" style="border: 1px solid rgb(75, 75, 75);">ENTRADA</th>

                    <th class="align-middle text-center" style="border: 1px solid rgb(75, 75, 75);">SALIDA</th>

                    <th class="align-middle text-center" style="border: 1px solid rgb(75, 75, 75);">SALDO</th>

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
                        {{-- <td>S/. {{ number_format($caja->monto, 2) }}</td> --}}
                        <td>{{ date('d-m-Y', strtotime($caja->created_at)) }}</td>
                        @if ($caja->operacion == 2)
                            <td class="bg-success" {{-- style="background-color: rgb(100, 250, 100);" --}}>S/ {{ number_format($caja->monto, 2) }}</td>
                        @else
                            <td></td>
                        @endif

                        @if ($caja->operacion == 3)
                            <td class="bg-danger" {{-- style="background-color: rgb(250, 100, 100);" --}}>S/ {{ number_format($caja->monto, 2) }}</td>
                        @else
                            <td></td>
                        @endif

                        <td class="bg-warning" style="color: black; font-weight: bold;">S/
                            {{ number_format($saldo, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>
