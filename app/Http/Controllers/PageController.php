<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;
use App\Models\Page;
use App\Models\T_page;
use App\Traits\UploadFile;
use App\Traits\GetLocales;
use App\Support\Collection;

class PageController extends Controller
{
    use UploadFile;
    use GetLocales;

    public function index(Request $request) {
        $pages = Page::query()
            ->withCount('views')
            ->with(['t_pages' => function ($q) {
                $q->whereHas('locale', function ($q) {
                    $q->where('short_sign', app()->getLocale());
                });
            }])
            ->get()
        ;

        // Translate The Features
        $pages->each(function ($item) {
            $locales = $this->locales();
            if ($item->t_pages->count() && $locales->count()) {
                $item->title = $item->t_pages->first()->title;
                $item->subtitle = $item->t_pages->first()->subtitle;
                $item->description = $item->t_pages->first()->description;
            }
            $item->author = $item->user->name;
            return $item;
        });

        if (in_array($request['sortBy'], ['title', 'author', 'is_published', 'views_count', 'created_at'])) {
            $pages = $pages->sortBy($request['sortBy']);
        }

        if (in_array($request['sortByDesc'], ['title', 'author', 'is_published', 'views_count', 'created_at'])) {
            $pages = $pages->sortByDesc($request['sortByDesc']);
        }

        $pages = (new Collection($pages))->paginate(PAGINATION_NUMBER);

        return view('admin.page.index', compact('pages'));
    }

    public function create() {
        $locales = $this->locales();
        return view('admin.page.create', compact('locales'));
    }

    public function store(PageRequest $request) {
        $validated = $request->safe()->all();

        // Upload Page Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'pages');

            $validated['image'] = $image_path;
        }

        if (isset($validated['templates'])) $validated['templates'] = json_encode($validated['templates']);

        $validated['user_id'] = auth()->user()->id;

        $locales = $this->locales();
        if ($locales->count()) {
            $validated['slug'] = ($validated['slug'] ? Str::slug($validated['slug'], '-') : Str::slug($validated['title'][DEFAULT_LOCALE], '-'));
            $val_page = $validated;
            $val_page['title'] = $validated['title'][DEFAULT_LOCALE];
            $val_page['subtitle'] = $validated['subtitle'][DEFAULT_LOCALE];
            $val_page['description'] = $validated['description'][DEFAULT_LOCALE];

            $page = Page::create($val_page);

            ## Create a new t_pages
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_page::create([
                        'locale_id' => $locale->id,
                        'page_id' => $page->id,
                        'title' => $validated['title'][$locale->short_sign],
                        'subtitle' => $validated['subtitle'][$locale->short_sign],
                        'description' => $validated['description'][$locale->short_sign],
                    ]);
                }
            }
        } else {
            $validated['slug'] = ($validated['slug'] ? Str::slug($validated['slug'], '-') : Str::slug($validated['title'], '-'));
            Page::create($validated);
        }

        return redirect()->route('page.index')->with('success', __('admin.page_add_success'));
    }

    public function edit(Page $page) {
        $locales = $this->locales();
        return view('admin.page.edit', compact('page', 'locales'));
    }

    public function update(Page $page, PageRequest $request) {
        $validated = $request->safe()->all();

        // Upload Page Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'pages');

            // Delete Page Image
            Storage::delete('public/' . $page->image);

            $validated['image'] = $image_path;
        }

        if (isset($validated['templates'])) $validated['templates'] = json_encode($validated['templates']);

        $validated['update_by'] = auth()->user()->id;

        $locales = $this->locales();
        if ($locales->count()) {
            $validated['slug'] = ($validated['slug'] ? Str::slug($validated['slug'], '-') : Str::slug($validated['title'][DEFAULT_LOCALE], '-'));
            $val_page = $validated;
            $val_page['title'] = $validated['title'][DEFAULT_LOCALE];
            $val_page['subtitle'] = $validated['subtitle'][DEFAULT_LOCALE];
            $val_page['description'] = $validated['subtitle'][DEFAULT_LOCALE];

            $page->update($val_page);

            ## Remove old t_pages then create a new t_pages
            T_page::where('page_id', $page->id)->delete();
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_page::create([
                        'locale_id' => $locale->id,
                        'page_id' => $page->id,
                        'title' => $validated['title'][$locale->short_sign],
                        'subtitle' => $validated['subtitle'][$locale->short_sign],
                        'description' => $validated['description'][$locale->short_sign],
                    ]);
                }
            }
        } else {
            $validated['slug'] = ($validated['slug'] ? Str::slug($validated['slug'], '-') : Str::slug($validated['title'], '-'));
            $page->update($validated);
        }

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
