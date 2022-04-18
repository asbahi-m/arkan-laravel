@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">{{ __('admin.users') }}</h4>
            <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
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
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'email' ? 'Desc' : '' }}=email">
                                    <i class="fa fa-sort{{ request('sortBy') == 'email' ? '-asc' : (request('sortByDesc') == 'email' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.email') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'email_verified_at' ? 'Desc' : '' }}=email_verified_at">
                                    <i class="fa fa-sort{{ request('sortBy') == 'email_verified_at' ? '-asc' : (request('sortByDesc') == 'email_verified_at' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.status') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="?sortBy{{ request('sortBy') == 'is_super_admin' ? 'Desc' : '' }}=is_super_admin">
                                    <i class="fa fa-sort{{ request('sortBy') == 'is_super_admin' ? '-asc' : (request('sortByDesc') == 'is_super_admin' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.role') }}</strong>
                            </th>
                            <th>{{ __('admin.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $key => $user)
                            <tr>
                                <td><small>{{ $users->firstItem() + $key }}</small></td>
                                <td>
                                    <img class="img-thumbnail rounded-circle" style="width: 80px; max-height: 80px"
                                            src="{{ $user->profile_photo_path ? asset(Storage::url($user->profile_photo_path)) : asset('admin/images/user.png') }}" alt="">
                                    <small><strong>{{ $user->name }}</strong></small>
                                </td>
                                <td><small>{{ $user->email }}</small></td>
                                <td>
                                    <small class="d-flex align-items-center">
                                        @if ($user->email_verified_at)
                                            <i class="fa fa-circle text-success mr-1"></i> <span>{{ __('admin.verified') }}</span>
                                        @else
                                            <i class="fa fa-circle text-dark mr-1"></i> <span>{{ __('admin.unverified') }}</span>
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <small class="d-flex align-items-center">
                                        @if ($user->is_super_admin)
                                            <span>{{ __('admin.super_admin') }}</span>
                                        @else
                                            <span>{{ __('admin.admin') }}</span>
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <a href="{{ route('user.edit', $user) }}" class="btn btn-info shadow btn-xs sharp mr-1">
                                            <i class="fa fa-pencil"></i></a>
                                        <button class="btn btn-danger shadow btn-xs sharp mr-1" onclick="confirmDelete({{ $user->id }})">
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
            <div class="py-2">{{ trans_choice('admin.pagination_info', $users->total(), ['items' => $users->count(), 'total' => $users->total()]) }}</div>
            <div>{{ $users->links() }}</div>
        </div>
    </div>
    <form method="POST" action="{{ route('user.destroy', 1) }}" id="form-delete" class="d-none">
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
