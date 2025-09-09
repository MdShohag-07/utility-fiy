{{-- resources/views/user/billing/index.blade.php --}}
@extends('layouts.app') {{-- Use the main public layout --}}

@section('title', 'Billing')

@section('content')
<div class="user-dashboard-layout user-billing-page"> {{-- Wrapper class for styles --}}

    {{-- === Desktop Sidebar === --}}
    @include('partials.user_dashboard_sidebar', ['active' => 'billing'])

    {{-- === Main Content Area === --}}
    <main class="dashboard-main-content">

        <div class="billing-top-bar">
            <h1 class="billing-page-title">Billing</h1>
            {{-- Optional: Keep search if needed, or remove if not in screenshots for this page --}}
            {{-- <div class="billing-top-actions">
                 <button class="search-icon-btn" aria-label="Search Billing"><i class="fas fa-search"></i></button>
            </div> --}}
        </div>

        <div class="billing-content-grid">
            <div class="billing-details-column">

                {{-- Balance/Payment Card (Adjusted to better match screenshot 1 structure) --}}
                <div class="billing-card balance-card">
                    {{-- Removed h2 based on screenshot 1 --}}
                    <div class="balance-amount">${{ number_format($billingData['balance'] ?? 0, 2) }}</div>
                    <div class="payment-status">{{ $billingData['paymentStatus'] ?? 'N/A' }}</div>
                    <a href="#" class="btn btn-outline-primary make-payment-btn">Make Additional Payment</a>
                </div>

                {{-- Settings Section --}}
                <div class="billing-section settings-section">
                    <h2>Settings</h2>
                    <ul class="billing-list">
                        <li>
                            <a href="#" class="billing-list-item">
                                <i class="fas fa-sync-alt icon"></i> {{-- Icon might be slightly different in screenshot --}}
                                <span>Auto Pay</span>
                                <i class="fas fa-chevron-right arrow"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="billing-list-item">
                                <i class="fas fa-credit-card icon"></i>
                                <span>Payment Methods</span>
                                <i class="fas fa-chevron-right arrow"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                 {{-- Statements Section - Link to the statements list page --}}
                <div class="billing-section statements-section">
                    <h2>Statements</h2>
                     <ul class="billing-list">
                        <li>
                            {{-- UPDATED LINK: Points to the new statements list route --}}
                            <a href="{{ route('my-account.billing.statements') }}" class="billing-list-item">
                                <div class="statement-info">
                                    <span class="service-type">{{ $billingData['accountIdentifier'] ?? 'Your Services' }}</span>
                                    <span class="account-number">Account Number: {{ $billingData['accountNumber'] ?? 'N/A' }}</span>
                                </div>
                                <i class="fas fa-chevron-right arrow"></i>
                            </a>
                        </li>
                    </ul>
                </div>

            </div> {{-- End Left Column --}}

            {{-- Right Column (Ad Banner - Hidden on Mobile) --}}
            <aside class="billing-ad-column hidden md:block">
                 <div class="ad-banner-sidebar">
                     <div class="ad-image"> <img src="{{ $adData['image'] ?? 'https://via.placeholder.com/300x150/cccccc/969696?text=Ad+Placeholder' }}" alt="{{ $adData['title'] ?? 'Advertisement' }}"> </div>
                     <div class="ad-text"> <h3>{{ $adData['title'] ?? 'Save More Today!' }}</h3> <p>{{ $adData['text'] ?? 'Check out our latest offers and deals.' }}</p> <a href="{{ $adData['buttonUrl'] ?? '#' }}" class="btn btn-primary btn-sm">{{ $adData['buttonText'] ?? 'Shop Now' }}</a> <a href="{{ $adData['detailsUrl'] ?? '#' }}" class="ad-details-link">See offer details</a> </div>
                 </div>
            </aside>

        </div> {{-- End Billing Content Grid --}}

         {{-- Mobile Ad Banner --}}
         <section class="offer-banner md:hidden mt-6">
            <div class="offer-badge">Your Recommended Offer</div>
            <div class="offer-content">
                {{-- Content structure depends on specific styles, adjust if needed --}}
                 {{-- Example structure: --}}
                 {{-- <div class="offer-image"> <img src="{{ $adData['image'] ?? '...' }}" alt="Mobile Offer"> </div> --}}
                <div class="offer-text">
                    <h3>{{ $adData['title'] ?? '' }}</h3>
                    <p>{{ $adData['text'] ?? '' }}</p>
                    <a href="{{ $adData['buttonUrl'] ?? '#' }}" class="btn btn-primary btn-sm">{{ $adData['buttonText'] ?? 'Shop Now' }}</a>
                    <a href="{{ $adData['detailsUrl'] ?? '#' }}" class="offer-details-link">See offer details</a>
                </div>
            </div>
        </section>

    </main> {{-- End Main Content --}}

    {{-- === Mobile Bottom Navigation === --}}
    @include('partials.user_mobile_nav', ['active' => 'billing'])

    {{-- PDF Modal Removed - Link is now on statement detail page --}}

</div> {{-- End Layout Wrapper --}}
@endsection

{{-- Styles Section: Contains ALL styles copied from your original file --}}
@push('styles')
<style>
    /* ========================================= */
    /* === User Dashboard/Billing Base Styles === */
    /* ========================================= */
    /* Using inline styles + classes for layout now, define specific component styles here */

    /* Basic Button Styles (if not in app.css) */
    .btn { display: inline-block; padding: 10px 20px; border: none; border-radius: var(--border-radius, 8px); font-size: 0.9rem; font-weight: 500; cursor: pointer; text-align: center; transition: all 0.2s ease; text-decoration: none; box-shadow: var(--box-shadow-light); }
    .btn-primary { background: linear-gradient(45deg, var(--primary-color, #005eb8), var(--accent-color, #00a9e0)); color: var(--white-color, #fff); }
    .btn-primary:hover { opacity: 0.9; }
    .btn-outline-primary { border: 1px solid var(--primary-color); color: var(--primary-color); background-color: transparent;} .btn-outline-primary:hover { background-color: var(--primary-color); color: white; }
    .btn-sm { padding: 0.4rem 0.8rem; font-size: 0.8rem;}

    /* Layout Styling */
    .user-dashboard-layout { display: flex; flex-wrap: nowrap; width: 100%; max-width: var(--container-max-width, 1250px); margin-left: auto; margin-right: auto; padding: 1rem 0; background-color: var(--white-color); min-height: calc(100vh - 140px); /* Adjust as needed */ }
    .dashboard-sidebar { width: 240px; flex-shrink: 0; padding: 1.5rem 1rem; background-color: #f8f9fa; border-right: 1px solid var(--border-color, #e5e7eb); }
    .dashboard-main-content { flex-grow: 1; padding: 1.5rem; background-color: var(--white-color); min-width: 0; }
    @media (min-width: 768px) { .dashboard-main-content { padding: 2rem; } }
    @media (max-width: 767px) { .dashboard-sidebar.hidden.md\:block { display: none; } .user-dashboard-layout { padding: 0; display: block; } .dashboard-main-content { width: 100%; padding: 1rem; padding-bottom: 70px; } }

    /* Sidebar Link Styles */
    .dashboard-sidebar nav ul { list-style: none; padding: 0; margin: 0; }
    .dashboard-sidebar nav ul li a { display: flex; align-items: center; padding: 0.7rem 0.75rem; margin-bottom: 0.25rem; font-size: 0.95rem; font-weight: 500; color: var(--dark-color); border-radius: 6px; text-decoration: none; transition: background-color 0.2s ease, color 0.2s ease; }
    .dashboard-sidebar nav ul li a i { width: 25px; margin-right: 10px; text-align: center; color: var(--medium-gray); font-size: 1.1rem; }
    .dashboard-sidebar nav ul li a:hover { background-color: #e9ecef; color: var(--primary-color); }
    .dashboard-sidebar nav ul li a.active { background-color: var(--white-color); color: var(--primary-color); font-weight: 600; box-shadow: 0 1px 3px rgba(0,0,0,0.05); border: 1px solid #eee; }
    .dashboard-sidebar nav ul li a.active i { color: var(--primary-color); }
    .sidebar-divider { height: 1px; background-color: var(--border-color, #e5e7eb); margin: 1rem 0.5rem; }

    /* Mobile Nav Styles */
    .mobile-bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; height: 60px; background-color: var(--white-color, #fff); border-top: 1px solid var(--border-color, #e5e7eb); box-shadow: 0 -2px 10px rgba(0,0,0,0.06); display: flex; justify-content: space-around; align-items: stretch; z-index: 900; }
    .mobile-nav-item { display: flex; flex-direction: column; align-items: center; justify-content: center; flex-grow: 1; text-decoration: none; color: var(--medium-gray); padding: 4px 0; font-size: 0.7rem; transition: color 0.2s ease; position: relative; }
    .mobile-nav-item i { font-size: 1.3rem; margin-bottom: 2px; }
    .mobile-nav-item span { line-height: 1.2; }
    .mobile-nav-item.active { color: var(--primary-color); font-weight: 500; }
    .mobile-nav-item.active::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background-color: var(--primary-color); border-bottom-left-radius: 2px; border-bottom-right-radius: 2px; }
    .mobile-nav-item:hover { color: var(--primary-color); }
    @media (min-width: 768px) { .mobile-bottom-nav.md\:hidden { display: none; } }

     /* --- Billing Page Specific Styles --- */
    .billing-top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color, #eee); }
    .billing-page-title { font-size: 1.75rem; font-weight: 600; color: var(--dark-color); margin: 0; padding: 0; border: none; }
    .search-icon-btn { background: none; border: none; font-size: 1.2rem; color: var(--medium-gray); cursor: pointer; padding: 0.5rem; }
    .billing-content-grid { display: flex; flex-direction: column; gap: 1.5rem; }
    @media (min-width: 768px) { .billing-content-grid { flex-direction: row; gap: 2rem; } }
    .billing-details-column { flex-grow: 1; display: flex; flex-direction: column; gap: 1.5rem; }
    .billing-ad-column { width: 100%; flex-shrink: 0; }
    @media (min-width: 768px) { .billing-ad-column { width: 300px; } }
    .billing-card, .billing-section { background-color: var(--white-color); border: 1px solid var(--border-color, #eee); border-radius: var(--border-radius); box-shadow: var(--box-shadow-light); overflow: hidden; }
    .billing-card { padding: 1.5rem; position: relative;}
    .billing-section { padding: 1rem 0; margin-bottom: 1.5rem; } /* Add margin back to sections */
    .billing-section:last-child { margin-bottom: 0; }
    .balance-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 4px; background-color: var(--primary-color); }
    .balance-card h2 { font-size: 1rem; font-weight: 500; color: var(--medium-gray); margin-bottom: 0.5rem; } /* Keep if needed for other cards */
    .balance-amount { font-size: 2.5rem; font-weight: 600; color: var(--dark-color); line-height: 1.1; margin-bottom: 0.25rem; }
    .payment-status { font-size: 0.9rem; color: var(--medium-gray); margin-bottom: 1.25rem; }
    .make-payment-btn { padding: 0.6rem 1.2rem; font-size: 0.9rem; font-weight: 500; display: block; text-align: center;} /* Made block */
    .billing-section h2 { font-size: 1.1rem; font-weight: 600; color: var(--dark-color); margin-bottom: 0.5rem; padding: 0 1.5rem; }
    .billing-list { list-style: none; padding: 0; margin: 0; }
    .billing-list li:not(:last-child) .billing-list-item { border-bottom: 1px solid #f3f4f6; }
    .billing-list-item { display: flex; align-items: center; justify-content: space-between; padding: 0.9rem 1.5rem; text-decoration: none; color: var(--dark-color); transition: background-color 0.2s ease; }
    .billing-list-item:hover { background-color: #f8f9fa; }
    .billing-list-item .icon { font-size: 1.1rem; color: var(--primary-color); margin-right: 1rem; width: 20px; text-align: center; }
    .billing-list-item span { flex-grow: 1; font-size: 0.95rem; font-weight: 500; }
    .billing-list-item .arrow { font-size: 0.8rem; color: var(--medium-gray); }
    .statement-info { display: flex; flex-direction: column; flex-grow: 1; }
    .statement-info .service-type { font-weight: 500; font-size: 0.95rem; line-height: 1.3; }
    .statement-info .account-number { font-size: 0.8rem; color: var(--medium-gray); line-height: 1.3; }
    .ad-banner-sidebar { background-color: var(--white-color); border: 1px solid var(--border-color, #eee); border-radius: var(--border-radius); padding: 1.5rem; box-shadow: var(--box-shadow-light); }
    .ad-banner-sidebar .ad-image img { max-width: 100%; height: auto; border-radius: 4px; margin-bottom: 1rem; }
    .ad-banner-sidebar .ad-text h3 { font-size: 1.1rem; color: var(--primary-color); margin-bottom: 0.5rem; }
    .ad-banner-sidebar .ad-text p { font-size: 0.9rem; margin-bottom: 1rem; color: var(--dark-color); line-height: 1.5; }
    .ad-banner-sidebar .ad-text .btn { display: block; width: 100%; text-align: center; margin-bottom: 0.75rem; }
    .ad-banner-sidebar .ad-text .ad-details-link { display: block; text-align: center; font-size: 0.85rem; color: var(--primary-color); text-decoration: underline; }
    .detail-section { border-bottom: 1px solid var(--border-color, #eee); }
    .detail-section:last-child { border-bottom: none; }
    .detail-header { display: flex; justify-content: space-between; align-items: center; padding: 0.9rem 1.5rem; cursor: pointer; }
    .detail-header span { font-weight: 500; font-size: 0.95rem; }
    .detail-header .expand-arrow { color: var(--primary-color); font-size: 0.8rem; transition: transform 0.2s ease; }
    .detail-header.open .expand-arrow { transform: rotate(180deg); } /* Added */
    .detail-content { padding: 0 1.5rem 1rem 1.5rem; }
    .detail-content.expandable-content { max-height: 0; overflow: hidden; transition: max-height 0.4s ease-out, padding 0.4s ease-out; padding-top: 0; padding-bottom: 0; border-top: 1px solid transparent; }
    .detail-content.expandable-content.open { max-height: 500px; /* Adjust as needed */ padding-top: 1rem; padding-bottom: 1rem; border-top-color: var(--border-color, #eee); transition: max-height 0.5s ease-in-out, padding 0.5s ease-in-out; }
    .detail-content p { font-size: 0.9rem; line-height: 1.5; color: var(--medium-gray); margin-bottom: 0.5rem; } .detail-content p:last-child { margin-bottom: 0; }
    .activity-item { display: flex; justify-content: space-between; font-size: 0.9rem; padding: 0.3rem 0; }
    .activity-item span:last-child { font-weight: 500; color: var(--dark-color); }
    .amount-due-section { padding: 1rem 1.5rem; background-color: #f8f9fa; }
    .amount-due-section .detail-line { display: flex; justify-content: space-between; align-items: baseline; }
    .amount-due-section .detail-line span:first-child { font-size: 0.95rem; font-weight: 500; color: var(--dark-color); }
    .amount-due-section .detail-line .amount { font-size: 1.5rem; font-weight: 600; color: var(--dark-color); }
    .amount-due-section .detail-line.subtext span { font-size: 0.85rem; color: var(--medium-gray); font-weight: 400; margin-top: 0.25rem;}
    .bill-details-footer { padding: 1rem 1.5rem; border-top: 1px solid var(--border-color, #eee); text-align: center; }
    .btn-link-styled { color: var(--primary-color); font-weight: 500; text-decoration: none; font-size: 0.95rem; } .btn-link-styled i { font-size: 0.9em; margin-left: 5px; } .btn-link-styled:hover { color: var(--secondary-color); text-decoration: underline; } /* Added icon margin */
    .billing-list.plain { padding: 0.5rem 1.5rem; }
    .billing-list.plain .service-list-item { padding: 0.4rem 0; border-bottom: none; } .billing-list.plain .service-list-item:hover { background-color: transparent; }
    .support-link { font-size: 0.95rem; font-weight: 500; color: var(--primary-color); text-decoration: none; } .support-link:hover { color: var(--secondary-color); text-decoration: underline;}
    .status-active, .status-connected { color: var(--success-color, #198754); font-weight: 500; }
    .status-inactive, .status-not-active, .status-unknown { color: var(--medium-gray); } .status-error { color: var(--danger-color); }

    /* Mobile Offer Banner Styles (Ensure these are defined or adjust) */
    .offer-banner { background-color: #f0f6ff; border: 1px solid #cce0ff; border-radius: var(--border-radius); margin-top: 1.5rem; position: relative; overflow: hidden; }
    .offer-badge { background-color: var(--primary-color); color: white; font-size: 0.75rem; font-weight: 500; padding: 3px 10px; border-radius: 4px; position: absolute; top: 10px; left: 10px; z-index: 1; }
    .offer-content { display: flex; flex-direction: column; /* Adjusted for better mobile layout */ padding: 1rem; padding-top: 2rem; /* Space for badge */ }
    .offer-image { text-align: center; margin-bottom: 1rem; }
    .offer-image img { max-width: 100%; height: auto; max-height: 100px; /* Example max height */ }
    .offer-text h3 { font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--dark-color); }
    .offer-text p { font-size: 0.9rem; margin-bottom: 1rem; color: var(--medium-gray); line-height: 1.4; }
    .offer-text .btn { margin-bottom: 0.75rem; }
    .offer-text .offer-details-link { display: block; text-align: center; font-size: 0.85rem; color: var(--primary-color); text-decoration: underline; }
    @media (min-width: 768px) { .offer-banner.md\:hidden { display: none; } }
    @media (min-width: 480px) { /* Adjust layout slightly on larger small screens */
        .offer-content { flex-direction: row; align-items: center; text-align: left; }
        .offer-image { margin-bottom: 0; margin-right: 1rem; flex-shrink: 0; }
        .offer-image img { max-height: 80px; }
        .offer-text { flex-grow: 1; }
    }

    /* PDF Modal styles (if needed elsewhere, keep; otherwise remove) */
    .pdf-modal-overlay { /* ... */ }
    .pdf-modal-content { /* ... */ } .pdf-modal-close-button { /* ... */ }

    /* Specific styles for statement list page */
    .statement-page-header { font-size: 1rem; color: var(--medium-gray); margin-bottom: 1.5rem; font-weight: 500; padding: 0 1.5rem; }
    .billing-section.current-statement { padding: 1rem 0 0 0; } /* No bottom padding needed before list */
    .billing-section.current-statement .billing-list-item { border-bottom: none; padding-bottom: 1rem; }
    .billing-section.billing-history { padding-top: 0; } /* Remove top padding if it follows current stmt */
    .current-statement-details { display: flex; justify-content: space-between; align-items: flex-start; width: 100%; }
    .current-statement-info { flex-grow: 1; }
    .current-statement-amount { font-size: 1rem; font-weight: 600; color: var(--dark-color); text-align: right; }
    .current-statement-due { font-size: 0.85rem; color: var(--success-color, #198754); font-weight: 500; margin-top: 2px; }
    .statement-history-item span { color: var(--dark-color); font-size: 0.95rem; } /* Simpler display */

    /* Specific styles for statement detail page */
    .statement-detail-header { padding: 1rem 1.5rem; border-bottom: 1px solid var(--border-color, #eee); background-color: #f8f9fa; }
    .statement-detail-title { display: flex; align-items: baseline; justify-content: space-between; margin-bottom: 0.25rem; }
    .statement-detail-title h1 { font-size: 1.5rem; font-weight: 600; color: var(--dark-color); }
    .statement-service-type { font-size: 1rem; color: var(--primary-color); font-weight: 500; }
    .statement-service-period { font-size: 0.9rem; color: var(--medium-gray); }
    .statement-back-link { display: inline-block; margin-bottom: 1rem; color: var(--primary-color); text-decoration: none; font-weight: 500; }
    .statement-back-link i { margin-right: 5px; }
    .statement-detail-content { padding: 0; } /* Remove padding from main container */
    .statement-section { border-bottom: 1px solid var(--border-color, #eee); }
    .statement-section:last-child { border-bottom: none; }
    .statement-section-header { display: flex; justify-content: space-between; align-items: center; padding: 0.9rem 1.5rem; cursor: pointer; background-color: #fff; }
    .statement-section-header span { font-weight: 600; font-size: 0.95rem; color: var(--dark-color); }
    .statement-section-header .value { font-weight: 500; color: var(--medium-gray); } /* For values in header like balance */
    .statement-section-header .expand-arrow { color: var(--primary-color); font-size: 1rem; transition: transform 0.2s ease; }
    .statement-section-header.open .expand-arrow { transform: rotate(180deg); }
    .statement-section-content { background-color: #fff; max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out, padding 0.3s ease-out; padding: 0 1.5rem; }
    .statement-section-content.open { max-height: 1000px; /* Large enough */ padding-top: 1rem; padding-bottom: 1rem; transition: max-height 0.4s ease-in, padding 0.4s ease-in; }
    .account-holder-details p { margin-bottom: 0.25rem; font-size: 0.9rem; color: var(--dark-color); line-height: 1.4; }
    .account-holder-details p strong { font-weight: 500; color: var(--medium-gray); display: block; font-size: 0.8rem; margin-bottom: 1px; }
    .activity-list .activity-item { padding: 0.5rem 0; border-bottom: 1px dashed #eee; }
    .activity-list .activity-item:last-child { border-bottom: none; }
    .activity-list .description { flex-grow: 1; margin-right: 1rem; }
    .activity-list .amount { font-weight: 500; }
    .statement-total-due { background-color: #f8f9fa; padding: 1rem 1.5rem; display: flex; justify-content: space-between; align-items: baseline; border-top: 1px solid var(--border-color, #eee); }
    .statement-total-due span:first-child { font-size: 1.1rem; font-weight: 600; color: var(--dark-color); }
    .statement-total-due .amount { font-size: 1.5rem; font-weight: 700; color: var(--dark-color); }
    .statement-due-date { font-size: 0.85rem; color: var(--medium-gray); text-align: right; margin-top: -0.75rem; padding-bottom: 0.5rem; background-color: #f8f9fa; padding-right: 1.5rem;}


</style>
@endpush

{{-- Scripts Section - Basic toggle, no complex logic needed here --}}
@push('scripts')
<script defer>
    // No specific JS needed for this overview page based on the flow change
</script>
@endpush