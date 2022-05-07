<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FeatureRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Feature;
use App\Models\T_feature;

use App\Traits\UploadFile;
use App\Traits\GetLocales;

use App\Support\Collection;

class FeatureController extends Controller
{
    use UploadFile;
    use GetLocales;

    public function index(Request $request) {
        $features = Feature::query()
            ->withCount('views')
            ->with(['t_features' => function ($q) {
                $q->whereHas('locale', function ($q) {
                    $q->where('short_sign', app()->getLocale());
                });
            }])
            ->get()
        ;

        // Translate The Features
        $features->each(function ($item) {
            $locales = $this->locales();
            if ($item->t_features->count() && $locales->count()) {
                $item->name = $item->t_features->first()->name;
                $item->description = $item->t_features->first()->description;
            }
            return $item;
        });

        if (in_array($request['sortBy'], ['name', 'description', 'is_published', 'views_count', 'created_at'])) {
            $features = $features->sortBy($request['sortBy']);
        }

        if (in_array($request['sortByDesc'], ['name', 'description', 'is_published', 'views_count', 'created_at'])) {
            $features = $features->sortByDesc($request['sortByDesc']);
        }

        $features = (new Collection($features))->paginate(PAGINATION_NUMBER)->withQueryString();

        return view('admin.feature.index', compact('features'));
    }

    public function create() {
        $locales = $this->locales();
        return view('admin.feature.create', compact('locales'));
    }

    public function store(FeatureRequest $request) {
        $validated = $request->safe()->all();

        // Upload Feature Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'features');

            $validated['image'] = $image_path;
        }

        $locales = $this->locales();
        if ($locales->count()) {
            $val_feature = $validated;
            $val_feature['name'] = $validated['name'][DEFAULT_LOCALE];
            $val_feature['description'] = $validated['description'][DEFAULT_LOCALE];

            $feature = Feature::create($val_feature);

            ## Create a new t_features
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_feature::create([
                        'locale_id' => $locale->id,
                        'feature_id' => $feature->id,
                        'name' => $request['name'][$locale->short_sign],
                        'description' => isset($request['description'][$locale->short_sign]) ? $request['description'][$locale->short_sign] : null,
                    ]);
                }
            }
        } else {
            Feature::create($validated);
        }

        return redirect()->route('feature.index')->with('success', __('admin.feature_add_success'));
    }

    public function edit(Feature $feature) {
        $locales = $this->locales();
        return view('admin.feature.edit', compact('feature', 'locales'));
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

        $locales = $this->locales();
        if ($locales->count()) {
            $val_feature = $validated;
            $val_feature['name'] = $validated['name'][DEFAULT_LOCALE];
            $val_feature['description'] = isset($validated['description'][DEFAULT_LOCALE]) ? $validated['description'][DEFAULT_LOCALE] : null;

            $feature->update($val_feature);

            ## Remove old t_features then create a new t_features
            T_feature::where('feature_id', $feature->id)->delete();
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_feature::create([
                        'locale_id' => $locale->id,
                        'feature_id' => $feature->id,
                        'name' => $validated['name'][$locale->short_sign],
                        'description' => isset($validated['description'][$locale->short_sign]) ? $validated['description'][$locale->short_sign] : null,
                    ]);
                }
            }
        } else {
            $feature->update($validated);
        }

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
