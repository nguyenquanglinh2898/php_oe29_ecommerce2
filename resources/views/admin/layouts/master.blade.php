<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | @yield('title')</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="icon" href="{{ config('setting.icon') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/common/css/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/AdminLTE/dist/css/skins/skin-red.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layout.scss') }}">
    @yield('embed-css')
    @yield('custom-css')

    <script src="{{ asset('bower_components/html5shiv.min/index.js') }}"></script>
    <script src="{{ asset('bower_components/respond.min/index.js') }}"></script>
</head>

<body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper">
        @include('admin.layouts.header')
        @include('admin.layouts.sidebar')

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    @yield('title')
                </h1>
                @yield('breadcrumb')
            </section>
            <section class="content container-fluid">
                @yield('content')
            </section>
        </div>

        @include('admin.layouts.footer')
    </div>

    @include('sweetalert::alert')
    <script src="{{ asset('bower_components/AdminLTE/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bower_components/common/js/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('bower_components/AdminLTE/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('js/admin/layouts/master.js') }}"></script>

    @yield('embed-js')
    @yield('custom-js')
</body>
</html>
