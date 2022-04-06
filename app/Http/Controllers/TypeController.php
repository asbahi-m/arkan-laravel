<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Type;

class TypeController extends Controller
{
    public function index(Request $request) {
        $types = Type::get();

        if ($request['sortBy'] == 'name') {
            $types = $types->sortBy('name');
        } else if (in_array($request['sortBy'], ['service', 'product', 'project'])) {
            $types = $types->sortBy(function ($q) use($request) {
                return $q[$request['sortBy']]->count();
            });
        }

        if ($request['sortByDesc'] == 'name') {
            $types = $types->sortByDesc('name');
        } else if (in_array($request['sortByDesc'], ['service', 'product', 'project'])) {
            $types = $types->sortByDesc(function ($q) use($request) {
                return $q[$request['sortByDesc']]->count();
            });
        }

        return view('admin.type.index', compact('types'));
    }

    public function inline_store(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'unique:types', 'min:2', 'max:100'],
        ]);

        Type::create([
            'name' => $request['name'],
        ]);

        return back()->with('success', __('admin.type_add_success'));
    }

    public function update(Request $request) {
        $type = Type::findOrFail($request['type_id']);
        $request->validate([
            'type_name' => ['required', 'string', Rule::unique('types', 'name')->ignore($type->id), 'min:2', 'max:100'],
        ]);

        $type->update([
            'name' => $request['type_name'],
        ]);

        return back()->with('success', __('admin.type_update_success'));

    }


    public function delete(Request $request) {
        $type = Type::findOrFail($request['delete'])->delete();

        return back()->with('success', __('admin.type_delete_success'));
    }


    // API's
    public function viewAPI() {
        $result = Type::all();
        return $result;
    }
}
