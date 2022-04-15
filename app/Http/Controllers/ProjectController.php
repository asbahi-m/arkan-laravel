<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use Storage;
use App\Models\Project;
use App\Models\Type;

class ProjectController extends Controller
{
    public function index(Request $request) {
        $projects = Project::query();

        if (in_array($request['sortBy'], ['name', 'type', 'description', 'is_published', 'created_at'])) {
            if ($request['sortBy'] == 'type') {
                $projects->join('types', 'types.id', '=', 'projects.type_id')
                ->select('projects.*', 'types.name as type_name')
                ->orderBy('type_name');
            } else {
                $projects->orderBy($request['sortBy']);
            }
        }

        if (in_array($request['sortByDesc'], ['name', 'type', 'description', 'is_published', 'created_at'])) {
            if ($request['sortByDesc'] == 'type') {
                $projects->join('types', 'types.id', '=', 'projects.type_id')
                ->select('projects.*', 'types.name as type_name')
                ->orderByDesc('type_name');
            } else {
                $projects->orderByDesc($request['sortByDesc']);
            }
        }

        $projects = $projects->paginate(20)->withQueryString();

        return view('admin.project.index', compact('projects'));
    }

    public function create() {
        $types = Type::all();
        return view('admin.project.create', compact('types'));
    }

    public function store(ProjectRequest $request) {
        $validated = $request->safe()->all();

        // Upload Project Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'projects/' . $image_name;

            $image->storePubliclyAs('projects', $image_name, 'public');

            $validated['image'] = $image_path;
        }

        if ($validated['type_id'] == 0) $validated['type_id'] = null;

        Project::create($validated);

        return redirect()->route('project.index')->with('success', __('admin.project_add_success'));
    }

    public function edit(Project $project) {
        $types = Type::all();
        return view('admin.project.edit', compact('project', 'types'));
    }

    public function update(Project $project, ProjectRequest $request) {
        $validated = $request->safe()->all();

        // Upload Project Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'projects/' . $image_name;

            $image->storePubliclyAs('projects', $image_name, 'public');

            // Delete Project Image
            Storage::delete('public/' . $project->image);

            $validated['image'] = $image_path;
        }

        if ($validated['type_id'] == 0) $validated['type_id'] = null;

        $project->update($validated);

        return redirect()->route('project.index')->with('success', __('admin.project_update_success'));

    }

    public function destroy(Request $request) {
        $project = Project::findOrFail($request['delete']);

        // Delete Project Image
        Storage::delete('public/' . $project->image);

        $project->delete();

        return back()->with('success', __('admin.project_delete_success'));
    }


    // API's
    public function viewAPI() {
        $result = Project::all();
        return $result;
    }

    public function latestAPI() {
        $result = Project::limit(3)->orderByDesc('id')->get();
        return $result;
    }

    public function showAPI($id) {
        $result = Project::findOrFail($id);
        return $result;
    }
}
