@extends('layouts.admin')

{{-- @section('titulo', 'Control Caja') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary h-auto p-5" style="border-radius: 21px 21px 21px 21px;">
        <div class="container">
            <div class="card w-50 bg-light shadow-lg bg-white mx-auto border-bottom-warning"
                style="border-radius: 21px 21px 21px 21px;">
                <div class="card-body">
                    {{-- <h5 class="card-title">APERTURAR CAJA</h5> --}}
                    <div class="d-flex justify-content-end align-items-end">
                        {{-- <span class="rounded-circle bg-gradient-success" style="width: 25px; height: 25px; "></span> --}}
                        <span class="rounded-circle bg-gradient-danger shadow-sm"
                            style="width: 25px; height: 25px; border: 2px solid white;"></span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-fw fa-cash-register fa-xl mr-2 text-muted"></i>
                        <h5 class="card-title text-muted font-weight-bold">APERTURAR CAJA</h5>
                    </div>
                    <hr>
                    <p class="card-text  mb-4 text-muted">Necesitas aperturar la caja para poder hacer registros de
                        <strong>INGRESO</strong>
                        y <strong>EGRESO</strong>.
                    </p>
                    <div class="d-flex justify-content-end align-items-end">
                        <a href="#" type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                            data-target="#formCaja">APERTURAR</a>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.modals.form-control-caja')
    </div>
@endsection
