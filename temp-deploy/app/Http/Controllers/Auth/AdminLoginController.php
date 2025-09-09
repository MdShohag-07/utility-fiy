<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Providers\RouteServiceProvider; // Ensure RouteServiceProvider is imported

class AdminLoginController extends Controller
{
    /**
     * Display the admin login view.
     *
     * We add a variable 'isAdminLogin' which can optionally be used
     * in the layout or view for specific conditional rendering.
     */
    public function create(): View
    {
        return view('auth.admin-login', ['isAdminLogin' => true]);
    }

    /**
     * Handle an incoming admin authentication request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validate the incoming request data
        $request->validate([
            'login' => ['required', 'string'], // 'login' field accepts email or username
            'password' => ['required', 'string'],
            'remember' => ['boolean'], // Validate remember me checkbox
        ]);

        // 2. Determine if the 'login' input is an email or a username
        $loginField = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 3. Prepare the credentials array for the authentication attempt.
        //    THIS IS THE CRITICAL PART FOR ADMIN-ONLY LOGIN.
        //    We explicitly add 'role' => 'admin' to the credentials.
        //    Auth::attempt will now only succeed if the user provides the correct
        //    email/username, the correct password, AND their 'role' column
        //    in the 'users' table is exactly 'admin'.
        $credentials = [
            $loginField => $request->input('login'),
            'password' => $request->input('password'),
            'role' => 'admin', // <-- Ensures only users with role 'admin' can pass
        ];

        // 4. Attempt to authenticate the user with the provided credentials
        //    The second argument `$request->boolean('remember')` handles the "Remember Me" functionality.
        if (!Auth::attempt($credentials, $request->boolean('remember'))) {
            // If authentication fails (wrong credentials OR user is not an admin),
            // throw a ValidationException. This will redirect back to the login
            // form with an error message associated with the 'login' field.
            // Using a generic 'auth.failed' message is good practice for security
            // as it doesn't reveal whether the username/email was correct but the
            // password/role was wrong.
            throw ValidationException::withMessages([
                'login' => trans('auth.failed'), // Standard Laravel authentication failure message
            ]);
        }

        // 5. If authentication succeeds, regenerate the session ID to prevent session fixation attacks.
        $request->session()->regenerate();

        // 6. Redirect the authenticated admin user to their intended destination.
        //    This defaults to the ADMIN_HOME path ('/admin/dashboard') defined
        //    in RouteServiceProvider. If the user was trying to access a specific
        //    admin page before being redirected to login, intended() will send them there.
        return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
    }
}