<!doctype html>
<html lang="en">

<head>

        <meta charset="utf-8">
        <title>Login {{ env('APP_NAME') }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="{{ env('APP_NAME') }}" name="description">
        <meta content="{{ env('APP_AUTHOR') }}" name="author">
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('img/fav.png') }}">

        <!-- Bootstrap Css -->
        <link href="{{ asset('veltrix') }}/assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css">
        <!-- Icons Css -->
        <link href="{{ asset('veltrix') }}/assets/css/icons.min.css" rel="stylesheet" type="text/css">
        <!-- App Css-->
        <link href="{{ asset('veltrix') }}/assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css">

    </head>

<body>

    <div class="home-btn d-none d-sm-block">
        <a href="{{ route('login') }}" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card overflow-hidden">
                        <div class="bg-primary">
                            <div class="text-primary text-center p-4">
                                <h5 class="text-white font-size-20">Login</h5>
                                <p class="text-white-50">Login untuk masuk ke aplikasi {{ env('APP_NAME') }}</p>
                                <a href="{{ route('login') }}" class="logo logo-admin" style="background-color: #333;">
                                    <img src="{{ asset('img/fav.png') }}" style="width: 50px" alt="logo">
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <div class="p-3">
                                <form class="mt-4" action="{{ route('login') }}" method="POST">
                                    @include('components.flash_messages')
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label" for="username">Username</label>
                                        <input type="text" class="form-control" id="username" placeholder="username" name="username">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="password">Password</label>
                                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                                    </div>

                                    <div class="mb-3 row">
                                        <div class="col-sm-12">
                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Log In</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>

                    <div class="mt-5 text-center">
                        <p class="mb-0">© 2023 {{ env('APP_NAME') }}{{ env('APP_AUTHOR') }}</p>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script src="{{ asset('veltrix') }}/assets/libs/jquery/jquery.min.js"></>
    <script src="{{ asset('veltrix') }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('veltrix') }}/assets/libs/metismenu/metisMenu.min.js"></script>
    <script src="{{ asset('veltrix') }}/assets/libs/simplebar/simplebar.min.js"></script>
    <script src="{{ asset('veltrix') }}/assets/libs/node-waves/waves.min.js"></script>

    <script src="assets/js/app.js"></script>

</body>

</html>
