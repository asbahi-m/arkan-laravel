@if ($features->count())
    <section class="unlimited-tech animate">
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
