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
use Illuminate\Support\Facades\DB;

class StoreDashboardController extends Controller
{
    public function index()
    {
        // Step 1: Get current user and their store ID
        $user = auth()->user(); // Assuming Auth is set up
        $storeId = $user->store_id;

        // Step 2: Get product IDs for this store from store_products
        $storeProductIds = DB::table('store_products')
            ->where('store_id', $storeId)
            ->pluck('product_id')
            ->toArray();

        $featuredCount = DB::table('store_products')
        ->where('store_id', $storeId)
        ->where('is_featured', 1)
        ->count();
        

        // Step 3: Get all product details for this store
        $products = Product::whereIn('id', $storeProductIds)->get();

        // Step 4: Wine type pie chart
        $productTypes = Product::whereIn('id', $storeProductIds)
            ->select('type')
            ->selectRaw('count(*) as count')
            ->groupBy('type')
            ->get()
            ->pluck('count', 'type')
            ->toArray();

        $productTypeLabels = array_keys($productTypes);
        $productTypeData = array_values($productTypes);

        if (empty($productTypeLabels)) {
            $productTypeLabels = ['Red Wine', 'White Wine', 'Rosé', 'Sparkling'];
            $productTypeData = [0, 0, 0, 0];
        }

        // Step 5: Grape variety pie chart
        $productsByGrape = Product::whereIn('id', $storeProductIds)
            ->select('grape_variety')
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

        // Step 6: Country pie chart
        $productsByCountry = Product::whereIn('id', $storeProductIds)
            ->select('country')
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

        // Step 7: Price range pie chart
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
            $count = Product::whereIn('id', $storeProductIds)
                ->where('retail_price', '>=', $limits[0])
                ->where('retail_price', '<', $limits[1])
                ->count();
            $priceData[] = $count;
        }


        // QUESTIONNAIRE CHART DATA (filtered by users of current store)
        $dates = [];
        for ($i = 6; $i >= 0; $i--) {
            $dates[] = Carbon::now()->subDays($i)->format('d M');
        }

        $responseData = DB::table('question_responses')
            ->join('users', 'question_responses.user_id', '=', 'users.id')
            ->select(
                DB::raw('DATE(question_responses.created_at) as date'),
                DB::raw('COUNT(DISTINCT question_responses.submission_id) as count')
            )
            ->where('question_responses.created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->where('users.store_id', $storeId)
            ->groupBy(DB::raw('DATE(question_responses.created_at)'))
            ->orderBy('date')
            ->get();

        $graphData = array_fill(0, count($dates), 0);
        foreach ($responseData as $row) {
            $dateLabel = Carbon::parse($row->date)->format('d M');
            $index = array_search($dateLabel, $dates);
            if ($index !== false) {
                $graphData[$index] = $row->count;
            }
        }


        return view('store-manager.storedashboard', compact(
            'productTypeLabels', 'productTypeData',
            'grapeLabels', 'grapeData',
            'countryLabels', 'countryData',
            'priceLabels', 'priceData',
            'products',
            'featuredCount',
            'graphData',
            'dates'
        ));
    }



    public function test()
    {
        return view('test.dashboard');
    }
   

}
