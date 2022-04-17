@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.pages') }}</h4>
            <a href="{{ route('page.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-responsive-md">
                    <thead class="thead-primary">
                        <tr>
                            <th>#</th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'title' ? 'Desc' : '' }}=title">
                                    <i class="fa fa-sort{{ request('sortBy') == 'title' ? '-asc' : (request('sortByDesc') == 'title' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.title') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'author' ? 'Desc' : '' }}=author">
                                    <i class="fa fa-sort{{ request('sortBy') == 'author' ? '-asc' : (request('sortByDesc') == 'author' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.author') }}</strong>
                            </th>
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
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'view_count' ? 'Desc' : '' }}=view_count">
                                    <i class="fa fa-sort{{ request('sortBy') == 'view_count' ? '-asc' : (request('sortByDesc') == 'view_count' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.views') }}</strong>
                            </th>
                            <th>{{ __('admin.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pages as $key => $page)
                            <tr>
                                <td><small>{{ $pages->firstItem() + $key }}</small></td>
                                <td><small><strong>{{ $page->title }}</strong></small></td>
                                <td><small>{{ $page->user->name }}</small></td>
                                <td>
                                    <img src="{{ asset(Storage::url($page->image)) }}" class="rounded-lg" width="80" alt=""/>
                                </td>
                                <td><small>{{ Carbon::create($page->created_at)->locale('en')->isoFormat('ll') }}</small></td>
                                <td>
                                    <small class="d-flex align-items-center">
                                        @if ($page->is_published)
                                            <i class="fa fa-circle text-success mr-1"></i> <span>{{ __('admin.published') }}</span>
                                        @else
                                            <i class="fa fa-circle text-dark mr-1"></i> <span>{{ __('admin.unpublished') }}</span>
                                        @endif
                                    </small>
                                </td>
                                <td><small>{{ $page->view_count }}</small></td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('page.edit', $page) }}" class="btn btn-info shadow btn-xs sharp mr-1">
                                            <i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger shadow btn-xs sharp mr-1" onclick="confirmDelete({{ $page->id }})">
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
            <div class="py-2">{{ trans_choice('admin.pagination_info', $pages->total(), ['items' => $pages->count(), 'total' => $pages->total()]) }}</div>
            <div>{{ $pages->links() }}</div>
        </div>
    </div>
    <form method="POST" action="{{ route('page.delete') }}" id="form-delete" class="d-none">
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
