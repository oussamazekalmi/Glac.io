<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin')->only([
            'index', 'create', 'store', 'edit', 'update',
        ]);
    }

    public function index()
    {
        $clients = Client::where('status', 'active')->get();
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => [
                'nullable',
                'regex:/^(05|06|07)[0-9]{8}$/'
            ],
        ]);

        Client::create([
            'full_name' => $request->full_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'status' => 'active',
        ]);

        return redirect()->route('clients.index')->with('success', 'Client ajouté avec succès.');
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => [
                'nullable',
                'regex:/^(05|06|07)[0-9]{8}$/'
            ],
            'status' => 'required|in:active,inactive',
        ]);

        $client = Client::findOrFail($id);

        $client->update([
            'full_name' => $request->full_name,
            'address' => $request->address,
            'phone' => $request->phone,
            'status' => $request->status,
        ]);

        return redirect()->route('clients.index')->with('success', 'Client modifié avec succès.');
    }
}
