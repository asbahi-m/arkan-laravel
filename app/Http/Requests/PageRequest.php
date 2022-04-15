<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
        return [
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'subtitle' => ['nullable', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_published' => ['required', 'boolean'],
            'is_marker' => ['nullable', 'boolean'],
            'templates' => ['nullable', 'array'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
            'view_image' => ['nullable', 'boolean'],
            'slug' => ['nullable', 'string', 'min:3', 'max:255'],
        ];
    }
}
