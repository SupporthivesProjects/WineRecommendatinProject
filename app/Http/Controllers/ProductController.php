<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

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
        // Eager load relationships
        $product->load(['images', 'reviews.user']);
        
        // Get similar products (same type and similar price range)
        $similarProducts = Product::where('id', '!=', $product->id)
            ->where('status', 'active')
            ->where('type', $product->type)
            ->whereBetween('retail_price', [
                max(0, $product->retail_price * 0.7),
                $product->retail_price * 1.3
            ])
            ->with('primaryImage') // Eager load primary image
            ->inRandomOrder()
            ->limit(4)
            ->get();

        // Get approved reviews with user data
        $reviews = $product->reviews()
            ->with('user')
            ->where('status', 'approved')
            ->latest()
            ->paginate(5, ['*'], 'reviews_page');

        // Calculate average rating
        $averageRating = $product->reviews()
            ->where('status', 'approved')
            ->avg('rating');

        // Get total number of approved reviews
        $totalReviews = $product->reviews()
            ->where('status', 'approved')
            ->count();

        // Get rating distribution for the chart
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingDistribution[$i] = $product->reviews()
                ->where('status', 'approved')
                ->where('rating', $i)
                ->count();
        }

        return view('user.product-detail', [
            'product' => $product,
            'similarProducts' => $similarProducts,
            'reviews' => $reviews,
            'averageRating' => $averageRating ?? 0, // Default to 0 if no reviews
            'totalReviews' => $totalReviews,
            'ratingDistribution' => $ratingDistribution,
        ]);
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
            $methods = $allProducts->pluck('Method')->unique()->sort()->values();

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

            return view('allwines', compact('products', 'allProducts', 'vintageYears', 'wineries', 'types', 'countries', 'methods'));
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
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function($q) use ($searchTerm) {
                $q->where('wine_name', 'LIKE', $searchTerm)
                  ->orWhere('winery', 'LIKE', $searchTerm)
                  ->orWhere('grape_variety', 'LIKE', $searchTerm)
                  ->orWhere('wine_sub_region', 'LIKE', $searchTerm)
                  ->orWhere('country', 'LIKE', $searchTerm);
            });
        }

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

        // Filter by Method
        if ($request->has('method') && !empty($request->method)) {
            $methods = is_array($request->method) ? $request->method : [$request->method];
            $query->whereIn('Method', $methods); // DB column stays 'Method'
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

        // Filter by featured status
        if ($request->has('featured') && $request->featured === 'true') {
            $query->where('admin_featured_product', true);
        }

        return $query;
    }

    public function filter(Request $request)
    {
        try {
            $query = Product::query();

            // Apply filters from the request
            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('wine_name', 'like', "%{$search}%")
                        ->orWhere('winery', 'like', "%{$search}%")
                        ->orWhere('grape_variety', 'like', "%{$search}%");
                });
            }

            // Apply type filter
            if ($request->has('type') && !empty($request->type)) {
                $types = is_array($request->type) ? $request->type : [$request->type];
                $query->whereIn('type', $types);
            }

            // Apply country filter
            if ($request->has('country') && !empty($request->country)) {
                $countries = is_array($request->country) ? $request->country : [$request->country];
                $query->whereIn('country', $countries);
            }

                        // Apply Method filtera
            if ($request->has('Method') && !empty($request->Method)) {
                $methods = is_array($request->Method) ? $request->Method : [$request->Method];
                $query->whereIn('Method', $methods);
            }


            // Apply price range filter
            if ($request->has('min_price') && is_numeric($request->min_price)) {
                $query->where('retail_price', '>=', (float)$request->min_price);
            }
            if ($request->has('max_price') && is_numeric($request->max_price)) {
                $query->where('retail_price', '<=', (float)$request->max_price);
            }

            // Apply featured filter
            if ($request->has('featured') && $request->featured === 'true') {
                $query->where('admin_featured_product', true);
            }

            // Get filtered products
            $products = $query->where('status', 'active')
                ->paginate(12);

            $products->appends($request->query());

            // Return JSON response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'html' => view('partials.product-grid', ['products' => $products])->render(),
                    'has_more_pages' => $products->hasMorePages()
                ]);
            }

            // For non-AJAX requests, redirect to browse page with filters
            return redirect()->route('browse', $request->query());
        } catch (\Exception $e) {
            Log::error('Product filter error: ' . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while filtering products.'
                ], 500);
            }

            return back()->with('error', 'An error occurred while filtering products.');
        }
    }
}
