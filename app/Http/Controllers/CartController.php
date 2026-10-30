<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        
        return view('user.cart');
    }

    public function get()
    {
        $cart = Session::get('cart', []);
        return response()->json(['cart' => $cart]);
    }

    public function updateQuantity(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        
        $cart = Session::get('cart', []);
        
        // Find and update the product quantity
        foreach ($cart as &$item) {
            if ($item['id'] == $productId) {
                $item['quantity'] = max(1, min(10, (int)$quantity)); // Ensure quantity is between 1 and 10
                break;
            }
        }
        
        Session::put('cart', $cart);
        
        return response()->json(['success' => true, 'message' => 'Quantity updated']);
    }

    public function checkout(Request $request)
    {
        $submissionId = $request->input('submission_id');
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return response()->json(['success' => false, 'message' => 'Cart is empty']);
        }
        
        // Here you can add your checkout logic
        // For example, save order to database, process payment, etc.
        
        // Clear cart after successful checkout
        Session::forget('cart');
        
        return response()->json(['success' => true, 'message' => 'Order placed successfully']);
    }
}
