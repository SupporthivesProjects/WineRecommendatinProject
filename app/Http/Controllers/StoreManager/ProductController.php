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
    public function index(Request $request)
    {
        $store = Auth::user()->store;

        $canAddProducts = $store->features()
            ->where('key', 'add_products')
            ->wherePivot('enabled', 1)
            ->exists();
        
        $canFeatureProducts = $store->features()
            ->where('key', 'featured_wine')
            ->wherePivot('enabled', 1)
            ->exists();

        // The table loads its rows page by page from here (DataTables server-side mode)
        if ($request->ajax() && $request->has('draw')) {
            return $this->productsTableData($request, $store->id, $canAddProducts, $canFeatureProducts);
        }

        return view('store-manager.storeDashboard.storeproducts-tab');
    }

    /**
     * One page of rows for the store's product table, in the DataTables server-side format.
     */
    private function productsTableData(Request $request, int $storeId, bool $canAddProducts, bool $canFeatureProducts)
    {
        $query = Product::where('products.status', 'active')
            ->leftJoin('store_products as sp', function ($join) use ($storeId) {
                $join->on('sp.product_id', '=', 'products.id')->where('sp.store_id', $storeId);
            })
            ->select('products.*')
            ->selectRaw("CASE WHEN sp.status = 'active' THEN 1 ELSE 0 END as is_available")
            ->selectRaw("CASE WHEN sp.status = 'active' AND sp.is_featured THEN 1 ELSE 0 END as is_store_featured");

        $total = (clone $query)->count();

        // Every search word must match at least one visible column, like the old client-side search
        foreach (preg_split('/\s+/', trim((string) $request->input('search.value')), -1, PREG_SPLIT_NO_EMPTY) as $word) {
            $query->where(function ($q) use ($word) {
                foreach (['products.id', 'products.wine_name', 'products.type', 'products.vintage_year'] as $column) {
                    $q->orWhere($column, 'like', '%'.$word.'%');
                }
            });
        }
        $filtered = (clone $query)->count();

        // Column index => sortable column
        $sortColumns = [0 => 'products.id', 1 => 'products.wine_name', 2 => 'products.type', 3 => 'products.vintage_year', 4 => 'products.status', 5 => 'is_available', 6 => 'is_store_featured'];
        $sortIndex = (int) $request->input('order.0.column', 0);
        $query->orderBy($sortColumns[$sortIndex] ?? 'products.id', $request->input('order.0.dir') === 'desc' ? 'desc' : 'asc')
            ->orderBy('products.id');

        $query->skip(max(0, (int) $request->input('start', 0)))
            ->take(min(max((int) $request->input('length', 10), 1), 100));

        $icons = [
            'red' => '<i class="fas fa-wine-glass text-danger" title="Red Wine"></i>',
            'white' => '<i class="fas fa-wine-glass text-warning" title="White Wine"></i>',
            'sparkling' => '<i class="fas fa-champagne-glasses text-info" title="Sparkling Wine"></i>',
            'still' => '<i class="fas fa-tint text-primary" title="Still Wine"></i>',
            'rosé' => '<i class="fas fa-wine-glass" style="color:#ff69b4;" title="Rosé Wine"></i>',
        ];

        $rows = $query->get()->map(function (Product $product) use ($icons, $canAddProducts, $canFeatureProducts) {
            $image = $product->image1 ? asset('storage/'.$product->image1) : asset('images/default.jpg');
            $type = \Illuminate\Support\Str::lower(trim($product->type));
            $active = $product->status === 'active';

            return [
                e($product->id),
                '<img src="'.e($image).'" alt="" class="ht-50 wd-50 me-3">'
                    .'<span class="my-auto text-truncate">'.e($product->wine_name).'</span>'
                    .'<span class="save-status ms-2" style="display:none;"></span>'
                    .'<a href="'.e(route('store-manager.singleproduct', $product->id)).'" class="ms-2" title="View Product"><i class="bi bi-box-arrow-up-right"></i></a>',
                ($icons[$type] ?? '<i class="fas fa-question-circle"></i>').' '.e(ucfirst($product->type)),
                e($product->vintage_year),
                '<span class="badge rounded-pill '.($active ? 'bg-success' : 'bg-danger').'">'.($active ? 'Available' : 'Not in Stock').'</span>',
                '<input type="checkbox" name="available[]" value="'.$product->id.'"'
                    .($product->is_available ? ' checked' : '').($canAddProducts ? '' : ' disabled').'>',
                '<input type="checkbox" name="featured[]" value="'.$product->id.'"'
                    .($product->is_store_featured ? ' checked' : '').($canFeatureProducts ? '' : ' disabled').'>',
            ];
        });

        return response()->json([
            'draw' => (int) $request->input('draw'),
            'recordsTotal' => $total,
            'recordsFiltered' => $filtered,
            'data' => $rows,
        ]);
    }

    
    /**
     * Update the store's product selection.
     */
    
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

        $canAddProducts = $user->store
            ->features()
            ->where('key', 'add_products')
            ->wherePivot('enabled', 1)
            ->exists();

        if (! $canAddProducts) {
            return response()->json([
                'success' => false,
                'message' => 'Add Products feature is not enabled for this store.'
            ], 403);
        }

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
        // $storeId = Auth::user()->store_id;
        $user = Auth::user();
        $storeId = $user->store_id;

        $canFeatureProducts = $user->store
            ->features()
            ->where('key', 'featured_wine')
            ->wherePivot('enabled', 1)
            ->exists();

        if (! $canFeatureProducts) {
            return response()->json([
                'success' => false,
                'message' => 'Featured Products feature is not enabled for this store.'
            ], 403);
        }
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
        //$product = Product::findOrFail($id);    
        $product = Product::with('images')->findOrFail($id);
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
    
    



}
