@extends('site.layout')

@section('title', $product->name)

@section('content')

@include('site.include.heading', [
'title' => $product->name,
'image' => null,
'route' => route('site.product', $product->id),
'parent_title' => __('site.Products'),
'parent_route' => route('site.products'),
])

<section>
    <div class="container">
        @include('site.include.headTitle')
        <article class="post">
            <figure class="post-img">
                <div class="figure-img">
                    <img class="lazyload" data-src="{{ asset(Storage::url($product->image)) }}" alt="{{ $product->name }}" />
                    <div class="overlay-bg">
                        <button class="modal-open" type="button" data-image="{{ asset(Storage::url($product->image)) }}">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>
                <!-- <figcaption></figcaption> -->
            </figure>

            <div class="post-content">
                <h2 class="post-title">{{ $product->name }} <i class="fas fa-quote-right text-large text-primary"></i></h2>
                {!! $product->description !!}
            </div>
        </article>
    </div>
</section>

@include('site.include.subscribe')

@endsection
