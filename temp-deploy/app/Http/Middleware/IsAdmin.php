<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Import User model

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            // If not authenticated and trying to access an admin route (that isn't the login page itself)
            // redirect to the admin login page.
            // This part is crucial if this middleware is somehow hit before full authentication for an admin area.
            return redirect()->route('admin.login'); // Assuming you have an 'admin.login' named route
        }

        $user = Auth::user();

        // Ensure the user object is an instance of your User model and then call isAdmin()
        if ($user instanceof User && $user->isAdmin()) { // <--- Uses the isAdmin() method
            return $next($request);
        }

        // If not an admin, redirect.
        // You could also check if the user is trying to access the admin login page
        // while already logged in as a non-admin, and handle that specifically.
        return redirect()->route('my-account.dashboard') // Redirect to user dashboard
                         ->with('error', 'You do not have permission to access the admin area.');
        // Or abort:
        // abort(403, 'Unauthorized action. Administrator access required.');
    }
}