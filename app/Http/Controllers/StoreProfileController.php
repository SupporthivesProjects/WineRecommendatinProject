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
}
