<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Type;
use App\Models\T_type;
use App\Models\Locale;
use App\Traits\GetLocales;

class TypeController extends Controller
{
    use GetLocales;

    public function index(Request $request) {
        $locales = $this->locales();
        if ($locales->count()) {
            $types = Type::with(['t_types'])->get();
            $types->each(function ($item) {
                $item->original_name = $item->name;
                $locale = Locale::firstWhere('short_sign', app()->getLocale());
                $locale_filter = $item->t_types->filter(function ($value) use ($locale) {
                    if ($locale)
                        return $value['locale_id'] == $locale->id;
                })->first();
                if ($locale_filter) $item->name = $locale_filter->name;
                $item->t_types = $item->t_types->map(function ($item) {
                    return [
                        $item->locale->short_sign => $item->name
                    ];
                })->collapse()->put(DEFAULT_LOCALE, $item->original_name)->toJson();
                return $item;
            });
        } else {
            $types = Type::get();
        }

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
            $locales = $this->locales();
            if ($locales->count()) {
                $types = Type::with('t_types')->get();
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
            } else {
                $types = Type::get();
            }

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

            $types_view = view('admin.type.row')->with(['types' => $types, 'locales' => $locales])->render();

            return response()->json([
                'status' => true,
                'data' => $types_view,
            ]);
        }
    }

    public function inline_store(Request $request) {
        $locales = $this->locales();
        if ($locales->count()) {
            $request->validate([
                'name.*' => ['required', 'string', 'min:2', 'max:100'],
            ]);
            ## Create Type with T_types
            $type = Type::create([
                'name' => $request['name.'. DEFAULT_LOCALE],
            ]);
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_type::create([
                        'locale_id' => $locale->id,
                        'type_id' => $type->id,
                        'name' => $request['name'][$locale->short_sign],
                    ]);
                }
            }
            $get_type = Type::where('name', $request['name.'. DEFAULT_LOCALE])->with(['t_types'])->get();
            $get_type->each(function ($item) {
                $item->original_name = $item->name;
                $locale = Locale::firstWhere('short_sign', app()->getLocale());
                $locale_filter = $item->t_types->filter(function ($value) use ($locale) {
                    if ($locale)
                        return $value['locale_id'] == $locale->id;
                })->first();
                if ($locale_filter) $item->name = $locale_filter->name;
                $item->t_types = $item->t_types->map(function ($item) {
                    return [
                        $item->locale->short_sign => $item->name
                    ];
                })->collapse()->put(DEFAULT_LOCALE, $item->original_name)->toJson();
                return $item;
            });
        } else {
            $request->validate([
                'name' => ['required', 'string', 'unique:types', 'min:2', 'max:100'],
            ]);
            ## Create Type without translate
            $type = Type::create([
                'name' => $request['name'],
            ]);
            $get_type = Type::where('name', $request['name'])->get();
        }

        $row = view('admin.type.row')->with(['types' => $get_type, 'locales' => $locales])->render();

        return response()->json([
            'status' => true,
            'row' => $row,
        ]);
    }

    public function update(Request $request) {
        $type = Type::findOrFail($request['type_id']);

        $locales = $this->locales();
        if ($locales->count()) {
            $request->validate([
                'type_name.*' => ['required', 'string', 'min:2', 'max:100'],
            ]);
            ## Update Type with T_types
            $type->update([
                'name' => $request['type_name.'. DEFAULT_LOCALE],
            ]);
            T_type::where('type_id', $request['type_id'])->delete();
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_type::create([
                        'locale_id' => $locale->id,
                        'type_id' => $type->id,
                        'name' => $request['type_name'][$locale->short_sign],
                    ]);
                }
            }
            $get_type = Type::where('id', $request['type_id'])->with(['t_types'])->get();
            $get_type->each(function ($item) {
                $item->original_name = $item->name;
                $locale = Locale::firstWhere('short_sign', app()->getLocale());
                $locale_filter = $item->t_types->filter(function ($value) use ($locale) {
                    if ($locale)
                        return $value['locale_id'] == $locale->id;
                })->first();
                if ($locale_filter) $item->name = $locale_filter->name;
                $item->t_types = $item->t_types->map(function ($item) {
                    return [
                        $item->locale->short_sign => $item->name
                    ];
                })->collapse()->put(DEFAULT_LOCALE, $item->original_name)->toJson();
                return $item;
            });
        } else {
            $request->validate([
                'type_name' => ['required', 'string', Rule::unique('types', 'name')->ignore($type->id), 'min:2', 'max:100'],
            ]);
            ## Update Type without translate
            $type->update([
                'name' => $request['type_name'],
            ]);
        }

        return response()->json([
            'status' => true,
            'id' => $type->id,
            'name' => isset($get_type) ? $get_type->first()->name : $type->name,
            't_types' => isset($get_type) ? $get_type->first()->t_types : $type->name,
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
