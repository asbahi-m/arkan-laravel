<div class="deznav">
    <div class="deznav-scroll">
        <!-- User Profile -->
        <div class="main-profile">
            <img src="{{ auth()->user()->profile_photo_path ? asset(Storage::url(auth()->user()->profile_photo_path)) : asset('admin/images/user.png') }}"
                    alt="" style="width: auto">
            <a href="{{ route('profile') }}"><i class="fa fa-cog" aria-hidden="true"></i></a>
            <h5 class="mb-0 fs-20 text-black "><span class="font-w400">{{ __('admin.hello') }},</span> {{ auth()->user()->name }}</h5>
            <p class="mb-0 fs-14 font-w400">{{ auth()->user()->email }}</p>
        </div>

        <hr class="bg-light">

        <!-- Sidebar Menu -->
        <ul class="metismenu" id="menu">
            @if (Route::has('dashboard'))
                <li><a href="{{ route('dashboard') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-144-layout"></i>
                        <span class="nav-text">{{ __('admin.dashboard') }}</span>
                    </a>
                </li>
            @endif

            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="flaticon-077-menu-1"></i>
                    <span class="nav-text">{{ __('admin.services') }}</span>
                </a>
                <ul aria-expanded="false">
                    @if (Route::has('services.all'))
                        <li><a href="{{ route('services.all') }}">{{ __('admin.services_all') }}</a></li>
                    @endif
                    @if (Route::has('service.create'))
                        <li><a href="{{ route('service.create') }}">{{ __('admin.service_add') }}</a></li>
                    @endif
                </ul>
            </li>

            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="fa fa-cubes"></i>
                    <span class="nav-text">{{ __('admin.products') }}</span>
                </a>
                <ul aria-expanded="false">
                    @if (Route::has('products.all'))
                        <li><a href="{{ route('products.all') }}">{{ __('admin.products_all') }}</a></li>
                    @endif
                    @if (Route::has('product.create'))
                        <li><a href="{{ route('product.create') }}">{{ __('admin.product_add') }}</a></li>
                    @endif
                </ul>
            </li>
        </ul>
        {{--<div class="copyright">
            <p><strong>Zenix Crypto Admin Dashboard</strong> © 2021 All Rights Reserved</p>
            <p class="fs-12">Made with <span class="heart"></span> by DexignZone</p>
        </div>--}}
    </div>
</div>