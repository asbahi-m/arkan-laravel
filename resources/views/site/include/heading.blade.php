@php
    $breadcrumb = asset(isset($image) ? Storage::url($image) : 'images/breadcrumb.jpg');
@endphp
<section class="heading text-light">
    <div class="container">
        <h1>{{ $title }}</h1>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('site.home') }}">{{ __('site.Home') }}</a></li>
            @isset($parent_route)
            <li class="breadcrumb-item"><a href="{{ $parent_route }}">{{ $parent_title }}</a></li>
            @endisset
            <li class="breadcrumb-item active" aria-current="page"><a href="{{ $route }}">{{ $title }}</a></li>
        </ul>
        <div class="carousel">
            <div class="carousel-inner">
                <div class="carousel-item overlay-img active" style="background-image: url('{{ $breadcrumb }}')"></div>
                {{-- <div class="carousel-item overlay-img" style="display: none; background-image: url('images/slider-3.jpg')"></div> --}}
            </div>
        </div>
    </div>
</section>
