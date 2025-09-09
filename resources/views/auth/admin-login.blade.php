{{-- resources/views/auth/admin-login.blade.php --}}
{{-- This view likely doesn't need the full header/footer layout --}}
{{-- We'll create a minimal structure with the specific background --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - {{ config('app.name', 'Laravel') }}</title>

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Load main CSS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Page-specific styles --}}
    <style>
        body.admin-login-body {
            /* Light blue gradient background */
            background: linear-gradient(to bottom, #e0f2ff, #f8fcff);
            min-height: 100vh;
            display: flex;
            flex-direction: column; /* Allow header and form centering */
            align-items: center; /* Center content horizontally */
            padding-top: 3rem; /* Add space at the top */
        }
        .admin-login-header {
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .admin-login-header img {
             max-height: 40px; /* Adjust logo size */
             margin-bottom: 0.5rem;
        }
         .admin-login-header h1 {
             font-size: 2rem; /* Adjust title size */
             color: var(--primary-color);
             margin: 0;
         }
        /* Container to constrain form width */
        .admin-login-container {
            width: 100%;
            max-width: 450px; /* Adjust max width as needed */
            background-color: var(--white-color, #fff);
            padding: 2rem 2.5rem; /* More padding */
            border-radius: var(--border-radius, 8px);
            box-shadow: var(--box-shadow-medium, 0 6px 20px rgba(0,0,0,0.1));
            border-top: 4px solid var(--primary-color, #005eb8); /* Accent border */
        }

        /* Reuse existing form styles if possible */
        .admin-login-container .form-group label {
             font-weight: 500; /* Slightly less bold */
             font-size: 0.9rem;
             color: var(--dark-color);
             margin-bottom: 0.4rem;
        }
        .admin-login-container .form-group input[type="text"],
        .admin-login-container .form-group input[type="password"] {
             background-color: #f7fafd; /* Light input background */
             border: 1px solid #dce5f0;
             padding: 0.75rem 1rem; /* Adjust padding */
        }
         .admin-login-container .form-group input:focus {
            background-color: #fff;
         }
        .admin-login-container .remember-me {
             margin-top: 1rem;
             margin-bottom: 1.5rem;
        }
         .admin-login-container .remember-me label {
             font-size: 0.9rem;
             color: var(--medium-gray);
         }
         .admin-login-container .login-button { /* Ensure .btn styles apply */
             padding: 0.8rem 1.5rem; /* Adjust button padding */
             font-size: 1rem;
             width: 100%;
         }
         /* Error Box Styling */
         .login-error-box { background-color: #fdf3f2; border: 1px solid #f8d7da; border-left: 4px solid var(--danger-color, #e74c3c); color: #a94442; padding: 15px; margin-bottom: 20px; border-radius: 4px; display: flex; gap: 10px; font-size: 0.9rem; }
         .login-error-box .error-icon { color: var(--danger-color, #e74c3c); font-size: 1.2rem; margin-top: 2px; }
    </style>

</head>
<body class="admin-login-body">

    {{-- Simple Header for Admin Login --}}
    <div class="admin-login-header">
         <a href="/">
             <img src="{{ asset('images/placeholder-logo.png') }}" alt="{{ config('app.name') }} Logo"> {{-- Use your logo --}}
         </a>
        <h1>Admin Login</h1>
    </div>

    {{-- Constrained Login Form Container --}}
    <div class="admin-login-container">

        <!-- Session Status Messages -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Login Errors -->
         @error('login')
            <div class="login-error-box">
               <i class="fas fa-times-circle error-icon"></i>
               <div>
                   <strong>{{ $message }}</strong><br> Please check your admin credentials.
               </div>
            </div>
         @enderror

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf

            <!-- Email or Username -->
            <div class="form-group">
                <label for="login">Email or Username</label>
                <input id="login"
                       class="form-control @error('login') is-invalid @enderror" {{-- Use your styled input class --}}
                       type="text"
                       name="login"
                       value="{{ old('login') }}"
                       required
                       autofocus
                       placeholder="Enter admin email or username"
                       autocomplete="username" />
            </div>

            <!-- Password -->
             <div class="form-group">
                <label for="password">Password</label>
                <input id="password"
                       class="form-control" {{-- Use your styled input class --}}
                       type="password"
                       name="password"
                       required
                       placeholder="Enter admin password"
                       autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block remember-me">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-[var(--primary-color)] shadow-sm focus:ring-[var(--primary-color)]" name="remember">
                    <span class="ml-2 text-sm">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Submit Button -->
            <div class="login-actions">
                <button type="submit" class="btn btn-primary login-button">
                    LOGIN
                </button>
            </div>
        </form>
    </div>

</body>
</html>