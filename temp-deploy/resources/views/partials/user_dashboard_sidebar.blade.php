{{-- resources/views/partials/user_dashboard_sidebar.blade.php --}}
{{-- Sidebar for the logged-in /my-account area --}}
<aside class="dashboard-sidebar hidden md:block">
    <nav>
        <ul>
            {{-- Links specific to the User Dashboard --}}
            <li> <a href="{{ route('my-account.index') }}" class="{{ ($active ?? '') === 'home' || ($active ?? '') === 'dashboard' ? 'active' : '' }}"> <i class="fas fa-home fa-fw sidebar-icon"></i><span class="sidebar-text">Dashboard</span></a> </li>
            <li> <a href="{{ route('my-account.billing.index') }}" class="{{ ($active ?? '') === 'billing' ? 'active' : '' }}"> <i class="fas fa-file-invoice-dollar fa-fw sidebar-icon"></i><span class="sidebar-text">Billing</span></a> </li>
            <li> <a href="{{ route('my-account.services.index') }}" class="{{ ($active ?? '') === 'services' ? 'active' : '' }}"> <i class="fas fa-concierge-bell fa-fw sidebar-icon"></i><span class="sidebar-text">Services</span></a> </li>
            <li> <a href="#" class="{{ ($active ?? '') === 'upgrade' ? 'active' : '' }}"> <i class="fas fa-shopping-cart fa-fw sidebar-icon"></i><span class="sidebar-text">Upgrade</span></a> </li>
            <li> <a href="#" class="{{ ($active ?? '') === 'support' ? 'active' : '' }}"> <i class="fas fa-headset fa-fw sidebar-icon"></i><span class="sidebar-text">Support</span></a> </li>
            <li> <a href="#" class="{{ ($active ?? '') === 'more' ? 'active' : '' }}"> <i class="fas fa-ellipsis-h fa-fw sidebar-icon"></i><span class="sidebar-text">More</span></a> </li>

            <hr class="sidebar-divider">

            <li> <a href="#"><i class="fas fa-comments fa-fw sidebar-icon"></i><span class="sidebar-text">Chat With Us</span></a> </li>
            {{-- === THIS LINK MUST BE UPDATED === --}}
            <li>
                <a href="{{ route('my-account.profile.edit') }}" class="{{ request()->routeIs('my-account.profile.edit') || request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <i class="fas fa-user-cog fa-fw sidebar-icon"></i><span class="sidebar-text">Edit Profile</span>
                </a>
            </li>
            {{-- === END OF UPDATED LINK === --}}

             {{-- Logout Link --}}
             <li class="mt-auto pt-4 border-t border-gray-700">
                 <a href="#logout"
                    onclick="event.preventDefault(); if(confirm('Are you sure?')) { document.getElementById('dashboard-logout-form').submit(); }">
                     <i class="fa-solid fa-arrow-right-from-bracket fa-fw sidebar-icon"></i>
                     <span class="sidebar-text">Logout</span>
                 </a>
                 <form id="dashboard-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
             </li>
        </ul>
    </nav>
</aside>