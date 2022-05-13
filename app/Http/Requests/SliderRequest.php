<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\GetLocales;

class SliderRequest extends FormRequest
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
        $rules = [
            // 'title' => ['nullable', 'string', 'min:3', 'max:100'],
            // 'subtitle' => ['nullable', 'string', 'min:3', 'max:100'],
            // 'brief' => ['nullable', 'string', 'min:3', 'max:500'],
            'media' => ['nullable', 'mimes:png,jpb,jpeg', 'max:1024'],
            'place' => ['required', 'string'],
            'order' => ['nullable', 'numeric', 'min:0'],
            'is_published' => ['required', 'boolean'],
            'primary_url' => ['nullable', 'url'],
            // 'primary_btn' => ['nullable', 'string', 'min:3', 'max:20'],
            'secondary_url' => ['nullable', 'url'],
            // 'secondary_btn' => ['nullable', 'string', 'min:3', 'max:20'],
        ];
        if ($locales->count()) {
            $rules['title.*'] = ['nullable', 'string', 'min:3', 'max:100'];
            $rules['subtitle.*'] = ['nullable', 'string', 'min:3', 'max:100'];
            $rules['brief.*'] = ['nullable', 'string', 'min:3', 'max:500'];
            $rules['primary_btn.*'] = ['nullable', 'string', 'min:3', 'max:20'];
            $rules['secondary_btn.*'] = ['nullable', 'string', 'min:3', 'max:20'];
        } else {
            $rules['title'] = ['nullable', 'string', 'min:3', 'max:100'];
            $rules['subtitle'] = ['nullable', 'string', 'min:3', 'max:100'];
            $rules['brief'] = ['nullable', 'string', 'min:3', 'max:500'];
            $rules['primary_btn'] = ['nullable', 'string', 'min:3', 'max:20'];
            $rules['secondary_btn'] = ['nullable', 'string', 'min:3', 'max:20'];
        }
        return $rules;
    }
}
