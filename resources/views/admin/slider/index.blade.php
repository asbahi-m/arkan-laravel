@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.sliders') }}</h4>
            <a href="{{ route('slider.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-responsive-md">
                    <thead class="thead-primary">
                        <tr>
                            <th>#</th>
                            <th><strong>{{ __('admin.image') }}</strong></th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'place' ? 'Desc' : '' }}=place">
                                    <i class="fa fa-sort{{ request('sortBy') == 'place' ? '-asc' : (request('sortByDesc') == 'place' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.place') }}</strong>
                            </th>
                            <th><strong>{{ __('admin.order') }}</strong></th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'is_published' ? 'Desc' : '' }}=is_published">
                                    <i class="fa fa-sort{{ request('sortBy') == 'is_published' ? '-asc' : (request('sortByDesc') == 'is_published' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.status') }}</strong>
                            </th>
                            <th>{{ __('admin.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sliders as $key => $slider)
                            <tr>
                                <td><small>{{ ++$key }}</small></td>
                                <td>
                                    <img src="{{ asset(Storage::url($slider->media)) }}" class="rounded-lg" width="150" alt=""/>
                                </td>
                                <td><small>{{ Str::ucFirst($slider->place) }}</small></td>
                                <td><small>{{ $slider->order }}</small></td>
                                <td>
                                    <small class="d-flex align-items-center">
                                        <i class="fa fa-circle text-{{ $slider->is_published == 'published' ? 'success' : 'dark' }} mr-1"></i>
                                        <span>{{ __('admin.' . $slider->is_published) }}</span>
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('slider.edit', $slider) }}" class="btn btn-info shadow btn-xs sharp mr-1">
                                            <i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger shadow btn-xs sharp mr-1" onclick='confirmDelete("{{ $slider->id }}")'>
                                            <i class="fa fa-trash"></i></button>
                                        <a href="#" target="_blank" class="btn btn-dark shadow btn-xs sharp">
                                            <i class="fa fa-eye"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="py-2">{{ trans_choice('admin.pagination_info', $sliders->count(), ['items' => $sliders->count(), 'total' => $sliders->count()]) }}</div>
        </div>
    </div>
    <form method="POST" action="{{ route('slider.delete') }}" id="form-delete" class="d-none">
        @csrf
        @method('DELETE')
        <input type="hidden" name="delete" value="">
    </form>
@endsection

@section('script')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script>
        function confirmDelete(value) {
            let form = document.forms['form-delete'];
            form['delete'].value = value;
            event.preventDefault()
            Swal.fire({
                title: "{!! __('admin.confirm_sure') !!}",
                text: "{!! __('admin.confirm_msg') !!}",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dd6b55",
                confirmButtonText: "{!! __('admin.confirm_delete_it') !!}",
                cancelButtonText: "{!! __('admin.cancel') !!}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        // Swal.fire(
                        //     "Deleted!",
                        //     "Your file has been deleted.",
                        //     "success"
                        // )
                    }
            })
        }
    </script>
@endsection
