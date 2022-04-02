<div class="deznav">
    <div class="deznav-scroll">
        <!-- User Profile -->
        <div class="main-profile">
            <img src="{{ auth()->user()->profile_photo_path ? asset(auth()->user()->profile_photo_path) : asset('admin/images/user.png') }}"
                    alt="" style="width: auto">
            <a href="javascript:void(0);"><i class="fa fa-cog" aria-hidden="true"></i></a>
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
            @if (Route::has('services'))
                <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-077-menu-1"></i>
                        <span class="nav-text">{{ __('admin.services') }}</span>
                    </a>
                    <ul aria-expanded="false">
                        <li><a href="{{ route('dashboard') }}">{{ __('admin.services') }}</a></li>
                        <li><a href="./post-details.html">{{ __('admin.service_add') }}</a></li>
                    </ul>
                </li>
            @endif
        </ul>
        {{--<div class="copyright">
            <p><strong>Zenix Crypto Admin Dashboard</strong> © 2021 All Rights Reserved</p>
            <p class="fs-12">Made with <span class="heart"></span> by DexignZone</p>
        </div>--}}
    </div>
</div>
