<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the stores.
     */
    public function index()
    {
        $stores = Store::orderBy('id', 'asc')->get();
        return view('admin.dashboard.stores-tab', compact('stores'));
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
    // public function show(Store $store)
    // {
    //     return view('admin.stores.show', compact('store'));
    // }
    public function show(Store $store)
    {
        $store->load('users');

        $activeProducts = $store->products()->wherePivot('status', 'active')->get();

        return view('admin.stores.show', compact('store', 'activeProducts'));
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
    /**
     * Get available store managers that can be assigned to this store.
     */
    public function getAvailableManagers(Store $store)
    {
        // Get users with role 'store_manager' who are not assigned to any store or assigned to this store
        $availableManagers = User::where('role', 'store_manager')
            ->where(function ($query) use ($store) {
                $query->whereNull('store_id')
                    ->orWhere('store_id', $store->id);
            })
            ->select('id', 'first_name', 'last_name', 'email')
            ->get();

        return response()->json($availableManagers);
    }

    /**
     * Assign a user to this store.
     */
    public function assignUser(Request $request, Store $store)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($validated['user_id']);

        // Check if the user is a store manager
        if ($user->role !== 'store_manager') {
            return response()->json([
                'success' => false,
                'message' => 'Only store managers can be assigned to stores',
            ], 422);
        }

        // Assign the user to the store
        $user->store_id = $store->id;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'User assigned to store successfully',
        ]);
    }
}
