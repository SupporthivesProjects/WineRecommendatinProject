<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StoreProfileController extends Controller
{
    public function show()
    {
        try {
            $user = Auth::user();

            if (!$user || !$user->store_id) {
                throw new \Exception('Authenticated user has no associated store.');
            }

            // get store and manager
            $store = Store::findOrFail($user->store_id);
            $manager = User::findOrFail($store->manager_id);

            // pass both to view
            return view('user.storeprofile', compact('store', 'manager'));

        } catch (\Throwable $e) {
            Log::error('Error fetching store/manager for storeprofile: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'user_id' => Auth::id() ?? null,
            ]);

            // Option A: show friendly message and redirect back
            return redirect()->back()->with('error', 'Unable to load store profile. Please try again later.');

            // Option B (if you prefer a 404):
            // abort(404, 'Store or manager not found.');
        }
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
