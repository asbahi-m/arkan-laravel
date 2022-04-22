<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FeatureRequest;
use Storage;
use App\Models\Feature;
use App\Traits\UploadFile;

class FeatureController extends Controller
{
    use UploadFile;
    public function index(Request $request) {
        $features = Feature::query()->withCount('views');

        if (in_array($request['sortBy'], ['name', 'description', 'is_published', 'views_count', 'created_at'])) {
            $features->orderBy($request['sortBy']);
        }

        if (in_array($request['sortByDesc'], ['name', 'description', 'is_published', 'views_count', 'created_at'])) {
            $features->orderByDesc($request['sortByDesc']);
        }

        $features = $features->paginate(PAGINATION_NUMBER)->withQueryString();

        return view('admin.feature.index', compact('features'));
    }

    public function create() {
        return view('admin.feature.create');
    }

    public function store(FeatureRequest $request) {
        $validated = $request->safe()->all();

        // Upload Feature Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'features');

            $validated['image'] = $image_path;
        }

        Feature::create($validated);

        return redirect()->route('feature.index')->with('success', __('admin.feature_add_success'));
    }

    public function edit(Feature $feature) {
        return view('admin.feature.edit', compact('feature'));
    }

    public function update(Feature $feature, FeatureRequest $request) {
        $validated = $request->safe()->all();

        // Upload Feature Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'features');

            // Delete Feature Image
            Storage::delete('public/' . $feature->image);

            $validated['image'] = $image_path;
        }

        $feature->update($validated);

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
