<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ __('site.site_name') }} | @yield('title')</title>
    <meta name="description" content="{{ __('site.site_description') }}" />
    <meta name="thumbnail" content="{{ asset('images/logo.jpg') }}" />

    <!-- <meta name="twitter:card" content="summary_large_image" /> -->
    <meta name="twitter:card" content="summary" />
    <meta property="og:url" content="{{ route('site.home') }}" />
    <meta property="og:title" content="{{ __('site.site_name') }}" />
    <meta property="og:description" content="{{ __('site.site_description') }}" />
    <meta property="og:image" content="{{ asset('images/logo.jpg') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="{{ app()->getLocale() }}" />

    <!-- Preload Files -->
    <link rel="preload" crossorigin as="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />
    <link rel="preload" crossorigin as="script" href="{{ asset('js/jquery.min.js') }}" />
    <link rel="preload" crossorigin as="script" href="{{ asset('js/fontawesome.js') }}" />
    <link rel="preload" crossorigin as="css" href="{{ asset('css/fontawesome.min.css') }}" />

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon" />

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}" />
    <!-- <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}" /> -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/app-extend.rtl.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>

<body>
    <button type="button" id="to-up" class="icon icon-secondary"><i class="fas fa-chevron-up"></i></button>
    <a type="button" id="live-chat" class="icon icon-secondary"><i class="fab fa-whatsapp"></i></a>

    <div class="modal" hidden>
        <div class="modal-body container">
            <div class="modal-header">
                <button type="button" class="modal-close btn btn-primary"><i class="fas fa-times"></i></button>
            </div>
            <div class="modal-content">
                <img src="" alt="" />
            </div>
            <div class="modal-search">
                <div class="search uppercase">{{ __('site.Search') }}</div>
                <form action="{{ route('site.search') }}">
                    <div class="field">
                        <input type="search" name="search" placeholder="{{ __('site.Keywords Search') }}..." />
                        <button class="btn btn-secondary" type="submit"><i class="fas fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="nav-top">
        <div class="container">
            <div class="social">
                <strong>{{ __('site.Join us') }}</strong>
                <a href="#" target="_blank" class="icon icon-primary"><i class="fab fa-instagram"></i></a>
                <a href="#" target="_blank" class="icon icon-dark"><i class="fab fa-linkedin-in"></i></a>
                <a href="#" target="_blank" class="icon icon-primary"><i class="fab fa-facebook-f"></i></a>
                <a href="#" target="_blank" class="icon icon-dark"><i class="fab fa-whatsapp"></i></a>
            </div>
            <div class="email">
                <a class="nav-link" href="mailto:info@developer-web.net">
                    <i class="far fa-envelope text-primary"></i><span>info@developer-web.net</span>
                </a>
            </div>
            <div class="locale">
                <a href="#" class="btn btn-primary">??????????????</a>
            </div>
        </div>
    </div>

    @include('site.include.header')

    <main class="{{ !request()->routeIs('site.home') ? 'page' : '' }}">
        @yield('content')
    </main>

    @include('site.include.footer')

    <!-- JS Files -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/lazysizes.min.js') }}"></script>
    <script src="{{ asset('js/fontawesome.js') }}"></script>
    <script src="{{ asset('js/multislider.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @include('sweetalert::alert')
</body>

</html>
