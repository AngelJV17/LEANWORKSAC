@extends('layouts.admin')

{{-- @section('titulo', 'Nueva Categoria') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-between text-white text-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">VER CATEGORÍA/SUBCATEGORÍA</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-folder-tree fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center align-items-center">
                        <a href="{{ route('categorias-globales.index') }}"
                            class="btn btn-light shadow-lg text-uppercase font-weight-bold" role="button"
                            data-bs-toggle="button">
                            <i class="fas fa-fw fa-angle-left"></i>
                            ATRÁS
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card bg-light shadow mx-auto p-4 h-auto p-3"
        style="width: 70%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <form action="{{ route('categorias-globales.update', $categoriaGlobal) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row m-2">
                <div class="form-group col-lg-6 mb-4">
                    <label for="categoria_descripcion">NOMBRE DE LA CATEGORÍA</label>
                    <h5 class="border-2">{{ $categoriaGlobal->categoria_descripcion }}</h5>
                </div>
                <div class="form-group col-lg-6 mb-4">
                    <label for="modulo">MÓDULO DE LA CATEGORÍA</label>
                    <h5 class="border-2"> {{ $categoriaGlobal->modulo }} </h5>
                </div>
            </div>
            <div class="form-row m-2 text-center">
                <div class="form-group col-lg-12 mb-4">
                    <label for="is_cat_padre">¿Es una categoría padre?</label><br>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="is_cat_padre" name="is_cat_padre" class="custom-control-input" disabled
                            value="SI" onchange="mostrar(this.value);" @checked($categoriaGlobal->is_categoria_padre)>
                        <label class="custom-control-label" for="is_cat_padre">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="not_cat_padre" name="is_cat_padre" class="custom-control-input" disabled
                            value="NO" onchange="mostrar(this.value);" @checked(!$categoriaGlobal->is_categoria_padre)>
                        <label class="custom-control-label" for="not_cat_padre">NO</label>
                    </div>
                </div>
            </div>

            @if ($categoriaGlobal->parent_id != 0)
                <div class="form-row m-2">
                    <div class="form-group col-lg-12 mb-4">
                        <label for="categoria_padre">CATEGORIA PADRE</label>
                        <h5 class="border-2"> {{ $categoriaGlobal->categoria_padre->categoria_descripcion }} </h5>
                    </div>
                </div>
            @endif

            <div class="text-center m-4">
                <a type="button" class="btn btn-warning text-white font-weight-bold m-2" title="EDITAR"
                    href="{{ route('categorias-globales.edit', $categoriaGlobal->id) }}">
                    <i class="fas fa-fw fa-pen fa-sm"></i>
                    EDITAR
                </a>
            </div>
        </form>
    </div>
@endsection
