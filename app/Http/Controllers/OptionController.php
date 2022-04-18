<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\OptionRequest;
use App\Models\Option;
use Route;

class OptionController extends Controller
{
    public function __construct() {
        $this->middleware('super')->only('update');
    }

    public function general() {
        $options = Option::where('option', 'general_options')->get()->map(function ($item, $key) {
            return [$item['key'] => $item['value']];
        })->collapse();

        return view('admin.option.general', compact('options'));
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
        $validate = $request->safe()->all();
        if (Route::is('option.general.update')) {
            foreach ($validate['general_options'] as $key => $value) {
                Option::updateOrCreate(['key' => $key], [
                    'option' => 'general_options',
                    'value' => $value,
                ]);
            }
        }

        if (Route::is('option.social.update')) {
            foreach ($validate['social_options'] as $key => $value) {
                Option::updateOrCreate(['key' => $key], [
                    'option' => 'social_options',
                    'value' => $value,
                ]);
            }
        }

        if (Route::is('option.contact.update')) {
            foreach ($validate['contact_options'] as $key => $value) {
                Option::updateOrCreate(['key' => $key], [
                    'option' => 'contact_options',
                    'value' => $value,
                ]);
            }
        }

        return back()->with('success', __('admin.options_update_success'));
    }
}
