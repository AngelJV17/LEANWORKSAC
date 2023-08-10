@extends('layouts.admin')

{{-- @section('titulo', 'Usuarios') --}}

@section('contenido')
    <div class="container-xl px-4 mt-4">
        <!-- Account page navigation-->
        <div class="p-3">
            <div class="text-right">
                <a href="{{ route('usuarios.index') }}" class="btn btn-dark shadow text-uppercase font-weight-bold"
                    role="button" data-bs-toggle="button">
                    <i class="fas fa-fw fa-angle-left"></i>
                    Atrás
                </a>
            </div>
        </div>
        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-xl-4">
                <!-- Profile picture card-->
                <div class="card mb-4 mb-xl-0 bg-gradient-info shadow-lg border-0" style="border-radius: 16px;">
                    <div class="h4 text-white font-weight-bold text-center text-uppercase mt-2">Perfil</div>
                    <hr class="bg-white">
                    <div class="card-body text-center">
                        <!-- Profile picture image-->
                        @if ($usuario->sexo == 4)
                            <img class="img-account-profile rounded-circle mb-3 shadow"
                                src="{{ asset('admin_assets/img/profiles/perfil_m_01.png') }}" alt=""
                                style="border: 2px solid white;">
                        @else
                            <img class="img-account-profile rounded-circle mb-3 shadow"
                                src="{{ asset('admin_assets/img/profiles/perfil_f_03.png') }}" alt=""
                                style="border: 2px solid white;">
                        @endif
                        <!-- Profile picture upload button-->
                        <br>
                        <p class="badge bg-dark text-uppercase p-2 text-white">
                            {{ $usuario->nombres . ' ' . $usuario->apellidos }}</p>
                        <br>
                        <span
                            class="badge bg-light text-uppercase text-muted shadow-sm">{{ $usuario->roles()->first()->name }}
                        </span>
                        <br>
                        @if ($usuario->estado)
                            <span class="badge bg-success text-uppercase text-white shadow-sm">HABILITADO
                            </span>
                        @else
                            <span class="badge bg-danger text-uppercase text-white shadow-sm">DESHABILITADO
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-8">
                <!-- Account details card-->
                <div class="card mb-4 shadow-lg border-0" style="border-radius: 16px;">
                    {{-- <div class="card-header">Account Details</div> --}}
                    <div class="card-body">
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (first name)-->
                            <div class="col-md-6">
                                <label class="mb-1 text-uppercase text-muted text-uppercase text-muted">Nombres</label>
                                <div class="p-2 shadow-sm"
                                    style="border-radius: 5px; border: solid 1px rgb(167, 167, 167);">
                                    {{ $usuario->nombres }}</div>
                            </div>
                            <!-- Form Group (last name)-->
                            <div class="col-md-6">
                                <label class="mb-1 text-uppercase text-muted">Apellidos</label>
                                <div class="p-2 shadow-sm"
                                    style="border-radius: 5px; border: solid 1px rgb(167, 167, 167);">
                                    {{ $usuario->apellidos }}</div>
                            </div>
                        </div>
                        <!-- Form Row        -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <div class="col-md-6">
                                <label class="mb-1 text-uppercase text-muted">Empresa</label>
                                <div class="p-2 shadow-sm"
                                    style="border-radius: 5px; border: solid 1px rgb(167, 167, 167);">LEAN WORK SAC</div>
                            </div>
                            <!-- Form Group (location)-->
                            <div class="col-md-6">
                                <label class="mb-1 text-uppercase text-muted">Dirección</label>
                                <div class="p-2 shadow-sm"
                                    style="border-radius: 5px; border: solid 1px rgb(167, 167, 167);">
                                    {{ $usuario->direccion }}
                                </div>
                            </div>
                        </div>
                        <!-- Form Group (email address)-->
                        <div class="mb-3">
                            <label class="mb-1 text-uppercase text-muted">Email</label>
                            <div class="p-2 shadow-sm" style="border-radius: 5px; border: solid 1px rgb(167, 167, 167);">
                                {{ $usuario->email }}</div>
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (phone number)-->
                            <div class="col-md-6">
                                <label class="mb-1 text-uppercase text-muted">Celular</label>
                                <div class="p-2 shadow-sm"
                                    style="border-radius: 5px; border: solid 1px rgb(167, 167, 167);">
                                    {{ $usuario->celular }}</div>
                            </div>
                            <!-- Form Group (birthday)-->
                            <div class="col-md-6">
                                <label class="mb-1 text-uppercase text-muted">Cumpleaños</label>
                                <div class="p-2 shadow-sm"
                                    style="border-radius: 5px; border: solid 1px rgb(167, 167, 167);">
                                    {{ date('d-m-Y', strtotime($usuario->fecha_nacimiento)) }}</div>
                            </div>
                        </div>
                        <!-- Save changes button-->
                        <a type="button" class="btn btn-outline-info btn-block font-weight-bold shadow-sm mt-4"
                            href="{{ route('usuarios.edit', $usuario->id) }}">EDITAR
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>{{--  --}}
@endsection
