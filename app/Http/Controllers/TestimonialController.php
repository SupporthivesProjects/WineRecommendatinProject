<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Store a newly created testimonial in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'testimonial' => 'required|string|min:10',
            'rating' => 'required|integer|min:1|max:5',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        try {
            // Generate initials if name is provided, otherwise use 'GUEST'
            $initials = $validated['name'] 
                ? implode('', array_map(fn($n) => strtoupper($n[0]), explode(' ', $validated['name'])))
                : 'GUEST';

            // Handle image upload if present
            $imageUrl = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($validated['name'] ?? 'guest') . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/testimonials', $imageName);
                $imageUrl = 'testimonials/' . $imageName;
            }

            // Create testimonial
            $testimonial = Testimonial::create([
                'name' => $validated['name'] ?? 'Anonymous',
                'initials' => $initials,
                'email' => $validated['email'],
                'testimonial' => $validated['testimonial'],
                'rating' => $validated['rating'],
                'position' => $validated['position'] ?? null,
                'company' => $validated['company'] ?? null,
                'image_url' => $imageUrl,
                'is_active' => false, // Admin needs to approve guest testimonials
                'sort_order' => Testimonial::max('sort_order') + 1,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Thank you for your review! It will be visible after approval.',
                'data' => $testimonial
            ]);

        } catch (\Exception $e) {
            Log::error('Error submitting testimonial: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to submit your review. Please try again later.'
            ], 500);
        }
    }
}
