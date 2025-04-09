<?php

namespace App\Http\Controllers\StoreManager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     */
    public function index()
    {
        $allProducts = Product::where('status', 'active')->get();
        $store = Auth::user()->store;
        $storeProducts = $store->products->pluck('id')->toArray();
        
        return view('store-manager.products.index', compact('allProducts', 'storeProducts'));
    }
    
    /**
     * Update the store's product selection.
     */
    public function updateStoreProducts(Request $request)
    {
        $validated = $request->validate([
            'product_ids' => 'required|array',
            'product_ids.*' => 'exists:products,id',
        ]);
        
        $store = Auth::user()->store;
        
        // Sync the products with the store
        $store->products()->sync($validated['product_ids']);
        
        return redirect()->route('store-manager.products.index')
            ->with('success', 'Store products updated successfully.');
    }
    
    /**
     * Display products available in the store.
     */
    public function storeProducts()
    {
        $store = Auth::user()->store;
        $products = $store->products()->where('status', 'active')->get();
        
        return view('store-manager.products.store-products', compact('products'));
    }
    
    /**
     * Display and manage featured products.
     */
    public function featuredProducts()
    {
        $store = Auth::user()->store;
        $storeProducts = $store->products()->where('status', 'active')->get();
        $featuredProducts = $store->featuredProducts->pluck('id')->toArray();
        
        return view('store-manager.products.featured', compact('storeProducts', 'featuredProducts'));
    }
    
    /**
     * Update the store's featured products.
     */
    public function updateFeaturedProducts(Request $request)
    {
        $validated = $request->validate([
            'featured_product_ids' => 'required|array',
            'featured_product_ids.*' => 'exists:products,id',
        ]);
        
        $store = Auth::user()->store;
        
        // Ensure all featured products are from the store's products
        $storeProductIds = $store->products->pluck('id')->toArray();
        $validFeaturedIds = array_intersect($validated['featured_product_ids'], $storeProductIds);
        
        // Sync the featured products
        $store->featuredProducts()->sync($validFeaturedIds);
        
        return redirect()->route('store-manager.products.featured')
            ->with('success', 'Featured products updated successfully.');
    }
}
