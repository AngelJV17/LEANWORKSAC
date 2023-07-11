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
        font-size: 10px;
        position: relative;
    }

    .centro {
        position: absolute;
        top: 50%;
        height: 10em;
        margin-top: -5em
    }
</style>

<body>
    <?php
    
    $id = $caja->id;
    $num_revision = '';
    switch ($id) {
        case $id < 10:
            $num_revision = '000000' . $id;
            break;
        case $id < 100:
            $num_revision = '00000' . $id;
            break;
        case $id < 1000:
            $num_revision = '0000' . $id;
            break;
        case $id < 99000:
            $num_revision = '000' . $id;
            break;
        case $id < 999000:
            $num_revision = '00' . $id;
            break;
        default:
            $num_revision = '0' . $id;
            break;
    }
    
    ?>
    <div class="centradoo">
        <table id="dataTable" class="table table-striped table-bordered table-dark" width="100%" cellspacing="0">
            <thead class="thead-light">
                <tr>
                    <th rowspan="4" colspan="2" class="align-middle"
                        style="border: 1px solid rgb(75, 75, 75); height: 80px;">
                        <img src="admin_assets/img/logo_lws.png" alt="" height="25">
                        <div style="margin-top: 5px; font-size: 14px;">
                            RUC: 20601724597
                        </div>
                    </th>
                    <th colspan="3" rowspan="2" class="align-middle"
                        style="border: 1px solid rgb(75, 75, 75); font-weight: 400;">
                        FICHA DE CONSTANCIA DE FLUJO DE CAJA</th>
                    <th class="align-middle" style="border: 1px solid rgb(75, 75, 75); font-weight: 400;">N° de
                        documento:
                    </th>

                </tr>
                <tr>
                    <th class="align-middle" style="border: 1px solid rgb(75, 75, 75);">{{ $num_revision }}</th>
                </tr>
                <tr>
                    <th colspan="3" rowspan="2" class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75); font-weight: 400;">ÁREA DE TESORERÍA
                    </th>

                    <th class="align-middle" style="border: 1px solid rgb(75, 75, 75); font-weight: 400;">Fecha de
                        emisión:</th>
                </tr>
                <tr>
                    <th class="align-middle text-center" style="border: 1px solid rgb(75, 75, 75);">
                        {{ $caja->created_at }}
                    </th>
                </tr>
                <tr>
                    <th colspan="2" class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75); height: 25px;">
                        PROYECTO</th>
                    <th colspan="4" class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75); height: 25px;">
                        {{ $caja->proyecto->nombre_proyecto }}</th>
                </tr>
                <tr>
                    <th colspan="2" class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75); height: 25px; font-weight: 400;">
                        NOMBRES Y APELLIDOS</th>
                    <th colspan="2" class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75); height: 25px;">
                        {{ $caja->_autorizadoPor->nombres }} {{ $caja->_autorizadoPor->apellidos }}</th>
                    <th class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75); height: 25px; font-weight: 400;">DNI</th>
                    <th class="align-middle text-center" style="border: 1px solid rgb(75, 75, 75); height: 25px;">
                        {{ $caja->_autorizadoPor->dni_ce }}</th>
                </tr>
                <tr>
                    <th class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75); height: 25px; font-weight: 400;">MONTO</th>
                    <th class="align-middle text-center" style="border: 1px solid rgb(75, 75, 75); height: 25px;">
                        S/. {{ number_format($caja->monto, 2) }}</th>
                    <th class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75); height: 25px; font-weight: 400;">TIPO</th>
                    <th colspan="3" class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75); height: 25px;">
                        {{ $caja->_operacion->categoria_descripcion }} - {{ $caja->_tipo->categoria_descripcion }} -
                        {{ $caja->_subtipo->categoria_descripcion }} </th>
                </tr>
                <tr>
                    <th class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75);  height: 100px; font-weight: 400;">
                        DESCRIPCIÓN</th>
                    <th colspan="5" class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75); height: 100px;">
                        {{ $caja->descripcion }}</th>
                </tr>
                <tr>
                    <th colspan="3" class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75); height: 25px; font-weight: 400;">
                        ENTREGADO A:</th>
                    <th colspan="3" class="align-middle text-center"
                        style="border: 1px solid rgb(75, 75, 75); height: 25px; font-weight: 400;">
                        APROBADO POR:</th>
                </tr>
                <tr>
                    <th colspan="3" class="align-middle text-center"
                        style="border-top: 1px solid rgb(75, 75, 75); border: 1px solid rgb(75, 75, 75); height: 25px;">
                        {{ $caja->realizado_a_favor }}</th>
                    <th colspan="3" class="align-middle text-center"
                        style="border-top: 1px solid rgb(75, 75, 75); border: 1px solid rgb(75, 75, 75); height: 25px;">
                        {{ $caja->_autorizadoPor->nombres }} {{ $caja->_autorizadoPor->apellidos }}</th>
                </tr>
                <tr>
                    <th colspan="3" class="align-middle text-center"
                        style="border-bottom: 1px solid rgb(75, 75, 75); border-right: 1px solid rgb(75, 75, 75);border-left: 1px solid rgb(75, 75, 75); height: 120px;">

                    </th>
                    <th colspan="3" class="align-middle text-center"
                        style="border-bottom: 1px solid rgb(75, 75, 75); border-right: 1px solid rgb(75, 75, 75);border-left: 1px solid rgb(75, 75, 75); height: 120px;">

                    </th>
                </tr>
            </thead>
        </table>
    </div>
</body>

</html>
