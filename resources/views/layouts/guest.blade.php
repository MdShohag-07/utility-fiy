<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- Use @yield or a variable for title --}}
        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />


        <!-- Scripts and Styles -->
        {{-- Ensure this includes your main CSS and JS for forms/base styles --}}
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @stack('styles')
    </head>
    <body class="font-sans text-gray-900 antialiased">
        {{-- Example wrapper for centering content, adjust classes as needed --}}
        {{-- This matches the structure often used with Breeze starter kit --}}
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div>
                {{-- Optional Logo Link for guest pages --}}
                {{-- If using global $siteLogoUrl, make sure AppServiceProvider shares it --}}
                {{--
                <a href="{{ route('home') }}">
                     <img src="{{ $siteLogoUrl ?? asset('images/placeholder-logo.png') }}" alt="Logo" class="w-20 h-20 text-gray-500">
                </a>
                 --}}
            </div>

            {{-- Card Wrapper - This often contains the actual form content --}}
            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">

                {{-- *** Use @yield to inject content from child views like login.blade.php *** --}}
                @yield('content')

            </div>
        </div>

        @stack('scripts')
    </body>
</html>