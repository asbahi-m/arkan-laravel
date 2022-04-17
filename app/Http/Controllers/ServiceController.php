<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ServiceRequest;
use Storage;
use App\Models\Service;
use App\Models\Type;
use App\Traits\UploadFile;

class ServiceController extends Controller
{
    use UploadFile;

    public function index(Request $request) {
        $services = Service::query()->withCount('view');

        if (in_array($request['sortBy'], ['name', 'type', 'description', 'is_published', 'view_count', 'created_at'])) {
            if ($request['sortBy'] == 'type') {
                $services->join('types', 'types.id', '=', 'services.type_id')
                ->select('services.*', 'types.name as type_name')
                ->orderBy('type_name');
            } else {
                $services->orderBy($request['sortBy']);
            }
        }

        if (in_array($request['sortByDesc'], ['name', 'type', 'description', 'is_published', 'view_count', 'created_at'])) {
            if ($request['sortByDesc'] == 'type') {
                $services->join('types', 'types.id', '=', 'services.type_id')
                ->select('services.*', 'types.name as type_name')
                ->orderByDesc('type_name');
            } else {
                $services->orderByDesc($request['sortByDesc']);
            }
        }

        $services = $services->paginate(20)->withQueryString();

        return view('admin.service.index', compact('services'));
    }

    public function create() {
        $types = Type::all();
        return view('admin.service.create', compact('types'));
    }

    public function store(ServiceRequest $request) {
        $validated = $request->safe()->all();

        // Upload Service Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'services');

            $validated['image'] = $image_path;
        }

        if ($validated['type_id'] == 0) $validated['type_id'] = null;

        Service::create($validated);

        return redirect()->route('service.index')->with('success', __('admin.service_add_success'));
    }

    public function edit(Service $service) {
        $types = Type::all();
        return view('admin.service.edit', compact('service', 'types'));
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

        $service->update($validated);

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
