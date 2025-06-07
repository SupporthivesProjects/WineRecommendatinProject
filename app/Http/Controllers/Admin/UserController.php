<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::with('store')->get();
        return view('admin.dashboard.users-tab', compact('users'));
        
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $stores = Store::where('status', 'active')->get();
        return view('admin.users.create', compact('stores'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
            'mobile' => ['required', 'string', 'max:20'],
            'role' => ['required', 'in:store_manager,customer,main_manager'],
            'status' => ['required', 'in:active,inactive'],
            'store_id' => ['nullable', 'exists:stores,id'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check for duplicate user by email AND mobile
        $existingUser = User::where('email', $request->email)
                            ->where('mobile', $request->mobile)
                            ->first();

        if ($existingUser) {
            return redirect()->back()
                ->withErrors(['duplicate' => 'A user with this email and mobile already exists.'])
                ->withInput();
        }

        // Store manager must have a store assigned
        if ($request->input('role') === 'store_manager' && empty($request->input('store_id'))) {
            return redirect()->back()
                ->withErrors(['store_id' => 'A store manager must be assigned to a store.'])
                ->withInput();
        }

        // Create the user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'role' => $request->role,
            'status' => $request->status,
            'store_id' => $request->role === 'store_manager' ? $request->store_id : null,
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'users'])
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $stores = Store::where('status', 'active')->get();
        return view('admin.users.edit', compact('user', 'stores'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'store_id' => ['nullable', 'exists:stores,id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role' => ['required', 'in:admin,store_manager,user'],
            'status' => ['required', 'in:active,inactive'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validate that store managers must have a store assigned
        if ($request->input('role') === 'store_manager' && empty($request->input('store_id'))) {
            return redirect()->back()
                ->withErrors(['store_id' => 'A store manager must be assigned to a store.'])
                ->withInput();
        }

        $userData = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => $request->mobile,
            'store_id' => $request->store_id,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle the user's status.
     */
    public function toggleStatus(User $user)
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();
        
        return redirect()->route('admin.users.show', $user)
            ->with('success', 'User status updated successfully.');
    }
}