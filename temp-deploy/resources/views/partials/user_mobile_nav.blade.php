{{-- resources/views/partials/user_mobile_nav.blade.php --}}
<nav class="mobile-bottom-nav md:hidden">
     <a href="{{ route('my-account.index') }}" class="mobile-nav-item {{ ($active ?? '') === 'home' ? 'active' : '' }}"> <i class="fas fa-home"></i> <span>Home</span> </a>
      <a href="{{ route('my-account.billing.index') }}" class="mobile-nav-item {{ ($active ?? '') === 'billing' ? 'active' : '' }}"> <i class="fas fa-file-invoice-dollar"></i> <span>Billing</span> </a>
      {{-- Updated Services Link --}}
      <a href="{{ route('my-account.services.index') }}" class="mobile-nav-item {{ ($active ?? '') === 'services' ? 'active' : '' }}"> <i class="fas fa-concierge-bell"></i> <span>Services</span> </a>
      <a href="#" class="mobile-nav-item {{ ($active ?? '') === 'upgrade' ? 'active' : '' }}"> <i class="fas fa-shopping-cart"></i> <span>Upgrade</span> </a>
     <a href="#" class="mobile-nav-item {{ ($active ?? '') === 'support' ? 'active' : '' }}"> <i class="fas fa-headset"></i> <span>Support</span> </a>
      <a href="#" class="mobile-nav-item {{ ($active ?? '') === 'more' ? 'active' : '' }}"> <i class="fas fa-ellipsis-h"></i> <span>More</span> </a>
</nav>