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
            $query->where(function ($q) use ($search) {
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

    public function browse(Request $request)
    {
        try {
            $query = Product::query()->with('images');
            
            // Get all unique values for filters
            $allProducts = Product::all();
            $vintageYears = $allProducts->pluck('vintage_year')->unique()->sort()->values();
            $wineries = $allProducts->pluck('winery')->unique()->sort()->values();
            $types = $allProducts->pluck('type')->unique()->sort()->values();
            $countries = $allProducts->pluck('country')->unique()->sort()->values();
            
            // Apply filters
            $query = $this->applyFilters($query, $request);
            
            // Get paginated results
            $products = $query->paginate(9);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'html' => view('partials.product_cards', ['products' => $products])->render(),
                    'count' => $products->total(),
                    'pagination' => [
                        'current_page' => $products->currentPage(),
                        'last_page' => $products->lastPage(),
                        'next_page_url' => $products->nextPageUrl(),
                        'prev_page_url' => $products->previousPageUrl(),
                        'total' => $products->total(),
                        'per_page' => $products->perPage(),
                        'links' => (string) $products->appends($request->except('page'))->links()
                    ]
                ]);
            }
            
            return view('allwines', compact('products', 'allProducts', 'vintageYears', 'wineries', 'types', 'countries'));
            
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error loading products: ' . $e->getMessage()
                ], 500);
            }
            
            // For non-AJAX requests, redirect back with error
            return back()->with('error', 'Error loading products: ' . $e->getMessage());
        }
    }
    
    protected function applyFilters($query, $request)
    {
        // Filter by type
        if ($request->has('type') && !empty($request->type)) {
            $types = is_array($request->type) ? $request->type : [$request->type];
            $query->whereIn('type', $types);
        }
        
        // Filter by vintage year
        if ($request->has('vintage_year') && !empty($request->vintage_year)) {
            $years = is_array($request->vintage_year) ? $request->vintage_year : [$request->vintage_year];
            $query->whereIn('vintage_year', $years);
        }
        
        // Filter by winery
        if ($request->has('winery') && !empty($request->winery)) {
            $wineries = is_array($request->winery) ? $request->winery : [$request->winery];
            $query->whereIn('winery', $wineries);
        }
        
        // Filter by country
        if ($request->has('country') && !empty($request->country)) {
            $countries = is_array($request->country) ? $request->country : [$request->country];
            $query->whereIn('country', $countries);
        }
        
        // Filter by price range
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        
        if (is_numeric($minPrice) || is_numeric($maxPrice)) {
            if (is_numeric($minPrice) && is_numeric($maxPrice)) {
                $query->whereBetween('retail_price', [
                    (float) $minPrice,
                    (float) $maxPrice
                ]);
            } elseif (is_numeric($minPrice)) {
                $query->where('retail_price', '>=', (float) $minPrice);
            } elseif (is_numeric($maxPrice)) {
                $query->where('retail_price', '<=', (float) $maxPrice);
            }
        }
        
        return $query;
    }
}
