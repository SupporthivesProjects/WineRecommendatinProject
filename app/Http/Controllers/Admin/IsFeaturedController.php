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
        $data = Product::where('admin_featured_product', 1)->get();
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
