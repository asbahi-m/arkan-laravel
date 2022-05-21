<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OptionRequest;
use App\Models\Option;
use App\Models\T_option;
use App\Traits\GetLocales;
use Illuminate\Support\Facades\Route;

class OptionController extends Controller
{
    use GetLocales;

    public function __construct() {
        $this->middleware('super')->only('update');
    }

    public function general() {
        $locales = $this->locales();
        $options = Option::where('option', 'general_options')->get()->groupBy('key')
        ->transform(function ($item) use ($locales) {
            $data = [];
            $data['value'] = $item->first()->value;
            if ($locales)
                $data['t_options'] = $item->first()->t_options->groupBy(function ($item) {
                    return $item->locale->short_sign;
                })->map(function ($item) {
                    return $item->first();
                });
            return $data;
        });

        return view('admin.option.general', compact('options', 'locales'));
    }

    public function social() {
        $options = Option::where('option', 'social_options')->get()->map(function ($item, $key) {
            return [$item['key'] => $item['value']];
        })->collapse();

        return view('admin.option.social', compact('options'));
    }

    public function contact() {
        $options = Option::where('option', 'contact_options')->get()->map(function ($item, $key) {
            return [$item['key'] => $item['value']];
        })->collapse();

        return view('admin.option.contact', compact('options'));
    }

    public function update(OptionRequest $request) {
        $validated = $request->safe()->all();
        if (Route::is('option.general.update')) {
            $general_options = $validated['general_options'];
            $locales = $this->locales();
            if ($locales->count()) {
                $val_general = $general_options;
                $val_general['site_name'] = $general_options['site_name'][DEFAULT_LOCALE];
                $val_general['site_identity'] = $general_options['site_identity'][DEFAULT_LOCALE];
                $val_general['site_description'] = $general_options['site_description'][DEFAULT_LOCALE];
                $val_general['keywords'] = $general_options['keywords'][DEFAULT_LOCALE];
                $val_general['copyrights'] = $general_options['copyrights'][DEFAULT_LOCALE];

                foreach ($val_general as $key => $value) {
                    $option = Option::updateOrCreate(['key' => $key], [
                        'option' => 'general_options',
                        'value' => $value,
                    ]);
                    foreach ($locales as $locale) {
                        if ($locale->short_sign != DEFAULT_LOCALE && is_array($general_options[$key])) {
                            T_option::updateOrCreate(['option_id' => $option->id, 'locale_id' => $locale->id], [
                                'locale_id' => $locale->id,
                                'option_id' => $option->id,
                                'value' => $general_options[$key][$locale->short_sign],
                            ]);
                        }
                    }
                }
            } else {
                foreach ($general_options as $key => $value) {
                    Option::updateOrCreate(['key' => $key], [
                        'option' => 'general_options',
                        'value' => $value,
                    ]);
                }
            }
        }

        if (Route::is('option.social.update')) {
            $social_options = $validated['social_options'];
            foreach ($social_options as $key => $value) {
                Option::updateOrCreate(['key' => $key], [
                    'option' => 'social_options',
                    'value' => $value,
                ]);
            }
        }

        if (Route::is('option.contact.update')) {
            $contact_options = $validated['contact_options'];
            foreach ($contact_options as $key => $value) {
                Option::updateOrCreate(['key' => $key], [
                    'option' => 'contact_options',
                    'value' => $value,
                ]);
            }
        }

        return back()->with('success', __('admin.options_update_success'));
    }
}
