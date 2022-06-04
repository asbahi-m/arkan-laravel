@if ($products->count())
    <section class="products bg-light">
        <div class="container">
            <h1 class="underline"><a>{!! __('site.Our_Products') !!}</a></h1>
            <div class="card-grid">
                @foreach ($products as $product)
                <div class="card">
                    <div class="card-img">
                        <div class="img">
                            <img class="lazyload" data-src="{{ asset(Storage::url($product->image)) }}" alt="{{ $product->name }}" />
                        </div>
                        <div class="overlay-bg">
                            <div class="buttons">
                                <a href="{{ route('site.product', $product->id) }}" class="icon icon-primary" type="button"><i class="fas fa-link"></i></a>
                                <button class="icon icon-primary modal-open" type="button" data-image="{{ asset(Storage::url($product->image)) }}">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body bg-white">
                        <h2 class="card-title"><a href="{{ route('site.product', $product->id) }}">{{ $product->name }}</a></h2>
                        <div class="card-desc">{!! Str::limit($product->description, 80) !!}</div>
                        <a href="{{ route('site.home') }}#subscribe" class="btn btn-secondary">{{ __('site.Order Now') }}</a>
                    </div>
                </div>
                @endforeach
            </div>
            {{ $products->links() }}
        </div>
    </section>
@endif
