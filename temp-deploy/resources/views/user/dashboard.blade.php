{{-- This is the content for the main user dashboard page, e.g., /my-account --}}
@extends('layouts.user_dashboard') {{-- Extends the new layout we created/modified --}}

{{-- Set variables to be used by the layout --}}
@php
    $pageTitle = 'My Account Dashboard'; // Specific title for this page

    // This tells the sidebar and mobile navigation which item should be marked 'active'.
    // Ensure 'dashboard' matches what your partials.user_dashboard_sidebar and partials.user_mobile_nav expect for the main link.
    // If they expect 'home', use 'home' here.
    $active_sidebar_item = 'dashboard';
    $active_mobile_nav_item = 'dashboard';
@endphp

@section('dashboard_content') {{-- This content will be injected into @yield('dashboard_content') in the layout --}}

    {{-- Top Icon Grid --}}
    <section class="icon-grid mb-6 md:mb-8">
        {{-- Replace # with actual routes when available. Example: route('my-account.plan.view') --}}
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
            {{-- This could link to a profile section or a dedicated payment methods page --}}
            <a href="{{ route('my-account.profile.edit') }}#payment-methods" class="icon-grid-item"> {{-- Example linking to a section --}}
                <i class="fas fa-credit-card"></i>
                <span>Manage Payment Methods</span>
            </a>
        </a>
    </section>

    {{-- Recommended Offer Banner --}}
    <section class="offer-banner mb-6 md:mb-8">
        <div class="offer-badge">Your Recommended Offer</div>
        <div class="offer-content">
            <div class="offer-image">
                {{-- Ideally, make image dynamic from settings or a promotions model --}}
                <img src="https://www.spectrum.com/content/dam/spectrum/residential/mobile/images/dt_sav_ban_mob_bau_df_1_ine_free.png" alt="Mobile Offer">
            </div>
            <div class="offer-text">
                <h3>Mobile Savings You'll Love</h3>
                <p>Save $360 by getting 1 year of Unlimited Mobile with unlimited talk, text and data, plus nationwide 5G – included with Spectrum Internet.</p>
                <a href="#" class="btn btn-primary btn-sm">Shop Mobile</a> {{-- Link to offer page --}}
                <a href="#" class="offer-details-link">See offer details</a>
            </div>
        </div>
    </section>

    {{-- Billing/Statement Action --}}
    <section class="widget-card dashboard-card mb-6 md:mb-8">
        <div class="widget-header">
            <h2 class="widget-title">Billing Quick View</h2>
        </div>
        <div class="widget-content">
            {{-- $billingSummary should be passed from UserDashboardController@index --}}
            <p class="mb-3">
                {{ $billingSummary['next_due_text'] ?? 'Your account is up to date.' }}
                @if(isset($billingSummary['balance']) && $billingSummary['balance'] > 0)
                    Current Balance: <span class="font-semibold">${{ number_format($billingSummary['balance'], 2) }}</span>
                @endif
            </p>
            {{-- This button should trigger the modal defined in layouts.user_dashboard.blade.php
                 or the modal defined at the bottom of this file if you moved it here. --}}
            <button id="view-statement-button" class="btn btn-secondary mr-2">View Latest Statement PDF</button>
            <a href="{{ route('my-account.billing.index') }}" class="btn btn-outline-primary">Go to Billing</a>
        </div>
    </section>

    {{-- Content Cards Section (Placeholders) --}}
    <section class="content-cards mb-6 md:mb-8">
         <h2 class="section-title">Keep Moving with {{ config('app.name', 'Utility Site') }}</h2>
         <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
             <div class="content-card-item">
                 <img src="https://via.placeholder.com/600x350/005eb8/ffffff?text=Content+Card+1" alt="Placeholder 1">
                 <div class="card-item-body">
                     <h4>Headline for Card 1</h4>
                     <p>Description text for the first content card goes here.</p>
                     <a href="#" class="card-item-link">Learn More →</a>
                 </div>
             </div>
              <div class="content-card-item">
                 <img src="https://via.placeholder.com/600x350/8dc63f/ffffff?text=Content+Card+2" alt="Placeholder 2">
                 <div class="card-item-body">
                     <h4>Headline for Card 2</h4>
                     <p>Description text for the second content card goes here.</p>
                      <a href="#" class="card-item-link">Learn More →</a>
                 </div>
             </div>
         </div>
    </section>

    {{--
        PDF Statement Modal:
        If the modal defined in layouts.user_dashboard.blade.php is intended to be triggered
        by the 'view-statement-button' on THIS page, then you don't need to redefine the modal HTML here.
        The JavaScript below will trigger the modal from the layout.
        If you decided the modal HTML itself should only be on this page, you would uncomment the HTML below
        and remove it from layouts.user_dashboard.blade.php.
    --}}
    {{--
    <div id="pdf-modal-overlay" class="pdf-modal-overlay hidden">
       <div id="pdf-modal-content" class="pdf-modal-content">
           <button id="close-modal-button" class="pdf-modal-close-button">×</button>
           <h2 class="text-xl font-semibold mb-4">Latest Billing Statement</h2>
           @if ($latestStatement ?? null)
               <p class="mb-6">View your statement from {{ $latestStatement->formatted_statement_date }} in PDF format.</p>
               <div class="text-center">
                   <a href="{{ route('my-account.billing.statement.downloadPdf', $latestStatement) }}" target="_blank" class="btn btn-primary">
                       View PDF Statement
                   </a>
               </div>
           @else
               <p class="mb-6">No statements are currently available to display.</p>
                <div class="text-center">
                   <a href="{{ route('my-account.billing.statements') }}" class="btn btn-secondary">
                       Go to All Statements
                   </a>
               </div>
           @endif
       </div>
    </div>
    --}}

@endsection

@push('styles')
{{--
    Add styles specific to the content of THIS page (Icon Grid, Offer Banner, specific card styles)
    ONLY IF they are not already defined globally or in the layouts.user_dashboard.blade.php.
    Many of these component styles (icon-grid, offer-banner, widget-card, content-card)
    were in your original user-dashboard.blade.php which became layouts.user_dashboard.blade.php.
    If those styles are now in the layout, you don't need to repeat them here unless you have
    page-specific overrides or new components.
--}}
<style>
    /* Example: Styles for components primarily used on this main dashboard page */
    /* If these are already in layouts/user_dashboard.blade.php or app.css, remove from here. */
    /*
    .icon-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }
    @media (min-width: 640px) { .icon-grid { grid-template-columns: repeat(3, 1fr); } }
    @media (min-width: 1024px) { .icon-grid { grid-template-columns: repeat(6, 1fr); } }
    .icon-grid-item { background-color: var(--white-color, #fff); border: 1px solid var(--border-color, #eee); border-radius: var(--border-radius, 8px); padding: 1.25rem 1rem; text-align: center; transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease; text-decoration: none; color: var(--dark-color, #374151); box-shadow: var(--box-shadow-light); }
    .icon-grid-item:hover { transform: translateY(-3px); box-shadow: var(--box-shadow-medium); border-color: var(--primary-color, #4f46e5); color: var(--primary-color, #4f46e5); }
    .icon-grid-item i { font-size: 1.75rem; color: var(--primary-color, #4f46e5); margin-bottom: 0.75rem; display: block; }
    .icon-grid-item span { font-size: 0.9rem; font-weight: 500; line-height: 1.3; display: block; }

    .offer-banner { background-color: #e7f3fe; border: 1px solid #b3d4fc; border-radius: var(--border-radius, 8px); padding: 1rem; position: relative; }
    .offer-badge { position: absolute; top: -10px; left: 15px; background-color: var(--primary-color, #4f46e5); color: white; font-size: 0.75rem; font-weight: 600; padding: 0.25rem 0.6rem; border-radius: 4px; text-transform: uppercase; }
    .offer-content { display: flex; flex-direction: column; gap: 1rem; padding-top: 1.25rem; }
    @media (min-width: 768px) { .offer-content { flex-direction: row; align-items: center; gap: 1.5rem; } }
    .offer-image { flex-shrink: 0; max-width: 150px; margin: 0 auto; }
    @media (min-width: 768px) { .offer-image { margin: 0; } }
    .offer-image img { border-radius: 4px; }
    .offer-text { flex-grow: 1; }
    .offer-text h3 { font-size: 1.2rem; margin-bottom: 0.5rem; color: var(--primary-color, #4f46e5); }
    .offer-text p { font-size: 0.95rem; margin-bottom: 1rem; color: var(--dark-color, #374151); line-height: 1.5; }
    .offer-details-link { display: inline-block; margin-left: 1rem; font-size: 0.9rem; color: var(--primary-color, #4f46e5); text-decoration: underline; }
    .offer-details-link:hover { color: var(--secondary-color, #10b981); }

    .widget-card.dashboard-card { /* Specific styles for dashboard cards if any */ }
    .content-cards .section-title { font-size: 1.4rem; font-weight: 600; margin-bottom: 1.5rem; color: var(--primary-color, #4f46e5); }
    .content-card-item { background-color: var(--white-color, #fff); border-radius: var(--border-radius, 8px); overflow: hidden; box-shadow: var(--box-shadow-light); transition: transform 0.2s ease, box-shadow 0.2s ease; display: flex; flex-direction: column; border: 1px solid #eee; }
    .content-card-item:hover { transform: translateY(-4px); box-shadow: var(--box-shadow-medium); }
    .content-card-item img { width: 100%; aspect-ratio: 16 / 9; object-fit: cover; }
    .card-item-body { padding: 1.25rem; flex-grow: 1; display: flex; flex-direction: column; }
    .card-item-body h4 { font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--primary-color, #4f46e5); }
    .card-item-body p { font-size: 0.95rem; color: var(--medium-gray, #6b7280); flex-grow: 1; margin-bottom: 1rem; }
    .card-item-link { margin-top: auto; font-weight: 500; color: var(--primary-color, #4f46e5); align-self: flex-start; }
    .card-item-link:hover { color: var(--secondary-color, #10b981); text-decoration: underline; }
    */
</style>
@endpush

@push('scripts')
<script defer>
    // JavaScript for the "View Latest Statement PDF" button ON THIS PAGE
    // This script assumes the modal HTML structure (pdf-modal-overlay, etc.)
    // is defined in the LAYOUT (layouts.user_dashboard.blade.php)
    // and that the layout's script defines global showModal()/hideModal() functions
    // or that those elements are directly accessible.

    const viewStatementButtonOnPage = document.getElementById('view-statement-button');
    const modalOverlayForPage = document.getElementById('pdf-modal-overlay'); // This might be in the layout
    const closeModalButtonForPage = document.getElementById('close-modal-button'); // This might be in the layout

    function showPageModal() {
        if (modalOverlayForPage) {
            modalOverlayForPage.classList.add('visible');
            modalOverlayForPage.classList.remove('hidden');
        }
    }

    function hidePageModal() {
        if (modalOverlayForPage) {
            modalOverlayForPage.classList.remove('visible');
            modalOverlayForPage.classList.add('hidden');
        }
    }

    if (viewStatementButtonOnPage) {
        viewStatementButtonOnPage.addEventListener('click', showPageModal);
    }

    // If the modal close button and overlay are indeed in the layout,
    // the layout's script should handle closing them.
    // If the modal HTML is specific to THIS page (uncommented above), then this JS is needed here:
    /*
    if (closeModalButtonForPage && modalOverlayForPage) {
        closeModalButtonForPage.addEventListener('click', hidePageModal);
    }
    if (modalOverlayForPage) {
        modalOverlayForPage.addEventListener('click', function(event) {
            if (event.target === modalOverlayForPage) {
                hidePageModal();
            }
        });
    }
    */
</script>
@endpush