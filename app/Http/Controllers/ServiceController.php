<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Validator;
use Illuminate\Validation\Rule;
use App\Models\Service;
use App\Models\Type;

class ServiceController extends Controller
{
    public function index(Request $request) {
        $services = Service::query();

        if (in_array($request['sortBy'], ['name', 'type', 'description', 'is_published', 'created_at'])) {
            if ($request['sortBy'] == 'type') {
                $services->join('types', 'types.id', '=', 'services.type_id')
                ->select('services.*', 'types.name as type_name')
                ->orderBy('type_name');
            } else {
                $services->orderBy($request['sortBy']);
            }
        }

        if (in_array($request['sortByDesc'], ['name', 'type', 'description', 'is_published', 'created_at'])) {
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

    public function store(Request $request) {
        $types = Type::all('id')->pluck('id')->push(0)->toArray();
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['nullable', 'string'],
            'type' => ['nullable', Rule::in($types)],
            'is_published' => ['required', 'boolean'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Upload Service Image
        if (isset($request['image'])) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'services/' . $image_name;

            $image->storePubliclyAs('services', $image_name, 'public');
        }

        Service::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'type_id' => $request['type'] == 0 ? null : $request['type'],
            'is_published' => $request['is_published'],
            'image' => isset($request['image']) ? $image_path : null,
        ]);

        return redirect()->route('service.index')->with('success', __('admin.service_add_success'));
    }

    public function edit(Service $service) {
        $types = Type::all();
        return view('admin.service.edit', compact('service', 'types'));
    }

    public function update(Service $service, Request $request) {
        $types = Type::all('id')->pluck('id')->push(0)->toArray();
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['nullable', 'string'],
            'type' => ['nullable', Rule::in($types)],
            'is_published' => ['required', 'boolean'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Upload Service Image
        if (isset($request['image'])) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'services/' . $image_name;

            $image->storePubliclyAs('services', $image_name, 'public');

            // Delete Service Image
            Storage::delete('public/' . $service->image);
        }

        $service->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'type_id' => $request['type'] == 0 ? null : $request['type'],
            'is_published' => $request['is_published'],
            'image' => isset($request['image']) ? $image_path : $service->image,
        ]);

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
