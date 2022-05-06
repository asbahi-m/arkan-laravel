@foreach ($types as $key => $type)
    <tr class="row-{{ $type->id }}">
        <td class="index"><small>{{ ++$key }}</small></td>
        <td class="type-name"><small><strong>{{ Str::upper($type->name) }}</strong></small></td>
        <td>
            @if ($type->services->count())
                <a class="px-3" href="{{ route('service.index', ['type' => $type->original_name]) }}">{{ $type->services->count() }}</a>
            @else
                <span class="px-3">0</span>
            @endif
        </td>
        <td>
            @if ($type->products->count())
                <a class="px-3" href="{{ route('product.index', ['type' => $type->original_name]) }}">{{ $type->products->count() }}</a>
            @else
                <span class="px-3">0</span>
            @endif
        </td>
        <td>
            @if ($type->projects->count())
                <a class="px-3" href="{{ route('project.index', ['type' => $type->original_name]) }}">{{ $type->projects->count() }}</a>
            @else
                <span class="px-3">0</span>
            @endif
        </td>
        <td>
            <div class="d-flex">
                <button class="btn btn-info shadow btn-xs sharp mr-1"
                        data-toggle="modal" data-target="#edit-type" data-id="{{ $type->id }}"
                        data-name="{{ $locales->count() ? $type->t_types : $type->name }}">
                    <i class="fa fa-pencil"></i></button>
                <button class="btn btn-danger shadow btn-xs sharp mr-1"
                        onclick='confirmDelete("{{ $type->id }}")'>
                    <i class="fa fa-trash"></i></button>
            </div>
        </td>
    </tr>
@endforeach
