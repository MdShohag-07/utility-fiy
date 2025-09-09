<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Add CSRF Token - important for forms and JS requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $pageTitle ?? config('app.name', 'Laravel') }}</title>

    {{-- Google Fonts & Font Awesome can stay as external links --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- === CORRECT ASSET LOADING using Vite === --}}
    {{-- Remove the old asset() link for style.css --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/style.css') }}"> --}}

    {{-- Use the @vite directive to include both CSS and JS entry points --}}
    {{-- This tells Vite to load resources/css/app.css and resources/js/app.js --}}
    {{-- Make SURE your custom styles are placed INSIDE resources/css/app.css --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- === END CORRECTION === --}}

    {{-- Stack for page-specific styles --}}
    @stack('styles')
</head>
<body>

    {{-- Include the PUBLIC header partial --}}
    @include('partials.public_header')

    <main>
        {{-- Main content area for child views --}}
        @yield('content')
    </main>

    {{-- Include the PUBLIC footer partial --}}
    @include('partials.public_footer')

    {{-- Stack for page-specific scripts --}}
    @stack('scripts')

    {{-- NOTE: @vite includes app.js, so no separate <script> tag for it needed here --}}
</body>
</html>