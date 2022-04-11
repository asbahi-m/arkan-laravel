@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('contact.index') }}">{{ __('admin.messages') }}</a></li>
        </ul>
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="reply-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('admin.reply') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="basic-form">
                    <form method="POST" action="{{ route('contact.reply') }}">
                        <div class="modal-body">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="text-label" for="reply-msg">{{ __('admin.reply_msg') }}:</label>
                                <textarea class="form-control" name="reply_msg" id="reply-msg" rows="2"
                                            required>{{ old('reply_msg') }}</textarea>
                                <input type="hidden" name="contact_id" value="">
                                <input type="hidden" name="contact_name" value="">
                                <input type="hidden" name="contact_email" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info btn-sm mr-2">{{ __('admin.reply') }}</button>
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
            <h4>{{ __('admin.message_number') }} {{ $contact->id }}</h4>
            <span>{{ $contact->created_at }}</span>
            <strong>{{ __('admin.status') }}:
                <span class="badge badge-{{ $contact->status == 'read' ? 'success' : 'light' }}">{{ __('admin.' . $contact->status) }}</span>
            </strong>
        </div>
        <div class="card-body">
            <div class="list-group list-group-flush">
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.name') }}:</span>
                    <span class="col">{{ $contact->name }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.email') }}:</span>
                    <a class="col" href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.phone') }}:</span>
                    <span class="col">{{ $contact->phone }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.message') }}:</span>
                    <span class="col">{{ $contact->message }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.response_by') }}:</span>
                    <span class="col">{{ $contact->response_by ? App\Models\User::find($contact->response_by)->name : '' }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.response_date') }}:</span>
                    <span class="col">{{ $contact->response_by ? $contact->updated_at : '' }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.reply_msg') }}:</span>
                    <span class="col">{{ $contact->reply_msg }}</span>
                </li>
            </div>
        </div>
        <div class="card-footer">
            @if (!$contact->reply_msg)
                <button class="btn btn-info shadow btn-sm sharp mr-1"
                        data-toggle="modal" data-target="#reply-modal"
                        data-id="{{ $contact->id }}"
                        data-name="{{ $contact->name }}"
                        data-email="{{ $contact->email }}">
                    <i class="fa fa-reply"></i> {{ __('admin.reply') }}</button>
            @endif
            <button class="btn btn-danger btn-sm shadow sharp mr-1" onclick="confirmDelete({{ $contact->id }})">
                <i class="fa fa-trash"></i> {{ __('admin.delete') }}</button>
        </div>
        <form method="POST" action="{{ route('contact.destroy') }}" id="form-delete" class="d-none">
            @csrf
            @method('DELETE')
            <input type="hidden" name="delete" value="">
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script>
        // Modal Reply Message
        $("#reply-modal").on("show.bs.modal", function (event) {
            let btnEdit = event.relatedTarget;
            $(this).find("form").attr("action", $(btnEdit).data("route"));
            $(this).find("[name=contact_id]").val($(btnEdit).data("id"));
            $(this).find("[name=contact_name]").val($(btnEdit).data("name"));
            $(this).find("[name=contact_email]").val($(btnEdit).data("email"));
        })
        $("#reply-modal").on("hidden.bs.modal", function () {
            $(this).find("[name^=contact]").val("");
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
