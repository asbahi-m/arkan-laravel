<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Validator;
use Str;
use Illuminate\Validation\Rule;
use App\Models\Page;

class PageController extends Controller
{
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

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'unique:pages', 'min:3', 'max:255'],
            'subtitle' => ['nullable', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_published' => ['required', 'boolean'],
            'is_marker' => ['nullable', 'boolean'],
            'templates' => ['nullable', 'array'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
            'view_image' => ['nullable', 'boolean'],
            'slug' => ['nullable', 'string', 'min:3', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Upload Page Image
        if (isset($request['image'])) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'pages/' . $image_name;

            $image->storePubliclyAs('pages', $image_name, 'public');
        }

        Page::create([
            'user_id' => auth()->user()->id,
            // 'update_by' => '',
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'description' => $request['description'],
            'is_published' => $request['is_published'],
            'is_marker' => $request['is_marker'],
            'templates' => json_encode($request['templates']),
            'image' => isset($request['image']) ? $image_path : null,
            'view_image' => $request['view_image'],
            'slug' => $request['slug'] ? Str::slug($request['slug'], '-') : Str::slug($request['title'], '-'),
        ]);

        return redirect()->route('pages')->with('success', __('admin.page_add_success'));
    }

    public function edit(Page $page) {
        return view('admin.page.edit', compact('page'));
    }

    public function update(Page $page, Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', Rule::unique('pages')->ignore($page->id), 'min:3', 'max:255'],
            'subtitle' => ['nullable', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string'],
            'is_published' => ['required', 'boolean'],
            'is_marker' => ['nullable', 'boolean'],
            'templates' => ['nullable', 'array'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
            'view_image' => ['nullable', 'boolean'],
            'slug' => ['nullable', 'string', 'min:3', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // dd($request->all());

        // Upload Page Image
        if (isset($request['image'])) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'pages/' . $image_name;

            $image->storePubliclyAs('pages', $image_name, 'public');

            // Delete Page Image
            Storage::delete('public/' . $page->image);
        }

        $page->update([
            'update_by' => auth()->user()->id,
            'title' => $request['title'],
            'subtitle' => $request['subtitle'],
            'description' => $request['description'],
            'is_published' => $request['is_published'],
            'is_marker' => $request['is_marker'],
            'templates' => isset($request['templates']) ? json_encode($request['templates']) : null,
            'image' => isset($request['image']) ? $image_path : $page->image,
            'view_image' => $request['view_image'],
            'slug' => $request['slug'] ? Str::slug($request['slug'], '-') : Str::slug($request['title'], '-'),
        ]);

        return redirect()->route('pages')->with('success', __('admin.page_update_success'));
    }

    public function delete(Request $request) {
        $page = Page::findOrFail($request['delete']);

        // Delete Page Image
        Storage::delete('public/' . $page->image);

        $page->delete();

        return back()->with('success', __('admin.page_delete_success'));
    }
}
