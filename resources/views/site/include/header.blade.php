<header>
    <div class="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('site.home') }}"><img src="{{ asset('images/logo-full.png') }}" alt="{{ __('site.site_name') }}" /></a>
            <button class="navbar-toggle" type="button">
                <i class="fas fa-bars"></i>
            </button>
            <div class="navbar-nav collapse">
                <a class="nav-link active" href="{{ route('site.home') }}"><span>{{ __('site.Home') }}</span></a>
                <a class="nav-link" href="{{ route('site.page', 1) }}"><span>{{ __('site.About Us') }}</span></a>
                <a class="nav-link" href="{{ route('site.services') }}"><span>{{ __('site.Services') }}</span></a>
                <a class="nav-link" href="{{ route('site.products') }}"><span>{{ __('site.Products') }}</span></a>
                <a class="nav-link" href="{{ route('site.page', 2) }}"><span>{{ __('site.Why Us') }}</span></a>
                <a class="nav-link" href="{{ route('site.page', 3) }}"><span>{{ __('site.Career') }}</span></a>
                <a class="nav-link" href="{{ route('site.page', 4) }}"><span>{{ __('site.Contact Us') }}</span></a>
                <a class="nav-link bg-primary border-radius" href="#">{{ __('site.Support') }}</a>
                <button class="nav-link open-modal-search" type="button"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </div>
</header>
