@extends('admin.layout')

@section('content')
    <div class="page-titles d-flex">
        <ul class="breadcrumb ml-auto">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('admin.dashboard') }}</a></li>
        </ul>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="edit-type" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ __('admin.type_edit') }}</h5>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="basic-form">
                    <form id="form-edit-type">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label class="text-label" for="edit-type-name">{{ __('admin.type_name') }}:</label>
                                @forelse ($locales as $locale)
                                    <div class="locale">
                                        <input type="text" id="edit-type-name" class="form-control" name="type_name[{{ $locale->short_sign }}]"
                                                lang="{{ $locale->short_sign }}" value="">
                                        <small>{{ $locale->short_sign }}</small>
                                    </div>
                                @empty
                                <input type="text" id="edit-type-name" class="form-control" name="type_name" value="" required>
                                @endforelse
                                <input type="hidden" name="type_id" value="">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info btn-sm mr-2">{{ __('admin.update') }}</button>
                            <button type="button" class="btn btn-danger btn-sm light" data-dismiss="modal">{{ __('admin.close' )}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row align-items-start">
        <!-- New Type Box -->
        <div class="col-xl-3 new-type-box">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('admin.type_add_new') }}</h4>
                </div>
                <div class="card-body">
                    <div class="basic-form">
                        <form id="form-add-type">
                            @csrf
                            <!-- Type Name -->
                            <div class="form-group row">
                                <label class="text-label col-auto" for="type-name">{{ __('admin.type_name') }}:</label>
                                <div class="col-12 col-sm col-xl-12">
                                    @forelse ($locales as $locale)
                                    <div class="locale">
                                        <input type="text" id="type-name" class="form-control" name="name[{{ $locale->short_sign }}]"
                                                lang="{{ $locale->short_sign }}" value="{{ old('name.' . $locale->short_sign) }}">
                                        <small>{{ $locale->short_sign }}</small>
                                    </div>
                                    @empty
                                    <input type="text" id="type-name" class="form-control" name="name"
                                            value="{{ old('name') }}" required>
                                    @endforelse
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
                    <a href="#" class="btn border-light btn-sm show-add-type"><i class="fa fa-plus"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-responsive-md">
                            <thead class="thead-primary">
                                <tr>
                                    <th>#</th>
                                    <th>
                                        <a type="button" class="sort" data-sort="name"><i class="fa fa-sort"></i></a>
                                        <strong>{{ __('admin.name') }}</strong>
                                    </th>
                                    <th>
                                        <a type="button" class="sort" data-sort="services"><i class="fa fa-sort"></i></a>
                                        <strong>{{ __('admin.services') }}</strong>
                                    </th>
                                    <th>
                                        <a type="button" class="sort" data-sort="products"><i class="fa fa-sort"></i></a>
                                        <strong>{{ __('admin.products') }}</strong>
                                    </th>
                                    <th>
                                        <a type="button" class="sort" data-sort="projects"><i class="fa fa-sort"></i></a>
                                        <strong>{{ __('admin.projects') }}</strong>
                                    </th>
                                    <th>{{ __('admin.action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @include('admin.type.row')
                            </tbody>
                        </table>
                    </div>
                    <div class="py-2">{{ trans_choice('admin.pagination_info', count($types), ['items' => count($types), 'total' => count($types)]) }}</div>
                </div>
            </div>
            <form id="form-delete" class="d-none">
                @csrf
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
        $("#edit-type").on("show.bs.modal", function (event) {
            let btnEdit = event.relatedTarget;
            let dataName = $(btnEdit).attr("data-name");
            if (isJson(dataName)) {
                let JSONTypeName = JSON.parse(dataName);
                for (const key in JSONTypeName) {
                    $(this).find(`[name='type_name[${key}]']`).val(JSONTypeName[key]);
                };
            } else {
                $(this).find("[name=type_name]").val(dataName);
            }
            $(this).find("[name=type_id]").val($(btnEdit).data("id"));
        })

        $("#edit-type").on("hidden.bs.modal", function () {
            $(this).find("[name=type_id]").val("");
            $(this).find("[name^=type_name]").val("");
        })

        $(".show-add-type").on("click", function () {
            $(this).toggleClass("btn-primary border-light");
            $(".new-type-box").fadeToggle();
        })

        // Sort Types By AJAX
        $("thead .sort").on("click", function (e) {
            e.preventDefault();

            $(this).toggleClass('desc');
            let data;
            if ($(this).hasClass('desc')) {
                data = {"sortBy": $(this).data("sort")};
                $(this).find("i").addClass("fa-sort-asc").removeClass("fa-sort");
            }
            else {
                data = {"sortByDesc": $(this).data("sort")};
                $(this).find("i").addClass("fa-sort-desc").removeClass("fa-sort fa-sort-asc");
            }

            $.ajax({
                type: "get",
                url: "{{ route('type.sort') }}",
                data: data,
                success: function (response) {
                    if (response.status) {
                        $("tbody").empty().html(response.data);
                        $(".index small").each(function (index) {
                            $(this).text(++index);
                        });
                    }
                },
                error: function (reject) {
                },
            })
        })

        // Add Type By AJAX
        $("#form-add-type").on("click", "[type=submit]", function (e) {
            e.preventDefault();

            // Remove All Error Message
            $(".invalid-feedback").remove();

            // Get Input Type Name;
            let form = $(e.delegateTarget)[0];
            let formData = new FormData(form);

            $.ajax({
                type: "post",
                url: "{{ route('type.inline_store') }}",
                // data: {
                //     "_token": "{{ csrf_token() }}",
                //     "name": name.val(),
                // },
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    if (data.status) {
                        swal.fire({
                            title: "{!! __('admin.type_add_success') !!}",
                            icon: "success",
                            timer: 1500,
                        });
                        $("tbody").prepend(data.row);
                        $(".index small").each(function (index) {
                            $(this).text(++index);
                        });
                        $("input[type=text]").val("");
                    }
                },
                error: function (reject) {
                    let errors = reject.responseJSON.errors;
                    for (const key in errors) {
                        let name = key;
                        let index = key.lastIndexOf('.');
                        if (index != -1) name = `${name.slice(0, index)}[${name.slice(index + 1)}]`;
                        $(`[name='${name}']`).after(`<div class="invalid-feedback animated fadeInUp" style="display: block;">
                            ${errors[key][0]}</div>`);
                    }
                },
            });
        })

        // Edit Type By AJAX
        $("#form-edit-type").on("click", "[type=submit]", function (e) {
            e.preventDefault();

            // Remove All Error Message
            $(".invalid-feedback").remove();

            // Get Inputs;
            let form = $(e.delegateTarget)[0];
            let formData = new FormData(form);

            $.ajax({
                type: "post",
                url: "{{ route('type.update') }}",
                // data: {
                //     "_token": "{{ csrf_token() }}",
                //     "type_id": id.val(),
                //     "type_name": name.val(),
                // },
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    if (data.status) {
                        $(".row-" + data.id + " .type-name strong").text(data.name.toUpperCase());
                        $("[data-dismiss='modal']").trigger('click');
                        $(".row-" + data.id + " button[data-name]").attr("data-name", data.t_types);
                    }
                },
                error: function (reject) {
                    let errors = reject.responseJSON.errors;
                    for (const key in errors) {
                        let name = key;
                        let index = key.lastIndexOf('.');
                        if (index != -1) name = `${name.slice(0, index)}[${name.slice(index + 1)}]`;
                        $(`[name='${name}']`).after(`<div class="invalid-feedback animated fadeInUp" style="display: block;">
                            ${errors[key][0]}</div>`);
                    }
                    // name.after(`<div class="invalid-feedback animated fadeInUp" style="display: block;">
                    //         ${errors.type_name[0]}</div>`);
                },
            });
        })

        // Delete Type By AJAX
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
                        // form.submit();
                        $.ajax({
                            type: "delete",
                            url: "{{ route('type.delete') }}",
                            data: {
                                '_token': "{{ csrf_token() }}",
                                'delete': value,
                            },
                            success: function (data) {
                                if (data.status) {
                                    Swal.fire({
                                        title: "{{ __('admin.deleted') }}",
                                        text: "{{ __('admin.type_delete_success') }}",
                                        timer: 1500,
                                        icon: "success",
                                    });
                                    $(".row-" + data.id).remove();
                                    $(".index small").each(function (index) {
                                        $(this).text(++index);
                                    });
                                }
                            },
                            error: function () {

                            }
                        })
                    }
                })
        }

        // Test Json
        function isJson(str) {
            try {
                JSON.parse(str);
            } catch (e) {
                return false;
            }
            return true;
        }
    </script>
@endsection
