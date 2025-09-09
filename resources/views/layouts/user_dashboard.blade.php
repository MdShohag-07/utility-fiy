{{-- resources/views/user-dashboard.blade.php --}}
@extends('layouts.app') {{-- Uses the public layout with header/footer --}}

@section('title', 'My Account')

{{-- Remove default container padding if layout adds it, or manage here --}}
@section('content')
<div class="user-dashboard-layout">

    {{-- === Desktop Sidebar (Hidden on Mobile) === --}}
    {{-- === Desktop Sidebar === --}}
    @include('partials.user_dashboard_sidebar', ['active' => 'home']) {{-- Mark 'home' active --}}

    {{-- === Main Content Area === --}}
    <main class="dashboard-main-content">

        {{-- Top Icon Grid --}}
        <section class="icon-grid mb-6 md:mb-8">
             {{-- Replace # with actual routes when available --}}
             <a href="#" class="icon-grid-item">
                 <i class="fas fa-file-alt"></i>
                 <span>View My Plan</span>
             </a>
             <a href="#" class="icon-grid-item">
                 <i class="fas fa-star"></i>
                 <span>Upgrade My Plan</span>
             </a>
              <a href="#" class="icon-grid-item">
                 <i class="fas fa-wifi"></i>
                 <span>Manage Internet/WiFi</span>
             </a>
             <a href="#" class="icon-grid-item">
                 <i class="fas fa-plus-circle"></i>
                 <span>Add Mobile</span>
             </a>
              <a href="#" class="icon-grid-item">
                 <i class="fas fa-tv"></i>
                 <span>Manage TV/Streaming</span>
             </a>
             <a href="#" class="icon-grid-item">
                 <i class="fas fa-credit-card"></i>
                 <span>Manage Payment Methods</span>
             </a>
        </section>

        {{-- Recommended Offer Banner --}}
        <section class="offer-banner mb-6 md:mb-8">
            <div class="offer-badge">Your Recommended Offer</div>
            <div class="offer-content">
                <div class="offer-image">
                    {{-- Replace with dynamic image later if needed --}}
                    <img src="https://www.spectrum.com/content/dam/spectrum/residential/mobile/images/dt_sav_ban_mob_bau_df_1_ine_free.png" alt="Mobile Offer">
                </div>
                <div class="offer-text">
                    <h3>Mobile Savings You'll Love</h3>
                    <p>Save $360 by getting 1 year of Unlimited Mobile with unlimited talk, text and data, plus nationwide 5G – included with Spectrum Internet.</p>
                    {{-- Replace # with actual route --}}
                    <a href="#" class="btn btn-primary btn-sm">Shop Mobile</a>
                    <a href="#" class="offer-details-link">See offer details</a>
                </div>
            </div>
        </section>

         {{-- Billing/Statement Action (Example - Adapt as needed) --}}
         <section class="widget-card dashboard-card mb-6 md:mb-8"> {{-- Reuse widget-card style --}}
             <div class="widget-header">
                 <h2 class="widget-title">Billing Quick View</h2>
             </div>
             <div class="widget-content">
                 <p>Your next payment is due soon.</p>
                 {{-- Add button to trigger PDF modal --}}
                 <button id="view-statement-button" class="btn btn-secondary mr-2">View Statement PDF</button>
                 <a href="#" class="btn btn-outline-primary">Make a Payment</a>
             </div>
         </section>


        {{-- Content Cards Section (Placeholders) --}}
        <section class="content-cards mb-6 md:mb-8">
             <h2 class="section-title">Keep Moving with {{ config('app.name', 'Utility Site') }}</h2>
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                 <div class="content-card-item">
                     {{-- Replace with dynamic content/image --}}
                     <img src="https://via.placeholder.com/600x350/005eb8/ffffff?text=Content+Card+1" alt="Placeholder 1">
                     <div class="card-item-body">
                         <h4>Headline for Card 1</h4>
                         <p>Description text for the first content card goes here.</p>
                         <a href="#" class="card-item-link">Learn More →</a>
                     </div>
                 </div>
                  <div class="content-card-item">
                      {{-- Replace with dynamic content/image --}}
                     <img src="https://via.placeholder.com/600x350/8dc63f/ffffff?text=Content+Card+2" alt="Placeholder 2">
                     <div class="card-item-body">
                         <h4>Headline for Card 2</h4>
                         <p>Description text for the second content card goes here.</p>
                          <a href="#" class="card-item-link">Learn More →</a>
                     </div>
                 </div>
             </div>
        </section>

    </main>

   {{-- === Mobile Bottom Navigation === --}}
    @include('partials.user_mobile_nav', ['active' => 'home']) {{-- Mark 'home' active --}}

    {{-- PDF Statement Modal (HTML remains the same) --}}
    <div id="pdf-modal-overlay" class="pdf-modal-overlay hidden">
       <div id="pdf-modal-content" class="pdf-modal-content">
           <button id="close-modal-button" class="pdf-modal-close-button">×</button>
           <h2 class="text-xl font-semibold mb-4">Billing Statement</h2>
           <p class="mb-6">View your latest billing statement in PDF format.</p>
           <div class="text-center">
               <a href="{{ route('my-account.statement') }}" target="_blank" class="btn btn-primary">
                   View PDF Statement
               </a>
           </div>
       </div>
    </div>

</div> {{-- End of .user-dashboard-layout --}}
@endsection

@push('styles')
<style>
    /* ================== User Dashboard/Billing Layout ================== */
    .user-dashboard-layout { display: flex; flex-wrap: nowrap; width: 100%; max-width: var(--container-max-width, 1250px); margin-left: auto; margin-right: auto; padding: 1rem 0; background-color: var(--white-color); min-height: calc(100vh - 140px); }
    .dashboard-sidebar { width: 240px; flex-shrink: 0; padding: 1.5rem 1rem; background-color: #f8f9fa; border-right: 1px solid var(--border-color, #e5e7eb); overflow-y: auto; }
    .dashboard-sidebar nav ul { list-style: none; padding: 0; margin: 0; }
    .dashboard-sidebar nav ul li a { display: flex; align-items: center; padding: 0.7rem 0.75rem; margin-bottom: 0.25rem; font-size: 0.95rem; font-weight: 500; color: var(--dark-color); border-radius: 6px; text-decoration: none; transition: background-color 0.2s ease, color 0.2s ease; }
    .dashboard-sidebar nav ul li a i { width: 25px; margin-right: 10px; text-align: center; color: var(--medium-gray); font-size: 1.1rem; }
    .dashboard-sidebar nav ul li a:hover { background-color: #e9ecef; color: var(--primary-color); }
    .dashboard-sidebar nav ul li a.active { background-color: var(--white-color); color: var(--primary-color); font-weight: 600; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #eee; }
    .dashboard-sidebar nav ul li a.active i { color: var(--primary-color); }
    .sidebar-divider { height: 1px; background-color: var(--border-color, #e5e7eb); margin: 1rem 0.5rem; }
    .dashboard-main-content { flex-grow: 1; padding: 1.5rem; background-color: var(--white-color); min-width: 0; }
    @media (min-width: 768px) { .dashboard-main-content { padding: 2rem; } }
    @media (max-width: 767px) { .dashboard-sidebar.hidden.md\:block { display: none; } .user-dashboard-layout { padding: 0; display: block; } .dashboard-main-content { width: 100%; padding: 1rem; padding-bottom: 70px; } }

    /* ================== Icon Grid ================== */
    .icon-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
    @media (min-width: 640px) { .icon-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (min-width: 1024px) { .icon-grid { grid-template-columns: repeat(6, 1fr); } }
    .icon-grid-item { background-color: var(--white-color); border: 1px solid var(--border-color, #eee); border-radius: var(--border-radius, 8px); padding: 1.25rem 1rem; text-align: center; transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease; text-decoration: none; color: var(--dark-color); box-shadow: var(--box-shadow-light); }
    .icon-grid-item:hover { transform: translateY(-3px); box-shadow: var(--box-shadow-medium); border-color: var(--primary-color); color: var(--primary-color); }
    .icon-grid-item i { font-size: 1.75rem; color: var(--primary-color); margin-bottom: 0.75rem; display: block; }
    .icon-grid-item span { font-size: 0.9rem; font-weight: 500; line-height: 1.3; display: block; }

    /* ================== Offer Banner ================== */
    .offer-banner { background-color: #e7f3fe; border: 1px solid #b3d4fc; border-radius: var(--border-radius); padding: 1rem; position: relative; }
    .offer-badge { position: absolute; top: -10px; left: 15px; background-color: var(--primary-color); color: white; font-size: 0.75rem; font-weight: 600; padding: 0.25rem 0.6rem; border-radius: 4px; text-transform: uppercase; }
    .offer-content { display: flex; flex-direction: column; gap: 1rem; padding-top: 1.25rem; }
    @media (min-width: 768px) { .offer-content { flex-direction: row; align-items: center; gap: 1.5rem; } }
    .offer-image { flex-shrink: 0; max-width: 150px; margin: 0 auto; }
    @media (min-width: 768px) { .offer-image { margin: 0; } }
    .offer-image img { border-radius: 4px; }
    .offer-text { flex-grow: 1; }
    .offer-text h3 { font-size: 1.2rem; margin-bottom: 0.5rem; color: var(--primary-color); }
    .offer-text p { font-size: 0.95rem; margin-bottom: 1rem; color: var(--dark-color); line-height: 1.5; }
    .offer-details-link { display: inline-block; margin-left: 1rem; font-size: 0.9rem; color: var(--primary-color); text-decoration: underline; }
    .offer-details-link:hover { color: var(--secondary-color); }

     /* ================== Reusable Widget Card (for Billing Quick View) ================== */
     .widget-card { background-color: #fff; border-radius: var(--border-radius); border: 1px solid #eee; box-shadow: var(--box-shadow-light); overflow: hidden; }
     .widget-header { padding: 0.75rem 1.25rem; background-color: #f8f9fa; border-bottom: 1px solid #eee;}
     .widget-title { font-size: 1.1rem; font-weight: 600; margin-bottom: 0; color: var(--dark-color); }
     .widget-content { padding: 1.25rem; }
     .widget-content p { margin-bottom: 1rem; font-size: 0.95rem; }

     /* ================== Content Cards (Placeholder Section) ================== */
    .content-cards .section-title { font-size: 1.4rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color); }
    .content-card-item { background-color: var(--white-color); border-radius: var(--border-radius); overflow: hidden; box-shadow: var(--box-shadow-light); transition: transform 0.2s ease, box-shadow 0.2s ease; display: flex; flex-direction: column; border: 1px solid #eee; }
    .content-card-item:hover { transform: translateY(-4px); box-shadow: var(--box-shadow-medium); }
    .content-card-item img { width: 100%; aspect-ratio: 16 / 9; object-fit: cover; }
    .card-item-body { padding: 1.25rem; flex-grow: 1; display: flex; flex-direction: column; }
    .card-item-body h4 { font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--primary-color); }
    .card-item-body p { font-size: 0.95rem; color: var(--medium-gray); flex-grow: 1; margin-bottom: 1rem; }
    .card-item-link { margin-top: auto; font-weight: 500; color: var(--primary-color); align-self: flex-start; }
    .card-item-link:hover { color: var(--secondary-color); text-decoration: underline; }

    /* ================== Mobile Bottom Nav ================== */
    .mobile-bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; height: 60px; background-color: var(--white-color, #fff); border-top: 1px solid var(--border-color, #e5e7eb); box-shadow: 0 -2px 10px rgba(0,0,0,0.06); display: flex; justify-content: space-around; align-items: stretch; z-index: 900; }
    .mobile-nav-item { display: flex; flex-direction: column; align-items: center; justify-content: center; flex-grow: 1; text-decoration: none; color: var(--medium-gray); padding: 4px 0; font-size: 0.7rem; transition: color 0.2s ease; position: relative; }
    .mobile-nav-item i { font-size: 1.3rem; margin-bottom: 2px; }
    .mobile-nav-item span { line-height: 1.2; }
    .mobile-nav-item.active { color: var(--primary-color); font-weight: 500; }
    .mobile-nav-item.active::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background-color: var(--primary-color); border-bottom-left-radius: 2px; border-bottom-right-radius: 2px; }
    .mobile-nav-item:hover { color: var(--primary-color); }
    @media (min-width: 768px) { .mobile-bottom-nav.md\:hidden { display: none; } }

    /* ================== PDF Modal ================== */
    .pdf-modal-overlay { position: fixed; inset: 0; background-color: rgba(0, 0, 0, 0.6); display: flex; align-items: center; justify-content: center; z-index: 1000; opacity: 0; visibility: hidden; transition: opacity 0.3s ease, visibility 0s linear 0.3s; }
    .pdf-modal-overlay.visible { opacity: 1; visibility: visible; transition: opacity 0.3s ease, visibility 0s linear 0s; }
    .pdf-modal-content { background-color: #fff; padding: 25px 30px; border-radius: 8px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); max-width: 500px; width: 90%; position: relative; transform: scale(0.9); transition: transform 0.3s ease; }
    .pdf-modal-overlay.visible .pdf-modal-content { transform: scale(1); }
    .pdf-modal-close-button { position: absolute; top: 10px; right: 15px; background: none; border: none; font-size: 1.8rem; font-weight: bold; color: #888; cursor: pointer; line-height: 1; }
    .pdf-modal-close-button:hover { color: #333; }
</style>
@endpush

{{-- Modal JS (Keep from previous steps) --}}
@push('scripts')
<script defer>
    // ... (Modal JS code remains the same) ...
     const viewStatementButton = document.getElementById('view-statement-button');
     const modalOverlay = document.getElementById('pdf-modal-overlay');
     const closeModalButton = document.getElementById('close-modal-button');
     function showModal() { if (modalOverlay) { modalOverlay.classList.add('visible'); modalOverlay.classList.remove('hidden'); } }
     function hideModal() { if (modalOverlay) { modalOverlay.classList.remove('visible'); modalOverlay.classList.add('hidden'); } }
     if (viewStatementButton && modalOverlay) viewStatementButton.addEventListener('click', showModal);
     if (closeModalButton && modalOverlay) closeModalButton.addEventListener('click', hideModal);
     if (modalOverlay) modalOverlay.addEventListener('click', function(event) { if (event.target === modalOverlay) hideModal(); });
</script>
@endpush