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

            @if (request()->routeIs('site.home'))
            <div class="benner">
                <a href="#"><img class="lazyload" data-src="{{ asset('images/benner.jpg') }}" alt="Benner" /></a>
            </div>
            @endif
        </div>
    </section>
@endif
