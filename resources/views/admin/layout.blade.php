<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir={{ app()->isLocale('ar') ? 'rtl' : 'ltr' }} class="{{ app()->isLocale('ar') ? 'rtl' : '' }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    {{--<link href="{{ asset('admin/vendor/chartist/css/chartist.min.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet">
    {{--<link href="{{ asset('admin/vendor/owl-carousel/owl.carousel.css') }}" rel="stylesheet">--}}
    @yield('link')
    @if (app()->isLocale('ar'))
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    @endif
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
    @yield('style')
    <style>
        [dir=rtl] body {
            font-family: 'Cairo', sans-serif;
            font-size: 16px;
        }
        @media only screen and (max-width: 575.98px) {
            [data-sidebar-style="overlay"] .header {
                padding-left: 4rem;
            }
            [direction="rtl"][data-sidebar-style="overlay"] .header {
                padding-left: unset;
                padding-right: 4rem;
            }
            [direction="rtl"][data-sidebar-style="overlay"] .header .header-content {
                padding-right: 3.5rem;
            }
        }
        [data-theme-version="dark"] .dropdown-menu,
        [data-theme-version="dark"] .header-right .dropdown-menu {
            box-shadow: 0px 0px 0px 1px rgb(44, 37, 74);
        }
        table thead th {
            white-space: nowrap;
        }
        .form-group {
            margin-bottom: 2rem !important;
        }
        [data-sidebar-style="full"][data-layout="vertical"] .deznav .metismenu > li > a {
            padding-top: 10px;
            padding-bottom: 10px;
            font-size: 14px;
        }
        .main-profile img {
            height: 80px;
            margin-bottom: 10px;
        }
        .main-profile i {
            top: 0;
        }
        .deznav .metismenu > li a > i {
            font-size: 1.3rem;
        }
        .header-left .nav-link {
            color: #fff;
            background: #2C254A;
            position: relative;
            border-radius: 15px;
            font-size: 14px;
            margin-left: 5px;
            margin-right: 5px;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }
        .header-left .nav-link .badge {
            position: absolute;
            right: -4px;
            top: -4px;
            font-size: 12px;
            height: 18px;
            width: 18px;
            line-height: 18px;
            padding: 0
        }
        [dir=rtl] .header-left .nav-link .badge {
            left: -4px;
            right: unset;
        }
        @media (min-width: 576px) {
            .header-left .nav-link {
                padding-left: 1rem;
                padding-right: 1rem;
            }
            .header-left .nav-link i {
                font-size: 20px;
            }
        }
        .locale {
            position: relative;
            margin-bottom: 15px;
        }
        .locale [lang] {
            direction: ltr;
        }
        .locale [lang=ar] {
            direction: rtl;
        }
        .locale small {
            display: inline-block;
            position: absolute;
            top: 50%;
            left: 100%;
            transform: translate(-50%, -50%);
            background: #eee;
            width: 25px;
            height: 25px;
            line-height: 25px;
            text-align: center;
            border-radius: 50%;
        }
    </style>
</head>
<body direction={{ app()->isLocale('ar') ? 'rtl' : 'ltr' }}>
    <!-- Preloader -->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <!-- Main wrapper -->
    <div id="main-wrapper">
        <!-- Header -->
        @include('admin.include.header')

        <!-- Sidebar -->
        @include('admin.include.sidebar')


        <!-- Content body -->
        <div class="content-body">
			<div class="container-fluid">
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        @include('admin.include.footer')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('admin/vendor/global/global.min.js') }}"></script>
	<script src="{{ asset('admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    @yield('script')
	{{--
        <script src="{{ asset('js/app.js') }}" defer></script>
        <!-- Chart piety plugin files -->
        <script src="{{ asset('admin/vendor/peity/jquery.peity.min.js') }}"></script>

        <!-- Apex Chart -->
        <script src="{{ asset('admin/vendor/apexchart/apexchart.js') }}"></script>
        <!-- Dashboard 1 -->
        <script src="{{ asset('admin/js/dashboard/dashboard-1.js') }}"></script>

        <script src="{{ asset('admin/vendor/owl-carousel/owl.carousel.js') }}"></script>
    --}}
    <script src="{{ asset('admin/js/custom.min.js') }}"></script>
	<script src="{{ asset('admin/js/deznav-init.js') }}"></script>
    @include('sweetalert::alert')
    <script>
        function showImage(target, $event) {
            let showImg = document.getElementById(target);
            var reader = new FileReader();
            reader.readAsDataURL(event.target.files[0]);
            reader.onloadend = function(event){
                showImg.src = event.target.result;
                showImg.style.display = "block";
            }
        }
    </script>
</body>
</html>
