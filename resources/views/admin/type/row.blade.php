@foreach ($types as $key => $type)
    @php
        $t_types = $type->t_types;
    @endphp
    <tr class="row-{{ $type->id }}">
        <td class="index"><small>{{ ++$key }}</small></td>
        <td class="type-name"><small><strong>{{ Str::upper($type->name) }}</strong></small></td>
        <td>
            @if ($type->services->count())
                <a class="px-3" href="{{ route('service.index', ['type' => $type->name]) }}">{{ $type->services->count() }}</a>
            @else
                <span class="px-3">0</span>
            @endif
        </td>
        <td>
            @if ($type->products->count())
                <a class="px-3" href="{{ route('product.index', ['type' => $type->name]) }}">{{ $type->products->count() }}</a>
            @else
                <span class="px-3">0</span>
            @endif
        </td>
        <td>
            @if ($type->projects->count())
                <a class="px-3" href="{{ route('project.index', ['type' => $type->name]) }}">{{ $type->projects->count() }}</a>
            @else
                <span class="px-3">0</span>
            @endif
        </td>
        <td>
            <div class="d-flex">
                <button class="btn btn-info shadow btn-xs sharp mr-1"
                        data-toggle="modal" data-target="#edit-type" data-id="{{ $type->id }}"
                        data-name='{"{{ DEFAULT_LOCALE }}": "{{ $type->original_name }}" @if($t_types->count()), @endif @foreach ($t_types as $key => $t_type) "{{ $t_type->locale->short_sign }}": "{{ $t_type->name }}"{{ $t_types->count() > $key+1 ? ',' : '' }} @endforeach}'>
                    <i class="fa fa-pencil"></i></button>
                <button class="btn btn-danger shadow btn-xs sharp mr-1"
                        onclick='confirmDelete("{{ $type->id }}")'>
                    <i class="fa fa-trash"></i></button>
            </div>
            {{--$t_types->count()--}}
        </td>
    </tr>
@endforeach
