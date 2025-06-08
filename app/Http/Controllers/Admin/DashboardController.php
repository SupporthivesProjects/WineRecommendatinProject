<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Store;
use App\Models\QuestionnaireTemplate;
use App\Models\QuestionnaireLog;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'dashboard');

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

        // Format dates for display and form defaults
        $defaultStartDate = $request->input('start_date', Carbon::now()->subDays(7)->format('Y-m-d'));
        $defaultEndDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
        $displayStartDate = Carbon::parse($startDate)->format('M d, Y');
        $displayEndDate = Carbon::parse($endDate)->format('M d, Y');

        // Products data with search functionality
        $productsQuery = Product::query();

        // Apply search filter for products
        if ($request->has('product_search') && !empty($request->product_search)) {
            $search = $request->product_search;
            $productsQuery->where(function ($query) use ($search) {
                $query->where('wine_name', 'like', "%{$search}%")
                    ->orWhere('winery', 'like', "%{$search}%")
                    ->orWhere('country', 'like', "%{$search}%")
                    ->orWhere('grape_variety', 'like', "%{$search}%");
            });
        }

        // Apply type filter for products
        if ($request->has('product_filter') && !empty($request->product_filter)) {
            $productsQuery->where('type', $request->product_filter);
        }

        // Get products for the table with pagination
        $productsCount = $productsQuery->count();
        $products = $productsQuery->orderBy('id', 'desc')->paginate(5);

        // Stores data with search functionality
        $storesQuery = Store::query();

        // Apply search filter for stores
        if ($request->has('store_search') && !empty($request->store_search)) {
            $search = $request->store_search;
            $storesQuery->where(function ($query) use ($search) {
                $query->where('store_name', 'like', "%{$search}%")
                    ->orWhere('contact_number', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Apply state filter for stores
        if ($request->has('store_filter') && !empty($request->store_filter)) {
            $storesQuery->where('state', $request->store_filter);
        }

        // Get stores for the table with pagination
        $storesCount = $storesQuery->count();
        $stores = $storesQuery->orderBy('id', 'desc')->paginate(10);

        // Get unique states for the filter dropdown
        $statesList = Store::distinct()->pluck('state')->filter()->sort()->values();

        // Users data with search functionality
        $usersQuery = User::query();

        // Apply search filter for users
        if ($request->has('user_search') && !empty($request->user_search)) {
            $search = $request->user_search;
            $usersQuery->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        // Apply role filter for users
        if ($request->has('role_filter') && !empty($request->role_filter)) {
            $usersQuery->where('role', $request->role_filter);
        }

        // Get users for the table with pagination
        $usersCount = $usersQuery->count();
        $users = $usersQuery->orderBy('id', 'desc')->paginate(10);
        

        // Products data for pie chart - categorized by wine type
        $productTypes = Product::select('type')
            ->selectRaw('count(*) as count')
            ->groupBy('type')
            ->get()
            ->pluck('count', 'type')
            ->toArray();

        $productTypeLabels = array_keys($productTypes);
        $productTypeData = array_values($productTypes);

        // If no products found, provide default labels
        if (empty($productTypeLabels)) {
            $productTypeLabels = ['Red Wine', 'White Wine', 'Rosé', 'Sparkling'];
            $productTypeData = [0, 0, 0, 0];
        }

        // Product data by grape variety
        $productsByGrape = Product::select('grape_variety')
            ->selectRaw('count(*) as count')
            ->whereNotNull('grape_variety')
            ->groupBy('grape_variety')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        $grapeLabels = [];
        $grapeData = [];

        if ($productsByGrape->count() > 0) {
            foreach ($productsByGrape as $grape) {
                $grapeLabels[] = ucfirst($grape->grape_variety ?: 'Unspecified');
                $grapeData[] = $grape->count;
            }
        } else {
            $grapeLabels = ['Cabernet Sauvignon', 'Chardonnay', 'Merlot', 'Pinot Noir', 'Sauvignon Blanc'];
            $grapeData = [0, 0, 0, 0, 0];
        }

        // Product data by country
        $productsByCountry = Product::select('country')
            ->selectRaw('count(*) as count')
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get();

        $countryLabels = [];
        $countryData = [];

        if ($productsByCountry->count() > 0) {
            foreach ($productsByCountry as $country) {
                $countryLabels[] = $country->country ?: 'Unspecified';
                $countryData[] = $country->count;
            }
        } else {
            $countryLabels = ['France', 'Italy', 'Spain', 'USA', 'Australia'];
            $countryData = [0, 0, 0, 0, 0];
        }

        // Product price ranges
        $priceRanges = [
            'Under $20' => [0, 20],
            '$20-$50' => [20, 50],
            '$50-$100' => [50, 100],
            '$100-$200' => [100, 200],
            'Over $200' => [200, 999999]
        ];

        $priceLabels = array_keys($priceRanges);
        $priceData = [];

        foreach ($priceRanges as $range => $limits) {
            $count = Product::where('retail_price', '>=', $limits[0])
                ->where('retail_price', '<', $limits[1])
                ->count();
            $priceData[] = $count;
        }

        // Users data for pie chart - categorized by role
        $userRoles = User::select('role')
            ->selectRaw('count(*) as count')
            ->groupBy('role')
            ->get()
            ->pluck('count', 'role')
            ->toArray();

        $userLabels = array_map('ucfirst', array_keys($userRoles));
        $userData = array_values($userRoles);

        // If no users found, provide default labels
        if (empty($userLabels)) {
            $userLabels = ['Admin', 'Store Manager', 'Customer'];
            $userData = [0, 0, 0];
        }

        // Stores data for pie chart - active vs inactive
        $storeStatus = Store::select('status')
            ->selectRaw('count(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        $storeLabels = array_map('ucfirst', array_keys($storeStatus));
        $storeData = array_values($storeStatus);

        // If no stores found, provide default labels
        if (empty($storeLabels)) {
            $storeLabels = ['Active', 'Inactive'];
            $storeData = [0, 0];
        }

        // Questionnaire usage data for the selected date range
        $dateRange = collect();
        $current = $startDate->copy();
        
        while ($current->lte($endDate)) {
            $dateRange->push($current->format('Y-m-d'));
            $current->addDay();
        }

        $dates = $dateRange->map(function($date) {
            return Carbon::parse($date)->format('d M');
        })->toArray();

        $adminData = [];
        $admin1Data = [];
        $admin2Data = [];

        // Check if questionnaire_logs table exists
        if (Schema::hasTable('questionnaire_logs')) {
            foreach ($dateRange as $date) {
                // Using model instead of DB facade
                $adminData[] = QuestionnaireLog::where('admin_id', 1)
                    ->whereDate('created_at', $date)
                    ->count();

                $admin1Data[] = QuestionnaireLog::where('admin_id', 2)
                    ->whereDate('created_at', $date)
                    ->count();

                $admin2Data[] = QuestionnaireLog::where('admin_id', 3)
                    ->whereDate('created_at', $date)
                    ->count();
            }
        } else {
            // Provide sample data if table doesn't exist
            foreach ($dateRange as $date) {
                $adminData[] = rand(5, 15);
                $admin1Data[] = rand(3, 12);
                $admin2Data[] = rand(2, 10);
            }
        }

        // Get questionnaires for the table
        $templates = QuestionnaireTemplate::orderBy('id', 'asc')->paginate(10);

        // If no questionnaire data found, provide default labels
        if (!isset($q1Labels)) {
            $q1Labels = ['Red', 'White', 'Sparkling'];
            $q1Values = [0, 0, 0];
        }

        // Get the data from the database within date range
        $usageData = DB::table('questionnaire_usage')
            ->select(DB::raw('DATE(created_on) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_on', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_on)'))
            ->orderBy('date', 'asc')
            ->get();

        // Convert the collection to arrays of dates and counts
        $usageDates = $usageData->pluck('date')->toArray();
        $counts = $usageData->pluck('count')->toArray();

        // Map over the generated dates and assign counts
        $counts = $dateRange->map(function ($date) use ($usageData) {
            // Use Carbon to parse the date correctly
            $record = $usageData->firstWhere('date', Carbon::parse($date)->toDateString());

            // Return the count if it exists, otherwise 0
            return $record ? $record->count : 0;
        })->toArray();

        // QUESTIONNAIRE CHART DATA within date range
        // Fetch counts of unique submissions grouped by day within date range
        $responseData = DB::table('question_responses')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(DISTINCT submission_id) as count')
            )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date')
            ->get();

        // Initialize graph data with zeros
        $graphData = array_fill(0, count($dates), 0);

        // Map the result to corresponding dates
        foreach ($responseData as $row) {
            $dateLabel = Carbon::parse($row->date)->format('d M');
            $index = array_search($dateLabel, $dates);
            if ($index !== false) {
                $graphData[$index] = $row->count;
            }
        }

        // Send list of all featured products
        $featuredCount = DB::table('store_products')
                    ->where('is_featured', 1)
                    ->count();

        return view('admin.bootadmindashboard', compact(
            'activeTab',
            'productTypeLabels',
            'productTypeData',
            'grapeLabels',
            'grapeData',
            'countryLabels',
            'countryData',
            'priceLabels',
            'priceData',
            'userLabels',
            'userData',
            'storeLabels',
            'storeData',
            'dates',
            'adminData',
            'admin1Data',
            'admin2Data',
            'stores',
            'statesList',
            'users',
            'products',
            'templates',
            'q1Labels',
            'q1Values',
            'counts',
            'usersCount',
            'storesCount',
            'productsCount',
            'graphData',
            'featuredCount',
            'defaultStartDate',
            'defaultEndDate',
            'displayStartDate',
            'displayEndDate'
        ));
    }


    /**
     * Display questionnaires.
     */
    public function questionnaires()
    {
        $questionnaires = QuestionnaireTemplate::orderBy('id', 'asc')->paginate(15);
        return view('admin.questionnaires.index', compact('questionnaires'));
    }

    /**
     * Show the form for creating a new questionnaire.
     */
    public function createQuestionnaire()
    {
        $products = Product::where('status', 'active')->get();
        return view('admin.questionnaires.create', compact('products'));
    }

    /**
     * Store a newly created questionnaire in storage.
     */
    public function storeQuestionnaire(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|in:first_sip,savy_sipper,pro',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'is_active' => 'boolean',
        ]);

        QuestionnaireTemplate::create($validated);

        return redirect()->route('admin.questionnaires.index')
            ->with('success', 'Questionnaire created successfully.');
    }

    /**
     * Display the specified questionnaire.
     */
    public function showQuestionnaire(QuestionnaireTemplate $questionnaire)
    {
        return view('admin.questionnaires.show', compact('questionnaire'));
    }

    /**
     * Show the form for editing the specified questionnaire.
     */
    public function editQuestionnaire(QuestionnaireTemplate $questionnaire)
    {
        return view('admin.questionnaires.edit', compact('questionnaire'));
    }

    /**
     * Update the specified questionnaire in storage.
     */
    public function updateQuestionnaire(Request $request, QuestionnaireTemplate $questionnaire)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'level' => 'required|in:first_sip,savy_sipper,pro',
            'description' => 'nullable|string',
            'questions' => 'required|array|min:1',
            'is_active' => 'boolean',
        ]);

        $questionnaire->update($validated);

        return redirect()->route('admin.questionnaires.index')
            ->with('success', 'Questionnaire updated successfully.');
    }

    /**
     * Remove the specified questionnaire from storage.
     */
    public function destroyQuestionnaire(QuestionnaireTemplate $questionnaire)
    {
        $questionnaire->delete();

        return redirect()->route('admin.questionnaires.index')
            ->with('success', 'Questionnaire deleted successfully.');
    }

    



}
