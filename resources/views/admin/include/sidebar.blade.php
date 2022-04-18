@php
    $orders_count = App\Models\Order::where('status', 'pending')->count();
    $careers_count = App\Models\Career::where('status', 'pending')->count();
    $msgs_count = App\Models\ContactUs::where('status', 'unread')->count();
@endphp
<div class="deznav">
    <div class="deznav-scroll">
        <!-- User Profile -->
        <div class="main-profile py-2">
            <img src="{{ auth()->user()->profile_photo_path ? asset(Storage::url(auth()->user()->profile_photo_path)) : asset('admin/images/user.png') }}"
                    alt="" style="width: auto">
            <a href="{{ route('profile') }}"><i class="fa fa-cog" aria-hidden="true"></i></a>
            <h5 class="mb-0 fs-16 text-black "><span class="font-w400">{{ __('admin.hello') }},</span> {{ auth()->user()->name }}</h5>
            <p class="mb-0 fs-14 font-w400">{{ auth()->user()->email }}</p>
        </div>

        <hr class="bg-light my-1">

        <!-- Sidebar Menu -->
        <ul class="metismenu" id="menu">
            @if (Route::has('dashboard'))
                <li><a href="{{ route('dashboard') }}" class="ai-icon" aria-expanded="false">
                        <i class="flaticon-144-layout"></i>
                        <span class="nav-text">{{ __('admin.dashboard') }}</span>
                    </a>
                </li>
            @endif

            @if (Route::has('type.index'))
                <li><a href="{{ route('type.index') }}" class="ai-icon" aria-expanded="false">
                        <i class="fa fa-linode"></i>
                        <span class="nav-text">{{ __('admin.types') }}</span>
                    </a>
                </li>
            @endif

            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-077-menu-1"></i>
                    <span class="nav-text">{{ __('admin.services') }}</span>
                </a>
                <ul aria-expanded="false">
                    @if (Route::has('service.index'))
                        <li><a href="{{ route('service.index') }}">{{ __('admin.services_all') }}</a></li>
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
                    @if (Route::has('product.index'))
                        <li><a href="{{ route('product.index') }}">{{ __('admin.products_all') }}</a></li>
                    @endif
                    @if (Route::has('product.create'))
                        <li><a href="{{ route('product.create') }}">{{ __('admin.product_add') }}</a></li>
                    @endif
                </ul>
            </li>

            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-clone"></i>
                    <span class="nav-text">{{ __('admin.projects') }}</span>
                </a>
                <ul aria-expanded="false">
                    @if (Route::has('project.index'))
                        <li><a href="{{ route('project.index') }}">{{ __('admin.projects_all') }}</a></li>
                    @endif
                    @if (Route::has('project.create'))
                        <li><a href="{{ route('project.create') }}">{{ __('admin.project_add') }}</a></li>
                    @endif
                </ul>
            </li>

            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-061-puzzle"></i>
                    <span class="nav-text">{{ __('admin.features') }}</span>
                </a>
                <ul aria-expanded="false">
                    @if (Route::has('feature.index'))
                        <li><a href="{{ route('feature.index') }}">{{ __('admin.features_all') }}</a></li>
                    @endif
                    @if (Route::has('feature.create'))
                        <li><a href="{{ route('feature.create') }}">{{ __('admin.feature_add') }}</a></li>
                    @endif
                </ul>
            </li>

            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-handshake-o"></i>
                    <span class="nav-text">{{ __('admin.clients') }}</span>
                </a>
                <ul aria-expanded="false">
                    @if (Route::has('client.index'))
                        <li><a href="{{ route('client.index') }}">{{ __('admin.clients_all') }}</a></li>
                    @endif
                    @if (Route::has('client.create'))
                        <li><a href="{{ route('client.create') }}">{{ __('admin.client_add') }}</a></li>
                    @endif
                </ul>
            </li>

            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-file"></i>
                    <span class="nav-text">{{ __('admin.pages') }}</span>
                </a>
                <ul aria-expanded="false">
                    @if (Route::has('page.index'))
                        <li><a href="{{ route('page.index') }}">{{ __('admin.pages_all') }}</a></li>
                    @endif
                    @if (Route::has('page.create'))
                        <li><a href="{{ route('page.create') }}">{{ __('admin.page_add') }}</a></li>
                    @endif
                </ul>
            </li>

            @if (Route::has('slider.index'))
                <li><a href="{{ route('slider.index') }}" class="ai-icon" aria-expanded="false">
                        <i class="fa fa-picture-o"></i>
                        <span class="nav-text">{{ __('admin.sliders') }}</span>
                    </a>
                </li>
            @endif

            @if (Route::has('order.index'))
                <li><a href="{{ route('order.index') }}" class="ai-icon d-flex" aria-expanded="false">
                        <i class="fa fa-cart-plus"></i>
                        <span class="nav-text mr-auto">{{ __('admin.orders') }}</span>
                        <span class="badge light badge-info">{{ $orders_count }}</span>
                    </a>
                </li>
            @endif

            @if (Route::has('career.index'))
                <li><a href="{{ route('career.index') }}" class="ai-icon d-flex" aria-expanded="false">
                        <i class="fa fa-id-badge"></i>
                        <span class="nav-text mr-auto">{{ __('admin.careers') }}</span>
                        <span class="badge light badge-info">{{ $careers_count }}</span>
                    </a>
                </li>
            @endif

            @if (Route::has('contact.index'))
                <li><a href="{{ route('contact.index') }}" class="ai-icon d-flex" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span class="nav-text mr-auto">{{ __('admin.messages') }}</span>
                        <span class="badge light badge-info">{{ $msgs_count }}</span>
                    </a>
                </li>
            @endif

            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-users"></i>
                    <span class="nav-text">{{ __('admin.users') }}</span>
                </a>
                <ul aria-expanded="false">
                    @if (Route::has('user.index'))
                        <li><a href="{{ route('user.index') }}">{{ __('admin.users_all') }}</a></li>
                    @endif
                    @if (Route::has('user.create'))
                        <li><a href="{{ route('user.create') }}">{{ __('admin.user_add') }}</a></li>
                    @endif
                </ul>
            </li>

            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="fa fa-sliders"></i>
                    <span class="nav-text">{{ __('admin.options') }}</span>
                </a>
                <ul aria-expanded="false">
                    @if (Route::has('option.general'))
                        <li><a href="{{ route('option.general') }}">{{ __('admin.general_options') }}</a></li>
                    @endif
                    @if (Route::has('option.social'))
                        <li><a href="{{ route('option.social') }}">{{ __('admin.social_media') }}</a></li>
                    @endif
                    @if (Route::has('option.contact'))
                        <li><a href="{{ route('option.contact') }}">{{ __('admin.contact_info') }}</a></li>
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
