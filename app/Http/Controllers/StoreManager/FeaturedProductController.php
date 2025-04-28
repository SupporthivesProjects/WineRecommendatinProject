<?php

namespace App\Http\Controllers\StoreManager;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeaturedProductController extends Controller
{
    public function index()
    {
        $allProducts = Product::where('status', 'active')->get();
        $store = Auth::user()->store;
        $storeProducts = $store->products->pluck('id')->toArray();
        
        return view('store-manager.storedashboard.storefeaturedproducts-tab',compact('allProducts', 'storeProducts'));
    }
    
}
