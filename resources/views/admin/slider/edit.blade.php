@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('slider.index') }}">{{ __('admin.sliders') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.slider_edit') }}</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('slider.update', $slider) }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Slider Title -->
                    <div class="form-group">
                        <label class="text-label" for="slider-title">{{ __('admin.slider_title') }}:</label>
                        <input type="text" id="slider-title" class="form-control" name="title"
                                value="{{ $slider->title }}">
                        @error('title')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slider Subtitle -->
                    <div class="form-group">
                        <label class="text-label" for="slider-subtitle">{{ __('admin.slider_subtitle') }}:</label>
                        <input type="text" id="slider-subtitle" class="form-control" name="subtitle"
                                value="{{ $slider->subtitle }}">
                        @error('subtitle')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slider Biref -->
                    <div class="form-group">
                        <label class="text-label" for="slider-brief">{{ __('admin.slider_brief') }}:</label>
                        <textarea class="form-control summernote" name="brief" rows="4">{{ $slider->brief }}</textarea>
                        @error('brief')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group row align-items-center">
                        <!-- Slider Publish -->
                        <div class="form-row col-12 col-sm-12 col-md-2 my-2">
                            <div class="custom-control custom-checkbox mb-2">
                                <input type="hidden" name="is_published" value="0">
                                <input type="checkbox" class="custom-control-input" id="publish" name="is_published"
                                        value="1" {{ $slider->is_published == 'published' ? 'checked' : '' }}>
                                <label class="custom-control-label" for="publish">{{ __('admin.publish') }}</label>
                            </div>
                            @error('is_published')
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slider Order -->
                        <div class="form-row col-12 col-sm-6 col-md-4 align-items-center my-2">
                            <label class="text-label col-auto" for="slider-order">{{ __('admin.slider_order') }}:</label>
                            <input type="number" min="0" id="slider-order" class="form-control col" name="order"
                                    value="{{ $slider->order }}">
                            @error('order')
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Slider Place -->
                        <div class="form-row col-12 col-sm-6 col-md-6 align-items-center my-2">
                            <label class="text-label col-auto">{{ __('admin.slider_place') }}:</label>
                            <select class="form-control default-select col" name="place">
                                @foreach ($places as $place)
                                    <option {{ $slider->place == $place ? 'selected' : '' }}
                                        value="{{ $place }}">{{ $place }}</option>
                                @endforeach
                            </select>
                            @error('place')
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row align-items-center">
                        <!-- Primary URL -->
                        <div class="form-group col-12 col-sm-6">
                            <label class="text-label" for="primary-url">{{ __('admin.primary_url') }}:</label>
                            <input type="url" id="primary-url" class="form-control" name="primary_url"
                                    value="{{ $slider->primary_url }}">
                            @error('primary_url')
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Primary Button Title -->
                        <div class="form-group col-12 col-sm-6">
                            <label class="text-label" for="primary-btn">{{ __('admin.primary_btn') }}:</label>
                            <input type="text" id="primary-btn" class="form-control" name="primary_btn"
                                    value="{{ $slider->primary_btn }}">
                            @error('primary_btn')
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="row align-items-center">
                        <!-- Secondary URL -->
                        <div class="form-group col-12 col-sm-6">
                            <label class="text-label" for="secondary-url">{{ __('admin.secondary_url') }}:</label>
                            <input type="url" id="secondary-url" class="form-control" name="secondary_url"
                                    value="{{ $slider->secondary_url }}">
                            @error('secondary_url')
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Secondary Button Title -->
                        <div class="form-group col-12 col-sm-6">
                            <label class="text-label" for="secondary-btn">{{ __('admin.secondary_btn') }}:</label>
                            <input type="text" id="secondary-btn" class="form-control" name="secondary_btn"
                                    value="{{ $slider->secondary_btn }}">
                            @error('secondary_btn')
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Slider Image -->
                    <div class="form-group">
                        <label class="text-label">{{ __('admin.slider_media') }}:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-upload"></i></span>
                            </div>
                            <div class="custom-file">
                                <input id="media" type="file" class="custom-file-input" name="media"
                                        onchange="showImage('show-image')" value="{{ $slider->media }}">
                                <label class="custom-file-label">{{ __('admin.choose_media') }}</label>
                            </div>
                        </div>
                        @error('media')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                        <img id="show-image" class="img-thumbnail mb-3"
                                style="max-width: 200px; display: {{ isset($slider->media) ? 'block' : 'none' }}"
                                src="{{ isset($slider->media) ? asset(Storage::url($slider->media)) : '' }}" alt="" />
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-sm mr-2">{{ __('admin.update') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('link')
    <link href="{{ asset('admin/vendor/summernote/summernote.css') }}" rel="stylesheet">
@endsection

@section('script')
    <!-- Summernote JS -->
    <script src="{{ asset('admin/vendor/summernote/js/summernote.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 100,
            });
        });
    </script>
@endsection
