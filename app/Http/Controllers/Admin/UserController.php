<?php

// --- Verify Namespace ---
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User; // Use the correct User model
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;

// --- Verify Class Name ---
class UserController extends Controller
{
    // Central validation rules helper
    private function validationRules($userId = null): array
    {
        $emailRule = ['required', 'string', 'lowercase', 'email', 'max:255'];
        $usernameRule = ['required', 'string', 'max:255'];

        if ($userId) {
            // Unique rules for update, ignoring the current user
            $emailRule[] = 'unique:'.User::class.',email,'.$userId;
            $usernameRule[] = 'unique:'.User::class.',username,'.$userId;
        } else {
            // Unique rules for create
            $emailRule[] = 'unique:'.User::class;
            $usernameRule[] = 'unique:'.User::class;
        }

        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => $usernameRule,
            'email' => $emailRule,
            'password' => [$userId ? 'nullable' : 'required', 'confirmed', Rules\Password::defaults()], // Required on create, optional on update
            'role' => ['required', 'string', 'in:'.User::ROLE_USER.','.User::ROLE_ADMIN], // Use model constants
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'zip_code' => ['nullable', 'string', 'max:20'],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ];
    }

    /**
     * Display a listing of the users.
     */
    public function index(): View
    {
        Log::info('UserController@index accessed.'); // Add logging
        try {
            $totalUserCount = User::count();
            // Use model constants/methods for role checks
            $adminCount = User::where('role', User::ROLE_ADMIN)->count();
            $regularUserCount = User::where('role', User::ROLE_USER)->count();

            $users = User::latest()->paginate(15);

            return view('admin.users.index', compact(
                'users', 'totalUserCount', 'adminCount', 'regularUserCount'
            ));
        } catch (\Exception $e) {
            Log::error('Error in UserController@index: ' . $e->getMessage());
            // Return view with error or abort
            return view('admin.users.index', ['users' => collect(), 'error' => 'Could not fetch user data.'])->withErrors('Failed to load users.');
        }
    }

    /**
     * Show the form for creating a new user.
     */
    public function create(): View
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate($this->validationRules());

        // Prepare data, including hashing password
        $data = $validated;
        $data['password'] = Hash::make($validated['password']);
        $data['email_verified_at'] = now(); // Optional: verify admin-created users

        // Create the user
        User::create($data);

        return redirect()->route('admin.users.index')
                         ->with('status', 'User created successfully!');
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View // Route model binding
    {
        // Ensure view exists: resources/views/admin/users/edit.blade.php
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): RedirectResponse // Route model binding
    {
        // Use validation rules, passing the user ID to ignore self on unique checks
        $validated = $request->validate($this->validationRules($user->id));

        // Prepare data, excluding password if empty
        $data = collect($validated)->except(['password', 'password_confirmation'])->all();

        // If a new password was provided, hash it
        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        // If email changes, mark as unverified
        if ($data['email'] !== $user->email) {
            $data['email_verified_at'] = null;
        }

        // Update user record
        $user->update($data);

        return redirect()->route('admin.users.index')
                         ->with('status', 'User updated successfully!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id() && $user->isAdmin()) { // Be more specific
             return back()->with('error', 'You cannot delete your own administrator account.');
        }

        $fullName = $user->full_name; // Get name before deleting
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('status', "User '{$fullName}' deleted successfully!");
    }

    // --- User Linking Methods ---
    public function showLinkForm(): View
    {
         // Use model constants/methods for role checks
        $users = User::where('role', User::ROLE_USER)
                     ->orderBy('last_name')->orderBy('first_name')
                     ->get(['id', 'first_name', 'last_name', 'username']); // Select only needed columns

        return view('admin.users.link', compact('users'));
    }

    public function storeLink(Request $request): RedirectResponse
    {
        $request->validate([
            'user_id_1' => 'required|exists:users,id',
            'user_id_2' => 'required|exists:users,id|different:user_id_1'
        ]);
        Log::info("Attempting to link User {$request->user_id_1} and User {$request->user_id_2}");
        // --- TODO: Implement User Linking Logic ---
        return redirect()->route('admin.users.link.show')
                         ->with('status', 'User linking function executed (logic pending).');
    }
}