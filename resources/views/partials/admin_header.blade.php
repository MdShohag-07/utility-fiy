{{-- Paste the inner <header>...</header> block from admin.html main section --}}
<header class="admin-header">
    <h1 id="page-title">{{ $pageTitle ?? 'Admin' }}</h1>
    <div class="admin-user-menu">
         @auth {{-- Show only if logged in --}}
             <i class="fa-solid fa-user-circle"></i>
             <span>{{ Auth::user()->first_name ?? 'Admin' }}</span>
             <i class="fa-solid fa-chevron-down"></i>
             {{-- Dropdown for profile/logout can be added here --}}
         @endauth
    </div>
</header>