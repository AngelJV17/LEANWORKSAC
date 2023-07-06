@extends('layouts.admin')

{{-- @section('titulo', 'Nueva Subcategoria') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;"
        id="categorias">

        {{-- <div class="container">
            <div class="d-flex align-items-center justify-content-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">NUEVA SUBCATEGORÍA</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-folder-tree fa-lg"></i>
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
                            <h4 class="font-weight-bold">NUEVO SUBCATEGORÍA</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-folder-tree fa-lg"></i>
                        </div>
                    </div>
                </div>
                <div class="p-3">
                    <div class="text-center align-items-center">
                        <a href="{{ route('parametros-globales.index') }}"
                            class="btn btn-success shadow-lg text-uppercase font-weight-bold" role="button"
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
        style="width: 50%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <form class="{{ url('parametros-globales.subcategoria') }}" method="post">
            @csrf

            {{ Form::hidden('tipo', 'subcategoria') }}
            <div class="form-row m-2">
                <div class="form-group col-lg-12 mb-4">
                    <label for="categoria_hijo">NOMBRE DE LA SUBCATEGORÍA</label>
                    <input type="text" class="form-control @error('categoria_hijo') is-invalid @enderror"
                        id="categoria_hijo" name="categoria_hijo" placeholder="Nombre de la subcategoría">
                    @error('categoria_hijo')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-lg-12 mb-4">
                    <label for="categoria_padre">CATEGORÍA PADRE</label>
                    <select id="categoria_padre" class="form-control @error('categoria_padre') is-invalid @enderror"
                        name="categoria_padre">
                        <option>Seleccione</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->categoria_padre }} ">{{ $categoria->categoria_padre }}</option>
                        @endforeach
                    </select>
                    @error('categoria_padre')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-lg-12 mb-4">
                    <label for="modulo">MÓDULO DE LA CATEGORÍA</label>
                    <input type="text" class="form-control @error('modulo') is-invalid @enderror" name="modulo"
                        id="modulo" placeholder="Módulo de la categoría" value="{{ old('modulo') }}">
                    @error('modulo')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2">
                <div class="form-group col-lg-12 mb-4">
                    <div class="row">
                        <legend class="col-form-label col-12 pt-0">¿La subcategoría contiene niveles?</legend>
                        <div class="col-12">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline1" name="customRadioInline1"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="customRadioInline1">SI</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadioInline2" name="customRadioInline1"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="customRadioInline2">NO</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- <div class="form-row m-2">
                <div class="form-group col-lg-12 mb-4">
                    <label for="validationCustom02">DESCRIPCIÓN</label>
                    <input type="text" class="form-control" id="validationCustom02" placeholder="Descripción de la subcategoría" required>
                    <div class="valid-feedback">
                    </div>
                </div>
            </div> --}}
            {{-- <div class="form-row m-2">
                <div class="form-group col-lg-12 mb-4">
                    <label for="validationCustom02">MÓDULO DE LA CATEGORÍA</label>
                    <input type="text" class="form-control" id="validationCustom02" placeholder="Módulo de la categoría" required>
                    <div class="valid-feedback">
                    </div>
                </div>
            </div> --}}
            <div class="text-center m-4">
                <button class="btn btn-success" type="submit">REGISTRAR</button>
            </div>
        </form>
    </div>
@endsection

{{-- <script src="{{ asset('admin_assets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/jquery-ui-1.13.2/jquery-ui.js') }}"></script> --}}

<script src="{{ asset('js/categorias.js') }}"></script>
