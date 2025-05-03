<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QuestionnaireTemplate;
use App\Models\QuestionnaireResponse;
use App\Models\Product;
use App\Models\UserQuestionnaireResponse;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Display the user dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get active questionnaires appropriate for the user's expertise level
        $questionnaires = QuestionnaireTemplate::where('is_active', true)
            ->when($user->expertise_level, function($query) use ($user) {
                // If user is a beginner (first_sip), only show beginner questionnaires
                if ($user->expertise_level == 'first_sip') {
                    return $query->where('level', 'first_sip');
                }
                
                // If user is intermediate (savy_sipper), show beginner and intermediate questionnaires
                if ($user->expertise_level == 'savy_sipper') {
                    return $query->whereIn('level', ['first_sip', 'savy_sipper']);
                }
                
                // If user is advanced (pro), show all questionnaires
                return $query;
            })
            ->orderBy('id', 'asc')
            ->get();
        
        // Get recent recommendations for the user
        $recentRecommendations = [];
        
        // Check if the user has completed any questionnaires
        $latestResponse = UserQuestionnaireResponse::where('user_id', $user->id)
            ->where('questionnaire_id', '!=', null)
            ->latest()
            ->first();
            
        if ($latestResponse) {
            // Extract product IDs from the response if available
            $responseData = json_decode($latestResponse->responses, true);
            
            if (isset($responseData['recommended_product_ids'])) {
                $recentRecommendations = Product::whereIn('id', $responseData['recommended_product_ids'])
                    ->where('status', 'active')
                    ->limit(6)
                    ->get();
            } else {
                // If no specific recommendations stored, get some based on preferences
                if (isset($responseData['preferences'])) {
                    $preferences = $responseData['preferences'];
                    
                    $query = Product::where('status', 'active');
                    
                    // Apply basic filters based on preferences
                    if (!empty($preferences['wine_type'])) {
                        $query->where('type', $preferences['wine_type']);
                    }
                    
                    $recentRecommendations = $query->inRandomOrder()->limit(6)->get();
                }
            }
        }
        
        return view('user.dashboard', compact('questionnaires', 'recentRecommendations'));
    }
    
    /**
     * Display the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        $user = Auth::user();
        
        // Get the user's questionnaire history
        $questionnaireHistory = UserQuestionnaireResponse::where('user_id', $user->id)
            ->with('questionnaire')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('user.profile', compact('user', 'questionnaireHistory'));
    }
    
    /**
     * Update the user's profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'wine_preferences' => 'nullable|array',
        ]);
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        if (isset($validated['wine_preferences'])) {
            $user->wine_preferences = json_encode($validated['wine_preferences']);
        }
        
        $user->save();
        
        return redirect()->route('user.profile')->with('success', 'Profile updated successfully.');
    }

    public function featuredproducts()
    {
        return view('user.featuredproducts');    
        
    }
   
    // public function products()
    // {
    //     $store = Auth::user()->store;

    //     // Fetch products linked to this store and eager load the 'images' relationship
    //     $storeProducts = DB::table('store_products')
    //         ->where('store_id', $store->id)
    //         ->get()
    //         ->keyBy('product_id'); 

    //     // Fetch the products with their images for the store products
    //     $productsQuery = Product::with('images')
    //         ->whereIn('id', $storeProducts->pluck('product_id'));

    //     // Apply pagination after applying map
    //     $products = $productsQuery->paginate(6);

    //     // Map the 'is_featured' value from store_products to each product
    //     $products->getCollection()->transform(function ($product) use ($storeProducts) {
    //         $product->is_featured = $storeProducts[$product->id]->is_featured;
    //         return $product;
    //     });


    //     return view('user.products', compact('products'));
    // }
    public function products()
    {
        // Get the matching products from the session
        $products = session('matching_products', []);

        // Pass the products to the view
        return view('user.products', compact('products'));
    }


    public function productDetails($id)
    {
        $product = Product::findOrFail($id);
        return view('user.product-detail', compact('product'));
    }

    public function storeResponse(Request $request)
    {

        $responses = $request->all();

        // Find matching products
        $matchingProducts = $this->getMatchingProducts($responses);

        dd($matchingProducts);

        // If no products found, you can return a fallback or 'No Results' page
        if ($matchingProducts->isEmpty()) {
            return redirect()->route('no.results'); // Your fallback route
        }

        // Store the matching products in the session
        session(['matching_products' => $matchingProducts]);

        // Redirect to the 'user.products' route
        return redirect()->route('user.products');
    }


    public function getMatchingProducts($responses)
    {
        // Start with a query for all products
        $query = Product::query();

        // Loop through all responses and add conditions to the query
        foreach ($responses as $key => $value) {
            // Ensure the response matches the product's attribute
            // Adjust the column names as per your database schema
            switch ($key) {
                case 'wine_type':
                    $query->where('wine_type', $value);
                    break;
                case 'sweetness':
                    $query->where('sweetness', $value);
                    break;
                case 'region':
                    $query->where('region', $value);
                    break;
                // Add more cases for other response fields
            }
        }

        // Execute the query to get matching products
        $matchingProducts = $query->get();

        return $matchingProducts;
    }



    

    

}