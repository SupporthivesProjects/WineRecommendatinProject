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

    public function matchedproducts()
    {
        // Get the matching products from the session
        $products = session('matching_products', []);

        // Pass the products to the view
        return view('user.matchedproducts', compact('products'));
    }


    public function productDetails($id)
    {
        $product = Product::findOrFail($id);
        return view('user.product-detail', compact('product'));
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
            'redirect' => route('user.matchedproducts')
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

}