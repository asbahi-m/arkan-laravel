@extends('site.layout')

@section('title', __('site.Services'))

@section('content')

@include('site.include.heading', [
'title' => __('site.Services'),
'image' => null,
'route' => route('site.services'),
'parent_title' => null,
'parent_route' => null,
])

@include('site.templates.services', $services)

<section class="boxlight animate">
    <div class="img">
        <img class="lazyload" data-src="{{ asset('images/ipad-pos.png') }}" alt="Develope Your Work" />
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

@endsection
