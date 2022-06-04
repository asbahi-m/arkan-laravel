@extends('site.layout')

@section('title', $service->name)

@section('content')

@include('site.include.heading', [
'title' => $service->name,
'image' => null,
'route' => route('site.service', $service->id),
'parent_title' => __('site.Services'),
'parent_route' => route('site.services'),
])

<section>
    <div class="container">
        @include('site.include.headTitle')
        <article class="post">
            <figure class="post-img">
                <div class="figure-img">
                    <img class="lazyload" data-src="{{ asset(Storage::url($service->image)) }}" alt="{{ $service->name }}" />
                    <div class="overlay-bg">
                        <button class="modal-open" type="button" data-image="{{ asset(Storage::url($service->image)) }}">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>
                <!-- <figcaption></figcaption> -->
            </figure>

            <div class="post-content">
                <h2 class="post-title">{{ $service->name }} <i class="fas fa-quote-right text-large text-primary"></i></h2>
                {!! $service->description !!}
            </div>
        </article>
    </div>
</section>

@include('site.templates.projects', [$projects, 'latest' => true])

@include('site.include.subscribe')

@endsection
