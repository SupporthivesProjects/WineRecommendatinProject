<?php

namespace App\Http\Controllers\StoreManager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\Store;
use App\Models\QuestionnaireTemplate;
use App\Models\QuestionnaireLog;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class StoreDashboardController extends Controller
{
    public function index()
    {
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
     
     // Get stores for the table
     $stores = Store::orderBy('id', 'asc')->paginate(10);
     
     // Get users for the table
     $users = User::orderBy('id', 'asc')->paginate(10);
     
     // Get products for the table
     $products = Product::orderBy('id', 'asc')->paginate(10);
     
     // Get questionnaires for the table
     $templates = QuestionnaireTemplate::orderBy('id', 'asc')->paginate(10);
   
     // If no questionnaire data found, provide default labels
     if (empty($q1Labels)) {
         $q1Labels = ['Red', 'White', 'Sparkling'];
         $q1Values = [0, 0, 0];
     }

        return view('store-manager.storedashboard', compact(
            'productTypeLabels', 'productTypeData',
            'grapeLabels', 'grapeData',
            'countryLabels', 'countryData',
            'priceLabels', 'priceData',
            'userLabels', 'userData',
            'storeLabels', 'storeData',
            'dates', 'adminData', 'admin1Data', 'admin2Data',
            'stores', 'users', 'products', 'templates',
            'q1Labels', 'q1Values'
        ));



    }

    public function test()
    {
        return view('test.dashboard');
    }

   

}
