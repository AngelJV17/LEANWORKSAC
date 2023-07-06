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
                            <h4 class="font-weight-bold">NUEVA CATEGORÍA/SUBCATEGORÍA</h4>
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
                    <input type="text" class="form-control @error('categoria_descripcion') is-invalid @enderror"
                        name="categoria_descripcion" id="categoria_descripcion" placeholder="Nombre de la categoría"
                        value="{{ $categoriaGlobal->categoria_descripcion }}">
                    @error('categoria_descripcion')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group col-lg-6 mb-4">
                    <label for="modulo">MÓDULO DE LA CATEGORÍA</label>
                    <input type="text" class="form-control @error('modulo') is-invalid @enderror" name="modulo"
                        id="modulo" placeholder="Módulo de la categoría" value="{{ $categoriaGlobal->modulo }}">
                    @error('modulo')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="form-row m-2 text-center">
                <div class="form-group col-lg-12 mb-4">
                    <label for="is_cat_padre">¿Es una categoría padre?</label><br>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="is_cat_padre" name="is_cat_padre" class="custom-control-input"
                            value="SI" onchange="mostrar(this.value);" @checked($categoriaGlobal->is_categoria_padre)>
                        <label class="custom-control-label" for="is_cat_padre">SI</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" id="not_cat_padre" name="is_cat_padre" class="custom-control-input"
                            value="NO" onchange="mostrar(this.value);" @checked(!$categoriaGlobal->is_categoria_padre)>
                        <label class="custom-control-label" for="not_cat_padre">NO</label>
                    </div>
                </div>
            </div>

            <div class="form-row m-2" {{-- id="div_padre" --}}>
                <div class="form-group col-lg-12 mb-4">
                    <label for="categoria_padre">CATEGORIA PADRE</label>
                    <select id="categoria_padre" name="categoria_padre" class="form-control">
                        <option selected disabled>Seleccione</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{ $categoria->id }}" @selected($categoriaGlobal->parent_id == $categoria->id)>
                                @if ($categoria->categoria_padre != null)
                                    ({{ $categoria->categoria_padre }})
                                    -
                                @endif
                                {{ $categoria->categoria_descripcion }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_padre')
                        <div class="alert alert-danger m-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="text-center m-4">
                <button class="btn btn-info" type="submit">ACTUALIZAR</button>
            </div>
        </form>
    </div>


    {{-- <script src="{{ asset('js/show-div.js') }}"></script> --}}
@endsection

{{-- <script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script> --}}
