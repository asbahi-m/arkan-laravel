@extends('admin.layout')

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.your_profile') }}</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Username -->
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}"
                                placeholder="{{ __('admin.username') }}" autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}"
                                placeholder="{{ __('admin.email') }}" autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Avatar -->
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-upload"></i></span>
                        </div>
                        <div class="custom-file">
                            <input id="avatar" type="file" class="custom-file-input" name="avatar">
                            <!-- <input type="hidden" name="delete_avatar" value=""> -->
                            <label class="custom-file-label">{{ __('admin.choose_avatar') }}</label>
                        </div>
                    </div>
                    @error('avatar')
                        <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                    @enderror
                    <div>
                        <img id="show-image" class="img-thumbnail mb-3" style="max-width: 200px"
                                src="{{ auth()->user()->profile_photo_path ? asset(Storage::url(auth()->user()->profile_photo_path)) : asset('admin/images/user.png') }}" alt="" />
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-sm mr-2">{{ __('admin.update') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        let inputImg = document.getElementById("avatar");
        let showImg = document.getElementById("show-image");
        inputImg.addEventListener("change", function () {
            var reader = new FileReader();
            reader.readAsDataURL(this.files[0]);
            reader.onloadend = function(event){
                showImg.src = event.target.result;
                showImg.style.display = "block";
            }
        })
    </script>
@endsection
