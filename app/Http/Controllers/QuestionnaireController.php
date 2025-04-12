<?php

namespace App\Http\Controllers;

use App\Models\QuestionnaireTemplate;
use App\Models\UserQuestionnaireResponse;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    /**
     * Display the questionnaire selection page.
     */
    public function index()
    {
        $templates = QuestionnaireTemplate::where('is_active', true)
            ->orderBy('level')
            ->get();
            
        return view('questionnaires.index', compact('templates'));
    }
    
    /**
     * Display the questionnaire form.
     */
    public function show(QuestionnaireTemplate $questionnaire)
    {
        if (!$questionnaire->is_active) {
            return redirect()->route('questionnaires.index')
                ->with('error', 'This questionnaire is not currently available.');
        }
        
        return view('questionnaires.show', compact('questionnaire'));
    }
    
    /**
     * Process the questionnaire submission and show recommendations.
     */
    public function submit(Request $request, QuestionnaireTemplate $questionnaire)
    {
        $request->validate([
            'responses' => 'required|array',
        ]);
        
        // Process the user's responses
        $responses = $request->input('responses');
        
        // Generate wine recommendations based on responses
        $recommendedProducts = $this->generateRecommendations($responses, $questionnaire);
        
        // Save the user's responses and recommendations
        if (Auth::check()) {
            UserQuestionnaireResponse::create([
                'user_id' => Auth::id(),
                'questionnaire_template_id' => $questionnaire->id,
                'responses' => $responses,
                'recommended_products' => $recommendedProducts->pluck('id')->toArray()
            ]);
        }
        
        // Get stores where these products are available
        $storeIds = [];
        foreach ($recommendedProducts as $product) {
            if (isset($product->store_ids)) {
                $storeIds = array_merge($storeIds, $product->store_ids);
            }
        }
        $storeIds = array_unique($storeIds);
        $stores = Store::whereIn('id', $storeIds)->where('status', 'active')->get();
        
        return view('questionnaires.results', compact('recommendedProducts', 'stores', 'questionnaire', 'responses'));
    }
    
    /**
     * Generate wine recommendations based on user responses.
     */
    private function generateRecommendations($responses, $questionnaire)
    {
        // Start with all products
        $query = Product::where('status', 'active');
        
        // Apply filters based on questionnaire level and responses
        if ($questionnaire->level === 'first_sip') {
            // Process First Sip (Basic) level responses
            foreach ($responses as $questionId => $answer) {
                $question = $questionnaire->questions[$questionId] ?? null;
                
                if (!$question) continue;
                
                switch ($question['text']) {
                    case 'What type of wine are you in the mood for?':
                        if ($answer === 'Red') {
                            $query->where('type', 'red');
                        } elseif ($answer === 'White') {
                            $query->where('type', 'white');
                        } elseif ($answer === 'Rosé') {
                            $query->where('type', 'rose');
                        } elseif ($answer === 'Sparkling') {
                            $query->where('type', 'sparkling');
                        }
                        break;
                        
                    case 'What is your price range?':
                        if ($answer === 'Under $20') {
                            $query->where('retail_price', '<', 20);
                        } elseif ($answer === '$20-$50') {
                            $query->where('retail_price', '>=', 20)
                                  ->where('retail_price', '<=', 50);
                        } elseif ($answer === '$50-$100') {
                            $query->where('retail_price', '>=', 50)
                                  ->where('retail_price', '<=', 100);
                        } elseif ($answer === 'Over $100') {
                            $query->where('retail_price', '>', 100);
                        }
                        break;
                        
                    case 'Do you prefer sweet or dry wines?':
                        if ($answer === 'Sweet') {
                            $query->where(function($q) {
                                $q->where('sweetness_level', 'like', '%sweet%')
                                  ->orWhere('nature', 'like', '%sweet%');
                            });
                        } elseif ($answer === 'Dry') {
                            $query->where(function($q) {
                                $q->where('sweetness_level', 'like', '%dry%')
                                  ->orWhere('nature', 'like', '%dry%');
                            });
                        }
                        break;
                }
            }
        } elseif ($questionnaire->level === 'savy_sipper') {
            // Process Savy Sipper (Intermediate) level responses
            foreach ($responses as $questionId => $answer) {
                $question = $questionnaire->questions[$questionId] ?? null;
                
                if (!$question) continue;
                
                switch ($question['text']) {
                    case 'What type of wine are you in the mood for?':
                        if ($answer === 'Red') {
                            $query->where('type', 'red');
                        } elseif ($answer === 'White') {
                            $query->where('type', 'white');
                        } elseif ($answer === 'Rosé') {
                            $query->where('type', 'rose');
                        } elseif ($answer === 'Sparkling') {
                            $query->where('type', 'sparkling');
                        }
                        break;
                        
                    case 'What is your price range?':
                        if ($answer === 'Under $20') {
                            $query->where('retail_price', '<', 20);
                        } elseif ($answer === '$20-$50') {
                            $query->where('retail_price', '>=', 20)
                                  ->where('retail_price', '<=', 50);
                        } elseif ($answer === '$50-$100') {
                            $query->where('retail_price', '>=', 50)
                                  ->where('retail_price', '<=', 100);
                        } elseif ($answer === 'Over $100') {
                            $query->where('retail_price', '>', 100);
                        }
                        break;
                        
                    case 'Which grape variety do you prefer?':
                        if (is_array($answer)) {
                            $query->where(function($q) use ($answer) {
                                foreach ($answer as $grape) {
                                    $q->orWhere('grape_variety', 'like', "%$grape%");
                                }
                            });
                        } else {
                            $query->where('grape_variety', 'like', "%$answer%");
                        }
                        break;
                        
                    case 'What food will you be pairing with?':
                        // This would require a more complex matching algorithm
                        // For now, we'll just use keywords
                        if ($answer === 'Red Meat') {
                            $query->where(function($q) {
                                $q->where('type', 'red')
                                  ->where(function($q2) {
                                      $q2->where('body', 'like', '%full%')
                                         ->orWhere('tannin_level', 'like', '%high%');
                                  });
                            });
                        } elseif ($answer === 'Seafood') {
                            $query->where(function($q) {
                                $q->where('type', 'white')
                                  ->orWhere('type', 'sparkling');
                            });
                        } elseif ($answer === 'Poultry') {
                            $query->where(function($q) {
                                $q->where('type', 'white')
                                  ->orWhere('type', 'red')
                                  ->where('body', 'like', '%medium%');
                            });
                        } elseif ($answer === 'Dessert') {
                            $query->where(function($q) {
                                $q->where('sweetness_level', 'like', '%sweet%')
                                  ->orWhere('nature', 'like', '%sweet%');
                            });
                        }
                        break;
                }
            }
        } elseif ($questionnaire->level === 'pro') {
            // Process Pro (Advanced) level responses
            foreach ($responses as $questionId => $answer) {
                $question = $questionnaire->questions[$questionId] ?? null;
                
                if (!$question) continue;
                
                switch ($question['text']) {
                    case 'What type of wine are you in the mood for?':
                        if ($answer === 'Red') {
                            $query->where('type', 'red');
                        } elseif ($answer === 'White') {
                            $query->where('type', 'white');
                        } elseif ($answer === 'Rosé') {
                            $query->where('type', 'rose');
                        } elseif ($answer === 'Sparkling') {
                            $query->where('type', 'sparkling');
                        }
                        break;
                        
                    case 'What is your price range?':
                        if ($answer === 'Under $20') {
                            $query->where('retail_price', '<', 20);
                        } elseif ($answer === '$20-$50') {
                            $query->where('retail_price', '>=', 20)
                                  ->where('retail_price', '<=', 50);
                        } elseif ($answer === '$50-$100') {
                            $query->where('retail_price', '>=', 50)
                                  ->where('retail_price', '<=', 100);
                        } elseif ($answer === 'Over $100') {
                            $query->where('retail_price', '>', 100);
                        }
                        break;
                        
                    case 'Which region do you prefer?':
                        if (is_array($answer)) {
                            $query->where(function($q) use ($answer) {
                                foreach ($answer as $region) {
                                    $q->orWhere('country', 'like', "%$region%")
                                      ->orWhere('wine_sub_region', 'like', "%$region%");
                                }
                            });
                        } else {
                            $query->where(function($q) use ($answer) {
                                $q->where('country', 'like', "%$answer%")
                                  ->orWhere('wine_sub_region', 'like', "%$answer%");
                            });
                        }
                        break;
                        
                    case 'What body weight do you prefer?':
                        $query->where('body', 'like', "%$answer%");
                        break;
                        
                    case 'What tannin level do you prefer?':
                        $query->where('tannin_level', 'like', "%$answer%");
                        break;
                        
                    case 'What acidity level do you prefer?':
                        $query->where('acidity', 'like', "%$answer%");
                        break;
                }
            }
        }
        
        // Get the recommendations
        $recommendations = $query->limit(6)->get();
        
        // If we don't have enough recommendations, relax some constraints
        if ($recommendations->count() < 3) {
            // Start with a more relaxed query
            $query = Product::where('status', 'active');
            
            // Apply only the most important filters
            foreach ($responses as $questionId => $answer) {
                $question = $questionnaire->questions[$questionId] ?? null;
                
                if (!$question) continue;
                
                if ($question['text'] === 'What type of wine are you in the mood for?') {
                    if ($answer === 'Red') {
                        $query->where('type', 'red');
                    } elseif ($answer === 'White') {
                        $query->where('type', 'white');
                    } elseif ($answer === 'Rosé') {
                        $query->where('type', 'rose');
                    } elseif ($answer === 'Sparkling') {
                        $query->where('type', 'sparkling');
                    }
                    break; // Only apply the wine type filter
                }
            }
            
            $recommendations = $query->limit(6)->get();
        }
        
        return $recommendations;
    }
}