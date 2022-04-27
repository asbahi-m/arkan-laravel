@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('order.index') }}">{{ __('admin.orders') }}</a></li>
        </ul>
    </div>

    <!-- Order Modal -->
    <div class="modal fade" id="order-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('admin.order_accept') }}</h5>
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
                                <input type="hidden" name="order_id" value="">
                                <input type="hidden" name="order_name" value="">
                                <input type="hidden" name="order_email" value="">
                                <input type="hidden" name="order_service" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success btn-sm mr-2">{{ __('admin.accept') }}</button>
                            <button type="button" class="btn btn-danger btn-sm light" data-dismiss="modal">{{ __('admin.close' )}}</button>
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
            <h4>{{ __('admin.order_number') }} {{ $order->id }}</h4>
            <span>{{ $order->created_at }}</span>
            <strong>{{ __('admin.status') }}:
                <span class="badge badge-{{
                    $order->status == 'accepted' ? 'success' : ($order->status == 'rejected' ? 'warning' : 'light')
                }}">{{ __('admin.' . $order->status) }}</span>
            </strong>
        </div>
        <div class="card-body">
            <div class="list-group list-group-flush">
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.name') }}:</span>
                    <span class="col">{{ $order->name }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.email') }}:</span>
                    <a class="col" href="mailto:{{ $order->email }}">{{ $order->email }}</a>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.phone') }}:</span>
                    <span class="col">{{ $order->phone }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.service') }}:</span>
                    <span class="col">{{ $order->service->name }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.response_by') }}:</span>
                    <span class="col">{{ $order->response_by ? App\Models\User::find($order->response_by)->name : '' }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.response_date') }}:</span>
                    <span class="col">{{ $order->response_by ? $order->updated_at : '' }}</span>
                </li>
                <li class="list-group-item d-flex flex-wrap">
                    <span class="col-auto col-sm-5 col-md-4 col-lg-3 text-light">{{ __('admin.reply_msg') }}:</span>
                    <span class="col">{{ $order->reply_msg }}</span>
                </li>
            </div>
        </div>
        <div class="card-footer">
            @if ($order->status == 'pending')
                <button class="btn btn-success shadow btn-sm sharp mr-1"
                        data-toggle="modal" data-target="#order-modal"
                        data-id="{{ $order->id }}"
                        data-name="{{ $order->name }}"
                        data-email="{{ $order->email }}"
                        data-service="{{ $order->service->name }}"
                        data-route="{{ route('order.accept') }}">
                    <i class="fa fa-check"></i> {{ __('admin.accept') }}</button>
                <button class="btn btn-warning shadow btn-sm sharp mr-1"
                        data-toggle="modal" data-target="#order-modal"
                        data-id="{{ $order->id }}"
                        data-name="{{ $order->name }}"
                        data-email="{{ $order->email }}"
                        data-service="{{ $order->service->name }}"
                        data-route="{{ route('order.reject') }}">
                    <i class="fa fa-times"></i> {{ __('admin.reject') }}</button>
            @endif
            <button class="btn btn-danger btn-sm shadow sharp mr-1" onclick="confirmDelete({{ $order->id }})">
                <i class="fa fa-trash"></i> {{ __('admin.delete') }}</button>
        </div>
        <form method="POST" action="{{ route('order.delete') }}" id="form-delete" class="d-none">
            @csrf
            @method('DELETE')
            <input type="hidden" name="delete" value="">
        </form>
    </div>
@endsection

@section('script')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script>
        // Modal Order Accept
        $("#order-modal").on("show.bs.modal", function (event) {
            let btnEdit = event.relatedTarget;
            $(this).find("form").attr("action", $(btnEdit).data("route"));
            $(this).find("[name=order_id]").val($(btnEdit).data("id"));
            $(this).find("[name=order_name]").val($(btnEdit).data("name"));
            $(this).find("[name=order_email]").val($(btnEdit).data("email"));
            $(this).find("[name=order_service]").val($(btnEdit).data("service"));
            if ($(btnEdit).hasClass("btn-success")) {
                $(this).find(".modal-title").text("{{ __('admin.order_accept') }}");
                $(this).find("[name=reply_msg]").val("{{ __('admin.order_accept_reply_msg') }}");
                $(this).find("[type=submit]").text("{{ __('admin.accept') }}").addClass("btn-success").removeClass("btn-warning");
            } else {
                $(this).find(".modal-title").text("{{ __('admin.order_reject') }}");
                $(this).find("[name=reply_msg]").val("{{ __('admin.order_reject_reply_msg') }}");
                $(this).find("[type=submit]").text("{{ __('admin.reject') }}").addClass("btn-warning").removeClass("btn-success");
            }
        })
        $("#order-modal").on("hidden.bs.modal", function () {
            $(this).find("[name^=order]").val("");
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
