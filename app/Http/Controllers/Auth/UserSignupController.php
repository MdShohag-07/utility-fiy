<?php

// ***** CORRECT NAMESPACE *****
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password; // Use the Password rule object

// ***** CORRECT CLASS NAME *****
class UserSignupController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // Pass any necessary data to the view
        return view('auth.user-signup'); // Ensure this view exists (resources/views/auth/signup.blade.php)
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            // Use 'full_name' based on your form
            'full_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class, 'confirmed'], // Added 'confirmed'
            'password' => ['required', 'confirmed', Password::defaults()], // Use Password rule & 'confirmed'
            'terms' => ['accepted'], // Add validation for terms
        ]);

        $user = User::create([
            'name' => $request->full_name, // Map full_name to name column
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Assign 'user' role specifically
        ]);

        event(new Registered($user));
        
        $password= Hash::make($request->password) ;
        dd(Hash::make($request->password));
        Log::debug($password);

        // No automatic login after signup for email verification flow
        // Auth::login($user);

        // Redirect back with success message and email for display
        // Or redirect to login page with a message
        return redirect()->route('signup') // Redirect back to the signup page
                         ->with('status', 'verification-link-sent')
                         ->with('signup_email', $request->email);

        // Alternative: Redirect to login page
        // return redirect()->route('login')->with('status', 'Registration successful! Please check your email to verify your account.');

        // Original Breeze Redirect (if auto-login was enabled):
        // return redirect(RouteServiceProvider::HOME);
    }
}