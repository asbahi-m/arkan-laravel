@extends('admin.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.change_pass') }}</h4>
        </div>
        <div class="card-body">
            <div class="form-validation">
                <form class="form-valide" action="#" method="post">
                    @csrf
                    <!-- Current Passowrd -->
                    <div class="form-group">
                        <label class="text-label" for="dz-password">
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
                    </div>

                    <!-- New Password -->
                    <div class="form-group">
                        <label class="text-label" for="val-password">
                            <span>{{ __('admin.password_new') }}</span><span class="text-danger">*</span>
                        </label>
                        <div>
                            <input type="text" class="form-control" id="val-password" name="val-password"
                                    placeholder="{{ __('admin.password_msg') }}" autocomplete="new-password">
                        </div>
                    </div>

                    <!-- Confirm New Password -->
                    <div class="form-group">
                        <label class="text-label" for="val-confirm-password">
                            <span>{{ __('admin.password_confirm') }}</span><span class="text-danger">*</span>
                        </label>
                        <div>
                            <input type="text" class="form-control" id="val-confirm-password" name="val-confirm-password"
                                    placeholder="{{ __('admin.password_confirm_msg') }}" autocomplete="new-password">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm mr-2">{{ __('admin.update') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- Jquery Validation -->
    <script src="{{ asset('admin/vendor/jquery-validation/jquery.validate.min.js') }}"></script>
    <!-- Form validate init -->
    <script src="{{ asset('admin/js/plugins-init/jquery.validate-init.js') }}"></script>
@endsection
