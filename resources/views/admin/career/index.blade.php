@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="career-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('admin.career_accept') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="basic-form">
                    <form method="POST" action="">
                        <div class="modal-body">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="text-label" for="reply-msg">{{ __('admin.reply_msg') }}:</label>
                                <textarea class="form-control" name="reply_msg" id="reply-msg" rows="2"
                                            required>{{ old('reply_msg') }}</textarea>
                                <input type="hidden" name="career_id" value="">
                                <input type="hidden" name="career_name" value="">
                                <input type="hidden" name="career_email" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success btn-sm mr-2">{{ __('admin.accept') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @error('reply_msg')
        <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
    @enderror

    <div class="card">
        <div class="card-header flex-column flex-sm-row">
            <h4 class="card-title">{{ __('admin.careers') }}</h4>
            <div class="filter d-flex flex-wrap">
                <a href="{{ route('career.index') }}" class="btn {{!request('status') ? 'btn-primary' : 'btn-info'}} btn-xs m-1">
                    <span>{{ __('admin.all') }}</span>
                    <span class="badge badge-light">{{ $careers_count }}</span>
                </a>
                <a href="{{ route('career.index', ['status' => 'pending']) }}" class="btn {{request('status') == 'pending' ? 'btn-primary' : 'btn-info'}} btn-xs m-1">
                    <span>{{ __('admin.pending') }}</span>
                    <span class="badge badge-light">{{ $pending_count }}</span>
                </a>
                <a href="{{ route('career.index', ['status' => 'accepted']) }}" class="btn {{request('status') == 'accepted' ? 'btn-primary' : 'btn-info'}} btn-xs m-1">
                    <span>{{ __('admin.accepted') }}</span>
                    <span class="badge badge-success">{{ $accepted_count }}</span>
                </a>
                <a href="{{ route('career.index', ['status' => 'rejected']) }}" class="btn {{request('status') == 'rejected' ? 'btn-primary' : 'btn-info'}} btn-xs m-1">
                    <span>{{ __('admin.rejected') }}</span>
                    <span class="badge badge-warning">{{ $rejected_count }}</span>
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
                                <a class="text-white" href="{{ route('career.index', array_merge(request()->only(['status']), [(request('sortBy') == 'name' ? 'sortByDesc' : 'sortBy') => 'name'])) }}">
                                    <i class="fa fa-sort{{ request('sortBy') == 'name' ? '-asc' : (request('sortByDesc') == 'name' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.name') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="{{ route('career.index', array_merge(request()->only(['status']), [(request('sortBy') == 'email' ? 'sortByDesc' : 'sortBy') => 'email'])) }}">
                                    <i class="fa fa-sort{{ request('sortBy') == 'email' ? '-asc' : (request('sortByDesc') == 'email' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.email') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="{{ route('career.index', array_merge(request()->only(['status']), [(request('sortBy') == 'phone' ? 'sortByDesc' : 'sortBy') => 'phone'])) }}">
                                    <i class="fa fa-sort{{ request('sortBy') == 'phone' ? '-asc' : (request('sortByDesc') == 'phone' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.phone') }}</strong>
                            </th>
                            <th><strong>{{ __('admin.cv') }}</strong></th>
                            <th>
                                <a class="text-white" href="{{ route('career.index', array_merge(request()->only(['status']), [(request('sortBy') == 'created_at' ? 'sortByDesc' : 'sortBy') => 'created_at'])) }}">
                                    <i class="fa fa-sort{{ request('sortBy') == 'created_at' ? '-asc' : (request('sortByDesc') == 'created_at' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.date') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="{{ route('career.index', array_merge(request()->only(['status']), [(request('sortBy') == 'status' ? 'sortByDesc' : 'sortBy') => 'status'])) }}">
                                    <i class="fa fa-sort{{ request('sortBy') == 'status' ? '-asc' : (request('sortByDesc') == 'status' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.status') }}</strong>
                            </th>
                            <th>
                                <a class="text-white" href="{{ route('career.index', array_merge(request()->only(['status']), [(request('sortBy') == 'response_by' ? 'sortByDesc' : 'sortBy') => 'response_by'])) }}">
                                    <i class="fa fa-sort{{ request('sortBy') == 'response_by' ? '-asc' : (request('sortByDesc') == 'response_by' ? '-desc' : '') }}"></i></a>
                                <strong>{{ __('admin.response_by') }}</strong>
                            </th>
                            <th>{{ __('admin.action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($careers as $key => $career)
                            <tr>
                                <td><small>{{ $careers->firstItem() + $key }}</small></td>
                                <td><small><strong>{{ $career->name }}</strong></small></td>
                                <td><small>{{ $career->email }}</small></td>
                                <td><small>{{ $career->phone }}</small></td>
                                <td><a href="{{ asset(Storage::url($career->attachment)) }}" class="btn btn-info btn-xs">{{ __('admin.download') }}</a></td>
                                <td><small>{{ Carbon::create($career->created_at)->locale('en')->isoFormat('ll') }}</small></td>
                                <td>
                                    <small class="d-flex align-items-center">
                                        @if ($career->status == 'pending')
                                            <i class="fa fa-circle text-light mr-1"></i> <span>{{ __('admin.pending') }}</span>
                                        @elseif ($career->status == 'accepted')
                                            <i class="fa fa-circle text-success mr-1"></i> <span>{{ __('admin.accepted') }}</span>
                                        @elseif ($career->status == 'rejected')
                                            <i class="fa fa-circle text-warning mr-1"></i> <span>{{ __('admin.rejected') }}</span>
                                        @endif
                                    </small>
                                </td>
                                <td><small>{{ $career->response_by ? App\Models\User::find($career->response_by)->name : '' }}</small></td>
                                <td>
                                    <div class="d-flex">
                                        @if ($career->status == 'pending')
                                            <button class="btn btn-success shadow btn-xs sharp mr-1"
                                                    data-toggle="modal" data-target="#career-modal"
                                                    data-id="{{ $career->id }}"
                                                    data-name="{{ $career->name }}"
                                                    data-email="{{ $career->email }}"
                                                    data-route="{{ route('career.accept') }}">
                                                <i class="fa fa-check"></i></button>
                                            <button class="btn btn-warning shadow btn-xs sharp mr-1"
                                                    data-toggle="modal" data-target="#career-modal"
                                                    data-id="{{ $career->id }}"
                                                    data-name="{{ $career->name }}"
                                                    data-email="{{ $career->email }}"
                                                    data-route="{{ route('career.reject') }}">
                                                <i class="fa fa-times"></i></button>
                                        @endif
                                        <button class="btn btn-danger shadow btn-xs sharp mr-1" onclick="confirmDelete({{ $career->id }})">
                                            <i class="fa fa-trash"></i></button>
                                        <a href="{{ route('career.show', $career) }}" class="btn btn-dark shadow btn-xs sharp">
                                            <i class="fa fa-eye"></i></a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="py-2">{{ trans_choice('admin.pagination_info', $careers->total(), ['items' => $careers->count(), 'total' => $careers->total()]) }}</div>
            <div>{{ $careers->links() }}</div>
        </div>
    </div>
    <form method="POST" action="{{ route('career.destroy') }}" id="form-delete" class="d-none">
        @csrf
        @method('DELETE')
        <input type="hidden" name="delete" value="">
    </form>
@endsection

@section('script')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script>
        // Modal Career Accept
        $("#career-modal").on("show.bs.modal", function (event) {
            let btnEdit = event.relatedTarget;
            $(this).find("form").attr("action", $(btnEdit).data("route"));
            $(this).find("[name=career_id]").val($(btnEdit).data("id"));
            $(this).find("[name=career_name]").val($(btnEdit).data("name"));
            $(this).find("[name=career_email]").val($(btnEdit).data("email"));
            if ($(btnEdit).hasClass("btn-success")) {
                $(this).find(".modal-title").text("{{ __('admin.job_accept') }}");
                $(this).find("[name=reply_msg]").val("{{ __('admin.job_accept_reply_msg') }}");
                $(this).find("[type=submit]").text("{{ __('admin.accept') }}").addClass("btn-success").removeClass("btn-warning");
            } else {
                $(this).find(".modal-title").text("{{ __('admin.job_reject') }}");
                $(this).find("[name=reply_msg]").val("{{ __('admin.job_reject_reply_msg') }}");
                $(this).find("[type=submit]").text("{{ __('admin.reject') }}").addClass("btn-warning").removeClass("btn-success");
            }
        })
        $("#career-modal").on("hidden.bs.modal", function () {
            $(this).find("[name^=career]").val("");
            $(this).find("[name=reply_msg]").val("");
        })

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
