<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Login &mdash; {{ $toko->nama_toko }}</title>

    
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('bootstrap4/css/bootstrap.min.css') }}">


    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('../assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('../assets/css/components.css') }}">
    <!-- PWA  -->
    <meta name="theme-color" content="#6777ef"/>
    <link rel="apple-touch-icon" href="{{ asset('asd.jpeg') }}">
    <link rel="manifest" href="{{ asset('/manifest.json') }}">
    <style>
        h1 {
            color: #000080;
        }

        body {
            font-family: 'Lt_Museum_Light';
        }
    </style>
</head>

<body>
    <div id="app">
        <section class="section">
            <div class="container mt-5">
                <div class="row">
                    <div
                        class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
                        <div class="login-brand mt-5">
                            <h1 width="100px" height="100px"
                                style="font-family: 'Neuton_Reguler' !important; text-transform: capitalize !important;">
                                {{ $toko->nama_toko }}
                            </h1>
                        </div>

                        <div class="card card-primary">
                            <div class="card-header">
                                <h4>Login</h4>
                            </div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('login') }}" class="" novalidate="">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input id="email" type="text" class="form-control" name="email"
                                            tabindex="1" autocomplete='off' required autofocus>
                                    </div>

                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label">Password</label>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password"
                                            tabindex="2" required>
                                    </div>

                                    <div class="form-group">

                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                                            Login
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="simple-footer">
                            Copyright &copy;
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('bootstrap4/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('jquery/ajax.popper.min.js') }}"></script>
    <script src="{{ asset('jquery/ajax.nicescroll.min.js') }}"></script>
    <script src="{{ asset('jquery/ajax.moment.min.js') }}"></script>
    <script src="{{ asset('../assets/js/stisla.js') }}"></script>

    <!-- Template JS File -->
    <script src="{{ asset('../assets/js/scripts.js') }}"></script>
    <script src="{{ asset('../assets/js/custom.js') }}"></script>

    @if (session()->has('success'))
        <script type="module">
          import { Eggy } from './eggyAlert/build/js/eggy.js';
          Eggy({
            title: 'Success'
            , message: '{{ session('success') }}'
            , position: 'top-right'
            , duration: 3000,
            

          });
        </script>
    @endif

    @if (session()->has('errors'))
        <script type="module">
          import { Eggy } from './eggyAlert/build/js/eggy.js';
          Eggy({
            title: 'Errors'
            , message: '{{ session('errors') }}'
            , position: 'top-right'
            , duration: 3000,
            type:  'error'

          });
        </script>
    @endif
    
    <script src="{{ asset('/sw.js') }}"></script>
    <script>
        if (!navigator.serviceWorker.controller) {
            navigator.serviceWorker.register("/sw.js").then(function (reg) {
                console.log("Service worker has been registered for scope: " + reg.scope);
            });
        }
    </script>
</body>

</html>
