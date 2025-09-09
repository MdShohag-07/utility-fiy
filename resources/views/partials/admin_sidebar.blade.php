{{-- resources/views/partials/admin_sidebar.blade.php --}}
<aside class="admin-sidebar">
    <div class="sidebar-header">
        {{-- Use the $siteLogoUrl variable provided by AppServiceProvider --}}
        {{-- Provides fallback to a placeholder if logo isn't set/found --}}
        <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-center py-4"> {{-- Added flex classes for centering --}}
            <img src="{{ $siteLogoUrl ?? asset('images/admin-logo-placeholder.png') }}"
                 alt="{{ config('app.name', 'Utility Site') }} Admin Logo"
                 class="admin-logo h-10 w-auto"> {{-- Adjust classes as needed --}}
        </a>
        {{-- <span class="admin-title">{{ config('app.name', 'Utility Site') }}</span> --}}
    </div>
    <nav class="sidebar-nav">
        <ul>
            {{-- Dashboard --}}
            <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa-solid fa-gauge-high fa-fw sidebar-icon"></i>
                    <span class="sidebar-text">Dashboard</span>
                </a>
            </li>

            {{-- User Management --}}
            <li class="{{ request()->routeIs('admin.users.*') && !request()->routeIs('admin.users.link.*') ? 'active' : '' }}"> {{-- More specific active check --}}
                <a href="{{ route('admin.users.index') }}">
                    <i class="fa-solid fa-users-cog fa-fw sidebar-icon"></i>
                    <span class="sidebar-text">User Manager</span>
                </a>
            </li>

            {{-- Content Management Heading --}}
            <li class="sidebar-heading"><span>Content Management</span></li>

            {{-- Homepage Link --}}
             <li class="{{ request()->routeIs('admin.pages.homepage.*') ? 'active' : '' }}">
                  <a href="{{ route('admin.pages.homepage.edit') }}">
                      <i class="fas fa-home fa-fw sidebar-icon"></i>
                      <span class="sidebar-text">Homepage</span>
                  </a>
             </li>

             {{-- Statements Link --}}
            <li class="{{ request()->routeIs('admin.statements.*') ? 'active' : '' }}">
                <a href="{{ route('admin.statements.index') }}">
                    <i class="fa-solid fa-file-lines fa-fw sidebar-icon"></i>
                    <span class="sidebar-text">Statements</span>
                </a>
            </li>

            {{-- *** ADDED: PDF Editor / Content Settings Link *** --}}
            {{-- Assuming you named the route 'admin.settings.pdf.edit' --}}
            <li class="{{ request()->routeIs('admin.settings.pdf.*') ? 'active' : '' }}">
                <a href="{{ route('admin.settings.pdf.edit') }}">
                    <i class="fas fa-file-invoice fa-fw sidebar-icon"></i> {{-- Example icon (same as Statements for now) --}}
                    <span class="sidebar-text">PDF Content</span>
                </a>
            </li>
            {{-- *** END ADDED LINK *** --}}

             {{-- Billing Link --}}
             <li class="{{ request()->routeIs('admin.billing.*') ? 'active' : '' }}">
                <a href="{{ route('admin.billing.index') }}">
                    <i class="fa-solid fa-file-invoice-dollar fa-fw sidebar-icon"></i>
                    <span class="sidebar-text">Billing Manager</span>
                </a>
            </li>

            {{-- Menu Manager Link --}}
             <li class="{{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">
                <a href="{{ route('admin.menus.index') }}">
                    <i class="fa-solid fa-bars fa-fw sidebar-icon"></i>
                    <span class="sidebar-text">Menu Manager</span>
                </a>
            </li>

            {{-- Footer Info Link --}}
              <li class="{{ request()->routeIs('admin.footer.*') ? 'active' : '' }}">
                  <a href="{{ route('admin.footer.edit') }}">
                      <i class="fa-solid fa-shoe-prints fa-fw sidebar-icon"></i>
                      <span class="sidebar-text">Footer Info</span>
                  </a>
              </li>

            {{-- Configuration Heading --}}
             <li class="sidebar-heading"><span>Configuration</span></li>

            {{-- General Settings Link --}}
             <li class="{{ request()->routeIs('admin.settings.general.*') ? 'active' : '' }}">
                 <a href="{{ route('admin.settings.general.edit') }}">
                    <i class="fas fa-cog fa-fw sidebar-icon"></i>
                    <span class="sidebar-text">General Settings</span>
                </a>
             </li>

             {{-- Link Users Page --}}
             <li class="{{ request()->routeIs('admin.users.link.*') ? 'active' : '' }}">
                  <a href="{{ route('admin.users.link.show') }}">
                      <i class="fas fa-link fa-fw sidebar-icon"></i>
                      <span class="sidebar-text">Link Users</span>
                  </a>
             </li>

             {{-- Logout Link --}}
             <li class="mt-auto pt-4 border-t border-gray-700">
                 <a href="#logout"
                    onclick="event.preventDefault(); if(confirm('Are you sure you want to log out?')) { document.getElementById('admin-logout-form-sidebar').submit(); }">
                     <i class="fa-solid fa-arrow-right-from-bracket fa-fw sidebar-icon"></i>
                     <span class="sidebar-text">Logout</span>
                 </a>
                 <form id="admin-logout-form-sidebar" action="{{ route('logout') }}" method="POST" style="display: none;">
                     @csrf
                 </form>
             </li>
        </ul>
    </nav>
</aside>