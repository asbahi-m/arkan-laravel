<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use Storage;
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

    public function store(ClientRequest $request) {
        $validated = $request->safe()->all();

        // Upload Client Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'clients/' . $image_name;

            $image->storePubliclyAs('clients', $image_name, 'public');

            $validated['image'] = $image_path;
        }

        Client::create($validated);

        return redirect()->route('client.index')->with('success', __('admin.client_add_success'));
    }

    public function edit(Client $client) {
        return view('admin.client.edit', compact('client'));
    }

    public function update(Client $client, ClientRequest $request) {
        $validated = $request->safe()->all();

        // Upload Client Image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_ext = $image->extension();
            $image_name = time() . '.' . $image_ext;
            $image_path = 'clients/' . $image_name;

            $image->storePubliclyAs('clients', $image_name, 'public');

            // Delete Client Image
            Storage::delete('public/' . $client->image);

            $validated['image'] = $image_path;
        }

        $client->update($validated);

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
