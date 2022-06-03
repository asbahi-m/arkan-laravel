<form action="{{ route('site.order') }}" method="POST" id="order">
    @csrf
    <div class="field">
        <label for="input-name">{{ __('site.Your Name') }}</label>
        <input type="text" name="name" id="input-name" value="{{ old('name') }}" required>
        @error('name')
            <small style="color: red; display: block;">{{ $message }}</small>
        @enderror
    </div>

    <div class="form-group">
        <div class="field">
            <label for="input-email">{{ __('site.Email') }}</label>
            <input type="email" name="email" id="input-email" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <small style="color: red; display: block;">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="input-phone">{{ __('site.Phone') }}</label>
            <input type="tel" name="phone" id="input-phone" value="{{ old('phone') }}">
            @error('phone')
                <small style="color: red; display: block;">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="field">
        <label for="input-service">{{ __('site.Service') }}</label>
        <select name="service_id" id="input-service" required>
            <option value="" disabled selected>{{ __('site.Please Select Service') }}</option>
            @foreach ($services as $service)
                <option {{ old('service_id') == $service->id ? 'selected' : '' }}
                    value="{{ $service->id }}">{{ $service->name }}</option>
            @endforeach
        </select>
        @error('service_id')
            <small style="color: red; display: block;">{{ $message }}</small>
        @enderror
    </div>

    <button class="btn btn-primary center" type="submit">{{ __('site.Service Order') }}</button>
</form>
