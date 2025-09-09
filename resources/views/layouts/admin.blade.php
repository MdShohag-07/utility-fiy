{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>

    {{-- Fonts & Icons --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Load ADMIN CSS/JS via Vite --}}
    {{-- Ensure vite.config.js includes 'resources/css/admin.css' as an input --}}
    {{-- Ensure resources/js/app.js is also included (needed for Alpine.js if used in admin) --}}
    @vite(['resources/css/admin.css', 'resources/js/app.js'])

    {{-- Stack for page-specific styles --}}
    @stack('styles')

</head>
<body class="admin-body"> {{-- Class to scope admin styles if needed --}}

    {{-- Main Layout Wrapper --}}
    <div class="admin-layout-wrapper"> {{-- Style this with Flexbox in admin.css --}}

        {{-- === Include the Admin Sidebar === --}}
        {{-- The sidebar partial itself will use $siteLogoUrl --}}
        @include('partials.admin_sidebar')

        {{-- Main Content Area --}}
        <div class="admin-main-content"> {{-- Style this with flex-grow in admin.css --}}

            {{-- Top Bar --}}
            <header class="admin-top-bar"> {{-- Style this in admin.css --}}
                 <div class="page-title">@yield('title', 'Dashboard')</div>
                 <div class="admin-user-menu">
                     {{-- Display Admin Name & Logout --}}
                     <span>Admin: {{ Auth::user()?->first_name ?? Auth::user()?->name ?? 'User' }}</span>
                     <a href="#" onclick="event.preventDefault(); document.getElementById('admin-logout-form-top').submit();" class="admin-logout-link">Logout</a>
                     <form id="admin-logout-form-top" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                 </div>
            </header>

            {{-- Page Specific Content --}}
            <main class="admin-page-content"> {{-- Style this in admin.css --}}
                {{-- Content from child views gets injected here --}}
                @yield('content')
            </main>

        </div> {{-- End Main Content Area --}}

    </div> {{-- End Layout Wrapper --}}

    {{-- Stack for page-specific scripts --}}
    @stack('scripts')
</body>
</html>