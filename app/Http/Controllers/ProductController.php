<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Validator;
use Illuminate\Validation\Rule;
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

    public function store(Request $request) {
        $types = Type::all('id')->pluck('id')->push(0)->toArray();
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['nullable', 'string'],
            'type' => ['nullable', Rule::in($types)],
            'is_published' => ['required', 'boolean'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Upload Product Image
        if (isset($request['image'])) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'products/' . $image_name;

            $image->storePubliclyAs('products', $image_name, 'public');
        }

        Product::create([
            'name' => $request['name'],
            'description' => $request['description'],
            'type_id' => $request['type'] == 0 ? null : $request['type'],
            'is_published' => $request['is_published'],
            'image' => isset($request['image']) ? $image_path : null,
        ]);

        return redirect()->route('products.all')->with('success', __('admin.product_add_success'));
    }

    public function edit(Product $product) {
        $types = Type::all();
        return view('admin.product.edit', compact('product', 'types'));
    }

    public function update(Product $product, Request $request) {
        $types = Type::all('id')->pluck('id')->push(0)->toArray();
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['nullable', 'string'],
            'type' => ['nullable', Rule::in($types)],
            'is_published' => ['required', 'boolean'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Upload Product Image
        if (isset($request['image'])) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'products/' . $image_name;

            $image->storePubliclyAs('products', $image_name, 'public');

            // Delete Product Image
            Storage::delete('public/' . $product->image);
        }

        $product->update([
            'name' => $request['name'],
            'description' => $request['description'],
            'type_id' => $request['type'] == 0 ? null : $request['type'],
            'is_published' => $request['is_published'],
            'image' => isset($request['image']) ? $image_path : $product->image,
        ]);

        return redirect()->route('products.all')->with('success', __('admin.product_update_success'));

    }

    public function delete(Request $request) {
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
