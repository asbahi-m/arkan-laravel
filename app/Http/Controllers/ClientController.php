<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Storage;
use Validator;
use App\Models\Client;

class ClientController extends Controller
{
    public function index(Request $request) {
        $clients = Client::query();

        if (in_array($request['sortBy'], ['name', 'is_published', 'created_at'])) {
            $clients->orderBy($request['sortBy']);
        }

        if (in_array($request['sortByDesc'], ['name', 'is_published', 'created_at'])) {
            $clients->orderByDesc($request['sortByDesc']);
        }

        $clients = $clients->paginate(20)->withQueryString();

        return view('admin.client.index', compact('clients'));
    }

    public function create() {
        return view('admin.client.create');
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'url_address' => ['nullable', 'url'],
            'is_published' => ['required', 'boolean'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Upload Client Image
        if (isset($request['image'])) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'clients/' . $image_name;

            $image->storePubliclyAs('clients', $image_name, 'public');
        }

        Client::create([
            'name' => $request['name'],
            'url_address' => $request['url_address'],
            'is_published' => $request['is_published'],
            'image' => isset($request['image']) ? $image_path : null,
        ]);

        return redirect()->route('client.index')->with('success', __('admin.client_add_success'));
    }

    public function edit(Client $client) {
        return view('admin.client.edit', compact('client'));
    }

    public function update(Client $client, Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'url_address' => ['nullable', 'url'],
            'is_published' => ['required', 'boolean'],
            'image' => ['nullable', 'mimes:png,jpg,jpeg', 'max:1024'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Upload Client Image
        if (isset($request['image'])) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'clients/' . $image_name;

            $image->storePubliclyAs('clients', $image_name, 'public');

            // Delete Client Image
            Storage::delete('public/' . $client->image);
        }

        $client->update([
            'name' => $request['name'],
            'url_address' => $request['url_address'],
            'is_published' => $request['is_published'],
            'image' => isset($request['image']) ? $image_path : $client->image,
        ]);

        return redirect()->route('client.index')->with('success', __('admin.client_update_success'));

    }

    public function destroy(Request $request) {
        $client = Client::findOrFail($request['delete']);

        // Delete Client Image
        Storage::delete('public/' . $client->image);

        $client->delete();

        return back()->with('success', __('admin.client_delete_success'));
    }
}
