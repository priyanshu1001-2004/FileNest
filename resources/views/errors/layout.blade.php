{{-- resources/views/errors/layout.blade.php --}}
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'DigiDrop'))</title>
    
    <!-- BOOTSTRAP CSS -->
    <link id="style" href="{{ asset('assets/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
    
    <!-- STYLE CSS -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/dark-style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/transparent-style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/skin-modes.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" />
    
    <style>
        body {
            background: #0d0f18;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-page {
            padding: 40px 20px;
        }
        .error-template {
            max-width: 600px;
            margin: 0 auto;
        }
        .error-template .display-1 {
            font-size: 120px;
            line-height: 1;
            font-weight: 700;
        }
        .error-template .fs-1 {
            font-size: 80px;
        }
        .error-template .card {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
        }
        .error-template .card .text-muted {
            color: rgba(255,255,255,0.6) !important;
        }
        .error-template .btn-outline-primary {
            color: #6c5ffc;
            border-color: #6c5ffc;
        }
        .error-template .btn-outline-primary:hover {
            background: #6c5ffc;
            color: #fff;
        }
        .error-template .btn-outline-danger {
            color: #fc5a5a;
            border-color: #fc5a5a;
        }
        .error-template .btn-outline-danger:hover {
            background: #fc5a5a;
            color: #fff;
        }
        .error-template .bg-opacity-10 {
            opacity: 0.1;
        }
        @media (max-width: 768px) {
            .error-template .display-1 {
                font-size: 80px;
            }
            .error-template .fs-1 {
                font-size: 60px;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body class="login-img">
    <div class="page">
        <div class="page-content error-page">
            <div class="container text-center">
                <div class="error-template">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- JQUERY JS -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    
    @stack('scripts')
</body>
</html>