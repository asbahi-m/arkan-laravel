<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Type;

class TypeController extends Controller
{
    public function index(Request $request) {
        $types = Type::get();

        return view('admin.type.index', compact('types'));
    }

    public function sortByAjax(Request $request) {
        if ($request->ajax()) {
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

            $types_view = view('admin.type.row')->with(['types' => $types])->render();

            return response()->json([
                'status' => true,
                'data' => $types_view,
            ]);
        }
    }

    public function inline_store(Request $request) {
        $request->validate([
            'name' => ['required', 'string', 'unique:types', 'min:2', 'max:100'],
        ]);

        Type::create([
            'name' => $request['name'],
        ]);

        $type = Type::where('name', $request['name'])->get();
        $row = view('admin.type.row')->with(['types' => $type])->render();

        return response()->json([
            'status' => true,
            'row' => $row,
        ]);
    }

    public function update(Request $request) {
        $type = Type::findOrFail($request['type_id']);
        $request->validate([
            'type_name' => ['required', 'string', Rule::unique('types', 'name')->ignore($type->id), 'min:2', 'max:100'],
        ]);

        $type->update([
            'name' => $request['type_name'],
        ]);

        return response()->json([
            'status' => true,
            'id' => $type->id,
            'name' => $type->name,
        ]);
    }


    public function destroy(Request $request) {
        $type = Type::findOrFail($request['delete'])->delete();

        return response()->json([
            'status' => true,
            'id' => $request['delete'],
        ]);
    }


    // API's
    public function viewAPI() {
        $result = Type::all();
        return $result;
    }
}
