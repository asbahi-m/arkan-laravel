@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('client.index') }}">{{ __('admin.clients_all') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.client_add_new') }}</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('client.store') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Client Name -->
                    <div class="form-group">
                        <label class="text-label" for="client-name">{{ __('admin.client_name') }}:</label>
                        @forelse ($locales as $locale)
                            <div class="locale">
                                <input type="text" id="client-name" class="form-control" name="name[{{ $locale->short_sign }}]"
                                        lang="{{ $locale->short_sign }}" value="{{ old('name.' . $locale->short_sign) }}">
                                <small>{{ $locale->short_sign }}</small>
                            </div>
                            @error('name.' . $locale->short_sign)
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        @empty
                            <input type="text" id="client-name" class="form-control" name="name"
                                    value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        @endforelse
                    </div>

                    <!-- Client URL Address -->
                    <div class="form-group">
                        <label class="text-label" for="client-url">{{ __('admin.client_url') }}:</label>
                        <input type="text" id="client-url" class="form-control" name="url_address"
                                value="{{ old('url_address') }}">
                        @error('url_address')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Client Publish -->
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" class="custom-control-input" id="publish" name="is_published"
                                    value="1" {{ old('is_published') == 0 && session()->has('errors') ? '' : 'checked' }}>
                            <label class="custom-control-label" for="publish">{{ __('admin.publish') }}</label>
                        </div>
                        @error('is_published')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Client Image -->
                    <div class="form-group">
                        <label class="text-label">{{ __('admin.client_image') }}:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-upload"></i></span>
                            </div>
                            <div class="custom-file">
                                <input id="image" type="file" class="custom-file-input" name="image"
                                        onchange="showImage('show-image')" value="{{ old('image') }}">
                                <label class="custom-file-label">{{ __('admin.choose_image') }}</label>
                            </div>
                        </div>
                        @error('image')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                        <img id="show-image" class="img-thumbnail mb-3" style="max-width: 200px; display: none"
                                src="" alt="" />
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-sm mr-2">{{ __('admin.create') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
