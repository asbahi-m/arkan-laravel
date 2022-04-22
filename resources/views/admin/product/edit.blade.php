@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ __('admin.products_all') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.product_edit') }}</h4>
        </div>
        <div class="card-body">
            <div class="basic-form">
                <form method="POST" action="{{ route('product.update', $product) }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Product Name -->
                    <div class="form-group">
                        <label class="text-label" for="product-name">{{ __('admin.product_name') }}:</label>
                        <input type="text" id="product-name" class="form-control" name="name"
                                value="{{ $product->name }}" required>
                        @error('name')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Product Description -->
                    <div class="form-group">
                        <label class="text-label" for="product-desc">{{ __('admin.product_desc') }}:</label>
                        <textarea class="form-control summernote" name="description" rows="4">{{ $product->description }}</textarea>
                        @error('description')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Product Type -->
                    <div class="form-group">
                        <label class="text-label">{{ __('admin.product_type') }}:</label>
                        <select class="form-control default-select" name="type_id">
                            <option value="0">{{ __('admin.no_type') }}</option>
                            @foreach ($types as $type)
                                <option {{ $product['type_id'] == $type['id'] ? 'selected' : '' }}
                                    value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                        @error('type_id')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Product Publish -->
                    <div class="form-group">
                        <div class="custom-control custom-checkbox mb-3">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" class="custom-control-input" id="publish" name="is_published"
                                    value="1" {{ $product->is_published == 'published' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="publish">{{ __('admin.publish') }}</label>
                        </div>
                        @error('is_published')
                            <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Product Image -->
                    <div class="form-group">
                        <label class="text-label">{{ __('admin.product_image') }}:</label>
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
                                style="max-width: 200px; display: {{ isset($product->image) ? 'block' : 'none' }}"
                                src="{{ isset($product->image) ? asset(Storage::url($product->image)) : '' }}" alt="" />
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
