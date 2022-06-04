@if ($clients->count())
    <section class="clients animate">
        <div class="container">
            <h1 class="underline uppercase"><a href="{{ route('site.clients') }}">{!! __('site.Our_Clients') !!}</a></h1>
            @if (isset($latest) && $latest)
            <a href="{{ route('site.clients') }}" class="btn btn-primary more">{{ __('site.More') }}</a>
            @endif
            <div class="{{ isset($latest) && $latest ? 'slider' : '' }}">
                <div class="MS-content items">
                    @foreach ($clients as $client)
                        <div class="item">
                            <a class="img" href="{{ $client->url_address }}" target="_blank">
                                <img class="lazyload" data-src="{{ asset(Storage::url($client->image)) }}" alt="$client->name" />
                            </a>
                        </div>
                    @endforeach
                </div>
                @if (isset($latest) && $latest)
                <div class="MS-controls">
                    <button class="MS-left prev" type="button"></button>
                    <button class="MS-right next" type="button"></button>
                </div>
                @else
                {{ $clients->links() }}
                @endif
            </div>
        </div>
    </section>
@endif
