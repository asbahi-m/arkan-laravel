@extends('admin.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.contact_add_new') }}</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('contact.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="text-label" for="contact-name">{{ __('admin.contact_name') }}:</label>
                        <input type="text" id="contact-name" class="form-control" name="name"
                                value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-label" for="contact-email">{{ __('admin.contact_email') }}:</label>
                        <input type="email" id="contact-email" class="form-control" name="email"
                                value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-label" for="contact-phone">{{ __('admin.contact_phone') }}:</label>
                        <input type="tel" id="contact-phone" class="form-control" name="phone"
                                value="{{ old('phone') }}">
                        @error('phone')
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
                    <button type="submit" class="btn btn-primary btn-sm mr-2">{{ __('admin.contact') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
