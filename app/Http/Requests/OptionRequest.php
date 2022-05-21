<?php

namespace App\Http\Requests;

use App\Traits\GetLocales;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class OptionRequest extends FormRequest
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
        if (Route::is('option.general.update')) {
            $locales = $this->locales();
            $rules = [
                // 'general_options.site_name' => ['required', 'string', 'min:3', 'max:100'],
                // 'general_options.site_identity' => ['nullable', 'string', 'min:3', 'max:255'],
                // 'general_options.site_description' => ['nullable', 'string', 'min:3', 'max:255'],
                // 'general_options.keywords' => ['nullable', 'string', 'min:3', 'max:255'],
                // 'general_options.copyrights' => ['nullable', 'string', 'min:3', 'max:255'],
                'general_options.site_email' => ['nullable', 'email'],
                'general_options.support_email' => ['nullable', 'email'],
                'general_options.live_chat_url' => ['nullable', 'url'],
                'general_options.support_url' => ['nullable', 'url'],

            ];
            if ($locales->count()) {
                $rules['general_options.site_name.*'] = ['required', 'string', 'min:3', 'max:100'];
                $rules['general_options.site_identity.*'] = ['nullable', 'string', 'min:3', 'max:255'];
                $rules['general_options.site_description.*'] = ['nullable', 'string', 'min:3', 'max:255'];
                $rules['general_options.keywords.*'] = ['nullable', 'string', 'min:3', 'max:255'];
                $rules['general_options.copyrights.*'] = ['nullable', 'string', 'min:3', 'max:255'];
            } else {
                $rules['general_options.site_name'] = ['required', 'string', 'min:3', 'max:100'];
                $rules['general_options.site_identity'] = ['nullable', 'string', 'min:3', 'max:255'];
                $rules['general_options.site_description'] = ['nullable', 'string', 'min:3', 'max:255'];
                $rules['general_options.keywords'] = ['nullable', 'string', 'min:3', 'max:255'];
                $rules['general_options.copyrights'] = ['nullable', 'string', 'min:3', 'max:255'];
            }
            return $rules;
        }

        if (Route::is('option.social.update')) {
            return [
                'social_options.facebook' => ['nullable', 'url'],
                'social_options.twitter' => ['nullable', 'url'],
                'social_options.linkedin' => ['nullable', 'url'],
                'social_options.instagram' => ['nullable', 'url'],
                'social_options.snapchat' => ['nullable', 'url'],
                'social_options.youtube' => ['nullable', 'url'],
                'social_options.whatsapp' => ['nullable', 'numeric'],
            ];
        }

        if (Route::is('option.contact.update')) {
            return [
                'contact_options.address' => ['nullable', 'string', 'min:3', 'max:100'],
                'contact_options.mobile' => ['nullable', 'numeric'],
                'contact_options.email' => ['nullable', 'email'],
                'contact_options.map' => ['nullable', 'string', 'min:3', 'max:255'],

            ];
        }
    }
}
