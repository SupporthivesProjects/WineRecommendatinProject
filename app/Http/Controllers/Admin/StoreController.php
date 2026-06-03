<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use App\Models\CheeseProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Feature;
use App\Models\StoreFeature;


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
            'address1' => 'required|string',
            'address2' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'location' => 'required|string|max:50',
            'city' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'state' => 'required|string|max:255',
            'licence_type' => 'required|string|max:255',
            'license_number' => 'required|string|max:255',
            'group' => 'nullable|string|max:255',
            'gst_vat' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        // Store::create($validated);
        $store = Store::create($validated);

        $features = Feature::where('status', 1)->get();

        foreach ($features as $feature) {
            StoreFeature::create([
                'store_id'  => $store->id,
                'feature_id' => $feature->id,
                'enabled'   => 0,
            ]);
        }

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store created successfully.');
    }

    
    public function show(Store $store)
    {
        $store->load('users');

        $activeProducts = $store->products()
            ->wherePivot('status', 'active')
            ->get();

        $storeProducts = $store->products()->get();

        $cheeseProducts = $store->cheeseProducts()
            ->withPivot(['quantity', 'is_available'])
            ->get();

        $assignedCheeseIds = $cheeseProducts->pluck('id');

        $availableCheeses = CheeseProduct::whereNotIn('id', $assignedCheeseIds)
            ->orderBy('name')
            ->get();

        $assignedProductIds = $storeProducts->pluck('id');

        $availableProducts = Product::whereNotIn('id', $assignedProductIds)
            ->orderBy('wine_name')
            ->get();

        $features = $store->features()->orderBy('name')->get();

        return view(
            'admin.stores.show',
            compact(
                'store',
                'activeProducts',
                'storeProducts',
                'availableProducts',
                'cheeseProducts',
                'availableCheeses',
                'features'
            )
        );
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
            'address1' => 'required|string',
            'address2' => 'required|string',
            'contact_number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
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


    // Admin Add cheese
    public function addCheese(Request $request, Store $store)
    {
        $request->validate([
            'cheese_ids' => 'required|array',
            'cheese_ids.*' => 'exists:cheese_products,id',
        ]);

        $data = [];

        foreach ($request->cheese_ids as $cheeseId) {
            $data[$cheeseId] = [
                'quantity' => 10,
                'is_available' => true,
            ];
        }
        
        $store->cheeseProducts()->syncWithoutDetaching($data);

        return back()->with(
            'success',
            'Cheese added successfully.'
        );
    }

    public function toggleCheese(Request $request,Store $store,CheeseProduct $cheese)
    {
        $status = (bool) $request->status;
    
        $store->cheeseProducts()->updateExistingPivot(
            $cheese->id,
            [
                'is_available' => $status,
                'updated_at' => now(),
            ]
        );
    
        return back()->with(
            'success',
            'Cheese status updated successfully.'
        );
    }

    //admin adds wine to store
    public function addProducts(Request $request, Store $store)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $data = [];

        foreach ($request->product_ids as $productId) {
            $data[$productId] = [
                'status' => 'active',
            ];
        }

        $store->products()->syncWithoutDetaching($data);

        return back()->with(
            'success',
            'Products added successfully.'
        );
    }

    public function toggleProduct(Request $request,Store $store,Product $product)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);
    
        $store->products()->updateExistingPivot(
            $product->id,
            [
                'status' => $request->status,
                'updated_at' => now(),
            ]
        );
    
        return back()->with(
            'success',
            'Product status updated successfully.'
        );
    }


    public function toggleFeature(Request $request,Store $store,Feature $feature)
    {
        $enabled = (bool) $request->enabled;
    
        $store->features()->updateExistingPivot(
            $feature->id,
            [
                'enabled' => $enabled,
                'updated_at' => now(),
            ]
        );
    
        return response()->json([
            'success' => true,
            'enabled' => $enabled,
        ]);
    }


}
