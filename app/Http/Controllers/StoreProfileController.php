<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class StoreProfileController extends Controller
{
    public function show()
    {
        // Get the currently logged-in user's associated store
        $store = Store::findOrFail(Auth::user()->store_id);

        // Pass the store data to the view
        return view('user.storeprofile', compact('store'));
    }
    public function storeTab()
    {
        $storeId = Auth::user()->store_id;
        if (is_null($storeId)) {
            return view('partials.storeprofile-content')->with('error', 'Store ID is not assigned to your account.');
        }
        $store = Store::find($storeId);
        if (!$store) {
            return view('partials.storeprofile-content')->with('error', 'The store associated with your account could not be found.');
        }
        return view('partials.storeprofile-content', compact('store'));
    }



    public function updateContactNumber(Request $request)
    {
        $request->validate([
            'new_contact_number' => 'required|numeric|digits_between:10,15',
        ]);

        $user = Auth::user();

        if (!$user->store_id) {
            return back()->with('error', 'No store assigned.');
        }

        $store = \App\Models\Store::find($user->store_id);

        if (!$store) {
            return back()->with('error', 'Store not found.');
        }

        // Save new number and set status to pending
        $store->new_contact_number = $request->new_contact_number;
        $store->contact_status = 'pending';
        $store->save();

        return back()->with('success', 'Your new number is under review.');
    }
}
