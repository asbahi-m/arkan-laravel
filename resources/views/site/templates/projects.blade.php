@if ($projects->count())
    <section class="latest animate">
        <div class="container">
            <h1 class="underline"><a>{!! __('site.Latest_Projects') !!}</a></h1>
            <div class="card-grid">
                @foreach ($projects as $project)
                    <div class="card">
                        <div class="card-img">
                            <div class="img">
                                <img class="lazyload" data-src="{{ asset(Storage::url($project->image)) }}" alt="{{ $project->name }}" />
                            </div>
                            <div class="overlay-bg">
                                <div class="buttons">
                                    <a href="{{ route('site.project', $project->id) }}" class="icon icon-primary" type="button"><i class="fas fa-link"></i></a>
                                    <button class="icon icon-primary modal-open" type="button" data-image="{{ asset(Storage::url($project->image)) }}">
                                        <i class="fas fa-expand"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <h2 class="card-title"><a class="stretched-link" href="{{ route('site.project', $project->id) }}">{{ $project->name }}</a></h2>
                            <div class="card-meta">{{ $project->type->name }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center more">
                <a class="btn btn-primary" href="#">{{ __('site.View More') }} <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>
        </div>
    </section>
@endif
