<!-- resources/views/main-layout.blade.php -->

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    {{-- <meta name="description" content="">
    <meta name="author" content=""> --}}
    <title>{{ config('app.name', 'LEAN WORK SAC') }}{{ isset($title) ? '| ' . $title : '' }}</title>
    <link rel="shortcut icon" href="{{ asset('admin_assets/img/logo_icon.png') }}">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <!-- Custom styles for this template-->
    <link rel="stylesheet" href="{{ asset('admin_assets/css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/jquery-ui-1.13.2/jquery-ui.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="{{ asset('admin_assets/vendor/datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin_assets/vendor/datatables/responsive.bootstrap4.min.css') }}">

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
</head>

<body class="bg-gradient-light">
    <div class="container">

        <!-- Outer Row -->
        <div class="d-flex align-self-center text-center justify-content-center" style="margin-top: 10rem;">
            <div class="card shadow-lg" style="border-radius: 16px; width: 50%;">
                <div class="card bg-gradient-primary p-0 position-relative mt-n5 mx-3 z-index-2 border-0 shadow-lg border-bottom-warning"
                    style="border-radius: 16px;">
                    <div class="py-3 pe-1">
                        <img src="{{ asset('admin_assets/img/logo_icon.png') }}" alt="" width="70">
                        <h4 class="text-white font-weight-bold text-center mt-2 mb-0">Login</h4>
                    </div>
                </div>
                <div class="card-body mt-4">
                    {{-- <h5 class="card-title">Card title</h5> --}}
                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="form-group text-left">
                            <label for="exampleInputEmail1">Email:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa-solid fa-at"></i></span>
                                </div>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email" aria-label="Email" aria-describedby="basic-addon1"
                                    name="email" required autocomplete="email" autofocus value="{{ old('email') }}">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group text-left">
                            <label for="exampleInputEmail1">Contraseña:</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1"><i
                                            class="fa-solid fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Contraseña" aria-label="Contraseña" aria-describedby="basic-addon1"
                                    name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="mt-5">
                            <button type="submit"
                                class="btn btn-primary btn-user btn-block mt-4 text-uppercase font-weight-bold">
                                Iniciar Sesión
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</body>

@include('sweetalert::alert')

@include('layouts.partials.scripts')

</html>
