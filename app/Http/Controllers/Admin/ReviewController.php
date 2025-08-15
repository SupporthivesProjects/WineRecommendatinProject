<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReviewController extends Controller
{
    /**
     * Display a listing of the reviews.
     */
    public function index()
    {
        $reviews = Review::with(['user', 'product'])
            ->latest()
            ->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Show the form for creating a new review.
     */
    public function create()
    {
        $users = User::pluck('first_name', 'id');
        $products = Product::pluck('wine_name', 'id');

        return view('admin.reviews.create', compact('users', 'products'));
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:2000',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        Review::create($validated);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review created successfully.');
    }

    /**
     * Display the specified review.
     */
    public function show(Review $review)
    {
        $review->load(['user', 'product']);
        return view('admin.reviews.show', compact('review'));
    }

    /**
     * Show the form for editing the specified review.
     */
    public function edit(Review $review)
    {
        $users = User::pluck('first_name', 'id');
        $products = Product::pluck('wine_name', 'id');

        return view('admin.reviews.edit', compact('review', 'users', 'products'));
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:2000',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $review->update($validated);

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    /**
     * Remove the specified review from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return redirect()
            ->route('admin.reviews.index')
            ->with('success', 'Review deleted successfully.');
    }

    /**
     * Update the status of the review.
     */
    public function updateStatus(Review $review, Request $request)
    {
        $request->validate([
            'status' => 'required|in:approved,pending,rejected'
        ]);

        $review->update(['status' => $request->status]);

        return back()->with('success', "Review has been {$request->status} successfully!");
    }
}
