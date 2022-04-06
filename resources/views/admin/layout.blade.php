<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
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
    <link href="{{ asset('admin/css/style.css') }}" rel="stylesheet">
</head>
<body>
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
