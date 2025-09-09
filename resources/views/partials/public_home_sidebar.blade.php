{{-- resources/views/partials/public_home_sidebar.blade.php --}}
{{-- Sidebar specifically for the public homepage, using $headerMenuItems --}}
<aside class="dashboard-sidebar public-sidebar hidden md:block">
    <nav>
        <ul>
            {{-- Dynamic Header Menu Items (Main Nav from 'header' location) --}}
            @forelse ($headerMenuItems ?? [] as $item)
                @php
                    $itemUrlPath = ltrim(parse_url($item->url, PHP_URL_PATH) ?? '/', '/');
                    $currentPath = request()->path() === '/' ? '' : ltrim(request()->path(), '/');
                    $isActive = false;
                    if ($itemUrlPath === '' && $currentPath === '') { $isActive = true; }
                    elseif ($itemUrlPath !== '' && str_starts_with($currentPath, $itemUrlPath)) { $isActive = true; }
                    if(isset($active) && $active === Str::slug(strtolower($item->title))) { $isActive = true; }
                @endphp
                <li>
                    <a href="{{ $item->url }}" target="{{ $item->target ?? '_self' }}" class="{{ $isActive ? 'active' : '' }}">
                        <i class="{{ $item->icon ?? 'fas fa-angle-right' }} fa-fw sidebar-icon"></i>
                        <span class="sidebar-text">{{ $item->title }}</span>
                    </a>
                </li>
            @empty
                <li>
                    <a>
                        <i class="fas fa-exclamation-circle fa-fw sidebar-icon"></i>
                        <span class="sidebar-text">No Menu Items Configured</span>
                    </a>
                </li>
            @endforelse
            {{-- End Dynamic Menu Items --}}


            {{-- *** REMOVED STATIC LINKS AND DIVIDER *** --}}
            {{-- <hr class="sidebar-divider"> --}}
            {{-- <li> <a href="#"><i class="fas fa-headset fa-fw sidebar-icon"></i><span class="sidebar-text">Support</span></a> </li> --}}
            {{-- <li> <a href="#"><i class="fas fa-ellipsis-h fa-fw sidebar-icon"></i><span class="sidebar-text">More</span></a> </li> --}}
            {{-- <li> <a href="#"><i class="fas fa-comments fa-fw sidebar-icon"></i><span class="sidebar-text">Chat With Us</span></a> </li> --}}
             {{-- *** END REMOVED STATIC LINKS *** --}}

             {{-- Keep Logout if it's meant to be here for logged-in users viewing public homepage --}}
             {{-- If homepage is only for guests, remove this @auth block --}}
            @auth
                 <li class="mt-auto pt-4 border-t border-gray-700">
                     <a href="#logout"
                        onclick="event.preventDefault(); if(confirm('Are you sure you want to log out?')) { document.getElementById('public_sidebar_logout_form').submit(); }"> {{-- Unique ID --}}
                         <i class="fa-solid fa-arrow-right-from-bracket fa-fw sidebar-icon"></i>
                         <span class="sidebar-text">Logout</span>
                     </a>
                     <form id="public_sidebar_logout_form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                 </li>
            @endauth
        </ul>
    </nav>
</aside>