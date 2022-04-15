<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Type;
use Rule;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $types = Type::pluck('id')->push(0)->toArray();
        return [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['nullable', 'string'],
            'type_id' => ['nullable', Rule::in($types)],
            'is_published' => ['required', 'boolean'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
        ];
    }
}
