<?php

namespace App\Http\Controllers;

use App\Models\PopupEnquiry;
use Illuminate\Http\Request;

class PopupEnquiryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female,Other,Prefer not to say',
            'mobile' => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'description' => 'nullable|string|max:2000',
            'product_name' => 'nullable|string|max:255',
        ]);

        $enquiry = PopupEnquiry::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Your enquiry has been submitted successfully.',
            'enquiry_id' => $enquiry->id,
        ]);
    }
}