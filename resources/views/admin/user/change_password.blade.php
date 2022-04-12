@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.change_pass') }}</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form class="form-valide-with-icon" action="{{ route('password.update') }}" method="POST">
                    @method('PUT')
                    @csrf
                    <!-- Current Passowrd -->
                    <div class="form-group">
                        <label class="text-label" for="current-password">
                            <span>{{ __('admin.password_current') }}</span> <span class="text-danger">*</span>
                        </label>
                        <div class="input-group transparent-append">
                            <input type="password" class="form-control" id="dz-password" name="current_password"
                                    autocomplete="current-password">
                            <div class="input-group-append show-pass">
                                <span class="input-group-text">
                                    <i class="fa fa-eye-slash"></i><i class="fa fa-eye"></i>
                                </span>
                            </div>
                        </div>
                        @error('current_password')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="form-group">
                        <label class="text-label" for="new-password">
                            <span>{{ __('admin.password_new') }}</span><span class="text-danger">*</span>
                        </label>
                        <div>
                            <input type="text" class="form-control" id="new-password" name="password"
                                    placeholder="{{ __('admin.password_msg') }}" autocomplete="new-password">
                        </div>
                        @error('password')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{$message}}</div>
                        @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div class="form-group">
                        <label class="text-label" for="password-confirm">
                            <span>{{ __('admin.password_confirm') }}</span><span class="text-danger">*</span>
                        </label>
                        <div>
                            <input type="text" class="form-control" id="password-confirm" name="password_confirmation"
                                    placeholder="{{ __('admin.password_confirm_msg') }}" autocomplete="new-password">
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-sm mr-2">{{ __('admin.update') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
