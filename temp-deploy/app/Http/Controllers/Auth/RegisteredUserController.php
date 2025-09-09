<?php

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

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        // WARNING: This view likely still uses 'name' field by default from Breeze.
        // You need to update resources/views/auth/register.blade.php
        // to use 'first_name' and 'last_name' inputs if using this route.
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request (intended for Admins via /register).
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
             // Add username validation if you added the field to auth.register view
             // 'username' => ['required', 'string', 'max:100', 'min:7', 'unique:'.User::class, 'regex:/^[a-zA-Z0-9]+$/'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
           
            
            'role' => User::ROLE_ADMIN, // Assign 'admin' role
             // Assign default username or get from request if added to form
            'username' => $request->username ?? $request->email, // Example default
            // Set optional fields to null
            'phone_number' => null, 'address' => null, 'city' => null, 'state' => null, 'zip_code' => null,
        ]);

        event(new Registered($user));
        
         $password= Hash::make($request->password) ;
        dd(Hash::make($request->password));
        Log::debug($password);

         
        Auth::login($user);

        // Redirect admins to the admin dashboard
        return redirect(RouteServiceProvider::HOME);
    }
}