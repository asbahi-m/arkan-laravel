@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('career.index') }}">{{ __('admin.careers') }}</a></li>
        </ul>
    </div>

    <!-- Career Modal -->
    <div class="modal fade" id="career-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('admin.career_accept') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
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
            <h4>{{ __('admin.career_number') }} {{ $career->id }}</h4>
            <span>{{ $career->created_at }}</span>
            <strong>{{ __('admin.status') }}:
                <span class="badge badge-{{
                    $career->status == 'accepted' ? 'success' : ($career->status == 'rejected' ? 'warning' : 'light')
                }}">{{ __('admin.' . $career->status) }}</span>
            </strong>
        </div>
        <div class="card-body">
            <div class="list-group list-group-flush">
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.name') }}:</span>
                    <span class="col">{{ $career->name }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.email') }}:</span>
                    <a class="col" href="mailto:{{ $career->email }}">{{ $career->email }}</a>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.phone') }}:</span>
                    <span class="col">{{ $career->phone }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.cv') }}:</span>
                    <span class="col"><a href="{{ asset(Storage::url($career->attachment)) }}" class="btn btn-info btn-xs">{{ __('admin.download') }}</a></span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.message') }}:</span>
                    <span class="col">{{ $career->message }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.response_by') }}:</span>
                    <span class="col">{{ $career->response_by ? App\Models\User::find($career->response_by)->name : '' }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.response_date') }}:</span>
                    <span class="col">{{ $career->response_by ? $career->updated_at : '' }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.reply_msg') }}:</span>
                    <span class="col">{{ $career->reply_msg }}</span>
                </li>
            </div>
        </div>
        <div class="card-footer">
            @if ($career->status == 'pending')
                <button class="btn btn-success shadow btn-sm sharp mr-1"
                        data-toggle="modal" data-target="#career-modal"
                        data-id="{{ $career->id }}"
                        data-name="{{ $career->name }}"
                        data-email="{{ $career->email }}"
                        data-route="{{ route('career.accept') }}">
                    <i class="fa fa-check"></i> {{ __('admin.accept') }}</button>
                <button class="btn btn-warning shadow btn-sm sharp mr-1"
                        data-toggle="modal" data-target="#career-modal"
                        data-id="{{ $career->id }}"
                        data-name="{{ $career->name }}"
                        data-email="{{ $career->email }}"
                        data-route="{{ route('career.reject') }}">
                    <i class="fa fa-times"></i> {{ __('admin.reject') }}</button>
            @endif
            <button class="btn btn-danger btn-sm shadow sharp mr-1" onclick="confirmDelete({{ $career->id }})">
                <i class="fa fa-trash"></i> {{ __('admin.delete') }}</button>
        </div>
        <form method="POST" action="{{ route('career.delete') }}" id="form-delete" class="d-none">
            @csrf
            @method('DELETE')
            <input type="hidden" name="delete" value="">
        </form>
    </div>
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
