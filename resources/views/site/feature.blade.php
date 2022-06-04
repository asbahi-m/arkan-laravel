@extends('site.layout')

@section('title', $feature->name)

@section('content')

@include('site.include.heading', [
'title' => $feature->name,
'image' => null,
'route' => route('site.feature', $feature->id),
'parent_title' => null,
'parent_route' => null,
])

<section>
    <div class="container">
        @include('site.include.headTitle')
        <article class="post">
            <figure class="post-img">
                <div class="figure-img">
                    <img class="lazyload" data-src="{{ asset('images/pic-join-us.jpg') }}" alt="{{ $feature->name }}" />
                    <div class="overlay-bg">
                        <button class="modal-open" type="button" data-image="{{ asset('images/pic-join-us.jpg') }}">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>
                <!-- <figcaption></figcaption> -->
            </figure>

            <div class="post-content">
                <h2 class="post-title">{{ $feature->name }} <i class="fas fa-quote-right text-large text-primary"></i></h2>
                {!! $feature->description !!}
            </div>
        </article>
    </div>
</section>

@endsection
