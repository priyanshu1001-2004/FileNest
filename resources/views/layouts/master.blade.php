<!doctype html>
<html lang="en" dir="ltr">

<head>

    <!-- META DATA -->
    <meta charset="UTF-8">
    <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sash – Bootstrap 5 Admin & Dashboard Template">
    <meta name="author" content="Spruko Technologies Private Limited">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- FAVICON -->
    <!-- <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/brand/favicon.ico') }}" /> -->

    <!-- TITLE -->
    <title>@yield('title', 'Dashboard')</title>

    @include('layouts.css')
</head>

<body class="app sidebar-mini ltr light-mode ">

    <!-- GLOBAL LOADER -->
    <div id="global-loader">
        <img src="{{ asset('assets/images/loader.svg') }}" class="loader-img" alt="Loader">
    </div>

    <!-- PAGE -->
    <div class="page">
        <div class="page-main">

            @include('layouts.header')

            @include('layouts.sidebar')

            <!-- APP CONTENT -->
            <div class="main-content app-content mt-0">
                <div class="side-app">

                    <div class="main-container container-fluid">
                        @yield('content')
                    </div>

                </div>
            </div>

        </div>

        @include('layouts.footer')

    </div>

    <!-- BACK TO TOP -->
    <a href="#top" id="back-to-top">
        <i class="fa fa-angle-up"></i>
    </a>
    
    @include('components.cropper')
    @include('layouts.js')

    @stack('scripts')

</body>

</html>