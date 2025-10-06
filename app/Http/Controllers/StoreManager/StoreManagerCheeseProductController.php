<?php

namespace App\Http\Controllers\StoreManager;

use App\Http\Controllers\Controller;
use App\Models\CheeseProduct;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreManagerCheeseProductController extends Controller
{
    public function index()
    {
        try {
            $store = Store::where('manager_id', Auth::id())->firstOrFail();

            
            // Get all active cheese products with their inventory status and quantity
            $cheeseProducts = CheeseProduct::where('is_active', true)
                ->with(['stores' => function($query) use ($store) {
                    $query->where('store_id', $store->id);
                }])
                ->leftJoin('store_inventory', function($join) use ($store) {
                    $join->on('cheese_products.id', '=', 'store_inventory.cheese_product_id')
                         ->where('store_inventory.store_id', '=', $store->id);
                })
                ->select(
                    'cheese_products.*',
                    'store_inventory.quantity as store_quantity',
                    'store_inventory.is_available as is_available_in_store'
                )
                ->orderBy('is_available_in_store', 'desc') // Available products first
                ->orderBy('name')
                ->paginate(10);

            return view('store-manager.cheese-products.index', [
                'cheeseProducts' => $cheeseProducts,
                'store' => $store
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error fetching cheese products: ' . $e->getMessage());
            return back()->with('error', 'Failed to load cheese products. Please try again.');
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:cheese_products,id',
                'status' => 'required|in:active,inactive'
            ]);

            $store = Store::where('manager_id', Auth::id())->firstOrFail();
            $productId = $request->input('product_id');
            $status = $request->input('status') === 'active';

            if ($store->cheeseProducts()->where('cheese_products.id', $productId)->exists()) {
                // Update existing
                $store->cheeseProducts()->updateExistingPivot($productId, [
                    'is_available' => $status,
                    'updated_at' => now()
                ]);
            } else {
                // Create new with default quantity 10
                $store->cheeseProducts()->attach($productId, [
                    'quantity' => 10,
                    'is_available' => $status,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product status updated successfully',
                'is_active' => $status
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating cheese product status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update product status: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateFeatured(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:cheese_products,id',
                'featured' => 'required|boolean'
            ]);

            $store = Store::where('manager_id', Auth::id())->firstOrFail();
            $productId = $request->input('product_id');
            $featured = $request->input('featured');

            // First check if the product is in the store's inventory and available
            $inventory = $store->cheeseProducts()->where('cheese_products.id', $productId)->first();
            
            if (!$inventory || !$inventory->pivot->is_available) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product must be available in your inventory.'
                ], 422);
            }

            // Update the product status
            $store->cheeseProducts()->updateExistingPivot($productId, [
                'updated_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Featured status updated successfully',
                'is_featured' => $featured
            ]);

        } catch (\Exception $e) {
            \Log::error('Error updating cheese product featured status: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to update featured status'
            ], 500);
        }
    }
}
