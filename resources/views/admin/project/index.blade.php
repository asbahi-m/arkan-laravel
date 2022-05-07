@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.projects') }}</h4>
            <a href="{{ route('project.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
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
                                <strong>{{ __('admin.name') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'type_name' ? 'Desc' : '' }}=type_name">
                                    <i class="fa fa-sort{{ request('sortBy') == 'type_name' ? '-asc' : (request('sortByDesc') == 'type_name' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.type') }}</strong>
                            </th>
                            {{-- <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'description' ? 'Desc' : '' }}=description">
                                    <i class="fa fa-sort{{ request('sortBy') == 'description' ? '-asc' : (request('sortByDesc') == 'description' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.description') }}</strong>
                            </th> --}}
                            <th><strong>{{ __('admin.image') }}</strong></th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'created_at' ? 'Desc' : '' }}=created_at">
                                    <i class="fa fa-sort{{ request('sortBy') == 'created_at' ? '-asc' : (request('sortByDesc') == 'created_at' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.date') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'is_published' ? 'Desc' : '' }}=is_published">
                                    <i class="fa fa-sort{{ request('sortBy') == 'is_published' ? '-asc' : (request('sortByDesc') == 'is_published' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.status') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'views_count' ? 'Desc' : '' }}=views_count">
                                    <i class="fa fa-sort{{ request('sortBy') == 'views_count' ? '-asc' : (request('sortByDesc') == 'views_count' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.views') }}</strong>
                            </th>
                            <th>{{ __('admin.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $key => $project)
                            <tr>
                                <td><small>{{ $projects->firstItem() + $key }}</small></td>
                                <td><small><strong>{{ $project->name }}</strong></small></td>
                                <td><small>{{ $project->type ? Str::upper($project->type_name) : '' }}</small></td>
                                {{-- <td style="width: 33.33%">
                                    <small>{{ Str::limit(strip_tags($project->description), '80', '...') }}</small>
                                </td> --}}
                                <td>
                                    <img src="{{ asset(Storage::url($project->image)) }}" class="rounded-lg" width="80" alt=""/>
                                </td>
                                <td><small>{{ Carbon::create($project->created_at)->locale(app()->getLocale())->isoFormat('ll') }}</small></td>
                                <td>
                                    <small class="d-flex align-items-center">
                                        <i class="fa fa-circle text-{{ $project->is_published == 'published' ? 'success' : 'dark' }} mr-1"></i>
                                        <span>{{ __('admin.' . $project->is_published) }}</span>
                                    </small>
                                </td>
                                <td><small>{{ $project->views_count }}</small></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('project.edit', $project) }}" class="btn btn-info shadow btn-xs sharp mr-1">
                                            <i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger shadow btn-xs sharp mr-1" onclick='confirmDelete("{{ $project->id }}")'>
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
            <div class="py-2">{{ trans_choice('admin.pagination_info', $projects->total(), ['items' => $projects->count(), 'total' => $projects->total()]) }}</div>
            <div>{{ $projects->links() }}</div>
        </div>
    </div>
    <form method="POST" action="{{ route('project.delete') }}" id="form-delete" class="d-none">
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
