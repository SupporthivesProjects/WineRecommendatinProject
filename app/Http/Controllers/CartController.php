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

    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $productName = $request->input('product_name');
        $productPrice = $request->input('product_price');

        // ✅ Fetch product from DB
        $product = Product::find($productId);

    
        $cart = Session::get('cart', []);
        
        // Check if product already exists in cart
        $existingIndex = null;
        foreach ($cart as $index => $item) {
            if ($item['id'] == $productId) {
                $existingIndex = $index;
                break;
            }
        }
        
        if ($existingIndex !== null) {
            // Product exists, increment quantity
            $cart[$existingIndex]['quantity'] = ($cart[$existingIndex]['quantity'] ?? 1) + 1;
        } else {
            // Add new product to cart
            $cart[] = [
                'id' => $productId,
                'name' => $productName,
                'retail_price' => $productPrice,
                'image' => $product->image1,
                'quantity' => 1
            ];
        }
        
        Session::put('cart', $cart);
        
        return response()->json(['success' => true, 'message' => 'Product added to cart']);
    }

    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = Session::get('cart', []);
        
        // Remove product from cart
        $cart = array_filter($cart, function($item) use ($productId) {
            return $item['id'] != $productId;
        });
        
        // Reindex array
        $cart = array_values($cart);
        
        Session::put('cart', $cart);
        
        return response()->json(['success' => true, 'message' => 'Product removed from cart']);
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
