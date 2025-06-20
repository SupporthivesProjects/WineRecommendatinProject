<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionnaireTemplate;
use App\Models\UserQuestionnaireResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the questionnaire templates.
     */
    public function index(Request $request)
    {
        $templates = QuestionnaireTemplate::orderBy('level')->get();

        // Get date range from request or set defaults
        $startDate = $request->input('start_date') 
            ? Carbon::parse($request->input('start_date'))->startOfDay()
            : Carbon::now()->subDays(7)->startOfDay();
            
        $endDate = $request->input('end_date') 
            ? Carbon::parse($request->input('end_date'))->endOfDay()
            : Carbon::now()->endOfDay();

        // Ensure start date is not after end date
        if ($startDate->gt($endDate)) {
            $temp = $startDate;
            $startDate = $endDate;
            $endDate = $temp;
        }

        // Generate date range for chart
        $dateRange = collect();
        $current = $startDate->copy();
        
        while ($current->lte($endDate)) {
            $dateRange->push($current->format('Y-m-d'));
            $current->addDay();
        }

        // Get data within the specified date range
        $rawData = DB::table('question_responses')
            ->select(DB::raw('DATE(created_at) as date'), 'template_id', DB::raw('COUNT(DISTINCT submission_id) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('template_id', DB::raw('DATE(created_at)'))
            ->get();

        // Format data for Chart.js
        $chartData = [];
        foreach ($templates as $template) {
            $data = [];
            foreach ($dateRange as $date) {
                $match = $rawData->first(fn($item) => $item->template_id == $template->id && $item->date == $date);
                $data[] = $match ? $match->count : 0;
            }
            $chartData[] = [
                'label' => $template->name,
                'data' => $data,
            ];
        }

        // Get total counts by template_id (distinct submissions) within date range
        $totalCounts = DB::table('question_responses')
            ->select('template_id', DB::raw('COUNT(DISTINCT submission_id) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('template_id')
            ->pluck('count', 'template_id');

        // Assign to individual variables
        $firstSipCount = $totalCounts[1] ?? 0;      
        $savySipperCount = $totalCounts[2] ?? 0;    
        $proCount = $totalCounts[3] ?? 0;           
        $quickPourCount = $totalCounts[4] ?? 0;

        // Format dates for display
        $defaultStartDate = $request->input('start_date', Carbon::now()->subDays(7)->format('Y-m-d'));
        $defaultEndDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $displayStartDate = Carbon::parse($startDate)->format('M d, Y');
        $displayEndDate = Carbon::parse($endDate)->format('M d, Y');

        // Format date labels for chart (limit to reasonable number for readability)
        $dateLabels = $dateRange->count() > 30 
            ? $dateRange->filter(function($date, $index) use ($dateRange) { 
                return $index % ceil($dateRange->count() / 15) === 0; 
            })->values()
            : $dateRange->toArray();

        // Also create last7Days for backward compatibility
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $last7Days->push(Carbon::today()->subDays($i)->format('Y-m-d'));
        }

        return view('admin.dashboard.questionnaires-tab', compact(
            'templates',
            'chartData',
            'dateLabels',
            'last7Days', // Keep for backward compatibility
            'firstSipCount',
            'savySipperCount',
            'quickPourCount',
            'proCount',
            'defaultStartDate',
            'defaultEndDate',
            'displayStartDate',
            'displayEndDate'
        ));
    }


    /**
     * Show the form for creating a new questionnaire template.
     */
    public function create()
    {
        $levels = [
            'first_sip' => 'First Sip (Basic)',
            'savy_sipper' => 'Savy Sipper (Intermediate)',
            'pro' => 'Pro (Advanced)'
        ];
        
        return view('admin.questionnaires.create', compact('levels'));
    }

    /**
     * Store a newly created questionnaire template in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'level' => 'required|in:first_sip,savy_sipper,pro',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:single,multiple,slider',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Process questions data
        $questions = [];
        foreach ($request->input('questions') as $question) {
            $questionData = [
                'text' => $question['text'],
                'type' => $question['type'],
            ];
            
            if ($question['type'] === 'slider') {
                $questionData['min'] = $question['min'] ?? 0;
                $questionData['max'] = $question['max'] ?? 100;
                $questionData['step'] = $question['step'] ?? 1;
                $questionData['default'] = $question['default'] ?? 50;
            } else {
                $questionData['options'] = $question['options'] ?? [];
            }
            
            $questions[] = $questionData;
        }

        $questionnaireTemplate = QuestionnaireTemplate::create([
            'name' => $request->input('name'),
            'level' => $request->input('level'),
            'description' => $request->input('description'),
            'questions' => $questions,
            'is_active' => $request->has('is_active'),
        ]);

        // After saving the questionnaire template, store the questions in the 'questions' table
        foreach ($questions as $question) {
            DB::table('questions')->insert([
                'template_id' => $questionnaireTemplate->id,
                'question' => $question['text'],
                'type' => $question['type'],
                'option_1' => $question['option_1'] ?? null,
                'option_2' => $question['option_2'] ?? null,
                'option_3' => $question['option_3'] ?? null,
                'option_4' => $question['option_4'] ?? null,
                'option_5' => $question['option_5'] ?? null,
                'option_6' => $question['option_6'] ?? null,
                'option_7' => $question['option_7'] ?? null,
                'option_8' => $question['option_8'] ?? null,
                'option_9' => $question['option_9'] ?? null,
                'option_10' => $question['option_10'] ?? null,
                'option_11' => $question['option_11'] ?? null,
                'option_12' => $question['option_12'] ?? null,
                'option_13' => $question['option_13'] ?? null,
                'option_14' => $question['option_14'] ?? null,
                'option_15' => $question['option_15'] ?? null,
                'min_value' => $question['min_value'] ?? null,
                'max_value' => $question['max_value'] ?? null,
                'step' => $question['step'] ?? null,
                'default' => $question['default'] ?? null,
            ]);
        }

        return redirect()->route('admin.questionnaires.index')
            ->with('success', 'Questionnaire template created successfully.');
    }

    /**
     * Display the specified questionnaire template.
     */
    public function show(QuestionnaireTemplate $questionnaire)
    {
        $responses = UserQuestionnaireResponse::where('questionnaire_template_id', $questionnaire->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.questionnaires.show', compact('questionnaire', 'responses'));
    }

    /**
     * Show the form for editing the specified questionnaire template.
     */
    public function edit(QuestionnaireTemplate $questionnaire)
    {
        $levels = [
            'first_sip' => 'First Sip (Basic)',
            'savy_sipper' => 'Savy Sipper (Intermediate)',
            'pro' => 'Pro (Advanced)'
        ];
        
        return view('admin.questionnaires.edit', compact('questionnaire', 'levels'));
    }

    /**
     * Update the specified questionnaire template in storage.
     */
    public function update(Request $request, QuestionnaireTemplate $questionnaire)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'level' => 'required|in:first_sip,savy_sipper,pro',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:single,multiple,slider',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Process questions data
        $questions = [];
        foreach ($request->input('questions') as $question) {
            $questionData = [
                'text' => $question['text'],
                'type' => $question['type'],
            ];
            
            if ($question['type'] === 'slider') {
                $questionData['min'] = $question['min'] ?? 0;
                $questionData['max'] = $question['max'] ?? 100;
                $questionData['step'] = $question['step'] ?? 1;
                $questionData['default'] = $question['default'] ?? 50;
            } else {
                $questionData['options'] = $question['options'] ?? [];
            }
            
            $questions[] = $questionData;
        }

        $questionnaire->update([
            'name' => $request->input('name'),
            'level' => $request->input('level'),
            'description' => $request->input('description'),
            'questions' => $questions,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.questionnaires.index')
            ->with('success', 'Questionnaire template updated successfully.');
    }

    /**
     * Remove the specified questionnaire template from storage.
     */
    public function destroy(QuestionnaireTemplate $questionnaire)
    {
        $questionnaire->delete();

        return redirect()->route('admin.questionnaires.index')
            ->with('success', 'Questionnaire template deleted successfully.');
    }

    /**
     * Toggle the active status of the questionnaire template.
     */
    public function toggleStatus(QuestionnaireTemplate $questionnaire)
    {
        $questionnaire->update([
            'is_active' => !$questionnaire->is_active
        ]);

        return redirect()->route('admin.questionnaires.show', $questionnaire)
            ->with('success', 'Questionnaire template status updated successfully.');
    }

    /**
     * Display analytics for questionnaire usage.
     */
    public function analytics()
    {
        // Get questionnaire templates
        $templates = QuestionnaireTemplate::all();
        
        // Get usage data for the last 30 days
        $startDate = Carbon::now()->subDays(30);
        $endDate = Carbon::now();
        
        $usageData = UserQuestionnaireResponse::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->selectRaw('DATE(created_at) as date, questionnaire_template_id, COUNT(*) as count')
            ->groupBy('date', 'questionnaire_template_id')
            ->get();
        
        // Format data for charts
        $dates = [];
        $datasets = [];
        
        // Initialize datasets for each template
        foreach ($templates as $template) {
            $datasets[$template->id] = [
                'label' => $template->name,
                'data' => [],
                'backgroundColor' => $this->getRandomColor(),
                'borderColor' => $this->getRandomColor(),
            ];
        }
        
        // Generate date range
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->subDays(29 - $i)->format('Y-m-d');
            $dates[] = $date;
            
            // Initialize count for each template on this date
            foreach ($templates as $template) {
                $datasets[$template->id]['data'][$date] = 0;
            }
        }
        
        // Fill in actual counts
        foreach ($usageData as $data) {
            $date = $data->date;
            $templateId = $data->questionnaire_template_id;
            $count = $data->count;
            
            if (isset($datasets[$templateId]['data'][$date])) {
                $datasets[$templateId]['data'][$date] = $count;
            }
        }
        
        // Convert datasets to sequential arrays for Chart.js
        foreach ($datasets as $templateId => $dataset) {
            $datasets[$templateId]['data'] = array_values($dataset['data']);
        }
        
        return view('admin.questionnaires.analytics', [
            'templates' => $templates,
            'dates' => $dates,
            'datasets' => array_values($datasets),
        ]);
    }
    
    /**
     * Generate a random color for chart visualization.
     */
    private function getRandomColor()
    {
        $r = rand(0, 255);
        $g = rand(0, 255);
        $b = rand(0, 255);
        
        return "rgb($r, $g, $b)";
    }

    public function showRespnses()
    {
        $submissions = DB::table('question_responses')
        ->join('questionnaire_usage', 'question_responses.customerID', '=', 'questionnaire_usage.id')
        ->select(
            'question_responses.submission_id',
            'question_responses.customerID',
            DB::raw('MIN(question_responses.created_at) as created_at'),
            'questionnaire_usage.cust_name',
            'questionnaire_usage.cust_email',
            'questionnaire_usage.cust_phone'
        )
        ->groupBy(
            'question_responses.submission_id',
            'question_responses.customerID',
            'questionnaire_usage.cust_name',
            'questionnaire_usage.cust_email',
            'questionnaire_usage.cust_phone'
        )
        ->orderByDesc('created_at')
        ->get();

        return view('admin.questionnaires.showResponses', compact('submissions'));
    }

    // Show a specific submission
    public function showIndividualResponses($submission_id)
    {
        // Fetch customer info from `questionnaire_usage`
        $customer = DB::table('questionnaire_usage')
            ->where('submission_id', $submission_id)
            ->first();

        // Fetch all responses for this submission
        $responses = DB::table('question_responses')
            ->where('submission_id', $submission_id)
            ->get();

        // Get template ID from one of the responses
        $templateId = optional($responses->first())->template_id;

        // Get all questions for that template
        $questions = DB::table('questions')
            ->where('template_id', $templateId)
            ->orderBy('question_order')
            ->pluck('question');  

        // Get template name (assuming you have a `templates` table)
        $templateName = DB::table('questionnaire_templates')
            ->where('id', $templateId)
            ->value('name');

        // Get user_id from one of the responses
        $userId = optional($responses->first())->user_id;

        // Fetch store_id from users table
        $storeId = DB::table('users')
            ->where('id', $userId)
            ->value('store_id');

        // Fetch store details
        $store = DB::table('stores')
            ->where('id', $storeId)
            ->first();

        return view('admin.questionnaires.showIndividualResponses', compact(
            'customer',
            'responses',
            'questions',
            'templateName',
            'store'
        ));
    }
}
