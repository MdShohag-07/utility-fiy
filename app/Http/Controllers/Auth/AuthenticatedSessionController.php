<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
// Remove RouteServiceProvider if not using its constants directly for redirect paths here
// use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User; // Ensure User model is imported

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login'); // Or your custom login view path
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate(); // Validates credentials & attempts login

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user instanceof User && $user->isAdmin()) {
            // Admin users go to the admin dashboard
            return redirect()->intended(route('admin.dashboard')); // Explicit named route
        } else {
            // Regular users go to THEIR account dashboard
            return redirect()->intended(route('my-account.index')); // Explicit named route
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/'); // Redirect to public homepage after logout
    }
}