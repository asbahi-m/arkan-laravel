@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.general_options') }}</h4>
            @include('admin.option.links_include')
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('option.general.update') }}">
                    @csrf
                    <!-- Site Name -->
                    <div class="form-group">
                        <label class="text-label" for="site-name">{{ __('admin.site_name') }}:</label>
                        <input type="text" id="site-name" class="form-control" name="general_options[site_name]"
                                value="{{ old('general_options.site_name') ? old('general_options.site_name') : (isset($options['site_name']) ? $options['site_name'] : '') }}" required>
                        @error('general_options.site_name')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Site Identity -->
                    <div class="form-group">
                        <label class="text-label" for="site-identity">{{ __('admin.site_identity') }}:</label>
                        <input type="text" id="site-identity" class="form-control" name="general_options[site_identity]"
                                value="{{ old('general_options.site_identity') ? old('general_options.site_identity') : (isset($options['site_identity']) ? $options['site_identity'] : '') }}">
                        <small class="form-text d-block">{{ __('admin.site_identity_help') }}</small>
                        @error('general_options.site_identity')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Site Description -->
                    <div class="form-group">
                        <label class="text-label" for="site-description">{{ __('admin.site_description') }}:</label>
                        <textarea class="form-control" name="general_options[site_description]" rows="2"
                            >{{ old('general_options.site_description') ? old('general_options.site_description') : (isset($options['site_description']) ? $options['site_description'] : '') }}</textarea>
                        <small class="form-text d-block">{{ __('admin.site_description_help') }}</small>
                        @error('general_options.site_description')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Keywords -->
                    <div class="form-group">
                        <label class="text-label" for="keywords">{{ __('admin.keywords') }}:</label>
                        <input type="text" id="keywords" class="form-control" name="general_options[keywords]"
                                value="{{ old('general_options.keywords') ? old('general_options.keywords') : (isset($options['keywords']) ? $options['keywords'] : '') }}">
                        <small class="form-text d-block">{{ __('admin.keywords_help') }}</small>
                        @error('general_options.keywords')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Copyrights -->
                    <div class="form-group">
                        <label class="text-label" for="copyrights">{{ __('admin.copyrights') }}:</label>
                        <input type="text" id="copyrights" class="form-control" name="general_options[copyrights]"
                                value="{{ old('general_options.copyrights') ? old('general_options.copyrights') : (isset($options['copyrights']) ? $options['copyrights'] : '') }}">
                        @error('general_options.copyrights')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Site Email -->
                    <div class="form-group">
                        <label class="text-label" for="site_email">{{ __('admin.site_email') }}:</label>
                        <input type="email" id="site_email" class="form-control" name="general_options[site_email]"
                                value="{{ old('general_options.site_email') ? old('general_options.site_email') : (isset($options['site_email']) ? $options['site_email'] : '') }}">
                        <small class="form-text d-block">{{ __('admin.site_email_help') }}</small>
                        @error('general_options.site_email')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Support Email -->
                    <div class="form-group">
                        <label class="text-label" for="support_email">{{ __('admin.support_email') }}:</label>
                        <input type="email" id="support_email" class="form-control" name="general_options[support_email]"
                                value="{{ old('general_options.support_email') ? old('general_options.support_email') : (isset($options['support_email']) ? $options['support_email'] : '') }}">
                        <small class="form-text d-block">{{ __('admin.support_email_help') }}</small>
                        @error('general_options.support_email')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Live Chat URL -->
                    <div class="form-group">
                        <label class="text-label" for="live_chat_url">{{ __('admin.live_chat_url') }}:</label>
                        <input type="url" id="live_chat_url" class="form-control" name="general_options[live_chat_url]"
                                value="{{ old('general_options.live_chat_url') ? old('general_options.live_chat_url') : (isset($options['live_chat_url']) ? $options['live_chat_url'] : '') }}">
                        @error('general_options.live_chat_url')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Support URL -->
                    <div class="form-group">
                        <label class="text-label" for="support_url">{{ __('admin.support_url') }}:</label>
                        <input type="url" id="support_url" class="form-control" name="general_options[support_url]"
                                value="{{ old('general_options.support_url') ? old('general_options.support_url') : (isset($options['support_url']) ? $options['support_url'] : '') }}">
                        @error('general_options.support_url')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-sm mr-2">{{ __('admin.update') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
