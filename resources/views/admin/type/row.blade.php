@foreach ($types as $key => $type)
    <tr class="row-{{ $type->id }}">
        <td class="index"><small>{{ ++$key }}</small></td>
        <td class="type-name"><small><strong>{{ Str::upper($type->name) }}</strong></small></td>
        <td>{{ count($type->service) }}</td>
        <td>{{ count($type->product) }}</td>
        <td>{{ count($type->project) }}</td>
        <td>
            <div class="d-flex">
                <button class="btn btn-info shadow btn-xs sharp mr-1"
                        data-toggle="modal" data-target="#edit-type"
                        data-name="{{ $type->name }}" data-id="{{ $type->id }}">
                    <i class="fa fa-pencil"></i></button>
                <button class="btn btn-danger shadow btn-xs sharp mr-1"
                        onclick="confirmDelete({{ $type->id }})">
                    <i class="fa fa-trash"></i></button>
            </div>
        </td>
    </tr>
@endforeach
