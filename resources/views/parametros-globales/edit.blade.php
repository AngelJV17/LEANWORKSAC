@extends('layouts.admin')

{{-- @section('titulo', 'Nueva Categoria') --}}

@section('contenido')
    {{-- {{dd($parametroGlobal)}} --}}

    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        {{-- <div class="container">
            <div class="d-flex align-items-center justify-content-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">EDITAR CATEGORIA</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-database fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="container">
            <div class="d-flex align-items-center justify-content-between text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">EDITAR CATEGORIA</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-users-gear fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center align-items-center">
                        <a href="{{ route('parametros-globales.index') }}"
                            class="btn btn-light shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button">
                            <i class="fas fa-fw fa-angle-left"></i>
                            Atrás
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card bg-light shadow mx-auto p-4 h-auto p-3"
        style="width: 80%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <form action="{{ url('parametros-globales.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- {{ Form::hidden('tipo', 'categoria') }} --}}
            <div class="form-row m-2">
                <div class="form-group col-lg-6 mb-4">
                    <label for="categoria_padre">CATEGORÍA PADRE</label>
                    <input type="text" class="form-control @error('categoria_padre') is-invalid @enderror"
                        name="categoria_padre" id="categoria_padre" placeholder="Nombre de la categoría padre" 
                        value="{{$parametroGlobal->categoria_padre}}">
                    @error('categoria_padre')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 mb-4">
                    <label for="categoria_hijo">CATEGORÍA HIJO</label>
                    <input type="text" class="form-control @error('categoria_hijo') is-invalid @enderror"
                        name="categoria_hijo" id="categoria_hijo" placeholder="Nombre de la categoría hijo"
                        value="{{ $parametroGlobal->categoria_hijo }}">
                    @error('categoria_hijo')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-lg-6 mb-4">
                    <label for="subcategoria_padre">SUBCATEGORÍA PADRE</label>
                    <input type="text" class="form-control @error('subcategoria_padre') is-invalid @enderror"
                        name="subcategoria_padre" id="subcategoria_padre" placeholder="Nombre de la subcategoría padre"
                        value="{{ $parametroGlobal->subcategoria_padre }}">
                    @error('subcategoria_padre')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 mb-4">
                    <label for="subcategoria_hijo">SUBCATEGORÍA HIJO</label>
                    <input type="text" class="form-control @error('subcategoria_hijo') is-invalid @enderror"
                        name="subcategoria_hijo" id="subcategoria_hijo" placeholder="Nombre de la subcategoría hijo"
                        value="{{ $parametroGlobal->subcategoria_hijo }}">
                    @error('modulo')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-lg-4 mb-4">
                    <label for="modulo">MÓDULO DE LA CATEGORÍA</label>
                    <input type="text" class="form-control @error('modulo') is-invalid @enderror" name="modulo"
                        id="modulo" placeholder="Módulo de la categoría" value="{{ $parametroGlobal->modulo }}">
                    @error('modulo')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="text-center m-4">
                <button class="btn btn-info" type="submit">ACTUALIZAR</button>
            </div>
        </form>
    </div>
@endsection
