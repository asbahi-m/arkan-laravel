@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.your_profile') }}</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <!-- Username -->
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}"
                                placeholder="{{ __('admin.username') }}" autocomplete="name" required>
                        @error('name')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}"
                                placeholder="{{ __('admin.email') }}" autocomplete="email" required>
                        @error('email')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($locales->count())
                        <!-- Favorite Locale -->
                        <div class="form-group">
                            <label class="text-label">{{ __('admin.fav_locale') }}:</label>
                            <select class="form-control default-select" name="fav_locale">
                                @foreach ($locales as $locale)
                                    <option {{ auth()->user()->locale && auth()->user()->locale->short_sign == $locale->short_sign ? 'selected' : '' }}
                                        value="{{ $locale->short_sign }}">{{ Str::ucfirst($locale->name) }}</option>
                                @endforeach
                            </select>
                            @error('fav_locale')
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <!-- Avatar -->
                    <div class="form-group">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-upload"></i></span>
                            </div>
                            <div class="custom-file">
                                <input id="avatar" type="file" class="custom-file-input" name="avatar"
                                        onchange="showImage('show-image')">
                                <!-- <input type="hidden" name="delete_avatar" value=""> -->
                                <label class="custom-file-label">{{ __('admin.choose_avatar') }}</label>
                            </div>
                        </div>
                        @error('avatar')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                        <img id="show-image" class="img-thumbnail mb-3" style="max-width: 200px; display: block"
                                src="{{ isset(auth()->user()->profile_photo_path) ? asset(Storage::url(auth()->user()->profile_photo_path)) : asset('admin/images/user.png') }}" alt="" />
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-sm mr-2">{{ __('admin.update') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
