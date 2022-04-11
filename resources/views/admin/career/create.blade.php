@extends('admin.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.career_add_new') }}</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('career.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="text-label" for="career-name">{{ __('admin.career_name') }}:</label>
                        <input type="text" id="career-name" class="form-control" name="name"
                                value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-label" for="career-email">{{ __('admin.career_email') }}:</label>
                        <input type="email" id="career-email" class="form-control" name="email"
                                value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-label" for="career-phone">{{ __('admin.career_phone') }}:</label>
                        <input type="tel" id="career-phone" class="form-control" name="phone"
                                value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-label">{{ __('admin.attach_cv') }}:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-upload"></i></span>
                            </div>
                            <div class="custom-file">
                                <input id="file" type="file" class="custom-file-input" name="file"
                                        value="{{ old('file') }}">
                                <label class="custom-file-label">{{ __('admin.choose_file') }}</label>
                            </div>
                        </div>
                        @error('file')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-label">{{ __('admin.message') }}:</label>
                        <textarea class="form-control" name="message" rows="4">{{ old('message') }}</textarea>
                        @error('message')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-sm mr-2">{{ __('admin.career') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
