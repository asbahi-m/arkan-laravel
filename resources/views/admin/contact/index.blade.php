@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <div class="card">
        <div class="card-header flex-column flex-sm-row">
            <h4 class="card-title">{{ __('admin.messages') }}</h4>
            <div class="filter d-flex flex-wrap">
                <a href="{{ route('contact.index') }}" class="btn {{!request('status') ? 'btn-primary' : 'btn-info'}} btn-xs m-1">
                    <span>{{ __('admin.all') }}</span>
                    <span class="badge badge-light">{{ $msgs_count }}</span>
                </a>
                <a href="{{ route('contact.index', ['status' => 'unread']) }}" class="btn {{request('status') == 'unread' ? 'btn-primary' : 'btn-info'}} btn-xs m-1">
                    <span>{{ __('admin.unread') }}</span>
                    <span class="badge badge-light">{{ $unread_count }}</span>
                </a>
                <a href="{{ route('contact.index', ['status' => 'read']) }}" class="btn {{request('status') == 'read' ? 'btn-primary' : 'btn-info'}} btn-xs m-1">
                    <span>{{ __('admin.read') }}</span>
                    <span class="badge badge-success">{{ $read_count }}</span>
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-responsive-md">
                    <thead class="thead-primary">
                        <tr>
                            <th>#</th>
                            <th>
                                <a class="text-white" href="{{ route('contact.index', array_merge(request()->only(['status']), [(request('sortBy') == 'name' ? 'sortByDesc' : 'sortBy') => 'name'])) }}">
                                    <i class="fa fa-sort{{ request('sortBy') == 'name' ? '-asc' : (request('sortByDesc') == 'name' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.name') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="{{ route('contact.index', array_merge(request()->only(['status']), [(request('sortBy') == 'email' ? 'sortByDesc' : 'sortBy') => 'email'])) }}">
                                    <i class="fa fa-sort{{ request('sortBy') == 'email' ? '-asc' : (request('sortByDesc') == 'email' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.email') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="{{ route('contact.index', array_merge(request()->only(['status']), [(request('sortBy') == 'phone' ? 'sortByDesc' : 'sortBy') => 'phone'])) }}">
                                    <i class="fa fa-sort{{ request('sortBy') == 'phone' ? '-asc' : (request('sortByDesc') == 'phone' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.phone') }}</strong>
                            </th>
                            <th><strong>{{ __('admin.message') }}</strong></th>
                            <th>
                                <a class="text-white" href="{{ route('contact.index', array_merge(request()->only(['status']), [(request('sortBy') == 'created_at' ? 'sortByDesc' : 'sortBy') => 'created_at'])) }}">
                                    <i class="fa fa-sort{{ request('sortBy') == 'created_at' ? '-asc' : (request('sortByDesc') == 'created_at' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.date') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="{{ route('contact.index', array_merge(request()->only(['status']), [(request('sortBy') == 'status' ? 'sortByDesc' : 'sortBy') => 'status'])) }}">
                                    <i class="fa fa-sort{{ request('sortBy') == 'status' ? '-asc' : (request('sortByDesc') == 'status' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.status') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="{{ route('contact.index', array_merge(request()->only(['status']), [(request('sortBy') == 'response_by' ? 'sortByDesc' : 'sortBy') => 'response_by'])) }}">
                                    <i class="fa fa-sort{{ request('sortBy') == 'response_by' ? '-asc' : (request('sortByDesc') == 'response_by' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.response_by') }}</strong>
                            </th>
                            <th>{{ __('admin.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $key => $contact)
                            <tr>
                                <td><small>{{ $contacts->firstItem() + $key }}</small></td>
                                <td><small><strong>{{ $contact->name }}</strong></small></td>
                                <td><small>{{ $contact->email }}</small></td>
                                <td><small>{{ $contact->phone }}</small></td>
                                <td style="width: 33.33%">
                                    <small>{{ Str::limit(strip_tags($contact->message), '80', '...') }}</small>
                                </td>
                                <td><small>{{ Carbon::create($contact->created_at)->locale('en')->isoFormat('ll') }}</small></td>
                                <td>
                                    <small class="d-flex align-items-center">
                                        @if ($contact->status == 'unread')
                                            <i class="fa fa-circle text-light mr-1"></i> <span>{{ __('admin.unread') }}</span>
                                        @else
                                            <i class="fa fa-circle text-success mr-1"></i> <span>{{ __('admin.read') }}</span>
                                        @endif
                                    </small>
                                </td>
                                <td><small>{{ $contact->response_by ? App\Models\User::find($contact->response_by)->name : '' }}</small></td>
                                <td>
                                    <div class="d-flex">
                                        <button class="btn btn-danger shadow btn-xs sharp mr-1" onclick="confirmDelete({{ $contact->id }})">
                                            <i class="fa fa-trash"></i></button>
                                        <a href="{{ route('contact.show', $contact) }}" class="btn btn-dark shadow btn-xs sharp">
                                            <i class="fa fa-eye"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="py-2">{{ trans_choice('admin.pagination_info', $contacts->total(), ['items' => $contacts->count(), 'total' => $contacts->total()]) }}</div>
            <div>{{ $contacts->links() }}</div>
        </div>
    </div>
    <form method="POST" action="{{ route('contact.delete') }}" id="form-delete" class="d-none">
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
