@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('page.index') }}">{{ __('admin.pages_all') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.page_edit') }}</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('page.update', $page) }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Page Title -->
                    <div class="form-group">
                        <label class="text-label" for="page-title">{{ __('admin.page_title') }}:</label>
                        <input type="text" id="page-title" class="form-control" name="title"
                                value="{{ $page->title }}" required>
                        @error('title')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Page Subtitle -->
                    <div class="form-group">
                        <label class="text-label" for="page-subtitle">{{ __('admin.page_subtitle') }}:</label>
                        <input type="text" id="page-subtitle" class="form-control" name="subtitle"
                                value="{{ $page->subtitle }}">
                        @error('subtitle')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Page Description -->
                    <div class="form-group">
                        <label class="text-label" for="page-desc">{{ __('admin.page_desc') }}:</label>
                        <textarea class="form-control summernote" name="description" rows="4">{{ $page->description }}</textarea>
                        @error('description')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Page Publish -->
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" class="custom-control-input" id="publish" name="is_published"
                                    value="1" {{ $page->is_published == 'published' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="publish">{{ __('admin.publish') }}</label>
                        </div>
                        @error('is_published')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Page Marker -->
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="checkbox" class="custom-control-input" id="marker" name="is_marker"
                                    value="1" {{ $page->is_marker == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="marker">{{ __('admin.marker') }}</label>
                        </div>
                        @error('')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Page View Image -->
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="hidden" name="view_image" value="0">
                            <input type="checkbox" class="custom-control-input" id="view-image" name="view_image"
                                    value="1" {{ $page->view_image == 1 ? 'checked' : '' }}>
                            <label class="custom-control-label" for="view-image">{{ __('admin.view_image') }}</label>
                        </div>
                        @error('view_image')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Page Templates -->
                    <div class="form-group">
                        <label class="text-label">{{ __('admin.page_templates') }}:</label>
                        <select class="multi-select" name="templates[]" multiple="multiple">
                            <option {{ $page->templates && in_array('service_order', json_decode($page->templates)) ? 'selected' : '' }} value="service_order"
                                >{{ __('admin.service_order') }}</option>
                            <option {{ $page->templates && in_array('job_application', json_decode($page->templates)) ? 'selected' : '' }} value="job_application"
                                >{{ __('admin.job_application') }}</option>
                            <option {{ $page->templates && in_array('contact_us', json_decode($page->templates)) ? 'selected' : '' }} value="contact_us"
                                >{{ __('admin.contact_us') }}</option>
                        </select>
                        @error('template')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Page Slug -->
                    <div class="form-group">
                        <label class="text-label" for="page-slug">{{ __('admin.page_slug') }}:</label>
                        <input type="text" id="page-slug" class="form-control" name="slug"
                                value="{{ $page->slug }}">
                        @error('slug')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Page Image -->
                    <div class="form-group">
                        <label class="text-label">{{ __('admin.page_image') }}:</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-upload"></i></span>
                            </div>
                            <div class="custom-file">
                                <input id="image" type="file" class="custom-file-input" name="image"
                                        onchange="showImage('show-image')" value="{{ old('image') }}">
                                <label class="custom-file-label">{{ __('admin.choose_image') }}</label>
                            </div>
                        </div>
                        @error('image')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                        <img id="show-image" class="img-thumbnail mb-3"
                                style="max-width: 200px; display: {{ isset($page->image) ? 'block' : 'none' }}"
                                src="{{ isset($page->image) ? asset(Storage::url($page->image)) : '' }}" alt="" />
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-primary btn-sm mr-2">{{ __('admin.update') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('link')
    <link rel="stylesheet" href="{{ asset('admin/vendor/select2/css/select2.min.css') }}">
    <link href="{{ asset('admin/vendor/summernote/summernote.css') }}" rel="stylesheet">
@endsection

@section('script')
    <script src="{{ asset('admin/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins-init/select2-init.js') }}"></script>
    <!-- Summernote JS -->
    <script src="{{ asset('admin/vendor/summernote/js/summernote.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                height: 200,
            });
        });
    </script>
@endsection
