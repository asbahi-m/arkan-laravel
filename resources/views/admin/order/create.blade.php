@extends('admin.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.order_add_new') }}</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('order.store') }}">
                    @csrf
                    <!-- Order Name -->
                    <div class="form-group">
                        <label class="text-label" for="order-name">{{ __('admin.order_name') }}:</label>
                        <input type="text" id="order-name" class="form-control" name="name"
                                value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="text-label" for="order-email">{{ __('admin.order_email') }}:</label>
                        <input type="email" id="order-email" class="form-control" name="email"
                                value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-label" for="order-phone">{{ __('admin.order_phone') }}:</label>
                        <input type="tel" id="order-phone" class="form-control" name="phone"
                                value="{{ old('phone') }}">
                        @error('phone')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="text-label">{{ __('admin.order_service') }}:</label>
                        <select class="form-control default-select" name="service" required>
                            @foreach ($services as $service)
                                <option {{ old('service') == $service->id || $service->first()->id == $service->id ? 'selected' : '' }}
                                    value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>
                        @error('service')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-sm mr-2">{{ __('admin.order') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection
