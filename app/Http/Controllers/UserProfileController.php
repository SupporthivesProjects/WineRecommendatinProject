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
        return view('user.userprofile', compact('user'));
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'string', 'min:8', 'confirmed'], // requires new_password_confirmation
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }
}
