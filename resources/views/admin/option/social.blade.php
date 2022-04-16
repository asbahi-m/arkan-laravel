@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.social_options') }}</h4>
            @include('admin.option.links_include')
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('option.social.update') }}">
                    @csrf
                    <!-- Facebook -->
                    <div class="form-group">
                        <label class="text-label" for="facebook">{{ __('admin.facebook') }}</label>
                        <div class="input-group transparent-append">
                            <input type="url" class="form-control" id="facebook" name="social_options[facebook]"
                                value="{{ old('social_options.facebook') ? old('social_options.facebook') : (isset($options['facebook']) ? $options['facebook'] : '') }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-facebook"></i></span>
                            </div>
                        </div>
                        @error('social_options.facebook')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Twitter -->
                    <div class="form-group">
                        <label class="text-label" for="twitter">{{ __('admin.twitter') }}</label>
                        <div class="input-group transparent-append">
                            <input type="url" class="form-control" id="twitter" name="social_options[twitter]"
                                value="{{ old('social_options.twitter') ? old('social_options.twitter') : (isset($options['twitter']) ? $options['twitter'] : '') }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-twitter"></i></span>
                            </div>
                        </div>
                        @error('social_options.twitter')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Linkedin -->
                    <div class="form-group">
                        <label class="text-label" for="linkedin">{{ __('admin.linkedin') }}</label>
                        <div class="input-group transparent-append">
                            <input type="url" class="form-control" id="linkedin" name="social_options[linkedin]"
                                value="{{ old('social_options.linkedin') ? old('social_options.linkedin') : (isset($options['linkedin']) ? $options['linkedin'] : '') }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-linkedin"></i></span>
                            </div>
                        </div>
                        @error('social_options.linkedin')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Instagram -->
                    <div class="form-group">
                        <label class="text-label" for="instagram">{{ __('admin.instagram') }}</label>
                        <div class="input-group transparent-append">
                            <input type="url" class="form-control" id="instagram" name="social_options[instagram]"
                                value="{{ old('social_options.instagram') ? old('social_options.instagram') : (isset($options['instagram']) ? $options['instagram'] : '') }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-instagram"></i></span>
                            </div>
                        </div>
                        @error('social_options.instagram')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Snapchat -->
                    <div class="form-group">
                        <label class="text-label" for="snapchat">{{ __('admin.snapchat') }}</label>
                        <div class="input-group transparent-append">
                            <input type="url" class="form-control" id="snapchat" name="social_options[snapchat]"
                                value="{{ old('social_options.snapchat') ? old('social_options.snapchat') : (isset($options['snapchat']) ? $options['snapchat'] : '') }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-snapchat"></i></span>
                            </div>
                        </div>
                        @error('social_options.snapchat')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Youtube -->
                    <div class="form-group">
                        <label class="text-label" for="youtube">{{ __('admin.youtube') }}</label>
                        <div class="input-group transparent-append">
                            <input type="url" class="form-control" id="youtube" name="social_options[youtube]"
                                value="{{ old('social_options.youtube') ? old('social_options.youtube') : (isset($options['youtube']) ? $options['youtube'] : '') }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-youtube"></i></span>
                            </div>
                        </div>
                        @error('social_options.youtube')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Whatsapp -->
                    <div class="form-group">
                        <label class="text-label" for="whatsapp">{{ __('admin.whatsapp') }}</label>
                        <div class="input-group transparent-append">
                            <input type="tel" class="form-control" id="whatsapp" name="social_options[whatsapp]"
                                value="{{ old('social_options.whatsapp') ? old('social_options.whatsapp') : (isset($options['whatsapp']) ? $options['whatsapp'] : '') }}">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fa fa-whatsapp"></i></span>
                            </div>
                        </div>
                        @error('social_options.whatsapp')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-sm mr-2">{{ __('admin.update') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
