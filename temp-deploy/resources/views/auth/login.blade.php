{{-- resources/views/auth/login.blade.php --}}

{{-- *** CHANGE THIS: Extend the main app layout *** --}}
@extends('layouts.app')

@section('title', 'Sign In') {{-- Set the page title --}}

@section('content')
    {{-- Add a container for centering and padding the login card on the page --}}
    <div class="login-page-container container mx-auto flex justify-center items-center py-12 md:py-20 min-h-[calc(100vh-250px)]"> {{-- Adjust min-height based on header/footer --}}

         {{-- Login Card --}}
         {{-- Increased max-width using Tailwind class max-w-lg --}}
         {{-- Adjust 'max-w-lg' to 'max-w-xl' or 'max-w-2xl' if you want it wider --}}
         <div class="login-card w-full max-w-lg bg-white p-8 md:p-10 rounded-lg shadow-md border border-gray-200">

            <h1 class="login-title text-3xl font-bold text-gray-800 mb-4 text-center">
                Sign In to Get Started
            </h1>

            {{-- Separator --}}
            <div class="separator flex items-center my-6">
                <hr class="flex-grow border-gray-300">
                <span class="mx-4 text-gray-500 text-sm font-medium">or</span>
                <hr class="flex-grow border-gray-300">
            </div>

            {{-- Create Username Link --}}
            <div class="text-center mb-6">
                {{-- Ensure route 'signup' exists --}}
                <a href="{{ route('signup') }}" class="text-blue-600 hover:underline font-medium">
                    Create a Username
                </a>
            </div>

            {{-- Session Status (Displays messages like password reset link sent) --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Username/Email -->
                {{-- Using 'login' as name to potentially accept username or email --}}
                <div class="form-group mb-4">
                    <label for="login" class="form-label flex justify-between items-center">
                        <span>Username</span>
                        <button type="button" class="help-icon text-gray-500 hover:text-blue-600 text-xs" aria-label="Username help"> <i class="fas fa-question-circle"></i> </button>
                    </label>
                    <input id="login" class="form-control @error('login') input-error @enderror @error('email') input-error @enderror" type="text" name="login" value="{{ old('login') }}" required autofocus autocomplete="username" />
                    {{-- Show validation errors for either 'login' or 'email' field if backend checks both --}}
                    @error('login') <span class="error-message">{{ $message }}</span> @enderror
                    @error('email') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Password -->
                <div class="form-group mb-4">
                    <label for="password" class="form-label"> Password </label>
                    <div class="password-wrapper relative">
                        <input id="password" class="form-control @error('password') input-error @enderror pr-10" type="password" name="password" required autocomplete="current-password" />
                        <button type="button" class="toggle-password absolute top-0 right-0 h-full px-3 text-gray-500 hover:text-blue-600" aria-label="Show password"> <i class="fas fa-eye"></i> </button>
                    </div>
                     @error('password') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-group mb-6 flex items-center justify-between">
                     <label for="remember_me" class="inline-flex items-center text-sm">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 mr-2" name="remember">
                        <span class="text-gray-700">Stay Signed In on This Device</span>
                    </label>
                    <button type="button" class="help-icon text-gray-500 hover:text-blue-600 text-xs" aria-label="Stay signed in help"> <i class="fas fa-question-circle"></i> </button>
                </div>

                <!-- Sign In Button -->
                <div class="form-group mb-6">
                    <button type="submit" class="btn btn-primary w-full justify-center py-3"> Sign In </button>
                </div>

                <!-- Forgot Links -->
                <div class="text-center">
                    {{-- Ensure routes 'forgot.username' and 'password.request' exist --}}
                    <a class="text-sm text-blue-600 hover:underline rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                       href="{{ route('forgot.username') }}?or={{ route('password.request') }}"> {{-- Consider separate links if needed --}}
                        Forgot Username or Password?
                    </a>
                </div>
            </form>
        </div> {{-- End Login Card --}}
    </div> {{-- End Container --}}
@endsection

{{-- No specific styles needed here if app.css handles .login-card etc. --}}
@push('styles')
<style>
    /* Minimal overrides if needed, but prefer app.css */
    /* Example: body { background-color: #f0f4f8; } */
</style>
@endpush

@push('scripts')
<script>
    // Password toggle JS (keep if not already in app.js)
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const passwordInput = this.previousElementSibling;
            const icon = this.querySelector('i');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });
</script>
@endpush