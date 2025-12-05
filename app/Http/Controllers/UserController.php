<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\QuestionnaireTemplate;
use App\Models\QuestionnaireResponse;
use App\Models\Product;
use App\Models\UserQuestionnaireResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\QuestionResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use App\Models\CartCheckout;
use Illuminate\Support\Collection;
use Illuminate\Support\Arr;


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
            ->when($user->expertise_level, function ($query) use ($user) {
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
        $store = Auth::user()->store;

        // Fetch featured store_products for this store (with product_id as key)
        $featuredStoreProducts = DB::table('store_products')
            ->where('store_id', $store->id)
            ->where('is_featured', 1)
            ->get()
            ->keyBy('product_id');

        // Fetch products with images where product id is in featured store products
        $productsQuery = Product::with('images')
            ->whereIn('id', $featuredStoreProducts->pluck('product_id'));

        // Paginate products
        $products = $productsQuery->paginate(6);

        // Attach is_featured value to each product from store_products
        $products->getCollection()->transform(function ($product) use ($featuredStoreProducts) {
            $product->is_featured = $featuredStoreProducts[$product->id]->is_featured ?? 0;
            return $product;
        });

        return view('user.featuredproducts', compact('products'));
    }


    public function userquestionnaire()
    {
        return view('user.userquestionnaire');
    }

    public function products()
    {
        $store = Auth::user()->store;

        // Fetch products linked to this store and eager load the 'images' relationship
        $storeProducts = DB::table('store_products')
            ->where('store_id', $store->id)
            ->orderBy('is_featured', 'desc')
            ->get()
            ->keyBy('product_id');

        // Fetch the products with their images for the store products
        $productsQuery = Product::with('images')
            ->whereIn('id', $storeProducts->pluck('product_id'));

        // Apply pagination after applying map
        $products = $productsQuery->paginate(6);

        // Map the 'is_featured' value from store_products to each product
        $products->getCollection()->transform(function ($product) use ($storeProducts) {
            $product->is_featured = $storeProducts[$product->id]->is_featured;
            return $product;
        });


        return view('user.products', compact('products'));
    }

    public function matchedproducts($submissionId)
    {
        // Store in session if needed
        session(['submission_id' => $submissionId]);

        // Get the matching products from the session
        $products = session('matching_products', []);
        $cart = session('cart', []);

        return view('user.matchedproducts', compact('products', 'cart'));

        // Pass the products to the view
        return view('user.matchedproducts', compact('products'));
    }


    public function productDetails($id)
    {
        // Fetch the current product with images and reviews
        $product = Product::with(['images', 'reviews.user'])->findOrFail($id);

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

        // Fetch 3 related products based on matching type or country, excluding the current product
        $relatedProducts = Product::with('images')
            ->where('id', '!=', $product->id)
            ->where(function ($query) use ($product) {
                $query->where('type', $product->type)
                    ->orWhere('country', $product->country);
            })
            ->inRandomOrder()
            ->limit(3)
            ->get();

        // If less than 3 related products, fetch random other products excluding current and already fetched
        if ($relatedProducts->count() < 3) {
            $excludeIds = $relatedProducts->pluck('id')->push($product->id)->toArray();

            $additionalProducts = Product::with('images')
                ->whereNotIn('id', $excludeIds)
                ->inRandomOrder()
                ->limit(3 - $relatedProducts->count())
                ->get();

            // Merge additional products with related products
            $relatedProducts = $relatedProducts->merge($additionalProducts);
        }

        return view('user.product-detail', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews,
            'averageRating' => $averageRating ?? 0,
            'totalReviews' => $totalReviews,
            'ratingDistribution' => $ratingDistribution,
        ]);
    }


    public function storeResponse(Request $request)
    {

        $responses = $request->all();
        $templateId = $responses['template_id'] ?? null;
        $answers = $responses['answers'] ?? [];

        $submissionId = Str::uuid();


        // Get values from the first 3 questions or set defaults
        $name = $answers['question1'] ?? 'John Doe';
        $phone = $answers['question2'] ?? '9988998899';
        $email = $answers['question3'] ?? 'johndoe@test.com';

        // If any of them have 'no response', replace with defaults
        if ($name === 'no response') {
            $name = 'John Doe';
        }
        if ($phone === 'no response') {
            $phone = '9988998899';
        }
        if ($email === 'no response') {
            $email = 'johndoe@test.com';
        }

        // Save to questionnaire_usage table
        $customerID = DB::table('questionnaire_usage')->insertGetId([
            'cust_name' => $name,
            'cust_phone' => $phone,
            'cust_email' => $email,
            'submission_id' => $submissionId,
            'created_on' => now()
        ]);

        Log::debug('Customer ID:', ['template_id' => $customerID]);

        foreach ($answers as $questionKey => $answerValue) {
            QuestionResponse::create([
                'template_id' => $templateId,
                'question_key' => $questionKey,
                'answer' => is_array($answerValue) ? json_encode($answerValue) : $answerValue,
                'user_id' => auth()->id(),
                'submission_id' => $submissionId,
                'customerID' => $customerID,
            ]);
        }

        // Filter out the first 3 questions before sending to product matcher
        $filteredAnswers = $answers;
        unset($filteredAnswers['question1'], $filteredAnswers['question2'], $filteredAnswers['question3']);



        // Pass only the filtered responses to product matcher
        $filteredResponses = $responses;
        $filteredResponses['answers'] = $filteredAnswers;

        // Get matching products
        $matchingProducts = $this->getMatchingProducts($filteredResponses);


        // If no products found, you can return a fallback or 'No Results' page
        if ($matchingProducts->isEmpty()) {
            return response()->json([
                'status' => 'no_results',
                'redirect' => route('user.dashboard')
            ], 200); // Status 200 for AJAX to process
        }

        // Store the matching products in the session
        session(['matching_products' => $matchingProducts]);

        // Redirect to the 'user.products' route
        return response()->json([
            'status' => 'success',
            'redirect' => route('user.matchedproducts', ['submissionId' => $submissionId])
        ], 200);
    }
    private function detectPriceBand($value)
    {
        $v = (float) $value;

        $bands = [
            ['min' => 0,     'max' => 5000],
            ['min' => 5000,  'max' => 25000],
            ['min' => 25000, 'max' => 50000],
            ['min' => 50000, 'max' => 100000],
        ];

        foreach ($bands as $band) {
            if ($v >= $band['min'] && $v <= $band['max']) {
                return $band;
            }
        }

        // fallback
        return ['min' => 0, 'max' => 100000];
    }


    public function getMatchingProducts($responses)
    {
        Log::info("=== START PRODUCT MATCHING ===");

        $templateId = $responses['template_id'];
        $answers = $responses['answers'];

        Log::info("Template ID Received: $templateId");
        Log::info("Raw Answers:", $answers);

        // Preserve order of answers
        $orderedAnswers = collect($answers)->filter();
        Log::info("Ordered Answers:", $orderedAnswers->toArray());

        // Store
        $store = Auth::user()->store;

        if (!$store) {
            Log::warning("User has no store assigned!");
            return collect();
        }

        Log::info("Store ID: {$store->id}");

        // Store product IDs
        $storeProductIds = DB::table('store_products')
            ->where('store_id', $store->id)
            ->pluck('product_id');

        Log::info("Store Product IDs Count: " . $storeProductIds->count());

        if ($storeProductIds->isEmpty()) {
            Log::warning("Store has NO products assigned!");
            return collect();
        }

        // START WITH ALL STORE PRODUCTS
        $currentProductIds = $storeProductIds->toArray();

        foreach ($orderedAnswers as $key => $value) 
        {


            // Skip questions where user selected "no response"
            if ($value === "no response" || $value === ["no response"]) {
                Log::info("Skipping $key because value is 'no response'");
                continue;
            }


            Log::info("---------------");
            Log::info("Processing Answer Key: $key", ['value' => $value]);
            Log::info("Current available product pool before filter: " . count($currentProductIds));

            $matches = $this->getMatchesForSingleAnswer(
                $templateId,
                $key,
                $value,
                $currentProductIds
            );

            Log::info("Matches returned for $key: " . $matches->count());

            if ($matches->count() === 0) {
                Log::warning("No matches for $key — skipping this filter and keeping previous pool.");
                continue; // MOVE TO NEXT QUESTION
            }

            // Update the pool for next iteration (progressive filtering)
            $currentProductIds = $matches->pluck('id')->toArray();

            Log::info("Pool after filtering by $key: " . count($currentProductIds));

            // If empty → break early
            if (empty($currentProductIds)) {
                Log::warning("No products remaining after filtering for $key — stopping.");
                break;
            }
        }

        // Final matched product records
        $finalProducts = Product::whereIn('id', $currentProductIds)->get();

        Log::info("Total products AFTER all filters: " . $finalProducts->count());

        // ---- FINAL LOGIC: 10 normal + 5 featured ----
        $featured = $finalProducts->where('admin_featured_product', true)->shuffle();
        $normal   = $finalProducts->where('admin_featured_product', false)->shuffle();

        Log::info("Featured candidates: " . $featured->count());
        Log::info("Normal candidates: " . $normal->count());

        $takeFeatured = $featured->take(5);
        $remaining    = 15 - $takeFeatured->count();
        $takeNormal   = $normal->take($remaining);

        $result = $takeFeatured->merge($takeNormal)->shuffle()->values();

        Log::info("=== FINAL RESULT COUNT: " . $result->count() . " ===");
        Log::info("=== END PRODUCT MATCHING ===");

        return $result;
    }

    private function getMatchesForSingleAnswer($templateId, $key, $value, $productIds)
    {
        Log::info("---- START MATCH BLOCK: $key ----");
        Log::info("Filtering inside product count: " . count($productIds));
        Log::info("Value:", (array)$value);

        if (empty($productIds)) {
            Log::warning("No products to filter inside!");
            return collect();
        }

        $values = is_array($value) ? $value : [$value];

        // BASE QUERY – only these products
        $q = Product::whereIn('id', $productIds)
            ->where('status', 'active'); // correct placement

        Log::info("Normalized Values:", $values);

        switch ($templateId) {

            case '1':
                switch ($key) 
                {
                    case 'question4': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('type', 'like', "%$v%")
                                  ->orWhere('method', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question5': 
                        $q->where(function($x) use ($values) {
                            $x->whereIn('closure_type', $values);
                        });
                        break;
        
                    case 'question6': 
                        $q->where(function($x) use ($values) {
                            $x->whereIn('nature', $values);
                        });
                        break;
        
                    case 'question7': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('body', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question8': 
                        $q->whereIn('style', $values);
                        break;
        
                    case 'question9': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('country', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question10': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('categories', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question11':
                        $band = $this->detectPriceBand($value);
                        Log::info("Price Band Detected:", $band);
                    
                        $q->whereBetween('retail_price', [$band['min'], $band['max']]);
                        break;
                        
                }
                break;
        
        
            case '2':
                switch ($key) 
                {
                    case 'question4': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('type', 'like', "%$v%")
                                  ->orWhere('method', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question5': 
                        $q->where(function($x) use ($value) {
                            $x->where('nature', $value);
                        });
                        break;
        
                    case 'question6': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('country', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question7': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('wine_sub_region', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question8': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('grape_variety', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question9': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('optimal_drinking', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question10': 
                        $q->where(function($x) use ($values, $value) {
                            foreach ($values as $v) {
                                $x->orWhere('aroma', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question11': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('categories', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question12':
                        $band = $this->detectPriceBand($value);
                        Log::info("Price Band Detected:", $band);
                    
                        $q->whereBetween('retail_price', [$band['min'], $band['max']]);
                        break;
                        
                }
                break;
        
        
            case '3':
                switch ($key) 
                {
                    case 'question4': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('categories', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question5': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('type', 'like', "%$v%")
                                  ->orWhere('method', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question6': 
                        $q->where(function($x) use ($value) {
                            $x->where('varietal_blend', 'like', "%$value%");
                        });
                        break;
        
                    case 'question7': 
                        $q->where(function($x) use ($value) {
                            $x->where('grape_variety', 'like', "%$value%");
                        });
                        break;
        
                    case 'question8': 
                        $q->where(function($x) use ($value) {
                            $x->where('country', 'like', "%$value%");
                        });
                        break;
                    case 'question9': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('country', 'like', "%{$v}%");
                            }
                        });
                        break;
        
                    case 'question10': 
                        $q->where(function($x) use ($value) {
                            $x->where('nature', 'like', "%$value%");
                        });
                        break;
        
                    case 'question11': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('optimal_drinking', 'like', "%$v%");
                            }
                        });
                        break;
                    case 'question12': 
                        $q->where(function($x) use ($value) {
                            $x->where('acidity', 'like', "%$value%");
                        });
                        break;
                    case 'question13': 
                        $q->where(function($x) use ($value) {
                            $x->where('tannin_level', 'like', "%$value%");
                        });
                        break;
                    case 'question14': 
                        $q->where(function($x) use ($value) {
                            $x->where('body', 'like', "%$value%");
                        });
                        break;
        
                    case 'question15': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('style', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question16':
                        $band = $this->detectPriceBand($value);
                        Log::info("Price Band Detected:", $band);
                    
                        $q->whereBetween('retail_price', [$band['min'], $band['max']]);
                        break;
                        
                }
                break;
        
        
            case '4':
                switch ($key) 
                {
                    case 'question4': 
                        $q->where(function($x) use ($value) {
                            $x->orWhere('categories', 'like', "%$value%");
                        });
                        break;
        
                    case 'question5': 
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('type', 'like', "%$v%")
                                  ->orWhere('method', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question6':
                        $q->where(function($x) use ($values) {
                            foreach ($values as $v) {
                                $x->orWhere('style', 'like', "%$v%");
                            }
                        });
                        break;
        
                    case 'question7':
                        $band = $this->detectPriceBand($value);
                        Log::info("Price Band Detected:", $band);
                    
                        $q->whereBetween('retail_price', [$band['min'], $band['max']]);
                        break;
                        
                }
                break;
        }
        
        Log::info("Executing Query for $key");
        Log::info("SQL: " . $q->toSql(), $q->getBindings());

        $results = $q->get();

        Log::info("Results for $key: " . $results->count());
        Log::info("---- END MATCH BLOCK: $key ----");

        return $results;
    }

    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);

        $productId = $request->input('product_id');
        $productName = $request->input('product_name');
        $productPrice = $request->input('product_price');

        // Check if product already in cart by id
        $foundIndex = null;
        foreach ($cart as $index => $item) {
            if ($item['id'] == $productId) {
                $foundIndex = $index;
                break;
            }
        }

        if ($foundIndex === null) {
            // Add new product object
            $cart[] = [
                'id' => $productId,
                'name' => $productName,
                'retail_price' => $productPrice,
                'quantity' => 1  // Optional: add quantity if needed
            ];
        } else {
            // Optionally increase quantity or ignore duplicates
            $cart[$foundIndex]['quantity']++;
        }

        session(['cart' => $cart]);

        return response()->json(['success' => true]);
    }


    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');

        $cart = array_filter($cart, fn($item) => $item['id'] != $productId);

        session(['cart' => array_values($cart)]);

        return response()->json(['success' => true]);
    }


    public function getCart()
    {
        $cart = session('cart', []);
        // Optional: fetch product details here if needed, e.g.
        // $products = Product::whereIn('id', $cart)->get();

        return response()->json(['cart' => $cart]);
    }




    public function checkout(Request $request)
    {
        $submissionId = $request->submission_id;
        $userId = auth()->id(); // Securely fetch user ID from session/auth

        Log::info('Checkout started for submission_id: ' . $submissionId);
        Log::info('Checkout started for user_id: ' . $userId);

        $cart = Session::get('cart', []);
        Log::info('Cart contents: ', $cart);

        if (empty($cart)) {
            Log::warning('Cart is empty.');
            return response()->json(['success' => false, 'message' => 'Cart is empty.']);
        }

        $responses = QuestionResponse::where('submission_id', $submissionId)->get();
        Log::info('Fetched responses count: ' . $responses->count());

        if ($responses->isEmpty()) {
            Log::warning('Invalid submission ID: no responses found.');
            return response()->json(['success' => false, 'message' => 'Invalid submission ID.']);
        }

        $username = $email = $phone = 'N/A';

        foreach ($responses as $response) {
            Log::info("Processing response: question_key={$response->question_key}, answer={$response->answer}");

            if ($response->question_key === 'question1') {
                $username = $response->answer;
                Log::info("Username set to: $username");
            } elseif ($response->question_key === 'question2') {
                $phone = $response->answer;
                Log::info("Email set to: $email");
            } elseif ($response->question_key === 'question3') {
                $email = $response->answer;
                Log::info("Phone set to: $phone");
            }
        }

        // Save the checkout
        $checkout = new CartCheckout();
        $checkout->store_manager_id = $userId;
        $checkout->username = $username;
        $checkout->email = $email;
        $checkout->phone = $phone;
        $checkout->submission_id = $submissionId;
        $checkout->products = json_encode($cart);

        $saved = $checkout->save();
        Log::info('Checkout saved: ' . ($saved ? 'yes' : 'no'));

        // Clear cart
        Session::forget('cart');
        Log::info('Cart cleared from session.');

        return response()->json(['success' => true]);
    }
}
