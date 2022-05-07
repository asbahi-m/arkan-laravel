<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\GetLocales;

class ClientRequest extends FormRequest
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
            // 'name' => ['required', 'string', 'min:3', 'max:100'],
            'url_address' => ['nullable', 'url'],
            'is_published' => ['required', 'boolean'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
        ];
        if ($locales->count()) {
            $rules['name.*'] = ['required', 'string', 'min:3', 'max:100'];
        } else {
            $rules['name'] = ['required', 'string', 'min:3', 'max:100'];
        }
        return $rules;
    }
}
