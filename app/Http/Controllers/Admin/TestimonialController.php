<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('sort_order')->latest()->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'initials' => 'required|string|max:10',
            'testimonial' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        try {
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/testimonials', $imageName);
                $validated['image_url'] = 'testimonials/' . $imageName;
            }

            $validated['is_active'] = $request->has('is_active');

            Testimonial::create($validated);

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial created successfully.');
                
        } catch (\Exception $e) {
            Log::error('Error creating testimonial: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error creating testimonial. Please try again.');
        }
    }

    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonials.show', compact('testimonial'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'initials' => 'required|string|max:10',
            'testimonial' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'position' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'sort_order' => 'integer|min:0',
            'is_active' => 'boolean'
        ]);

        try {
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($testimonial->image_url) {
                    Storage::delete('public/' . $testimonial->image_url);
                }
                
                $image = $request->file('image');
                $imageName = time() . '_' . Str::slug($validated['name']) . '.' . $image->getClientOriginalExtension();
                $image->storeAs('public/testimonials', $imageName);
                $validated['image_url'] = 'testimonials/' . $imageName;
            }
            
            $validated['is_active'] = $request->boolean('is_active');

            $testimonial->update($validated);

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial updated successfully');
                
        } catch (\Exception $e) {
            Log::error('Error updating testimonial: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error updating testimonial. Please try again.');
        }
    }

    public function destroy(Testimonial $testimonial)
    {
        try {
            // Delete image if exists
            if ($testimonial->image_url) {
                Storage::delete('public/' . $testimonial->image_url);
            }
            
            $testimonial->delete();

            return redirect()->route('admin.testimonials.index')
                ->with('success', 'Testimonial deleted successfully');
                
        } catch (\Exception $e) {
            Log::error('Error deleting testimonial: ' . $e->getMessage());
            return back()->with('error', 'Error deleting testimonial. Please try again.');
        }
    }
}
