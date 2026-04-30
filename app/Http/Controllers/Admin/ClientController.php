<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        if ($q = trim((string) $request->query('q'))) {
            $query->where(function ($w) use ($q) {
                $w->where('email', 'like', "%{$q}%")
                  ->orWhere('name', 'like', "%{$q}%")
                  ->orWhere('company', 'like', "%{$q}%");
            });
        }
        if ($status = $request->query('status')) {
            $query->where('status', $status);
        }

        $clients = $query->latest()->paginate(25)->withQueryString();

        return view('admin.clients.index', [
            'clients'  => $clients,
            'filters'  => $request->only(['q', 'status']),
            'statuses' => Client::STATUSES,
        ]);
    }

    public function update(Request $request, Client $client)
    {
        $data = $request->validate([
            'status'    => 'nullable|in:' . implode(',', Client::STATUSES),
            'notes'     => 'nullable|string|max:5000',
            'service'   => 'nullable|string|max:160',
            'start_date'=> 'nullable|date',
            'end_date'  => 'nullable|date',
        ]);

        $client->fill(array_filter($data, fn ($v) => $v !== null))->save();

        return back()->with('flash', 'Client updated.');
    }
}
