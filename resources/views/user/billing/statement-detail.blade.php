{{-- resources/views/user/billing/statement-detail.blade.php --}}
@extends('layouts.app')

@section('title', 'Bill Details - ' . $statementDetails['statementDate'])

@section('content')
{{-- NOTE: This view might look better without the full sidebar/mobile nav like the screenshots.
     You could create a simpler layout or use CSS to hide them specifically on this page if desired.
     For now, it uses the standard layout. --}}
<div class="user-dashboard-layout user-billing-page"> {{-- Use same wrapper --}}

    {{-- === Desktop Sidebar === --}}
    @include('partials.user_dashboard_sidebar', ['active' => 'billing'])

    {{-- === Main Content Area === --}}
    <main class="dashboard-main-content">

        {{-- Back Link --}}
        <a href="{{ route('my-account.billing.statements') }}" class="statement-back-link">
            <i class="fas fa-chevron-left"></i> Billing Statements
        </a>

        {{-- Statement Header --}}
        <div class="statement-detail-header">
            <div class="statement-detail-title">
                 <h1>{{ $statementDetails['statementDate'] }}</h1>
                 <span class="statement-service-type">{{ $statementDetails['accountIdentifier'] }}</span>
            </div>
            <p class="statement-service-period">{{ $statementDetails['servicePeriod'] }}</p>
             {{-- Optional: Expand All link from screenshot --}}
             {{-- <button class="btn-link-styled text-sm mt-2" id="expand-all-details">Expand All</button> --}}
        </div>

        <div class="statement-detail-content">

            {{-- Amount Due Section (Top) --}}
            <div class="statement-section">
                <div class="statement-section-header amount-header">
                    <span>Amount Due</span>
                    <span class="value" style="font-size: 1.5rem; font-weight: 600;">${{ number_format($statementDetails['amountDue'], 2) }}</span>
                </div>
                 <div class="statement-due-date">Payment Due {{ $statementDetails['paymentDueDate'] }}</div>
                 {{-- Content could be added if needed, or keep it simple --}}
            </div>

            {{-- Account Holder Information (Expandable) --}}
            <div class="statement-section expandable-section">
                <div class="statement-section-header" data-toggle="collapse" data-target="#account-holder-content">
                    <span>Account Holder Information</span>
                    <i class="fas fa-chevron-down expand-arrow"></i>
                </div>
                <div id="account-holder-content" class="statement-section-content collapse account-holder-details">
                    <p>{{ $statementDetails['accountHolder']['name'] }}</p>
                    <p>{{ $statementDetails['accountHolder']['addressLine1'] }}</p>
                    <p>{{ $statementDetails['accountHolder']['addressLine2'] }}</p>
                    <p>Account Number: {{ $statementDetails['accountHolder']['accountNumber'] }}</p>
                </div>
            </div>

            {{-- Previous Activity (Expandable) --}}
            <div class="statement-section expandable-section">
                <div class="statement-section-header" data-toggle="collapse" data-target="#previous-activity-content">
                    <span>PREVIOUS ACTIVITY</span>
                    <span class="value">${{ number_format($statementDetails['previousActivity']['remainingBalance'], 2) }}</span> {{-- Show value in header --}}
                    {{-- <i class="fas fa-chevron-down expand-arrow"></i> --}} {{-- Arrow optional if value shown --}}
                </div>
                <div id="previous-activity-content" class="statement-section-content collapse activity-list">
                    {{-- Content for previous activity if needed, screenshot only shows balance --}}
                     <div class="activity-item">
                         <span class="description">Remaining Balance</span>
                         <span class="amount">${{ number_format($statementDetails['previousActivity']['remainingBalance'], 2) }}</span>
                     </div>
                    {{-- Add more items like past payments here --}}
                </div>
            </div>

             {{-- Current Activity (Expandable) --}}
            <div class="statement-section expandable-section">
                <div class="statement-section-header" data-toggle="collapse" data-target="#current-activity-content">
                    <span>CURRENT ACTIVITY</span>
                    <i class="fas fa-chevron-down expand-arrow"></i>
                </div>
                <div id="current-activity-content" class="statement-section-content collapse activity-list">
                     @if (!empty($statementDetails['currentActivity']))
                        @foreach ($statementDetails['currentActivity'] as $item)
                            <div class="activity-item expandable-section"> {{-- Make each item expandable? Based on Screenshot 6 --}}
                                <div class="statement-section-header w-full" data-toggle="collapse" data-target="#activity-item-{{ $loop->index }}">
                                    <span class="description flex-grow">{{ $item['description'] }}</span>
                                    <span class="amount mr-4">${{ number_format($item['amount'], 2) }}</span> {{-- Add margin right --}}
                                    <i class="fas fa-chevron-down expand-arrow text-sm"></i> {{-- Smaller arrow --}}
                                </div>
                                <div id="activity-item-{{ $loop->index }}" class="statement-section-content collapse w-full pl-4">
                                    {{-- Placeholder for sub-details of this activity item --}}
                                    <p class="text-xs text-gray-500 py-2">Details for {{ $item['description'] }} would appear here.</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p>No current activity details.</p>
                    @endif
                </div>
            </div>

            {{-- Amount Due Section (Bottom) --}}
            <div class="statement-total-due">
                 <span>Amount Due</span>
                 <span class="amount">${{ number_format($statementDetails['amountDue'], 2) }}</span>
            </div>
            <div class="statement-due-date">Payment Due {{ $statementDetails['paymentDueDate'] }}</div>


            {{-- Footer Link --}}
            <div class="bill-details-footer">
                {{-- Link to the named route for PDF statement --}}
                {{-- You might need to pass the statement ID if the PDF route requires it --}}
                {{-- Example: route('my-account.statement', ['statementId' => $statementDetails['id']]) --}}
                <a href="{{ route('my-account.statement') }}" target="_blank" class="btn-link-styled">
                    View Printable Statement <i class="fas fa-download"></i>
                </a>
            </div>

        </div>

    </main> {{-- End Main Content --}}

    {{-- === Mobile Bottom Navigation === --}}
    @include('partials.user_mobile_nav', ['active' => 'billing'])

</div> {{-- End Layout Wrapper --}}
@endsection

{{-- Styles Section: Copy ALL styles from index.blade.php --}}
@push('styles')
<style>
    /* PASTE ALL CSS FROM index.blade.php HERE */
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
    .activity-item { display: flex; justify-content: space-between; font-size: 0.9rem; padding: 0.3rem 0; flex-wrap: wrap; /* Allow wrapping for nested collapse */}
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

{{-- Scripts Section - Add JS for collapse/expand --}}
@push('scripts')
<script defer>
document.addEventListener('DOMContentLoaded', function () {
    const triggers = document.querySelectorAll('[data-toggle="collapse"]');

    triggers.forEach(trigger => {
        trigger.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const targetElement = document.querySelector(targetId);
            const arrow = this.querySelector('.expand-arrow');

            if (targetElement) {
                const isOpen = targetElement.classList.contains('open');

                if (isOpen) {
                    targetElement.classList.remove('open');
                    this.classList.remove('open'); // For styling the header itself if needed
                    if (arrow) arrow.classList.remove('rotate-180'); // Use rotate class or direct transform
                } else {
                    targetElement.classList.add('open');
                    this.classList.add('open');
                    if (arrow) arrow.classList.add('rotate-180');
                }
            }
        });
    });

    // Optional: Expand All functionality
    // const expandAllButton = document.getElementById('expand-all-details');
    // if (expandAllButton) {
    //     expandAllButton.addEventListener('click', function() {
    //         triggers.forEach(trigger => {
    //             const targetId = trigger.getAttribute('data-target');
    //             const targetElement = document.querySelector(targetId);
    //             const arrow = trigger.querySelector('.expand-arrow');
    //             if (targetElement && !targetElement.classList.contains('open')) {
    //                  targetElement.classList.add('open');
    //                  trigger.classList.add('open');
    //                  if (arrow) arrow.classList.add('rotate-180');
    //             }
    //         });
    //     });
    // }
});
</script>
@endpush