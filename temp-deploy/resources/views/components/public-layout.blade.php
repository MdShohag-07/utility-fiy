{{-- resources/views/components/public-layout.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- Keep CSRF token --}}

    <title>{{ $title ?? config('app.name', 'Your Utility Company') }}</title>

    <!-- Google Fonts (Poppins from your index.html) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome for Icons (from your index.html) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Styles & Scripts (Using Vite - ensure your style.css content is in resources/css/app.css) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body> {{-- Removed default body classes if style.css handles base styling --}}

    {{-- Include the Public Header Partial --}}
    @include('partials.public_header')

    <!-- Page Content -->
    <main> {{-- Removed flex-grow, rely on style.css for layout --}}
        {{-- Content from the specific page (e.g., home.blade.php) goes here --}}
        {{ $slot }}
    </main>

    {{-- Include the Public Footer Partial --}}
    @include('partials.public_footer')

    <!-- Basic script for current year (from your index.html) -->
    {{-- Note: More JS needed for mobile nav, sliders etc. should go in resources/js/app.js --}}
    <script>
        // This handles the copyright year, moved from footer partial to layout
        const currentYearSpan = document.getElementById('current-year');
        if(currentYearSpan) {
            currentYearSpan.textContent = new Date().getFullYear();
        }
        // Add other *essential* inline JS here if needed, but prefer app.js
    </script>
</body>
</html>