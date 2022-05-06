@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('service.index') }}">{{ __('admin.services_all') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.service_edit') }}</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('service.update', $service) }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Service Name -->
                    <div class="form-group">
                        <label class="text-label" for="service-name">{{ __('admin.service_name') }}:</label>
                        @forelse ($locales as $locale)
                            @php
                                $t_service = $service->t_services->filter(function ($value) use ($locale) {
                                    return $value['locale_id'] == $locale->id;
                                })->first();
                                $service_name = $locale->short_sign == DEFAULT_LOCALE ? $service->name : '';
                            @endphp
                            <div class="locale">
                                <input type="text" id="service-name" class="form-control" name="name[{{ $locale->short_sign }}]"
                                        lang="{{ $locale->short_sign }}" value="{{ $t_service ? $t_service->name : $service_name }}">
                                <small>{{ $locale->short_sign }}</small>
                            </div>
                            @error('name.' . $locale->short_sign)
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        @empty
                            <input type="text" id="service-name" class="form-control" name="name" value="{{ $service->name }}" required>
                            @error('name')
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        @endforelse
                    </div>

                    <!-- Service Description -->
                    <div class="form-group">
                        <label class="text-label" for="service-desc">{{ __('admin.service_desc') }}:</label>
                        @forelse ($locales as $locale)
                            @php
                                $t_service = $service->t_services->filter(function ($value) use ($locale) {
                                    return $value['locale_id'] == $locale->id;
                                })->first();
                                $service_desc = $locale->short_sign == DEFAULT_LOCALE ? $service->description : '';
                            @endphp
                            <div class="locale">
                                <textarea class="form-control summernote" name="description[{{ $locale->short_sign }}]" rows="4"
                                        lang="{{ $locale->short_sign }}">{{ $t_service ? $t_service->description : $service_desc }}</textarea>
                                <small>{{ $locale->short_sign }}</small>
                            </div>
                            @error('description.' . $locale->short_sign)
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        @empty
                            <textarea class="form-control summernote" name="description" rows="4">{{ $service->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                            @enderror
                        @endforelse
                    </div>

                    <!-- Service Type -->
                    <div class="form-group">
                        <label class="text-label">{{ __('admin.service_type') }}:</label>
                        <select class="form-control default-select" name="type_id">
                            <option value="0">{{ __('admin.no_type') }}</option>
                            @foreach ($types as $type)
                                <option {{ $service['type_id'] == $type['id'] ? 'selected' : '' }}
                                    value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('type_id')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Service Publish -->
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" class="custom-control-input" id="publish" name="is_published"
                                    value="1" {{ $service->is_published == 'published' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="publish">{{ __('admin.publish') }}</label>
                        </div>
                        @error('is_published')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Service Image -->
                    <div class="form-group">
                        <label class="text-label">{{ __('admin.service_image') }}:</label>
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
                                style="max-width: 200px; display: '{{ isset($service->image) ? 'block' : 'none' }}'"
                                src="{{ isset($service->image) ? asset(Storage::url($service->image)) : '' }}" alt="" />
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
            $('.summernote').summernote();
        });
    </script>
@endsection
