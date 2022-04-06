@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.services') }}</h4>
            <a href="{{ route('service.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-responsive-md">
                    <thead class="thead-primary">
                        <tr>
                            <th>#</th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'name' ? 'Desc' : '' }}=name">
                                    <i class="fa fa-sort{{ request('sortBy') == 'name' ? '-asc' : (request('sortByDesc') == 'name' ? '-desc' : '') }}"></i></a>
                                <strong>Name</strong>
                            </th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'type' ? 'Desc' : '' }}=type">
                                    <i class="fa fa-sort{{ request('sortBy') == 'type' ? '-asc' : (request('sortByDesc') == 'type' ? '-desc' : '') }}"></i></a>
                                <strong>Type</strong>
                            </th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'description' ? 'Desc' : '' }}=description">
                                    <i class="fa fa-sort{{ request('sortBy') == 'description' ? '-asc' : (request('sortByDesc') == 'description' ? '-desc' : '') }}"></i></a>
                                <strong>Description</strong>
                            </th>
                            <th><strong>Image</strong></th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'created_at' ? 'Desc' : '' }}=created_at">
                                    <i class="fa fa-sort{{ request('sortBy') == 'created_at' ? '-asc' : (request('sortByDesc') == 'created_at' ? '-desc' : '') }}"></i></a>
                                <strong>Date</strong>
                            </th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'is_published' ? 'Desc' : '' }}=is_published">
                                    <i class="fa fa-sort{{ request('sortBy') == 'is_published' ? '-asc' : (request('sortByDesc') == 'is_published' ? '-desc' : '') }}"></i></a>
                                <strong>Status</strong>
                            </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($services as $key => $service)
                            <tr>
                                <td><small>{{ $services->firstItem() + $key }}</small></td>
                                <td><small><strong>{{ $service->name }}</strong></small></td>
                                <td><small>{{ $service->type ? Str::upper($service->type->name) : '' }}</small></td>
                                <td style="width: 33.33%">
                                    <small>{{ Str::limit(strip_tags($service->description), '80', '...') }}</small>
                                </td>
                                <td>
                                    <img src="{{ asset(Storage::url($service->image)) }}" class="rounded-lg" width="80" alt=""/>
                                </td>
                                <td><small>{{ Carbon::create($service->created_at)->locale('en')->isoFormat('ll') }}</small></td>
                                <td>
                                    <small class="d-flex align-items-center">
                                        @if ($service->is_published)
                                            <i class="fa fa-circle text-success mr-1"></i> <span>{{ __('admin.published') }}</span>
                                        @else
                                            <i class="fa fa-circle text-dark mr-1"></i> <span>{{ __('admin.unpublished') }}</span>
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('service.edit', $service) }}" class="btn btn-info shadow btn-xs sharp mr-1">
                                            <i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger shadow btn-xs sharp mr-1" onclick="confirmDelete({{ $service->id }})">
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
            <div class="py-2">Showing {{ $services->count() }} of {{ $services->total() }} results</div>
            <div>{{ $services->links() }}</div>
        </div>
    </div>
    <form methods="GET" action="{{ route('service.delete') }}" id="form-delete" class="d-none">
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
