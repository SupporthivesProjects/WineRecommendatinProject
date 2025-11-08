<?php

namespace App\Http\Controllers\StoreManager;

use App\Http\Controllers\Controller;
use App\Models\CheeseProduct;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreManagerCheeseProductController extends Controller
{

    public function index()
    {
        try {
            // Step 1: Get the logged-in user and their store ID
            $user = Auth::user();

            if (!$user || !$user->store_id) {
                throw new \Exception('Authenticated user has no associated store.');
            }

            $storeId = $user->store_id;

            // Step 2: Get all active cheese products joined with store inventory
            $cheeseProducts = CheeseProduct::where('is_active', true)
                ->leftJoin('store_inventory', function($join) use ($storeId) {
                    $join->on('cheese_products.id', '=', 'store_inventory.cheese_product_id')
                        ->where('store_inventory.store_id', '=', $storeId);
                })
                ->select(
                    'cheese_products.*',
                    'store_inventory.quantity as store_quantity',
                    'store_inventory.is_available as is_available_in_store'
                )
                ->orderBy('is_available_in_store', 'desc')
                ->orderBy('cheese_products.name')
                ->paginate(10);

            // Step 3: Return view
            return view('store-manager.cheese-products.index', [
                'cheeseProducts' => $cheeseProducts,
                'storeId' => $storeId,
            ]);

        } catch (\Throwable $e) {
            // Log the full error with message, line, and file for debugging
            Log::error('Error loading cheese products list: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Option 1: Show a friendly error message to the user
            return redirect()->back()->with('error', 'Unable to load cheese products. Please try again later.');

            // Option 2 (optional): for debugging only
            // dd($e->getMessage());
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $request->validate([
                'product_id' => 'required|exists:cheese_products,id',
                'status' => 'required|in:active,inactive',
            ]);

            $user = Auth::user();

            // Check if the logged-in user is associated with a store
            if (!$user || !$user->store_id) {
                throw new \Exception('No store assigned to this user.');
            }

            // Get the store using the user's store_id
            $store = Store::findOrFail($user->store_id);
            $productId = $request->input('product_id');
            $status = $request->input('status') === 'active';

            // Check if the product already exists in the store's pivot table
            if ($store->cheeseProducts()->where('cheese_products.id', $productId)->exists()) {
                // Update existing pivot
                $store->cheeseProducts()->updateExistingPivot($productId, [
                    'is_available' => $status,
                    'updated_at' => now(),
                ]);
            } else {
                // Create new pivot record with default quantity
                $store->cheeseProducts()->attach($productId, [
                    'quantity' => 10,
                    'is_available' => $status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product status updated successfully',
                'is_active' => $status,
            ]);

        } catch (\Throwable $e) {
            \Log::error('Error updating cheese product status: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => Auth::id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to update product status: ' . $e->getMessage(),
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
