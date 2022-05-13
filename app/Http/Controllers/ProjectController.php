<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProjectRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Models\T_project;
use App\Models\Type;
use App\Traits\UploadFile;
use App\Traits\GetLocales;
use App\Models\Locale;
use App\Support\Collection;

class ProjectController extends Controller
{
    use UploadFile;
    use GetLocales;

    public function index(Request $request) {
        $projects = Project::query()
            ->withCount('views')
            ->with(['t_projects' => function ($q) {
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

        // Translate The Projects
        $projects->each(function ($item) {
            $locales = $this->locales();
            if ($item->t_projects->count() && $locales->count()) {
                $item->name = $item->t_projects->first()->name;
                $item->description = $item->t_projects->first()->description;
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
            $projects = $projects->sortBy($request['sortBy']);
        }

        if (in_array($request['sortByDesc'], ['name', 'type_name', 'description', 'is_published', 'views_count', 'created_at'])) {
            $projects = $projects->sortByDesc($request['sortByDesc']);
        }

        $projects = (new Collection($projects))->paginate(PAGINATION_NUMBER)->withQueryString();

        return view('admin.project.index', compact('projects'));
    }

    public function create() {
        $locales = $this->locales();
        $types = Type::all();
        return view('admin.project.create', compact('types', 'locales'));
    }

    public function store(ProjectRequest $request) {
        $validated = $request->safe()->all();

        // Upload Project Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'projects');

            $validated['image'] = $image_path;
        }

        if ($validated['type_id'] == 0) $validated['type_id'] = null;

        $locales = $this->locales();
        if ($locales->count()) {
            $val_project = $validated;
            $val_project['name'] = $validated['name'][DEFAULT_LOCALE];
            $val_project['description'] = $validated['description'][DEFAULT_LOCALE];

            $project = Project::create($val_project);

            ## Create a new t_projects
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_project::create([
                        'locale_id' => $locale->id,
                        'project_id' => $project->id,
                        'name' => $validated['name'][$locale->short_sign],
                        'description' => $validated['description'][$locale->short_sign],
                    ]);
                }
            }
        } else {
            Project::create($validated);
        }

        return redirect()->route('project.index')->with('success', __('admin.project_add_success'));
    }

    public function edit(Project $project) {
        $locales = $this->locales();
        $types = Type::all();
        return view('admin.project.edit', compact('project', 'types', 'locales'));
    }

    public function update(Project $project, ProjectRequest $request) {
        $validated = $request->safe()->all();

        // Upload Project Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'projects');

            // Delete Project Image
            Storage::delete('public/' . $project->image);

            $validated['image'] = $image_path;
        }

        if ($validated['type_id'] == 0) $validated['type_id'] = null;

        $locales = $this->locales();
        if ($locales->count()) {
            $val_project = $validated;
            $val_project['name'] = $validated['name'][DEFAULT_LOCALE];
            $val_project['description'] = $validated['description'][DEFAULT_LOCALE];

            $project->update($val_project);

            ## Remove old t_projects then create a new t_projects
            T_project::where('project_id', $project->id)->delete();
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_project::create([
                        'locale_id' => $locale->id,
                        'project_id' => $project->id,
                        'name' => $validated['name'][$locale->short_sign],
                        'description' => $validated['description'][$locale->short_sign],
                    ]);
                }
            }
        } else {
            $project->update($validated);
        }

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
