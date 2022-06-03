<form action="{{ route('site.career') }}" method="POST" id="career" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <div class="field">
            <label for="input-name">{{ __('site.Your Name') }}</label>
            <input type="text" name="name" id="input-name" value="{{ old('name') }}" required>
            @error('name')
                <small style="color: red; display: block;">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="input-email">{{ __('site.Email') }}</label>
            <input type="email" name="email" id="input-email" value="{{ old('email') }}" required autocomplete="email">
            @error('email')
                <small style="color: red; display: block;">{{ $message }}</small>
            @enderror
        </div>
    </div>

    <div class="form-group">
        <div class="field">
            <label for="input-phone">{{ __('site.Phone') }}</label>
            <input type="tel" name="phone" id="input-phone" value="{{ old('phone') }}">
            @error('phone')
                <small style="color: red; display: block;">{{ $message }}</small>
            @enderror
        </div>

        <div class="field">
            <label for="input-attach-cv">{{ __('site.Attach CV') }}:</label>
            <div class="custom-file">
                <input type="file" name="attachment" id="input-attach-cv" value="{{ old('attachment') }}">
                <span tabindex="-1" class="custom-file-label">{{ __('site.Attach CV') }}</span>
            </div>
            @error('attachment')
                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="field">
        <label for="input-message">Message</label>
        <textarea name="message" id="input-message" rows="2">{{ old('message') }}</textarea>
        @error('message')
            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
        @enderror
    </div>

    <button class="btn btn-primary center" type="submit">{{ __('site.Submit Request') }}</button>
</form>
