<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ClientRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\Client;
use App\Models\T_client;

use App\Traits\UploadFile;
use App\Traits\GetLocales;

use App\Support\Collection;

class ClientController extends Controller
{
    use UploadFile;
    use GetLocales;

    public function index(Request $request) {
        $clients = Client::query()
            ->withCount('views')
            ->with(['t_clients' => function ($q) {
                $q->whereHas('locale', function ($q) {
                    $q->where('short_sign', app()->getLocale());
                });
            }])
            ->get()
        ;

        // Translate The Clients
        $clients->each(function ($item) {
            $locales = $this->locales();
            if ($item->t_clients->count() && $locales->count()) {
                $item->name = $item->t_clients->first()->name;
            }
            return $item;
        });

        if (in_array($request['sortBy'], ['name', 'is_published', 'views_count', 'created_at'])) {
            $clients = $clients->sortBy($request['sortBy']);
        }

        if (in_array($request['sortByDesc'], ['name', 'is_published', 'views_count', 'created_at'])) {
            $clients = $clients->sortByDesc($request['sortByDesc']);
        }

        $clients = (new Collection($clients))->paginate(PAGINATION_NUMBER)->withQueryString();

        return view('admin.client.index', compact('clients'));
    }

    public function create() {
        $locales = $this->locales();
        return view('admin.client.create', compact('locales'));
    }

    public function store(ClientRequest $request) {
        $validated = $request->safe()->all();

        // Upload Client Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'clients');

            $validated['image'] = $image_path;
        }

        $locales = $this->locales();
        if ($locales->count()) {
            $val_client = $validated;
            $val_client['name'] = $validated['name'][DEFAULT_LOCALE];

            $client = Client::create($val_client);

            ## Create a new t_clients
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_client::create([
                        'locale_id' => $locale->id,
                        'client_id' => $client->id,
                        'name' => $validated['name'][$locale->short_sign],
                    ]);
                }
            }
        } else {
            Client::create($validated);
        }

        return redirect()->route('client.index')->with('success', __('admin.client_add_success'));
    }

    public function edit(Client $client) {
        $locales = $this->locales();
        return view('admin.client.edit', compact('client', 'locales'));
    }

    public function update(Client $client, ClientRequest $request) {
        $validated = $request->safe()->all();

        // Upload Client Image
        if ($request->hasFile('image')) {
            $image_path = $this->saveFile($request->file('image'), 'clients');

            // Delete Client Image
            Storage::delete('public/' . $client->image);

            $validated['image'] = $image_path;
        }

        $locales = $this->locales();
        if ($locales->count()) {
            $val_client = $validated;
            $val_client['name'] = $validated['name'][DEFAULT_LOCALE];

            $client->update($val_client);

            ## Remove old t_clients then create a new t_clients
            T_client::where('client_id', $client->id)->delete();
            foreach ($locales as $locale) {
                if ($locale->short_sign != DEFAULT_LOCALE) {
                    T_client::create([
                        'locale_id' => $locale->id,
                        'client_id' => $client->id,
                        'name' => $validated['name'][$locale->short_sign],
                    ]);
                }
            }
        } else {
            $client->update($validated);
        }

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
