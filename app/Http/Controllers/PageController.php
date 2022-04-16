<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use Storage;
use Rule;
use Str;
use App\Models\Page;
use App\Traits\UploadFile;

class PageController extends Controller
{
    use UploadFile;

    public function index(Request $request) {
        $pages = Page::query();

        if (in_array($request['sortBy'], ['title', 'author', 'is_published', 'created_at'])) {
            if ($request['sortBy'] == 'author') {
                $pages->join('users', 'users.id', '=', 'pages.user_id')
                ->select('pages.*', 'users.name as username')
                ->orderBy('username');
            } else {
                $pages->orderBy($request['sortBy']);
            }
        }

        if (in_array($request['sortByDesc'], ['title', 'author', 'is_published', 'created_at'])) {
            if ($request['sortByDesc'] == 'author') {
                $pages->join('users', 'users.id', '=', 'pages.user_id')
                ->select('pages.*', 'users.name as username')
                ->orderByDesc('username');
            } else {
                $pages->orderByDesc($request['sortByDesc']);
            }
        }

        $pages = $pages->paginate(20)->withQueryString();

        return view('admin.page.index', compact('pages'));
    }

    public function create() {
        return view('admin.page.create');
    }

    public function store(PageRequest $request) {
        $request->validate([
            'title' => [Rule::unique('pages')],
        ]);

        $validated = $request->safe();

        // Upload Page Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'pages');

            $validated['image'] = $image_path;
        }

        if (isset($validated['templates'])) $validated['templates'] = json_encode($validated['templates']);

        $validated['slug'] = ($validated['slug'] ? Str::slug($validated['slug'], '-') : Str::slug($validated['title'], '-'));

        Page::create($validated->merge(['user_id' => auth()->user()->id])->all());

        return redirect()->route('page.index')->with('success', __('admin.page_add_success'));
    }

    public function edit(Page $page) {
        return view('admin.page.edit', compact('page'));
    }

    public function update(Page $page, PageRequest $request) {
        $request->validate([
            'title' => [Rule::unique('pages')->ignore($page->id)],
        ]);

        $validated = $request->safe();

        // Upload Page Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'pages');

            // Delete Page Image
            Storage::delete('public/' . $page->image);

            $validated['image'] = $image_path;
        }

        if (isset($validated['templates'])) $validated['templates'] = json_encode($validated['templates']);

        $validated['slug'] = ($validated['slug'] ? Str::slug($validated['slug'], '-') : Str::slug($validated['title'], '-'));

        $page->update($validated->merge(['update_by' => auth()->user()->id])->all());

        return redirect()->route('page.index')->with('success', __('admin.page_update_success'));
    }

    public function destroy(Request $request) {
        $page = Page::findOrFail($request['delete']);

        // Delete Page Image
        Storage::delete('public/' . $page->image);

        $page->delete();

        return back()->with('success', __('admin.page_delete_success'));
    }
}
