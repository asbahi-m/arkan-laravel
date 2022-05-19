@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('user.index') }}">{{ __('admin.users_all') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.user_edit') }}</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('user.update', $user) }}">
                    @csrf
                    @method('PUT')
                    <!-- Username -->
                    <div class="form-group">
                        <label class="text-label" for="username">{{ __('admin.username') }}:</label>
                        <input type="text" id="username" class="form-control" name="name"
                                value="{{ $user->name }}" required>
                        @error('name')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- User Email -->
                    <div class="form-group">
                        <label class="text-label" for="email">{{ __('admin.email_address') }}:</label>
                        <input type="email" id="email" class="form-control" name="email"
                                value="{{ $user->email }}" required>
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
                                    <option {{ $user->locale && $user->locale->short_sign == $locale->short_sign ? 'selected' : '' }}
                                        value="{{ $locale->short_sign }}">{{ Str::ucfirst($locale->name) }}</option>
                                @endforeach
                            </select>
                            @error('fav_locale')
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif

                    <!-- User Password -->
                    <div class="form-group">
                        <label class="text-label" for="password">{{ __('admin.password') }}:</label>
                        <input type="text" id="password" class="form-control" name="password">
                        @error('password')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label class="text-label" for="confirm-password">{{ __('admin.password_confirm') }}:</label>
                        <input type="text" id="confirm-password" class="form-control" name="password_confirmation">
                    </div>

                    <!-- User Super Admin -->
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="super-admin" name="is_super_admin"
                                    value="1" {{ $user->is_super_admin ? 'checked' : '' }}>
                            <label class="custom-control-label" for="super-admin">{{ __('admin.super_admin') }}</label>
                        </div>
                        @error('is_super_admin')
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
