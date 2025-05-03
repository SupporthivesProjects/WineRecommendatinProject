<?php

namespace App\Http\Controllers\StoreManager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StoreProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class ProductController extends Controller
{
    /**
     * Display a listing of all products.
     */
    public function index()
    {
        $allProducts = Product::where('status', 'active')->paginate(10);
        $store = Auth::user()->store;

        // Fetch products linked to this store
        $storeProducts = DB::table('store_products')
            ->where('store_id', $store->id)
            ->get()
            ->keyBy('product_id'); // Makes it easy to lookup

        return view('store-manager.storedashboard.storeproducts-tab', compact('allProducts', 'storeProducts'));
    }

    
    /**
     * Update the store's product selection.
     */
    // public function updateStoreProducts(Request $request)
    // {
    //     $validated = $request->validate([
    //         'product_ids' => 'required|array',
    //         'product_ids.*' => 'exists:products,id',
    //     ]);
        
    //     $store = Auth::user()->store;
        
    //     // Sync the products with the store
    //     $store->products()->sync($validated['product_ids']);
        
    //     return redirect()->route('store-manager.products.index')
    //         ->with('success', 'Store products updated successfully.');
    // }

    public function updateStatus(Request $request)
    {
        Log::info('Entered updateStatus method.', ['user_id' => Auth::id()]);

        $data = $request->validate([
            'product_id' => 'required|integer',
            'status' => 'required|in:active,inactive',
        ]);

        Log::info('Validated data:', $data);

        $user = Auth::user();
        $storeId = $user->store_id;

        Log::info('User store ID retrieved:', ['store_id' => $storeId]);

        // Try to find existing record
        $storeProduct = StoreProduct::where('store_id', $storeId)
            ->where('product_id', $data['product_id'])
            ->first();

        if (!$storeProduct && $data['status'] === 'active') {
            Log::info('No existing storeProduct found. Creating new record.');

            $storeProduct = StoreProduct::create([
                'store_id' => $storeId,
                'product_id' => $data['product_id'],
                'is_featured' => 0,
                'status' => 'active',
            ]);

            Log::info('New storeProduct created successfully.', ['id' => $storeProduct->id]);

        } elseif ($storeProduct) {
            Log::info('Existing storeProduct found. Updating status.', ['id' => $storeProduct->id]);

            $storeProduct->status = $data['status'];
            $storeProduct->save();

            Log::info('storeProduct status updated.', ['id' => $storeProduct->id, 'status' => $data['status']]);
        } else {
            Log::warning('Attempted to deactivate a product that is not in store_products.', [
                'store_id' => $storeId,
                'product_id' => $data['product_id']
            ]);

            return response()->json(['message' => 'Product not available to deactivate'], 400);
        }

        Log::info('updateStatus completed successfully.');
        return response()->json(['message' => 'Product updated successfully']);
    }



    public function updateFeatured(Request $request)
    {
        $storeId = Auth::user()->store_id;
        \DB::table('store_products')
            ->updateOrInsert(
                ['store_id' => $storeId, 'product_id' => $request->product_id],
                ['is_featured' => $request->is_featured]
            );

        return response()->json(['success' => true]);
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
     * redirect store manager to single product page.
     */
    public function singleproduct($id)
    {
        $product = Product::findOrFail($id);
        return view('store-manager.storeDashboard.storeSingleProduct', compact('product'));
    }

    /**
     * Display and manage featured products.
     */
    public function featuredProducts()
    {
        $store = Auth::user()->store;
        $storeProducts = $store->products()->where('status', 'active')->get();
        $featuredProducts = $store->featuredProducts->pluck('id')->toArray();
        
        return view('store-manager.products.store-products', compact('storeProducts', 'featuredProducts'));
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
        
        return redirect()->route('store-manager.products.store-products')
            ->with('success', 'Featured products updated successfully.');
    }

    



}
