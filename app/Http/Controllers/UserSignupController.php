<?php

namespace App\Http\Controllers;

// Required Imports
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session; // <-- Added for Session Flash
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rules;
use App\Providers\RouteServiceProvider;

class UserSignupController extends Controller
{
    /**
     * Display the regular user registration view.
     */
    public function create(): View
    {
        return view('auth.user-signup');
    }

    /**
     * Handle an incoming registration request for regular users.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:100', 'min:7', 'unique:'.User::class, 'regex:/^[a-zA-Z0-9]+$/'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class, 'confirmed'],
            'password' => ['required', 'confirmed', Rules\Password::min(8)],
            'terms' => ['required'], // Use 'required' rule
             // Optional fields
             'phone_number' => ['nullable', 'string', 'max:20'],
             'address' => ['nullable', 'string', 'max:255'],
             'city' => ['nullable', 'string', 'max:100'],
             'state' => ['nullable', 'string', 'max:100'],
             'zip_code' => ['nullable', 'string', 'max:20'],
        ], [
            'username.regex' => 'The username must contain only letters and numbers.',
            'username.min' => 'The username must be at least 7 characters.',
            'username.unique' => 'This username has already been taken.',
            'email.unique' => 'This email address is already registered.',
            'email.confirmed' => 'The email confirmation does not match.',
            'password.confirmed' => 'The password confirmation does not match.',
            'terms.required' => 'You must agree to the Terms of Service to register.',
        ]);

        $nameParts = explode(' ', $request->full_name, 2);
        $firstName = $nameParts[0];
        $lastName = $nameParts[1] ?? '';

        $user = User::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'city' => $request->city,
            'state' => $request->state,
            'zip_code' => $request->zip_code,
            'role' => User::ROLE_USER,
        ]);

        // Dispatch the Registered event (triggers email verification)
        event(new Registered($user));

        // === DO NOT Automatically log the user in ===
        // Auth::login($user); // REMOVED/COMMENTED OUT

        // Store email in session to display on the notice page
        Session::flash('signup_email', $user->email);

        // Redirect back to the signup page view with a status message
        return redirect()->back()->with('status', 'verification-link-sent');

    } // End store method

} // End UserSignupController class