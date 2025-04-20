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

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'dashboard');

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
        $products = $productsQuery->orderBy('id', 'desc')->paginate(10);

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

        // Questionnaire usage data for last 5 days
        $dates = [];
        $adminData = [];
        $admin1Data = [];
        $admin2Data = [];

        // Get the last 5 days
        for ($i = 4; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dates[] = $date->format('d M');

            // Check if questionnaire_logs table exists
            if (Schema::hasTable('questionnaire_logs')) {
                // Using model instead of DB facade
                $adminData[] = QuestionnaireLog::where('admin_id', 1)
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->count();

                $admin1Data[] = QuestionnaireLog::where('admin_id', 2)
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->count();

                $admin2Data[] = QuestionnaireLog::where('admin_id', 3)
                    ->whereDate('created_at', $date->format('Y-m-d'))
                    ->count();
            } else {
                // Provide sample data if table doesn't exist
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

        return view('admin.dashboard', compact(
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
            'q1Values'
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
