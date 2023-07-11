@extends('layouts.admin')

{{-- @section('titulo', 'Roles') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary h-auto" style="border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">ROLES</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-users-gear fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center">
                        <a href="{{ route('roles.create') }}"
                            class="btn btn-outline-warning shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button">
                            Nuevo Rol
                            <i class="fas fa-fw fa-users-gear"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">

                @foreach ($roles as $rol)
                    {{-- {{ dd($rol->nombre) }} --}}
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card bg-light shadow-lg p-3 mb-5 bg-white mx-auto border-bottom-warning w-auto"
                            style="border-radius: 21px 21px 21px 21px;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted" style="vertical-align: inherit;">Total
                                        {{-- @if (array_column(json_decode($usuarios), 'rol_id') != null)
                                            {{ array_count_values(array_column(json_decode($usuarios), 'rol_id'))[$rol->id] }}
                                        @endif --}}
                                        @if (array_key_exists($rol->id, json_decode($usuarios)))
                                            <strong>{{ array_count_values(array_column(json_decode($usuarios), 'rol_id'))[$rol->id] }}</strong>
                                        @else
                                            <strong>0</strong>
                                        @endif
                                        usuarios
                                    </span>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between align-items-end">
                                    <div class="role-heading">
                                        <h5 class="mb-1 text-muted mb-2">{{ $rol->nombre }}</h5>
                                        <a href="{{ route('roles.edit', $rol) }}" type="button"
                                            class="class btn btn-outline-info btn-sm text-uppercase">
                                            Editar Rol <i class="fa-solid fa-pen fa-sm m-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end align-items-end">
                                <form action="{{ route('roles.delete', $rol->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm rounded-circle" title="ELIMINAR">
                                        {{-- <i class="fas fa-fw fa-trash fa-sm"></i> --}}
                                        <i class="fas fa-fw fa-trash-can  fa-sm"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
