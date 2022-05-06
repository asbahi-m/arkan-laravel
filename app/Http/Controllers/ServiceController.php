<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Service;
use App\Models\T_service;
use App\Models\Type;
use App\Traits\UploadFile;
use App\Traits\GetLocales;
use App\Models\Locale;
use App\Support\Collection;

class ServiceController extends Controller
{
    use UploadFile;
    use GetLocales;

    public function index(Request $request) {
        $services = Service::query()
            ->withCount('views')
            ->with(['t_services' => function ($q) {
                $q->whereHas('locale', function ($q) {
                    $q->where('short_sign', app()->getLocale());
                });
            }])
            ->when($request['type'], function ($q) use ($request) {
                $q->whereHas('type', function ($q) use ($request) {
                    $q->where('name', $request['type']);
                });
            })
            ->get()
        ;

        // Translate The Services
        $services->each(function ($item) {
            $locales = $this->locales();
            if ($item->t_services->count() && $locales->count()) {
                $item->name = $item->t_services->first()->name;
                $item->description = $item->t_services->first()->description;
            }

            ## Get Type Name with translate
            if ($item->type) {
                $t_types_filter = $item->type->t_types->filter(function ($value) {
                    $locale = Locale::firstWhere('short_sign', app()->getLocale());
                    return $value['locale_id'] == $locale->id;
                })->first();
                $item->type_name = $t_types_filter ? $t_types_filter->name : $item->type->name;
            }

            return $item;
        });

        if (in_array($request['sortBy'], ['name', 'type_name', 'description', 'is_published', 'views_count', 'created_at'])) {
            $services = $services->sortBy($request['sortBy']);
        }

        if (in_array($request['sortByDesc'], ['name', 'type_name', 'description', 'is_published', 'views_count', 'created_at'])) {
            $services = $services->sortByDesc($request['sortByDesc']);
        }

        $services = (new Collection($services))->paginate(PAGINATION_NUMBER)->withQueryString();

        /* if ($request['type']) {
            $services->whereHas('type', function ($q) use ($request) {
                $q->where('name', $request['type']);
            });
        }

        if (in_array($request['sortBy'], ['name', 'type', 'description', 'is_published', 'views_count', 'created_at'])) {
            if ($request['sortBy'] == 'type') {
                $services->join('types', 'types.id', '=', 'services.type_id')
                ->select('services.*', 'types.name as type_name')
                ->orderBy('type_name');
            } else {
                $services->orderBy($request['sortBy']);
            }
        }

        if (in_array($request['sortByDesc'], ['name', 'type', 'description', 'is_published', 'views_count', 'created_at'])) {
            if ($request['sortByDesc'] == 'type') {
                $services->join('types', 'types.id', '=', 'services.type_id')
                ->select('services.*', 'types.name as type_name')
                ->orderByDesc('type_name');
            } else {
                $services->orderByDesc($request['sortByDesc']);
            }
        }

        $services = $services->paginate(PAGINATION_NUMBER)->withQueryString(); */

        return view('admin.service.index', compact('services'));
    }

    public function create() {
        $locales = $this->locales();
        $types = Type::all();
        return view('admin.service.create', compact('types', 'locales'));
    }

    public function store(ServiceRequest $request) {
        $validated = $request->safe()->all();

        // Upload Service Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'services');

            $validated['image'] = $image_path;
        }

        if ($validated['type_id'] == 0) $validated['type_id'] = null;

        $locales = $this->locales();
        if ($locales->count()) {
            $val_service = $validated;
            $val_service['name'] = $validated['name'][DEFAULT_LOCALE];
            $val_service['description'] = $validated['description'][DEFAULT_LOCALE];

            $service = Service::create($val_service);

            ## Create a new t_services
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_service::create([
                        'locale_id' => $locale->id,
                        'service_id' => $service->id,
                        'name' => $request['name'][$locale->short_sign],
                        'description' => isset($request['description'][$locale->short_sign]) ? $request['description'][$locale->short_sign] : null,
                    ]);
                }
            }
        } else {
            Service::create($validated);
        }

        return redirect()->route('service.index')->with('success', __('admin.service_add_success'));
    }

    public function edit(Service $service) {
        $locales = $this->locales();
        $types = Type::all();
        return view('admin.service.edit', compact('service', 'types', 'locales'));
    }

    public function update(Service $service, ServiceRequest $request) {
        $validated = $request->safe()->all();

        // Upload Service Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'services');

            // Delete Service Image
            Storage::delete('public/' . $service->image);

            $validated['image'] = $image_path;
        }

        if ($validated['type_id'] == 0) $validated['type_id'] = null;

        $locales = $this->locales();
        if ($locales->count()) {
            $val_service = $validated;
            $val_service['name'] = $validated['name'][DEFAULT_LOCALE];
            $val_service['description'] = isset($validated['description'][DEFAULT_LOCALE]) ? $validated['description'][DEFAULT_LOCALE] : null;

            $service->update($val_service);

            ## Remove old t_services then create a new t_services
            T_service::where('service_id', $service->id)->delete();
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_service::create([
                        'locale_id' => $locale->id,
                        'service_id' => $service->id,
                        'name' => $validated['name'][$locale->short_sign],
                        'description' => isset($validated['description'][$locale->short_sign]) ? $validated['description'][$locale->short_sign] : null,
                    ]);
                }
            }
        } else {
            $service->update($validated);
        }

        return redirect()->route('service.index')->with('success', __('admin.service_update_success'));
    }

    public function destroy(Request $request) {
        $service = Service::findOrFail($request['delete']);

        // Delete Service Image
        Storage::delete('public/' . $service->image);

        $service->delete();

        return back()->with('success', __('admin.service_delete_success'));
    }


    // API's
    public function viewAPI() {
        $result = Service::all();
        return $result;
    }

    public function showAPI($id) {
        $result = Service::findOrFail($id);
        return $result;
    }
}
