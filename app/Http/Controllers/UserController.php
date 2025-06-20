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
        // Fetch the current product with images
        $product = Product::with('images')->findOrFail($id);

        // Fetch 3 related products based on matching type or country, excluding the current product
        $relatedProducts = Product::with('images')
            ->where('id', '!=', $product->id)
            ->where(function($query) use ($product) {
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
 
        return view('user.product-detail', compact('product', 'relatedProducts'));
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

    public function getMatchingProducts($responses)
    {
        $templateId = $responses['template_id'];
        $answers = $responses['answers'];

        Log::debug('Template ID:', ['template_id' => $templateId]);

        $query = Product::query();

        // Wrap all conditions in a single where closure to group the ORs
        $query->where(function ($q) use ($templateId, $answers) {
            foreach ($answers as $key => $value) {
                Log::debug('Response:', ['key' => $key, 'value' => $value]);

                switch ($templateId) {
                    case '1':
                        switch ($key) {
                            case 'question4': // Wine Type
                                $q->orWhere('type', $value);
                                break;
                            // case 'question2': // Cork yes or no
                            //     $q->orWhere('sweetness_level', $value);
                            //     break;
                            case 'question6': // wine sweet or dry
                                $q->orWhere('nature', $value);
                                break;
                            case 'question7': // flavour
                                if (is_array($value)) {
                                    foreach ($value as $aroma) {
                                        $q->orWhere('aroma', 'like', "%$aroma%");
                                    }
                                }
                                break;
                            case 'question8': // how bold would you like your wine to be
                                $q->orWhere('body', $value);
                                break;
                            case 'question9': // how fruity
                                $q->orWhere('palate', 'like', "%$value%");
                                break;
                            case 'question10': // how old 
                                $q->orWhere('aging', $value);
                                break;
                            case 'question11': // Region
                                $q->orWhere('country', $value);
                                break;
                            case 'question12': // Price
                                $q->orWhere('retail_price', '<=', $value);
                                break;
                            case 'question13': // Occasion
                                $q->orWhere('style', 'like', "%$value%");
                                break;
                        }
                        break;

                    case '2':
                        switch ($key) {
                            case 'question4': // Wine Type
                                $q->orWhere('type', $value);
                                break;
                            // case 'question2': // Cork yes or no
                            //     $q->orWhere('sweetness_level', $value);
                            //     break;
                            case 'question5': // wine sweet or dry
                                $q->orWhere('nature', $value);
                                break;
                            case 'question10': // flavour
                                if (is_array($value)) {
                                    foreach ($value as $aroma) {
                                        $q->orWhere('aroma', 'like', "%$aroma%");
                                    }
                                }
                                break;
                            case 'question2': // how bold would you like your wine to be
                                $q->orWhere('body', $value);
                                break;
                            case 'question1': // how fruity
                                $q->orWhere('palate', 'like', "%$value%");
                                break;
                            case 'question7': // how old 
                                $q->orWhere('aging', $value);
                                break;
                            case 'question6': // Region
                                $q->orWhere('country', $value);
                                break;
                            case 'question12': // Price
                                $q->orWhere('retail_price', '<=', $value);
                                break;
                            case 'question11': // Occasion
                                $q->orWhere('style', 'like', "%$value%");
                                break;
                        }
                        break;

                    case '3':
                        switch ($key) {
                            case 'question4': // Wine Type
                                $q->orWhere('type', $value);
                                break;
                            // case 'question2': // Cork yes or no
                            //     $q->orWhere('sweetness_level', $value);
                            //     break;
                            case 'question5': // wine sweet or dry
                                $q->orWhere('nature', $value);
                                break;
                            case 'question5': // flavour
                                if (is_array($value)) {
                                    foreach ($value as $aroma) {
                                        $q->orWhere('aroma', 'like', "%$aroma%");
                                    }
                                }
                                break;
                            case 'question10': // how bold would you like your wine to be
                                $q->orWhere('body', $value);
                                break;
                            case 'question6': // how fruity
                                $q->orWhere('palate', 'like', "%$value%");
                                break;
                            case 'question10': // how old 
                                $q->orWhere('aging', $value);
                                break;
                            case 'question8': // Region
                                $q->orWhere('country', $value);
                                break;
                            case 'question14': // Price
                                $q->orWhere('retail_price', '<=', $value);
                                break;
                            case 'question111': // Occasion
                                $q->orWhere('style', 'like', "%$value%");
                                break;
                        }
                        break;

                    case '4':
                        switch ($key) {
                            case 'question5': // Wine Type
                                $q->orWhere('type', $value);
                                break;
        
                            case 'question5': // how bold would you like your wine to be
                                $q->orWhere('body', $value);
                                break;
                            case 'question6': // how fruity
                                $q->orWhere('palate', 'like', "%$value%");
                                break;
                            case 'question7': // Price
                                $q->orWhere('retail_price', '<=', $value);
                                break;
                            case 'question10': // Occasion
                                $q->orWhere('style', 'like', "%$value%");
                                break;
                        }
                        break;

                    default:
                        break;
                }
            }
        });

        Log::debug('Generated Query: ' . $query->toSql());
        Log::debug('Bindings: ' . json_encode($query->getBindings()));

        return $query->get();
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