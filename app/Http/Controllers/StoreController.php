<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the stores.
     */
    public function index(Request $request)
    {
        $query = Store::where('status', 'active');
        
        // Apply location filter if provided
        if ($request->has('location')) {
            $location = $request->location;
            $query->where(function($q) use ($location) {
                $q->where('address', 'like', "%{$location}%")
                  ->orWhere('state', 'like', "%{$location}%");
            });
        }
        
        $stores = $query->paginate(10);
        
        return view('stores.index', compact('stores'));
    }
    
    /**
     * Display the specified store.
     */
    public function show(Store $store)
    {
        // Check if store is active
        if ($store->status !== 'active') {
            abort(404);
        }
        
        return view('stores.show', compact('store'));
    }
}
