@extends('layouts.admin')

{{-- @section('titulo', 'Nueva Categoria') --}}

@section('contenido')
    <!-- Page Heading -->
    <div class="bg-gradient-primary text-white text-center" style="height: 180px; border-radius: 21px 21px 21px 21px;">

        <div class="container">
            <div class="d-flex align-items-center justify-content-center">
                <div class="p-3">
                    <div class="row align-items-center justify-content-center">
                        <div class="sidebar-brand-text m-3">
                            <h4 class="font-weight-bold">NUEVA CATEGORIA</h4>
                        </div>
                        <div class="sidebar-brand-icon rotate-n-15">
                            <i class="fas fa-fw fa-database fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="card bg-light shadow mx-auto p-4 h-auto p-3"
        style="width: 50%; border-radius: 16px; margin-top: -4rem !important; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <form action="{{ url('parametros-globales') }}" method="POST">
            @csrf

            {{ Form::hidden('tipo', 'categoria') }}
            <div class="form-row m-2">
                <div class="form-group col-lg-12 mb-4">
                    <label for="categoria_padre">NOMBRE DE LA CATEGORÍA</label>
                    <input type="text" class="form-control @error('categoria_padre') is-invalid @enderror" name="categoria_padre"
                        id="categoria_padre" placeholder="Nombre de la categoría" value="{{ old('categoria_padre') }}">
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
            <div class="text-center m-4">
                <button class="btn btn-success" type="submit">REGISTRAR</button>
            </div>
        </form>
    </div>
@endsection



<script>
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
</script>
