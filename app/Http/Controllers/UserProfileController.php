<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
   
    public function show()
{
    // Get the currently logged-in user
    $user = Auth::user();

    // Pass user data to a Blade view
    return view('user.profile', compact('user'));
}

}
