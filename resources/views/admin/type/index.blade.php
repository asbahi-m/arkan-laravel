@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="edit-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('admin.type_edit') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="basic-form">
                    <form method="POST" action="{{ route('type.update') }}">
                        <div class="modal-body">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label class="text-label" for="type-name">{{ __('admin.type_name') }}:</label>
                                <input type="text" id="type-name" class="form-control" name="type_name" value="" required>
                                <input type="hidden" name="type_id" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger btn-sm light" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-info btn-sm mr-2">{{ __('admin.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @error('type_name')
        <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
    @enderror

    <div class="row align-items-start">
        <!-- New Type Box -->
        <div class="col-xl-3 new-type-box">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('admin.type_add_new') }}</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="POST" action="{{ route('type.inline_store') }}">
                            @csrf
                            <!-- Type Name -->
                            <div class="form-group row">
                                <label class="text-label col-auto" for="type-name">{{ __('admin.type_name') }}:</label>
                                <div class="col-12 col-sm col-xl-12">
                                    <input type="text" id="type-name" class="form-control" name="name"
                                            value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback animated fadeInUp" style="display: block;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-primary btn-sm mr-2">{{ __('admin.create') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Types Table -->
        <div class="col types-table">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('admin.types') }}</h4>
                    <a href="#" class="btn border-light btn-sm add-type"><i class="fa fa-plus"></i></a>
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
                                        <a class="text-white" href="?sortBy{{ request('sortBy') == 'service' ? 'Desc' : '' }}=service">
                                            <i class="fa fa-sort{{ request('sortBy') == 'service' ? '-asc' : (request('sortByDesc') == 'service' ? '-desc' : '') }}"></i></a>
                                        <strong>{{ __('admin.services') }}</strong>
                                    </th>
                                    <th>
                                        <a class="text-white" href="?sortBy{{ request('sortBy') == 'product' ? 'Desc' : '' }}=product">
                                            <i class="fa fa-sort{{ request('sortBy') == 'product' ? '-asc' : (request('sortByDesc') == 'product' ? '-desc' : '') }}"></i></a>
                                        <strong>{{ __('admin.products') }}</strong>
                                    </th>
                                    <th>
                                        <a class="text-white" href="?sortBy{{ request('sortBy') == 'project' ? 'Desc' : '' }}=project">
                                            <i class="fa fa-sort{{ request('sortBy') == 'project' ? '-asc' : (request('sortByDesc') == 'project' ? '-desc' : '') }}"></i></a>
                                        <strong>{{ __('admin.projects') }}</strong>
                                    </th>
                                    <th>{{ __('admin.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($types as $key => $type)
                                    <tr>
                                        <td><small>{{ ++$key }}</small></td>
                                        <td><small><strong>{{ Str::upper($type->name) }}</strong></small></td>
                                        <td>{{ count($type->service) }}</td>
                                        <td>{{ count($type->product) }}</td>
                                        <td>{{ count($type->project) }}</td>
                                        <td>
                                            <div class="d-flex">
                                                <button class="btn btn-info shadow btn-xs sharp mr-1"
                                                        data-toggle="modal" data-target="#edit-modal"
                                                        data-name="{{ $type->name }}" data-id="{{ $type->id }}">
                                                    <i class="fa fa-pencil"></i></button>
                                                <button class="btn btn-danger shadow btn-xs sharp mr-1"
                                                        onclick="confirmDelete({{ $type->id }})">
                                                    <i class="fa fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="py-2">{{ trans_choice('admin.pagination_info2', count($types), ['items' => count($types), 'total' => count($types)]) }}</div>
                </div>
            </div>
            <form methods="GET" action="{{ route('type.delete') }}" id="form-delete" class="d-none">
                @method('DELETE')
                <input type="hidden" name="delete" value="">
            </form>
        </div>
    </div>

@endsection

@section('script')
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
    <script>
        // Modal Edit
        $("#edit-modal").on("show.bs.modal", function (event) {
            let btnEdit = event.relatedTarget;
            $(this).find("[name=type_name]").val($(btnEdit).data("name"));
            $(this).find("[name=type_id]").val($(btnEdit).data("id"));
        })
        $("#edit-modal").on("hidden.bs.modal", function () {
            $(this).find("[name=type_id]").val("");
        })

        $(document).ready(function () {
            $(".add-type").on("click", function () {
                $(this).toggleClass("btn-primary border-light");
                // $(".types-table").css("transition", "all 3s");
                $(".new-type-box").fadeToggle();

            })
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
