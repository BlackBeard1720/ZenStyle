<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $clients = Client::query()
            ->with('user')->when($request->id, function ($query, $id) {
                $query->where('id', $id);
            })
            ->when($request->full_name, function ($query, $fullName) {
                $query->where('full_name', 'like', '%' . $fullName . '%');
            })
            ->when($request->phone, function ($query, $phone) {
                $query->where('phone', 'like', '%' . $phone . '%');
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('staff.clients.index', [
            'clients' => $clients,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('staff.clients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30', 'unique:clients,phone'],
            'email' => ['nullable', 'email', 'max:255', 'unique:clients,email'],
            'dob' => ['nullable', 'date'],
            'preferences' => ['nullable', 'string'],
        ]);

        Client::create([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->filled('email') ? $request->email : null,
            'dob' => $request->dob,
            'preferences' => $request->preferences,
        ]);

        return to_route('staff.clients.index')
            ->with('success', 'Client created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Client $client)
    {
        $client->load(['appointments', 'user']);

        return view('staff.clients.show', ['client' => $client]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Client $client)
    {
        return view('staff.clients.edit', [
            'client' => $client,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'max:30',
                Rule::unique('clients', 'phone')->ignore($client),
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('clients', 'email')->ignore($client),
            ],
            'dob' => ['nullable', 'date'],
            'preferences' => ['nullable', 'string'],
        ]);

        $client->update([
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'email' => $request->filled('email') ? $request->email : null,
            'dob' => $request->dob,
            'preferences' => $request->preferences,
        ]);

        return to_route('staff.clients.index')
            ->with('success', 'Client updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Client $client)
    {
        $client->delete();

        return to_route('staff.clients.index')
            ->with('success', 'Client deleted successfully.');
    }
}
