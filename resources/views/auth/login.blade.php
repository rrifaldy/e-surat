<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>E Surat - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('template/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('template/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: #f2f2f2;
        }

        .container {
            margin-top: 80px;
        }

        @media screen and (max-width: 768px) {
            .container {
                margin-top: 0px;
            }
        }

        .card {
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .bg-login-image {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100%;
            padding: 20px;
        }

        .bg-login-image img {
            max-width: 100%;
            height: auto;
            margin-top: 55px;
        }

        .btn-login {
            border-radius: 3px;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-5 bg-login-image">
                                <img src="{{ asset('images/Garut.png') }}" alt="Logo Garut">
                            </div>

                            <!-- Form Login -->
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Selamat Datang Kembali!</h1>
                                    </div>
                                    <form method="POST" action="{{ route('login') }}" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input type="email" name="email"
                                                class="form-control form-control-user"
                                                id="email"
                                                placeholder="Masukkan Alamat Email..."
                                                value="{{ old('email') }}"
                                                required autofocus>
                                            @error('email')
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <input type="password" name="password"
                                                class="form-control form-control-user"
                                                id="password"
                                                placeholder="Masukkan Kata Sandi"
                                                required>
                                            @error('password')
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" name="remember"
                                                    class="custom-control-input"
                                                    id="customCheck">
                                                <label class="custom-control-label"
                                                    for="customCheck">Ingat Saya</label>
                                            </div>
                                        </div>

                                        <button type="submit"
                                            class="btn btn-primary btn-user btn-block btn-login">
                                            Masuk
                                        </button>
                                    </form>

                                    <hr>

                                    <div class="text-center">
                                        @if (Route::has('password.request'))
                                        <a class="small" href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
                                        @endif
                                    </div>

                                    <div class="text-center">
                                        <a class="small" href="{{ route('register') }}">Buat Akun Baru!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('template/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('template/js/sb-admin-2.min.js') }}"></script>

</body>

</html>