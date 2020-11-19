<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title> @yield('title') - {{ config('config.name') }} </title>
        <link rel="icon" href="{{ config('setting.icon') }}" type="image/png">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('bower_components/common/css/normalize.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/common/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/common/css/bootstrap-theme.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/common/css/animate.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/common/css/fontawesome/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/common/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/common/css/owl.theme.default.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bower_components/common/css/sweetalert2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customer/style.css') }}">
        <link rel="stylesheet" href="{{ asset('css/customer/pages/minicart.css') }}">
        @yield('css')
    </head>
    <body>
        @include('layouts.header')
        <div class="container">
            <div class="site-content">
                @yield('content')
            </div>
        </div>
        @if (Request::route()->getName() != 'cart.show_detail')
            <div class="cart">
                @include('layouts.minicart')
            </div>
        @endif
        @include('layouts.footer')
        @include('sweetalert::alert')
        <script src="{{ asset('bower_components/common/js/jquery-3.3.1.js') }}"></script>
        <script src="{{ asset('bower_components/common/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('bower_components/common/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('bower_components/common/js/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('js/customer/custom.js') }}"></script>
        <script type="text/javascript" src="{{ asset('js/customer/pages/search.js') }}"></script>
        @if (Request::route()->getName() != 'cart.show_detail')
            <script src="{{ asset('js/customer/pages/minicart.js') }}"></script>
        @endif
        @yield('js')
    </body>
</html>
