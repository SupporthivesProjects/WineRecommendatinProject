<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\StoreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Store;
use App\Models\Product;

class IsFeaturedController extends Controller
{
    public function index()
    {
            $storesWithFeaturedCounts = DB::table('store_products')
            ->select('store_id', DB::raw('count(*) as featured_count'))
            ->where('is_featured', 1)
            ->groupBy('store_id')
            ->get();

        // Get store details for each store_id
        $stores = Store::whereIn('id', $storesWithFeaturedCounts->pluck('store_id'))->get()->keyBy('id');

        // Merge store details into the collection
        $data = $storesWithFeaturedCounts->map(function ($item) use ($stores) {
            $store = $stores[$item->store_id];
            return [
                'id' => $item->store_id,
                'store_name' => $store->store_name,
                'contact_number' => $store->contact_number,
                'email' => $store->email,
                'featured_count' => $item->featured_count
            ];
        });

        return view('admin.dashboard.is_featured_products', compact('data'));
    }

    public function show($store_id)
    {
        $store = Store::findOrFail($store_id);

        $featuredProducts = DB::table('store_products')
            ->join('products', 'store_products.product_id', '=', 'products.id')
            ->select('products.wine_name as product_name', 'products.retail_price', 'store_products.created_at', 'store_products.updated_at')
            ->where('store_products.store_id', $store_id)
            ->where('store_products.is_featured', 1)
            ->get();

        return view('admin.dashboard.is_featured_product_details', compact('store', 'featuredProducts'));
    }


}
