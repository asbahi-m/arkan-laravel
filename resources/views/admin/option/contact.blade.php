@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.contact_options') }}</h4>
            @include('admin.option.links_include')
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('option.contact.update') }}">
                    @csrf
                    <!-- Address -->
                    <div class="form-group">
                        <label class="text-label" for="address">{{ __('admin.address') }}:</label>
                        <input type="text" id="address" class="form-control" name="contact_options[address]"
                                value="{{ old('contact_options.address') ? old('contact_options.address') : (isset($options['address']) ? $options['address'] : '') }}">
                        @error('contact_options.address')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Mobile -->
                    <div class="form-group">
                        <label class="text-label" for="mobile">{{ __('admin.mobile') }}:</label>
                        <input type="tel" id="mobile" class="form-control" name="contact_options[mobile]"
                                value="{{ old('contact_options.mobile') ? old('contact_options.mobile') : (isset($options['mobile']) ? $options['mobile'] : '') }}">
                        @error('contact_options.mobile')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label class="text-label" for="email">{{ __('admin.email') }}:</label>
                        <input type="email" id="email" class="form-control" name="contact_options[email]"
                                value="{{ old('contact_options.email') ? old('contact_options.email') : (isset($options['email']) ? $options['email'] : '') }}">
                        @error('contact_options.email')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Map -->
                    <div class="form-group">
                        <label class="text-label" for="map">{{ __('admin.map') }}:</label>
                        <input type="text" id="map" class="form-control" name="contact_options[map]"
                                value="{{ old('contact_options.map') ? old('contact_options.map') : (isset($options['map']) ? $options['map'] : '') }}">
                        @error('contact_options.map')
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
