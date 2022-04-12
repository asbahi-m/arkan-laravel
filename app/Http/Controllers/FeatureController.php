<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Validator;
use App\Models\Feature;

class FeatureController extends Controller
{
    public function index(Request $request) {
        $features = Feature::query();

        if (in_array($request['sortBy'], ['name', 'description', 'is_published', 'created_at'])) {
            $features->orderBy($request['sortBy']);
        }

        if (in_array($request['sortByDesc'], ['name', 'description', 'is_published', 'created_at'])) {
            $features->orderByDesc($request['sortByDesc']);
        }

        $features = $features->paginate(20)->withQueryString();

        return view('admin.feature.index', compact('features'));
    }

    public function create() {
        return view('admin.feature.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_published' => ['required', 'boolean'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Upload Feature Image
        if (isset($request['image'])) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'features/' . $image_name;

            $image->storePubliclyAs('features', $image_name, 'public');
        }

        Feature::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'is_published' => $request['is_published'],
            'image' => isset($request['image']) ? $image_path : null,
        ]);

        return redirect()->route('feature.index')->with('success', __('admin.feature_add_success'));
    }

    public function edit(Feature $feature) {
        return view('admin.feature.edit', compact('feature'));
    }

    public function update(Feature $feature, Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['nullable', 'string'],
            'is_published' => ['required', 'boolean'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Upload Feature Image
        if (isset($request['image'])) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'features/' . $image_name;

            $image->storePubliclyAs('features', $image_name, 'public');

            // Delete Feature Image
            Storage::delete('public/' . $feature->image);
        }

        $feature->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'is_published' => $request['is_published'],
            'image' => isset($request['image']) ? $image_path : $feature->image,
        ]);

        return redirect()->route('feature.index')->with('success', __('admin.feature_update_success'));

    }

    public function destroy(Request $request) {
        $feature = Feature::findOrFail($request['delete']);

        // Delete Feature Image
        Storage::delete('public/' . $feature->image);

        $feature->delete();

        return back()->with('success', __('admin.feature_delete_success'));
    }
}
