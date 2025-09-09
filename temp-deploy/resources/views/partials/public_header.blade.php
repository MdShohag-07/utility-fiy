{{-- resources/views/partials/public_header.blade.php --}}

<header class="spectrum-header">
    <div class="header-container container mx-auto">
        <div class="header-logo">
            {{-- MODIFIED: Conditional logo link --}}
            @auth
                {{-- If user is authenticated, link logo to their dashboard --}}
                <a href="{{ route('my-account.index')  }}">
                    <img src="{{ $siteLogoUrl ?? asset('images/spectrum-logo-placeholder.svg') }}" alt="{{ config('app.name', 'Logo') }} - My Account">
                </a>
            @else
                {{-- If user is a guest, link logo to the public homepage --}}
                <a href="{{ route('home') }}">
                    <img src="{{ $siteLogoUrl ?? asset('images/spectrum-logo-placeholder.svg') }}" alt="{{ config('app.name', 'Logo') }}">
                </a>
            @endauth
        </div>
        <div class="header-right-actions">
            <nav class="utility-nav">
                <ul>
                     @forelse($secondaryMenuItems ?? [] as $item)
                        <li><a href="{{ $item->url }}" target="{{ $item->target ?? '_self' }}">{{ $item->title }}</a></li>
                     @empty
                        {{-- Provide fallback or remove if an empty list is acceptable --}}
                        {{-- <li><a href="#">Placeholder Link</a></li> --}}
                     @endforelse
                </ul>
            </nav>
            <div class="main-actions">
                <button class="action-button search-button" aria-label="Search"> <i class="fas fa-search"></i> </button>
                <div class="language-switcher-container"> <button class="action-button language-button">English <i class="fas fa-chevron-down text-xs"></i></button> </div>
                @auth
                    <div class="relative">
                        {{-- Ensure your Dropdown component and its slots are correctly implemented --}}
                        {{-- The x-slot name="content" was /* ... Dropdown Links ... */, you'll need actual links --}}
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="action-button user-button" aria-label="User Menu">
                                    <i class="fas fa-user-circle"></i>
                                    {{-- Optionally display user's name or initial --}}
                                    {{-- <span class="ml-2 hidden md:inline">{{ Auth::user()->first_name ?? Auth::user()->username }}</span> --}}
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                {{-- Common Dropdown Links for Authenticated Users --}}
                                <x-dropdown-link :href="route('my-account.index')">
                                    {{ __('My Account') }}
                                </x-dropdown-link>

                                <x-dropdown-link :href="route('my-account.profile.edit')"> {{-- Assuming profile.edit is within my-account group --}}
                                    {{ __('Profile Settings') }}
                                </x-dropdown-link>

                                @if(Auth::user()->isAdmin())
                                    <div class="border-t border-gray-200 dark:border-gray-600"></div>
                                    <x-dropdown-link :href="route('admin.dashboard')">
                                        {{ __('Admin Panel') }}
                                    </x-dropdown-link>
                                @endif

                                <div class="border-t border-gray-200 dark:border-gray-600"></div>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                @else
                    {{-- Links for Guest Users --}}
                    <a href="{{ route('login') }}" class="action-button">Log In</a>
                    @if (Route::has('signup')) {{-- Or your 'register' route --}}
                        <a href="{{ route('signup') }}" class="action-button btn btn-primary ml-2">Sign Up</a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</header>