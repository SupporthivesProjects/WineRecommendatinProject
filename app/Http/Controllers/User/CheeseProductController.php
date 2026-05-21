<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CheeseProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheeseProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get the logged-in user with their store
        $user = User::with('store')->findOrFail(Auth::id());

        if (!$user->store_id) {
            return back()->with('error', 'No store assigned to your account. Please contact support.');
        }

        // Get cheeses that are available in the user's store
        $cheeses = CheeseProduct::whereHas('stores', function ($query) use ($user) {
            $query->where('store_id', $user->store_id)
                ->where('is_available', true)
                ->where('quantity', '>', 0);
        })
            ->with(['stores' => function ($query) use ($user) {
                $query->where('store_id', $user->store_id)
                    ->select('stores.id', 'store_name', 'address1')
                    ->withPivot(['quantity', 'is_available']);
            }])
            ->paginate(12);

        return view('user.cheeses', [
            'cheeses' => $cheeses,
            'store' => $user->store
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('store')->findOrFail(Auth::id());

        if (!$user->store_id) {
            return back()->with('error', 'No store assigned to your account. Please contact support.');
        }

        $cheese = CheeseProduct::with(['stores' => function ($query) use ($user) {
            $query->where('store_id', $user->store_id)
                ->where('is_available', true)
                ->where('quantity', '>', 0)
                ->select('stores.id', 'store_name', 'address1')
                ->withPivot(['quantity', 'is_available']);
        }])->findOrFail($id);

        // Debug: Find products with the cheese name in cheese_pairing using LIKE
        $cheeseName = $cheese->name;
        $matchingProducts = \App\Models\Product::where('cheese_pairing', 'LIKE', '%' . $cheeseName . '%')
            ->with(['images' => function ($query) {
                $query->orderBy('is_primary', 'desc'); // Primary image first
            }])
            ->get();

        // Get related cheeses from the same store
        $relatedCheeses = CheeseProduct::whereHas('stores', function ($query) use ($user, $id) {
            $query->where('store_id', $user->store_id)
                ->where('is_available', true)
                ->where('quantity', '>', 0);
        })
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        // Get cart items from session
        $cart = session()->get('cart', []);
        $cartItemIds = array_keys($cart);

        return view('user.cheese-details', [
            'cheese' => $cheese,
            'relatedCheeses' => $relatedCheeses,
            'store' => $user->store,
            'cart' => $cartItemIds,
            'pairedWines' => $matchingProducts // Add paired wines to the view
        ]);
    }
}
