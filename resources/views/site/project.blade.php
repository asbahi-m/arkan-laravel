@extends('site.layout')

@section('title', $project->name)

@section('content')

@include('site.include.heading', [
'title' => $project->name,
'image' => null,
'route' => route('site.project', $project->id),
'parent_title' => __('site.Projects'),
'parent_route' => route('site.projects'),
])

<section>
    <div class="container">
        @include('site.include.headTitle')
        <article class="post">
            <figure class="post-img">
                <div class="figure-img">
                    <img class="lazyload" data-src="{{ asset(Storage::url($project->image)) }}" alt="{{ $project->name }}" />
                    <div class="overlay-bg">
                        <button class="modal-open" type="button" data-image="{{ asset(Storage::url($project->image)) }}">
                            <i class="fas fa-expand"></i>
                        </button>
                    </div>
                </div>
                <!-- <figcaption></figcaption> -->
            </figure>

            <div class="post-content">
                <h2 class="post-title">{{ $project->name }} <i class="fas fa-quote-right text-large text-primary"></i></h2>
                {!! $project->description !!}
            </div>
        </article>
    </div>
</section>

@include('site.include.subscribe')

@endsection
