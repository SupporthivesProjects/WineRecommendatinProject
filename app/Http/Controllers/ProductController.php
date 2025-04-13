<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Product::where('status', 'active');
        
        // Apply filters if provided
        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }
        
        if ($request->has('country') && $request->country) {
            $query->where('country', $request->country);
        }
        
        if ($request->has('price_min') && $request->price_min) {
            $query->where('retail_price', '>=', $request->price_min);
        }
        
        if ($request->has('price_max') && $request->price_max) {
            $query->where('retail_price', '<=', $request->price_max);
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('wine_name', 'like', "%{$search}%")
                  ->orWhere('winery', 'like', "%{$search}%")
                  ->orWhere('grape_variety', 'like', "%{$search}%");
            });
        }
        
        // Get filter options for the sidebar
        $types = Product::select('type')->distinct()->pluck('type')->filter();
        $countries = Product::select('country')->distinct()->pluck('country')->filter();
        
        // Get products with pagination
        $products = $query->orderBy('id', 'desc')->paginate(12);
        
        return view('user.products', compact('products', 'types', 'countries'));
    }

    /**
     * Display the specified product.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        // Get similar products (same type and similar price range)
        $similarProducts = Product::where('id', '!=', $product->id)
            ->where('status', 'active')
            ->where('type', $product->type)
            ->whereBetween('retail_price', [
                max(0, $product->retail_price * 0.7),
                $product->retail_price * 1.3
            ])
            ->inRandomOrder()
            ->limit(4)
            ->get();
            
        return view('user.product-detail', compact('product', 'similarProducts'));
    }
}