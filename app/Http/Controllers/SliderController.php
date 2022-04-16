<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SliderRequest;
use App\Models\Slider;
use Rule;
use Storage;
use App\Traits\UploadFile;

class SliderController extends Controller
{
    use UploadFile;

    public function __construct() {
        $this->places = ['home', 'services', 'products', 'projects'];
    }

    public function index() {
        $sliders = Slider::all();

        return view('admin.slider.index', compact('sliders'));
    }

    public function create() {
        $places = $this->places;
        return view('admin.slider.create', compact('places'));
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

        Slider::create($validated);

        return redirect()->route('slider.index')->with('success', __('admin.slider_add_success'));
    }

    public function edit(Slider $slider) {
        $places = $this->places;
        return view('admin.slider.edit', compact('slider', 'places'));
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

        $slider->update($validated);

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
