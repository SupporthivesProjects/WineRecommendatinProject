<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the stores.
     */
    public function index()
    {
        $stores = Store::all();
        return view('admin.stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new store.
     */
    public function create()
    {
        return view('admin.stores.create');
    }

    /**
     * Store a newly created store in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'business_type' => 'required|string|max:255',
            'store_name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'state' => 'required|string|max:255',
            'licence_type' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'group' => 'nullable|string|max:255',
            'gst_vat' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Store::create($validated);

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store created successfully.');
    }

    /**
     * Display the specified store.
     */
    public function show(Store $store)
    {
        return view('admin.stores.show', compact('store'));
    }

    /**
     * Show the form for editing the specified store.
     */
    public function edit(Store $store)
    {
        return view('admin.stores.edit', compact('store'));
    }

    /**
     * Update the specified store in storage.
     */
    public function update(Request $request, Store $store)
    {
        $validated = $request->validate([
            'business_type' => 'required|string|max:255',
            'store_name' => 'required|string|max:255',
            'address' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'state' => 'required|string|max:255',
            'licence_type' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'group' => 'nullable|string|max:255',
            'gst_vat' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $store->update($validated);

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store updated successfully.');
    }

    /**
     * Remove the specified store from storage.
     */
    public function destroy(Store $store)
    {
        $store->delete();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store deleted successfully.');
    }
}
