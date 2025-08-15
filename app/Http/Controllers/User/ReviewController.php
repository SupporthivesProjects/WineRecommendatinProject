<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:10|max:1000',
        ]);

        // Check if user has already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($existingReview) {
            return back()
                ->with('error', 'You have already reviewed this product.')
                ->withInput();
        }

        // Create new review
        $review = new Review([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'pending', // Default status, can be changed in admin
        ]);

        $review->save();

        return back()
            ->with('success', 'Thank you for your review! It will be visible once approved.');
    }

    public function destroy(Review $review)
    {
        // Check if the authenticated user is the owner of the review
        if (Auth::id() !== $review->user_id) {
            abort(403, 'Unauthorized action.');
        }

        $review->delete();

        return back()->with('success', 'Your review has been deleted.');
    }
}
