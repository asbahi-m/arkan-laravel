<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Storage;
use App\Models\Product;
use App\Models\Type;

class ProductController extends Controller
{
    public function index(Request $request) {
        $products = Product::query();

        if (in_array($request['sortBy'], ['name', 'type', 'description', 'is_published', 'created_at'])) {
            if ($request['sortBy'] == 'type') {
                $products->join('types', 'types.id', '=', 'products.type_id')
                ->select('products.*', 'types.name as type_name')
                ->orderBy('type_name');
            } else {
                $products->orderBy($request['sortBy']);
            }
        }

        if (in_array($request['sortByDesc'], ['name', 'type', 'description', 'is_published', 'created_at'])) {
            if ($request['sortByDesc'] == 'type') {
                $products->join('types', 'types.id', '=', 'products.type_id')
                ->select('products.*', 'types.name as type_name')
                ->orderByDesc('type_name');
            } else {
                $products->orderByDesc($request['sortByDesc']);
            }
        }

        $products = $products->paginate(20)->withQueryString();

        return view('admin.product.index', compact('products'));
    }

    public function create() {
        $types = Type::all();
        return view('admin.product.create', compact('types'));
    }

    public function store(ProductRequest $request) {
        $validated = $request->safe()->all();

        // Upload Product Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'products/' . $image_name;

            $image->storePubliclyAs('products', $image_name, 'public');

            $validated['image'] = $image_path;
        }

        if ($validated['type_id'] == 0) $validated['type_id'] = null;

        Product::create($validated);

        return redirect()->route('product.index')->with('success', __('admin.product_add_success'));
    }

    public function edit(Product $product) {
        $types = Type::all();
        return view('admin.product.edit', compact('product', 'types'));
    }

    public function update(Product $product, ProductRequest $request) {
        $validated = $request->safe()->all();

        // Upload Product Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'products/' . $image_name;

            $image->storePubliclyAs('products', $image_name, 'public');

            // Delete Product Image
            Storage::delete('public/' . $product->image);

            $validated['image'] = $image_path;
        }

        if ($validated['type_id'] == 0) $validated['type_id'] = null;

        $product->update($validated);

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
