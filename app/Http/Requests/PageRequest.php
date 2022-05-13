<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Traits\GetLocales;

class PageRequest extends FormRequest
{
    use GetLocales;
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
        $locales = $this->locales();
        if (request()->routeIs('*.store')) {
            $title_unique = Rule::unique('pages', 'title');
            $slug_unique = Rule::unique('pages', 'slug');
        }
        else {
            $title_unique = Rule::unique('pages', 'title')->ignore(intval(request('id')));
            $slug_unique = Rule::unique('pages', 'slug')->ignore(intval(request('id')));
        }
        $rules = [
            // 'title' => ['required', 'string', 'min:3', 'max:255', $title_unique],
            // 'subtitle' => ['nullable', 'string', 'min:3', 'max:255'],
            // 'description' => ['nullable', 'string'],
            'is_published' => ['required', 'boolean'],
            'is_marker' => ['nullable', 'boolean'],
            'templates' => ['nullable', 'array'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
            'view_image' => ['nullable', 'boolean'],
            'slug' => ['nullable', 'string', 'min:3', 'max:255', $slug_unique],
        ];
        if ($locales->count()) {
            $rules['title.*'] = ['required', 'string', 'min:3', 'max:255', $title_unique];
            $rules['subtitle.*'] = ['nullable', 'string', 'min:3', 'max:255'];
            $rules['description.*'] = ['nullable', 'string'];
        } else {
            $rules['title'] = ['required', 'string', 'min:3', 'max:255', $title_unique];
            $rules['subtitle'] = ['nullable', 'string', 'min:3', 'max:255'];
            $rules['description'] = ['nullable', 'string'];
        }
        return $rules;
    }
}
