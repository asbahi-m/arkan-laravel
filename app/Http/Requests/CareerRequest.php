<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CareerRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email'],
            'phone' => ['nullable', 'numeric', 'min:8'],
            'attachment' => ['required', 'mimes:pdf', 'max:5120'],
            'message' => ['nullable', 'string', 'min:3', 'max:1000'],
        ];
    }
}
