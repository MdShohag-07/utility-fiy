<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class, // Uncomment if needed
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class, // Handles Cross-Origin Resource Sharing
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class, // Often included with Breeze/Jetstream, uncomment if needed
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            // \App\Http\Middleware\SetLocale::class, // Example: If you add multi-language support
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, // Uncomment if using Sanctum SPA auth
            'throttle:api', // Default API throttling
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used instead of class names to conveniently assign middleware
     * to routes and groups. Keyed by the alias name.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class, // Good to have aliased
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class, // For sensitive actions
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class, // For Livewire/Inertia interaction
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class, // Used for email verification links
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, // Breeze uses this

        // **** Your Custom Middleware Alias ****
        'is.admin' => \App\Http\Middleware\IsAdmin::class,
    ];

     /**
      * The priority-sorted list of middleware.
      *
      * This forces non-global middleware to always be in the given order.
      * Usually, you don't need to change this unless you have specific ordering needs
      * between middleware that aren't handled by groups.
      *
      * @var string[]
      */
     protected $middlewarePriority = [
         \Illuminate\Cookie\Middleware\EncryptCookies::class,
         \Illuminate\Session\Middleware\StartSession::class,
         \Illuminate\View\Middleware\ShareErrorsFromSession::class,
         \App\Http\Middleware\Authenticate::class,
         \Illuminate\Session\Middleware\AuthenticateSession::class,
         \Illuminate\Routing\Middleware\SubstituteBindings::class,
         \Illuminate\Auth\Middleware\Authorize::class,
     ];
}