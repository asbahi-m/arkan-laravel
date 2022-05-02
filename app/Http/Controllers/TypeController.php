<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Type;
use App\Models\T_type;
use App\Models\Locale;

class TypeController extends Controller
{
    public function __construct() {
        $this->locales = Locale::query()
            // ->where('short_sign', '!=', DEFAULT_LOCALE))
            ->whereNull('is_disabled')
            ->select('id', 'short_sign')
            ->get();
    }

    public function index(Request $request) {
        $locales = $this->locales;

        $types = Type::with(['t_types'])->get();
        $types->each(function ($item) {
            $item->original_name = $item->name;
            $locale = Locale::firstWhere('short_sign', app()->getLocale());
            $locale_filter = $item->t_types->filter(function ($value) use ($locale) {
                if ($locale)
                    return $value['locale_id'] == $locale->id;
            })->first();
            if ($locale_filter) $item->name = $locale_filter->name;
            return $item;
        });

        /* $types = Type::with(['t_types' => function ($q) {
            $q->whereHas('locale', function ($q) {
                $q->where('short_sign', app()->getLocale());
            });
        }])->get();
        $types->each(function ($item) {
            $item->original_name = $item->name;
            if ($item->t_types->count()) $item->name = $item->t_types->first()->name;
            return $item;
        }); */

        /* $types = Type::get();
        $types->each(function ($item) {
            $t_types = $item->t_types->transform(function ($t_type) {
                $t_type = $t_type->whereHas('locale', function ($q) {
                    $q->where('short_sign', app()->getLocale());
                })->first();
                return $t_type;
            })->first();
            $item->name = $t_types ? $t_types->name : $item->name;
            return $item;
        }); */
        // return $types;

        return view('admin.type.index', compact('types', 'locales'));
    }

    public function sortByAjax(Request $request) {
        if ($request->ajax()) {
            $types = Type::get();

            if ($request['sortBy'] == 'name') {
                $types = $types->sortBy('name');
            } else if (in_array($request['sortBy'], ['services', 'products', 'projects'])) {
                $types = $types->sortBy(function ($q) use($request) {
                    return $q[$request['sortBy']]->count();
                });
            }

            if ($request['sortByDesc'] == 'name') {
                $types = $types->sortByDesc('name');
            } else if (in_array($request['sortByDesc'], ['services', 'products', 'projects'])) {
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
            // 'name' => ['required', 'string', 'unique:types', 'min:2', 'max:100'],
            'name.*' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $locales = collect($request->name);

        $type = Type::create([
            'name' => $request['name.'. DEFAULT_LOCALE],
        ]);

        if (isset($locales)) {
            foreach ($locales as $key => $locale) {
                if ($key != DEFAULT_LOCALE) {
                    $locale_id = Locale::where('short_sign', $key)->first()->id;
                    T_type::create([
                        'locale_id' => $locale_id,
                        'type_id' => $type->id,
                        'name' => $locale,
                    ]);
                }
            }
        }

        $get_type = Type::where('name', $request['name.'. DEFAULT_LOCALE])->with(['t_types'])->get()->each(function ($item) {
            $item->original_name = $item->name;
            $locale = Locale::firstWhere('short_sign', app()->getLocale());
            $locale_filter = $item->t_types->filter(function ($value) use ($locale) {
                if ($locale)
                    return $value['locale_id'] == $locale->id;
            })->first();
            if ($locale_filter) $item->name = $locale_filter->name;
            return $item;
        });

        $row = view('admin.type.row')->with(['types' => $get_type])->render();

        return response()->json([
            'status' => true,
            'row' => $row,
        ]);
    }

    public function update(Request $request) {
        $type = Type::findOrFail($request['type_id']);
        $request->validate([
            // 'type_name' => ['required', 'string', Rule::unique('types', 'name')->ignore($type->id), 'min:2', 'max:100'],
            'type_name.*' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $locales = collect($request->type_name);

        $type->update([
            'name' => $request['type_name.'. DEFAULT_LOCALE],
        ]);

        if (isset($locales)) {
            T_type::where('type_id', $request['type_id'])->delete();
            foreach ($locales as $key => $locale) {
                $locale_id = Locale::where('short_sign', $key)->first()->id;
                if ($key != DEFAULT_LOCALE) {
                    T_type::create([
                        'locale_id' => $locale_id,
                        'type_id' => $type->id,
                        'name' => $locale,
                    ]);
                }
            }
        }

        $get_type = Type::where('id', $request['type_id'])->with(['t_types'])->get()->each(function ($item) {
            $item->original_name = $item->name;
            $locale = Locale::firstWhere('short_sign', app()->getLocale());
            $locale_filter = $item->t_types->filter(function ($value) use ($locale) {
                if ($locale)
                    return $value['locale_id'] == $locale->id;
            })->first();
            if ($locale_filter) $item->name = $locale_filter->name;
            return $item;
        });

        $type_name = $get_type->first()->name;
        $t_types = $type->t_types->map(function ($item) {
            return [
                $item->locale->short_sign => $item->name
            ];
        })->collapse()->put(DEFAULT_LOCALE, $get_type->first()->original_name);

        return response()->json([
            'status' => true,
            'id' => $type->id,
            'name' => $type_name,
            't_types' => $t_types,
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
