<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\T_product;
use App\Models\Type;
use App\Traits\UploadFile;
use App\Traits\GetLocales;
use App\Models\Locale;
use App\Support\Collection;

class ProductController extends Controller
{
    use UploadFile;
    use GetLocales;

    public function index(Request $request) {
        $products = Product::query()
            ->withCount('views')
            ->with(['t_products' => function ($q) {
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

        // Translate The Products
        $products->each(function ($item) {
            $locales = $this->locales();
            if ($item->t_products->count() && $locales->count()) {
                $item->name = $item->t_products->first()->name;
                $item->description = $item->t_products->first()->description;
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
            $products = $products->sortBy($request['sortBy']);
        }

        if (in_array($request['sortByDesc'], ['name', 'type_name', 'description', 'is_published', 'views_count', 'created_at'])) {
            $products = $products->sortByDesc($request['sortByDesc']);
        }

        $products = (new Collection($products))->paginate(PAGINATION_NUMBER)->withQueryString();

        return view('admin.product.index', compact('products'));
    }

    public function create() {
        $locales = $this->locales();
        $types = Type::all();
        return view('admin.product.create', compact('types', 'locales'));
    }

    public function store(ProductRequest $request) {
        $validated = $request->safe()->all();

        // Upload Product Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'products');

            $validated['image'] = $image_path;
        }

        if ($validated['type_id'] == 0) $validated['type_id'] = null;

        $locales = $this->locales();
        if ($locales->count()) {
            $val_product = $validated;
            $val_product['name'] = $validated['name'][DEFAULT_LOCALE];
            $val_product['description'] = $validated['description'][DEFAULT_LOCALE];

            $product = Product::create($val_product);

            ## Create a new t_products
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_product::create([
                        'locale_id' => $locale->id,
                        'product_id' => $product->id,
                        'name' => $request['name'][$locale->short_sign],
                        'description' => isset($request['description'][$locale->short_sign]) ? $request['description'][$locale->short_sign] : null,
                    ]);
                }
            }
        } else {
            Product::create($validated);
        }

        return redirect()->route('product.index')->with('success', __('admin.product_add_success'));
    }

    public function edit(Product $product) {
        $locales = $this->locales();
        $types = Type::all();
        return view('admin.product.edit', compact('product', 'types', 'locales'));
    }

    public function update(Product $product, ProductRequest $request) {
        $validated = $request->safe()->all();

        // Upload Product Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'products');

            // Delete Product Image
            Storage::delete('public/' . $product->image);

            $validated['image'] = $image_path;
        }

        if ($validated['type_id'] == 0) $validated['type_id'] = null;

        $locales = $this->locales();
        if ($locales->count()) {
            $val_product = $validated;
            $val_product['name'] = $validated['name'][DEFAULT_LOCALE];
            $val_product['description'] = isset($validated['description'][DEFAULT_LOCALE]) ? $validated['description'][DEFAULT_LOCALE] : null;

            $product->update($val_product);

            ## Remove old t_products then create a new t_products
            T_product::where('product_id', $product->id)->delete();
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_product::create([
                        'locale_id' => $locale->id,
                        'product_id' => $product->id,
                        'name' => $validated['name'][$locale->short_sign],
                        'description' => isset($validated['description'][$locale->short_sign]) ? $validated['description'][$locale->short_sign] : null,
                    ]);
                }
            }
        } else {
            $product->update($validated);
        }

        return redirect()->route('product.index')->with('success', __('admin.product_update_success'));
    }

    public function destroy(Request $request) {
        $product = Product::findOrFail($request['delete']);

        // Delete Product Image
        Storage::delete('public/' . $product->image);

        $product->delete();

        return back()->with('success', __('admin.product_delete_success'));
    }


    // API's
    public function viewAPI() {
        $result = Product::all();
        return $result;
    }
}
