<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SliderRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use App\Models\Slider;
use App\Models\T_slider;
use App\Traits\UploadFile;
use App\Traits\GetLocales;

class SliderController extends Controller
{
    use UploadFile;
    use GetLocales;

    public function __construct() {
        $this->places = ['home', 'services', 'products', 'projects'];
    }

    public function index(Request $request) {
        $sliders = Slider::get();

        if (in_array($request['sortBy'], ['place', 'is_published'])) {
            $sliders = $sliders->sortBy($request['sortBy']);
        }

        if (in_array($request['sortByDesc'], ['place', 'is_published'])) {
            $sliders = $sliders->sortByDesc($request['sortByDesc']);
        }

        return view('admin.slider.index', compact('sliders'));
    }

    public function create() {
        $places = $this->places;
        $locales = $this->locales();
        return view('admin.slider.create', compact('places', 'locales'));
    }

    public function store(SliderRequest $request) {
        $request->validate([
            'media' => ['required'],
            'place' => [Rule::in($this->places)],
        ]);

        $validated = $request->safe()->all();

        // Upload Slider Media
        if ($request->hasFile('media')) {
            $media_path = $this->saveFile($request->file('media'), 'sliders');

            $validated['media'] = $media_path;
        }

        $locales = $this->locales();
        if ($locales->count()) {
            $val_slider = $validated;
            $val_slider['title'] = $validated['title'][DEFAULT_LOCALE];
            $val_slider['subtitle'] = $validated['subtitle'][DEFAULT_LOCALE];
            $val_slider['brief'] = $validated['brief'][DEFAULT_LOCALE];
            $val_slider['primary_btn'] = $validated['primary_btn'][DEFAULT_LOCALE];
            $val_slider['secondary_btn'] = $validated['secondary_btn'][DEFAULT_LOCALE];

            $slider = Slider::create($val_slider);

            ## Create a new t_sliders
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_slider::create([
                        'locale_id' => $locale->id,
                        'slider_id' => $slider->id,
                        'title' => $validated['title'][$locale->short_sign],
                        'subtitle' => $validated['subtitle'][$locale->short_sign],
                        'brief' => $validated['brief'][$locale->short_sign],
                        'primary_btn' => $validated['primary_btn'][$locale->short_sign],
                        'secondary_btn' => $validated['secondary_btn'][$locale->short_sign],
                    ]);
                }
            }
        } else {
            Slider::create($validated);
        }

        return redirect()->route('slider.index')->with('success', __('admin.slider_add_success'));
    }

    public function edit(Slider $slider) {
        $places = $this->places;
        $locales = $this->locales();
        return view('admin.slider.edit', compact('slider', 'places', 'locales'));
    }

    public function update(Slider $slider, SliderRequest $request) {
        $request->validate([
            'place' => [Rule::in($this->places)],
        ]);

        $validated = $request->safe()->all();

        // Upload Slider Media
        if ($request->hasFile('media')) {
            $media_path = $this->saveFile($request->file('media'), 'sliders');

            // Delete Slider Media
            Storage::delete('public/' . $slider->media);

            $validated['media'] = $media_path;
        }

        $locales = $this->locales();
        if ($locales->count()) {
            $val_slider = $validated;
            $val_slider['title'] = $validated['title'][DEFAULT_LOCALE];
            $val_slider['subtitle'] = $validated['subtitle'][DEFAULT_LOCALE];
            $val_slider['brief'] = $validated['brief'][DEFAULT_LOCALE];
            $val_slider['primary_btn'] = $validated['primary_btn'][DEFAULT_LOCALE];
            $val_slider['secondary_btn'] = $validated['secondary_btn'][DEFAULT_LOCALE];

            $slider->update($val_slider);

            ## Remove old t_sliders then create a new t_sliders
            T_slider::where('slider_id', $slider->id)->delete();
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_slider::create([
                        'locale_id' => $locale->id,
                        'slider_id' => $slider->id,
                        'title' => $validated['title'][$locale->short_sign],
                        'subtitle' => $validated['subtitle'][$locale->short_sign],
                        'brief' => $validated['brief'][$locale->short_sign],
                        'primary_btn' => $validated['primary_btn'][$locale->short_sign],
                        'secondary_btn' => $validated['secondary_btn'][$locale->short_sign],
                    ]);
                }
            }
        } else {
            $slider->update($validated);
        }

        return redirect()->route('slider.index')->with('success', __('admin.slider_update_success'));
    }

    public function destroy(Request $request) {
        $slider = Slider::findOrFail($request['delete']);

        // Delete Slider Media
        Storage::delete('public/' . $slider->media);

        $slider->delete();

        return back()->with('success', __('admin.slider_delete_success'));
    }
}
