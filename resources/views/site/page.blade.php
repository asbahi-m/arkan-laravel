@extends('site.layout')

@section('title', $page->title)

@section('content')

@include('site.include.heading', [
'title' => $page->title,
'image' => null,
'route' => route('site.page', $page->id),
'parent_title' => null,
'parent_route' => null,
])

@if ($page->slug != 'contact-us')
<section class="{{ $page->slug }}">
    <div class="container">
        @includeUnless($page->slug == 'contact-us', 'site.include.headTitle')

        <article class="{{ $page->slug != 'why-us' ? 'post' : '' }}">
            @if($page->view_image && $page->image)
            <figure class="post-img">
                <div class="figure-img">
                    <img class="lazyload" data-src="{{ asset(Storage::url($page->image)) }}" alt="{{ $page->title }}" />
                    <div class="overlay-bg">
                        <button class="modal-open" type="button" data-image="{{ asset(Storage::url($page->image)) }}">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>
                <!-- <figcaption></figcaption> -->
            </figure>
            @endif

            <div class="post-content">
                @isset($page->subtitle)
                <h2 class="post-title">{{ $page->subtitle }} <i class="fas fa-quote-right text-large text-primary"></i></h2>
                @endisset
                {!! $page->description !!}
            </div>
        </article>
    </div>
</section>
@endif

@includeWhen($page->slug == 'about-us', 'site.templates.features', $features)

@includeWhen($page->slug == 'about-us', 'site.templates.projects', [$projects, 'latest' => true])

@includeWhen($page->slug == 'about-us', 'site.templates.clients', [$clients, 'latest' => true])

@if ($page->slug == 'why-us')
<section class="our-client-list">
    <div class="container">
        <h1>{{ __('site.Join our client list') }}</h1>
        <p>
            It is a long established fact that a reader will be distracted by the readable content of a page when
            looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of
            letters, as opposed to using "Content here, content here", making it look like readable English.
        </p>
        <div class="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="container">
                        <div class="item-caption">
                            <h2 class="item-title">Always Close Together</h2>
                            <p class="item-desc">
                                It is a long established fact that a reader will be distracted by the readable content of a page
                                when looking at its layout.
                            </p>
                            <span class="mark">
                                <img src="{{ asset('images/logo-white.png') }}" alt="Arkan Pro" />
                                <span><strong>Arkan</strong>Pro</span>
                            </span>
                        </div>
                        <div class="item-img overlay-img" style="background-image: url('{{ asset('images/slider-2.jpg') }}')"></div>
                    </div>
                </div>
                <div class="carousel-item" style="display: none">
                    <div class="container">
                        <div class="item-caption">
                            <h2 class="item-title">Always Close Together 2</h2>
                            <p class="item-desc">
                                It is a long established fact that a reader will be distracted by the readable content of a page
                                when looking at its layout.
                            </p>
                            <span class="mark">
                                <img src="{{ asset('images/logo-white.png') }}" alt="Arkan Pro" />
                                <span><strong>Arkan</strong>Pro</span>
                            </span>
                        </div>
                    </div>
                    <div class="item-img overlay-img" style="background-image: url('{{ asset('images/slider-3.jpg') }}')"></div>
                </div>
            </div>
            <div class="carousel-control">
                <a type="button" class="prev" aria-controls="prev"></a>
                <a type="button" class="next" aria-controls="next"></a>
            </div>
        </div>
    </div>
</section>
@endif

@if ($page->slug == 'career')
<section class="bg-light">
    <div class="container">
        @include('site.templates.job_application')
    </div>
</section>
@endif

@if ($page->slug == 'contact-us')
<section class="contact-us">
    @if ($page->view_image && $page->image)
    <div class="map">
        <img class="lazyload" data-src="{{ asset(Storage::url($page->image)) }}" alt="{{ $page->title }}" />
    </div>
    @endif
    <div class="container-fluid">
        <div class="contact-info">
            <h1>{{ $page->title }}</h1>
            {!! $page->description !!}
            @include('site.include.contact_info')
        </div>
        @include('site.templates.contcat_us')
    </div>
</section>
@endif

@endsection
