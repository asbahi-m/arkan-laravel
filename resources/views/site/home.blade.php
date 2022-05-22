@extends('site.layout')

@section('title', __('site.Home'))

@section('content')
    @if ($sliders->count())
        <section class="no-gutters main-slider">
            <div class="carousel slide main">
                <div class="carousel-inner">
                    @foreach ($sliders as $slider)
                        <div class="carousel-item{{ $loop->index == 0 ? ' active' : '' }}" {{ $loop->index != 0 ? 'style=display:none' : '' }}>
                            @if ($slider->title || $slider->primary_btn || $slider->secondary_btn)
                            <div class="container">
                                <div class="item-caption">
                                    <div class="sub-title uppercase">{{ $slider->subtitle }}</div>
                                    <h2 class="item-title uppercase">{{ $slider->title }}</h2>
                                    <div class="item-desc">{!! Str::limit($slider->brief, 80) !!}</div>
                                    <div class="buttons">
                                        @isset($slider->primary_btn)
                                            <a href="{{ $slider->primary_url }}" class="btn btn-secondary" type="button"
                                                >{{ $slider->primary_btn }} <i class="fas fa-chevron-right"></i>
                                            </a>
                                        @endisset
                                        @isset($slider->secondary_btn)
                                            <a href="{{ $slider->secondary_url }}" class="btn btn-dark btn-outline" type="button"
                                                >{{ $slider->secondary_btn }}</a>
                                        @endisset
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="item-img overlay-img" style="background-image: url('{{ asset(Storage::url($slider->media)) }}')"></div>
                        </div>
                    @endforeach
                </div>
                <div class="carousel-control">
                    <a type="button" class="prev" aria-controls="prev"></a>
                    <a type="button" class="next" aria-controls="next"></a>
                </div>
            </div>
        </section>
    @endif

    @isset($about_us)
        <section id="about-us" class="about-us">
            <div class="container">
                <div class="text-center">
                    <h1 class="head-title"><a href="#">Arkan <span>Pro</span></a></h1>
                    <div class="sub-title text-primary uppercase">Always close together</div>
                    <p class="sub-text text-center">
                        It is a long established fact that a reader will be distracted by
                        the readable content of a page when looking at its layout. The point
                        of using Lorem Ipsum is that it has a more-or-less normal
                        distribution of letters ...
                    </p>
                </div>

                <article class="card row">
                    <div class="card-img">
                        <div class="img">
                            <img class="lazyload" data-src="{{ asset(Storage::url($about_us->image)) }}" alt="{{ $about_us->title }}" />
                        </div>
                        <div class="overlay-bg">
                            <div class="buttons">
                                <a href="{{ route('site.page', $about_us->id) }}" class="icon icon-primary" type="button"><i class="fas fa-link"></i></a>
                                <button class="icon icon-primary modal-open" type="button" data-image="{{ asset(Storage::url($about_us->image)) }}">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h2 class="card-title uppercase">
                            {{ $about_us->subtitle }} <i class="fas fa-quote-right text-large text-primary"></i>
                        </h2>
                        <div class="card-desc">{!! Str::limit($about_us->description, STR_LIMIT) !!}</div>
                        <a href="{{ route('site.page', $about_us->id) }}" class="btn btn-primary">Read More <i class="fas fa-chevron-right"></i></a>
                        <span class="mark arrow">
                            <img src="{{ asset('images/logo-white.png') }}" alt="{{ __('site.site_name') }}" />
                            <span><strong>Arkan</strong>Pro</span>
                        </span>
                    </div>
                </article>
            </div>
        </section>
    @endisset

    @if ($features->count())
        <section id="unlimited-tech" class="unlimited-tech animate">
            <div class="container">
                <h1 class="underline"><a>{!! __('site.Unlimited_Technolgoy') !!}</a></h1>
                <div class="items">
                    @foreach ($features as $feature)
                        <div class="item{{ $loop->index == 2 ? ' special' : '' }}">
                            <span class="img-circle">
                                <img class="lazyload" data-src="{{ asset(Storage::url($feature->image)) }}" alt="{{ $feature->name }}" />
                            </span>
                            <h2>{{ $feature->name }}</h2>
                            <div>{!! $feature->description !!}</div>
                            <a class="more" href="{{ route('site.feature', $feature->id) }}">
                                <i class="fas fa-arrow-{{ $loop->index == 2 ? 'down' : 'right' }}"></i></a>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($services->count())
        <section id="services" class="services animate">
            <div class="container">
                <div class="shuflle">
                    <h1 class="underline"><a>{!! __('site.Services_web_provide') !!}</a></h1>
                    <ul class="list">
                        <li class="active" data-list="all">{{ __('site.All') }}</li>
                        @foreach ($types as $type)
                            @if ($type->services->count())
                                <li data-list="{{ $type->name }}">{{ Str::ucfirst($type->name) }}</li>
                            @endif
                        @endforeach
                    </ul>
                    <div class="items card-grid">
                        @foreach ($services as $service)
                            <div class="card" data-sort="{{ $service->type->name }}">
                                <div class="card-img">
                                    <div class="img">
                                        <img class="lazyload" data-src="{{ asset(Storage::url($service->image)) }}" alt="{{ $service->name }}" />
                                    </div>
                                    <div class="overlay-bg">
                                        <div class="buttons">
                                            <a href="{{ route('site.service', $service->id) }}" class="icon icon-primary" type="button"><i class="fas fa-link"></i></a>
                                            <button class="icon icon-primary modal-open" type="button" data-image="{{ asset(Storage::url($service->image)) }}">
                                                <i class="fas fa-expand"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h2 class="card-title"><a href="{{ route('site.service', $service->id) }}">{{ $service->name }}</a></h2>
                                    <div class="card-meta">{{ Str::ucFirst($service->type->name) }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="benner">
                    <a href="#"><img class="lazyload" data-src="{{ asset('images/benner.jpg') }}" alt="Benner" /></a>
                </div>
            </div>
        </section>
    @endif

    <section class="boxlight animate">
        <div class="img">
            <img class="lazyload" data-src="images/ipad-pos.png" alt="Develope Your Work" />
        </div>
        <div class="container">
            <div class="card row custom-card">
                <div class="card-body">
                    <h2 class="card-title uppercase">Develope Your Work</h2>
                    <p class="card-desc">
                        It is a long established fact that a reader will be distracted
                        by the readable content of a page when looking at its layout.
                        The point of using Lorem Ipsum is that it has a more-or-less
                        normal distribution of letters, as opposed to using "Content
                        here, content here", making it look like readable English.
                    </p>
                </div>
            </div>
        </div>
    </section>

    @if ($clients->count())
        <section id="clients" class="clients animate">
            <div class="container">
                <h1 class="underline uppercase"><a href="{{ route('site.clients') }}">{!! __('site.Our_Clients') !!}</a></h1>
                <a href="{{ route('site.clients') }}" class="btn btn-primary more">{{ __('site.More') }}</a>
                <div class="slider">
                    <div class="MS-content items">
                        @foreach ($clients as $client)
                            <div class="item">
                                <a class="img" href="{{ $client->url_address }}" target="_blank">
                                    <img class="lazyload" data-src="{{ asset(Storage::url($client->image)) }}" alt="$client->name" />
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="MS-controls">
                        <button class="MS-left prev" type="button"></button>
                        <button class="MS-right next" type="button"></button>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section id="subscribe" class="subscribe boxlight bg-secondary animate">
        <div class="container">
            <div class="card row">
                <div class="card-body">
                    <h1 class="card-title">Request one of our services</h1>
                    <p class="card-desc">
                        Remember that customers always want their orders to arrive on time, so go ahead and think of the Smart
                        Delivery application that helps you achieve their satisfaction in the first place, especially if you seek
                        to grow and expand your customer base. Don't bother looking for experienced drivers, just choose to
                        subscribe to the Smart Delivery application to get highly skiled drivedrs to deliver your customer's
                        requiests wherever he is.
                    </p>
                </div>
                @include('site.templates.service_order', $services)
            </div>
        </div>
    </section>
@endsection
