<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionnaireTemplate;
use App\Models\QuestionnaireResponse;
use App\Models\Product;
use App\Models\User;
use App\Models\UserQuestionnaireResponse;
use Illuminate\Support\Facades\Auth;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the questionnaires.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questionnaires = QuestionnaireTemplate::where('is_active', true)
            ->orderBy('id', 'asc')
            ->get();
            
        return view('user.questionnaires', compact('questionnaires'));
    }
    
    /**
     * Display the expertise assessment questionnaire.
     *
     * @return \Illuminate\Http\Response
     */
    public function expertise()
    {
        return view('user.expertise-questionnaire');
    }
    
    /**
     * Process the expertise assessment submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function submitExpertise(Request $request)
    {
        $request->validate([
            'wine_consumption' => 'required|string',
            'wine_knowledge' => 'required|string',
            'wine_tasting' => 'required|string',
            'wine_pairing' => 'required|string',
        ]);
        
        // Calculate expertise level based on answers
        $score = 0;
        
        if ($request->wine_consumption == 'weekly' || $request->wine_consumption == 'daily') {
            $score += 2;
        } elseif ($request->wine_consumption == 'monthly') {
            $score += 1;
        }
        
        if ($request->wine_knowledge == 'intermediate') {
            $score += 2;
        } elseif ($request->wine_knowledge == 'advanced') {
            $score += 4;
        }
        
        if ($request->wine_tasting == 'yes_sometimes') {
            $score += 1;
        } elseif ($request->wine_tasting == 'yes_regularly') {
            $score += 2;
        }
        
        if ($request->wine_pairing == 'yes_sometimes') {
            $score += 1;
        } elseif ($request->wine_pairing == 'yes_confidently') {
            $score += 2;
        }
        
        // Determine expertise level based on score
        $expertiseLevel = 'first_sip'; // Default level
        
        if ($score >= 7) {
            $expertiseLevel = 'pro';
        } elseif ($score >= 4) {
            $expertiseLevel = 'savy_sipper';
        }
        
        // Update user's expertise level
        $user = Auth::user();
        $user->expertise_level = $expertiseLevel;
        $user->save();
        
        // Store the questionnaire response
        UserQuestionnaireResponse::create([
            'user_id' => $user->id,
            'questionnaire_id' => null, // This is an expertise assessment, not a regular questionnaire
            'responses' => json_encode($request->except('_token')),
            'expertise_assessment' => true,
        ]);
        
        return redirect()->route('user.dashboard')
            ->with('success', 'Your wine expertise level has been updated to ' . ucfirst(str_replace('_', ' ', $expertiseLevel)) . '. Now you can get personalized recommendations!');
    }

    /**
     * Display the specified questionnaire.
     *
     * @param  \App\Models\QuestionnaireTemplate  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function show(QuestionnaireTemplate $questionnaire)
    {
        // Check if questionnaire is active
        if (!$questionnaire->is_active) {
            return redirect()->route('user.dashboard')
                ->with('error', 'This questionnaire is not currently available.');
        }
        
        // Check if user's expertise level is appropriate for this questionnaire
        $user = Auth::user();
        
        if (!$user->expertise_level) {
            return redirect()->route('questionnaires.expertise')
                ->with('info', 'Please complete the expertise assessment first.');
        }
        
        // Allow access if:
        // 1. Questionnaire level matches user level, OR
        // 2. Questionnaire is 'first_sip' (available to all), OR
        // 3. User is 'pro' (can access all), OR
        // 4. User is 'savy_sipper' and questionnaire is not 'pro'
        if ($questionnaire->level == $user->expertise_level || 
            $questionnaire->level == 'first_sip' || 
            $user->expertise_level == 'pro' ||
            ($user->expertise_level == 'savy_sipper' && $questionnaire->level != 'pro')) {
            
            return view('user.questionnaire-show', compact('questionnaire'));
        }
        
        return redirect()->route('user.dashboard')
            ->with('error', 'This questionnaire is designed for a different expertise level.');
    }

    /**
     * Process the questionnaire submission.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\QuestionnaireTemplate  $questionnaire
     * @return \Illuminate\Http\Response
     */
    public function submit(Request $request, QuestionnaireTemplate $questionnaire)
    {
        $request->validate([
            'answers' => 'required|array',
        ]);
        
        $user = Auth::user();
        $answers = $request->answers;
        
        // Process answers to extract preferences
        $preferences = $this->processAnswers($questionnaire, $answers);
        
        // Store the questionnaire response
        UserQuestionnaireResponse::create([
            'user_id' => $user->id,
            'questionnaire_id' => $questionnaire->id,
            'responses' => json_encode([
                'answers' => $answers,
                'preferences' => $preferences
            ]),
        ]);
        
        // Get recommended products based on preferences
        $recommendedProducts = $this->getRecommendedProducts($preferences);
        
        return view('user.questionnaire-results', compact('preferences', 'recommendedProducts'));
    }
    
    /**
     * Process questionnaire answers to extract wine preferences.
     *
     * @param  \App\Models\QuestionnaireTemplate  $questionnaire
     * @param  array  $answers
     * @return array
     */
    private function processAnswers(QuestionnaireTemplate $questionnaire, array $answers)
    {
        $questions = json_decode($questionnaire->questions, true);
        $preferences = [];
        
        foreach ($questions as $index => $question) {
            if (!isset($answers[$index])) {
                continue;
            }
            
            $answer = $answers[$index];
            
            // Extract preferences based on question type and answer
            if (isset($question['preference_key']) && $question['preference_key']) {
                $key = $question['preference_key'];
                
                if ($question['type'] == 'multiple_choice') {
                    // For multiple choice, map the answer to a preference value
                    if (isset($question['preference_mapping'][$answer])) {
                        $preferences[$key] = $question['preference_mapping'][$answer];
                    } else {
                        // Default mapping: use the option text
                        $preferences[$key] = $question['options'][$answer] ?? $answer;
                    }
                } elseif ($question['type'] == 'checkbox') {
                    // For checkboxes, create an array of selected values
                    $preferences[$key] = [];
                    foreach ($answer as $selected) {
                        if (isset($question['preference_mapping'][$selected])) {
                            $preferences[$key][] = $question['preference_mapping'][$selected];
                        } else {
                            $preferences[$key][] = $question['options'][$selected] ?? $selected;
                        }
                    }
                } elseif ($question['type'] == 'slider') {
                    // For sliders, map the numeric value to a preference
                    if (isset($question['preference_mapping'])) {
                        // Find the closest mapping
                        $closest = null;
                        $closestDiff = PHP_INT_MAX;
                        
                        foreach ($question['preference_mapping'] as $value => $mapping) {
                            $diff = abs($value - $answer);
                            if ($diff < $closestDiff) {
                                $closest = $mapping;
                                $closestDiff = $diff;
                            }
                        }
                        
                        if ($closest !== null) {
                            $preferences[$key] = $closest;
                        } else {
                            $preferences[$key] = $answer;
                        }
                    } else {
                        $preferences[$key] = $answer;
                    }
                } else {
                    // For text or other types, use the answer directly
                    $preferences[$key] = $answer;
                }
            }
        }
        
        return $preferences;
    }
    
    /**
     * Get recommended products based on preferences.
     *
     * @param  array  $preferences
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function getRecommendedProducts(array $preferences)
    {
        $query = Product::where('status', 'active');
        
        // Apply filters based on preferences
        if (!empty($preferences['wine_type'])) {
            $query->where('type', $preferences['wine_type']);
        }
        
        if (!empty($preferences['price_range'])) {
            // Parse price range and apply filter
            $priceRange = explode('-', $preferences['price_range']);
            if (count($priceRange) == 2) {
                $query->whereBetween('retail_price', [$priceRange[0], $priceRange[1]]);
            }
        }
        
        if (!empty($preferences['grape_variety'])) {
            if (is_array($preferences['grape_variety'])) {
                $query->where(function($q) use ($preferences) {
                    foreach ($preferences['grape_variety'] as $grape) {
                        $q->orWhere('grape_variety', 'like', '%' . $grape . '%');
                    }
                });
            } else {
                $query->where('grape_variety', 'like', '%' . $preferences['grape_variety'] . '%');
            }
        }
        
        if (!empty($preferences['country'])) {
            if (is_array($preferences['country'])) {
                $query->whereIn('country', $preferences['country']);
            } else {
                $query->where('country', $preferences['country']);
            }
        }
        
        if (!empty($preferences['sweetness'])) {
            // Assuming we have a sweetness field or we're using a tag-based approach
            $query->where('sweetness', $preferences['sweetness'])
                  ->orWhere('description', 'like', '%' . $preferences['sweetness'] . '%');
        }
        
        if (!empty($preferences['body'])) {
            // Assuming we have a body field or we're using a tag-based approach
            $query->where('body', $preferences['body'])
                  ->orWhere('description', 'like', '%' . $preferences['body'] . '%');
        }
        
        // Limit to a reasonable number of recommendations
        return $query->inRandomOrder()->limit(6)->get();
    }
}