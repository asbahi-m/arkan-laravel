<footer>
    <div class="container">
        <div class="items">
            <div class="item">
                <a href="{{ route('site.home') }}" class="brand d-block"><img src="{{ asset('images/logo-full.png') }}" alt="{{ __('site.site_name') }}" /></a>
                <div class="social">
                    <a href="#" target="_blank" class="icon icon-primary"><i class="fab fa-instagram"></i></a>
                    <a href="#" target="_blank" class="icon icon-primary"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" target="_blank" class="icon icon-primary"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>

            <div class="item">
                <h2 class="underline">{{ __('site.Company') }}</h2>
                <div class="links">
                    <a class="nav-link" href="{{ route('site.home') }}">{{ __('site.Home') }}</a>
                    <a class="nav-link" href="{{ route('site.page', 1) }}">{{ __('site.About Us') }}</a>
                    <a class="nav-link" href="{{ route('site.services') }}">{{ __('site.Services') }}</a>
                    <a class="nav-link" href="{{ route('site.clients') }}">{{ __('site.Our Clients') }}</a>
                    <a class="nav-link" href="{{ route('site.page', 2) }}">{{ __('site.Why Us') }}</a>
                    <a class="nav-link" href="{{ route('site.page', 4) }}">{{ __('site.Contact Us') }}</a>
                </div>
            </div>

            <div class="item">
                <h2 class="underline">{{ __('site.Info Contact') }}</h2>
                <div class="contact-info">
                    <div>
                        <span><i class="fas fa-map-marker-alt"></i></span>
                        <a>Saudi Arabia - Khobar</a>
                    </div>
                    <div>
                        <span><i class="far fa-envelope"></i></span>
                        <a href="mailto:info@arkanpro.com">info@arkanpro.com</a>
                    </div>
                    <div>
                        <span><i class="fas fa-phone-volume"></i></span>
                        <a>+966 555 123456</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="sub-footer">
        <div class="container">
            <a class="btn btn-secondary support" type="button" href="#"><i class="fas fa-question"></i></a>
            <span>{{ __('site.Copyright') }} © 2022</span>
            <span class="logo"><img src="{{ asset('images/logo-white.png') }}" alt="{{ __('site.site_name') }}" /> {{ __('site.site_name') }}</span>
            <span>{{ __('site.All Rights Reserved') }}.</span>
        </div>
    </div>
</footer>
