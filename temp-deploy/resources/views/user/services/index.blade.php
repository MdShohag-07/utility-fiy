{{-- resources/views/user/services/index.blade.php --}}
@extends('layouts.app')

@section('title', 'My Services')

@section('content')
<div class="user-dashboard-layout user-services-page"> {{-- Main Layout Wrapper --}}

    {{-- === Desktop Sidebar === --}}
    @include('partials.user_dashboard_sidebar', ['active' => 'services'])

    {{-- === Main Content Area === --}}
    <main class="dashboard-main-content">

        {{-- Page Title --}}
        <h1 class="main-page-title">Services</h1> {{-- Use a consistent title class --}}

        {{-- Tab Navigation --}}
        <nav class="service-tabs-container mb-6">
            <ul class="service-tab-list">
                {{-- Tab Links with Data Attributes --}}
                <li><a href="#internet" data-tab-target="internet" class="service-tab-item {{ ($servicesData['internet']['active'] ?? false) ? 'active' : '' }}">Internet</a></li>
                <li><a href="#tv" data-tab-target="tv" class="service-tab-item {{ ($servicesData['tv']['active'] ?? false) ? 'active' : '' }}">TV/Streaming</a></li>
                <li><a href="#mobile" data-tab-target="mobile" class="service-tab-item {{ ($servicesData['mobile']['active'] ?? false) ? 'active' : '' }}">Mobile</a></li>
                <li><a href="#phone" data-tab-target="phone" class="service-tab-item {{ ($servicesData['phone']['active'] ?? false) ? 'active' : '' }}">Home Phone</a></li>
            </ul>
        </nav>

        {{-- Tab Content Panels --}}
        <div class="service-tab-content">

            {{-- Internet Content Panel --}}
            <div id="internet-content" class="tab-content-panel {{ ($servicesData['internet']['active'] ?? false) ? 'active' : '' }}" data-tab-content="internet">
                {{-- Status Check --}}
                <div class="service-card service-status-card mb-5">
                     <div class="status-indicator connected"><i class="fas fa-check-circle mr-1"></i> Your internet is connected.</div>
                     {{-- Other status examples:
                     <div class="status-indicator checking"><i class="fas fa-spinner fa-spin mr-1"></i> Checking Status...</div>
                     <div class="status-indicator error"><i class="fas fa-exclamation-triangle mr-1"></i> Service Unavailable</div>
                     --}}
                 </div>

                {{-- Sections using list structure --}}
                <div class="service-section">
                    <h2 class="service-section-title">Your Plan</h2>
                    <ul class="service-list">
                         <li> <a href="{{ $servicesData['internet']['planDetailsUrl'] ?? '#' }}" class="service-list-item prominent"> <div class="item-content"> <span class="item-title">{{ $servicesData['internet']['planName'] ?? 'N/A' }}</span> <span class="item-subtext">{{ $servicesData['internet']['planDetails'] ?? '' }}</span> </div> <span class="item-action-link">View Plan Details</span> </a> </li>
                    </ul>
                </div>

                 <div class="service-section">
                    <h2 class="service-section-title">Speed Test</h2>
                     <ul class="service-list">
                        <li> <a href="#" class="service-list-item"> <div class="item-content"> <span class="item-title">Check your internet performance.</span> </div> <span class="item-action-link">Run a Speed Test</span> </a> </li>
                     </ul>
                </div>

                 <div class="service-section">
                    <div class="service-section-header">
                         <h2 class="service-section-title">Your WiFi Networks ({{ $servicesData['internet']['wifiNetworksCount'] ?? 0 }})</h2>
                         <a href="{{ $servicesData['internet']['addEquipmentUrl'] ?? '#' }}" class="section-header-action"><i class="fas fa-plus mr-1"></i> Add Equipment</a>
                    </div>
                     <ul class="service-list">
                        <li> <a href="{{ $servicesData['internet']['modemUrl'] ?? '#' }}" class="service-list-item with-icon"> <i class="fas fa-hdd list-icon"></i> <div class="item-content"> <span class="item-title">Modem</span> <span class="item-subtext status-{{ strtolower($servicesData['internet']['modemStatus'] ?? 'unknown') }}">{{ $servicesData['internet']['modemStatus'] ?? 'Unknown' }}</span> </div> <i class="fas fa-chevron-right arrow"></i> </a> </li>
                         {{-- Add more equipment --}}
                    </ul>
                </div>

                 <div class="service-section">
                    <h2 class="service-section-title">Explore</h2>
                     <ul class="service-list compact"> {{-- Compact list --}}
                         @foreach($servicesData['internet']['exploreLinks'] ?? [] as $link)
                         <li> <a href="{{ $link['url'] ?? '#' }}" class="service-list-item"> <div class="item-content"> <span class="item-title">{{ $link['text'] ?? '' }}</span> <span class="item-subtext">{{ $link['subtext'] ?? '' }}</span> </div> <i class="fas fa-chevron-right arrow"></i> </a> </li>
                         @endforeach
                    </ul>
                </div>

                 <div class="service-section">
                    <h2 class="service-section-title">Internet Support</h2>
                     <ul class="service-list plain"> {{-- Plain links --}}
                        @foreach($servicesData['internet']['supportLinks'] ?? [] as $link)
                        <li> <a href="{{ $link['url'] ?? '#' }}" class="support-link">{{ $link['text'] ?? '' }}</a> </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            {{-- TV/Streaming Content Panel --}}
            <div id="tv-content" class="tab-content-panel {{ ($servicesData['tv']['active'] ?? false) ? 'active' : '' }}" data-tab-content="tv">
                 <div class="service-card p-6"> <h2 class="text-lg font-semibold mb-2">TV/Streaming</h2> <p>TV details for plan '{{ $servicesData['tv']['planName'] ?? 'N/A' }}' go here...</p> </div>
            </div>

            {{-- Mobile Content Panel --}}
            <div id="mobile-content" class="tab-content-panel {{ ($servicesData['mobile']['active'] ?? false) ? 'active' : '' }}" data-tab-content="mobile">
                 <div class="service-card p-6"> <h2 class="text-lg font-semibold mb-2">Mobile</h2> <p>Mobile service details go here...</p> </div>
            </div>

            {{-- Home Phone Content Panel --}}
            <div id="phone-content" class="tab-content-panel {{ ($servicesData['phone']['active'] ?? false) ? 'active' : '' }}" data-tab-content="phone">
                 <div class="service-card p-6"> <h2 class="text-lg font-semibold mb-2">Home Phone</h2> <p>Home Phone service details go here...</p> </div>
            </div>

        </div> {{-- End Service Tab Content --}}

    </main> {{-- End Main Content --}}

    {{-- === Mobile Bottom Navigation === --}}
    @include('partials.user_mobile_nav', ['active' => 'services']) {{-- Mark 'services' active --}}

    {{-- PDF Modal (Keep if statement functionality links here) --}}
    {{-- <div id="pdf-modal-overlay" class="pdf-modal-overlay hidden"> ... </div> --}}

</div> {{-- End Layout Wrapper --}}
@endsection

{{-- ========================================= --}}
{{-- Styles Section --}}
{{-- ========================================= --}}
@push('styles')
<style>
    /* Ensure base variables/buttons/layout styles are in app.css */

    /* --- Services Page Specific Styles --- */
    .main-page-title { font-size: 1.5rem; font-weight: 600; color: var(--dark-color); margin-bottom: 1rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--border-color, #eee); }
    .service-tabs-container { border-bottom: 2px solid var(--border-color, #e5e7eb); overflow-x: auto; white-space: nowrap; scrollbar-width: none; -ms-overflow-style: none; }
    .service-tabs-container::-webkit-scrollbar { display: none; }
    .service-tab-list { display: inline-flex; list-style: none; padding: 0; margin: 0 0 -2px 0; }
    .service-tab-item { padding: 0.75rem 1.25rem; border: 2px solid transparent; border-bottom: none; color: var(--medium-gray); font-weight: 500; font-size: 0.95rem; text-decoration: none; cursor: pointer; transition: color 0.2s ease, border-color 0.2s ease; position: relative; margin-right: 4px; }
    .service-tab-item:hover { color: var(--primary-color); }
    .service-tab-item.active { color: var(--primary-color); font-weight: 600; border-color: var(--border-color, #e5e7eb) var(--border-color, #e5e7eb) var(--white-color); border-top-left-radius: 6px; border-top-right-radius: 6px; background-color: var(--white-color); }
    .service-tab-item.active::after { content: ''; position: absolute; bottom: -2px; left: 0; right: 0; height: 2px; background-color: var(--primary-color); }
    .tab-content-panel { display: none; animation: fadeIn 0.3s ease-out; }
    .tab-content-panel.active { display: block; }
    @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
    .service-section { background-color: var(--white-color); border: 1px solid var(--border-color, #eee); border-radius: var(--border-radius); margin-bottom: 1.5rem; box-shadow: var(--box-shadow-light); padding: 15px; }
    .service-section-header { display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.25rem; border-bottom: 1px solid var(--border-color, #eee); }
    .service-section-title { font-size: 1.1rem; font-weight: 600; color: var(--dark-color); margin: 0; padding: 0; border: none; }
    .section-header-action { font-size: 0.85rem; font-weight: 500; color: var(--primary-color); }
    .section-header-action i { font-size: 0.75rem;}
    .service-list { list-style: none; padding: 0; margin: 0; }
    .service-list li:not(:last-child) .service-list-item { border-bottom: 1px solid #f3f4f6; }
    .service-list-item { display: flex; align-items: center; padding: 1rem 1.25rem; text-decoration: none; color: var(--dark-color); transition: background-color 0.2s ease; }
    .service-list-item:hover { background-color: #f9fafb; }
    .service-list-item .list-icon { font-size: 1.2rem; color: var(--primary-color); margin-right: 1rem; width: 25px; text-align: center; flex-shrink: 0; }
    .service-list-item .item-content { flex-grow: 1; }
    .service-list-item .item-title { display: block; font-weight: 500; font-size: 0.95rem; color: var(--dark-color); margin-bottom: 2px; line-height: 1.3; }
    .service-list-item .item-subtext { display: block; font-size: 0.85rem; color: var(--medium-gray); line-height: 1.3; }
    .service-list-item .arrow { font-size: 0.8rem; color: var(--medium-gray); margin-left: 1rem; }
    .service-list-item .item-action-link { font-size: 0.9rem; font-weight: 500; color: var(--primary-color); margin-left: 1rem; white-space: nowrap; }
    .service-list-item .item-action-link:hover { color: var(--secondary-color); }
    .service-list-item.prominent .item-title { font-size: 1.05rem; font-weight: 600; }
    .service-list.compact .service-list-item { padding-top: 0.75rem; padding-bottom: 0.75rem; }
    .service-list.plain { padding: 0.5rem 1.25rem; }
    .service-list.plain .service-list-item { padding: 0.4rem 0; border-bottom: none; }
    .service-list.plain .service-list-item:hover { background-color: transparent; }
    .support-link { font-size: 0.95rem; font-weight: 500; color: var(--primary-color); text-decoration: none; }
    .support-link:hover { color: var(--secondary-color); text-decoration: underline;}
    .status-active, .status-connected { color: var(--success-color, #198754); font-weight: 500; }
    .status-inactive, .status-not-active, .status-unknown { color: var(--medium-gray); }
    .status-error { color: var(--danger-color); }
    .service-card { background-color: #fff; border: 1px solid #eee; border-radius: var(--border-radius); padding: 1rem 1.25rem; box-shadow: var(--box-shadow-light); }
    .service-status-card { border-left: 4px solid; padding-left: 1rem; }
    .service-status-card .status-indicator { font-weight: 500; font-size: 0.95rem; display: flex; align-items: center; }
    .service-status-card.status-connected { border-left-color: var(--success-color);}
    .service-status-card.status-checking { border-left-color: var(--medium-gray);}
    .service-status-card.status-error { border-left-color: var(--danger-color);}
    .btn-link-styled { color: var(--primary-color); font-weight: 500; font-size: 0.9rem; text-decoration: none; }
    .btn-link-styled:hover { text-decoration: underline; color: var(--secondary-color); }
    .billing-content-grid { display: flex; flex-direction: column; gap: 1.5rem; }
    @media (min-width: 768px) { .billing-content-grid { flex-direction: row; gap: 2rem; } }
    .billing-details-column { flex-grow: 1; display: flex; flex-direction: column; gap: 1.5rem; }
    .billing-ad-column { width: 100%; flex-shrink: 0; }
    @media (min-width: 768px) { .billing-ad-column { width: 300px; } }
    .ad-banner-sidebar { background-color: var(--white-color); border: 1px solid var(--border-color, #eee); border-radius: var(--border-radius); padding: 1.5rem; box-shadow: var(--box-shadow-light); }
    .ad-banner-sidebar .ad-image img { max-width: 100%; height: auto; border-radius: 4px; margin-bottom: 1rem; }
    .ad-banner-sidebar .ad-text h3 { font-size: 1.1rem; color: var(--primary-color); margin-bottom: 0.5rem; }
    .ad-banner-sidebar .ad-text p { font-size: 0.9rem; margin-bottom: 1rem; color: var(--dark-color); line-height: 1.5; }
    .ad-banner-sidebar .ad-text .btn { display: block; width: 100%; text-align: center; margin-bottom: 0.75rem; }
    .ad-banner-sidebar .ad-text .ad-details-link { display: block; text-align: center; font-size: 0.85rem; color: var(--primary-color); text-decoration: underline; }

    /* === ADDED Mobile Bottom Nav Styles === */
    .mobile-bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; height: 60px; background-color: var(--white-color, #fff); border-top: 1px solid var(--border-color, #e5e7eb); box-shadow: 0 -2px 10px rgba(0,0,0,0.06); display: flex; justify-content: space-around; align-items: stretch; z-index: 900; }
    .mobile-nav-item { display: flex; flex-direction: column; align-items: center; justify-content: center; flex-grow: 1; text-decoration: none; color: var(--medium-gray); padding: 4px 0; font-size: 0.7rem; transition: color 0.2s ease; position: relative; }
    .mobile-nav-item i { font-size: 1.3rem; margin-bottom: 2px; }
    .mobile-nav-item span { line-height: 1.2; }
    .mobile-nav-item.active { color: var(--primary-color); font-weight: 500; }
    .mobile-nav-item.active::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background-color: var(--primary-color); border-bottom-left-radius: 2px; border-bottom-right-radius: 2px; }
    .mobile-nav-item:hover { color: var(--primary-color); }
    @media (min-width: 768px) { .mobile-bottom-nav.md\:hidden { display: none; } } /* Hide on medium+ screens */
    /* ===================================== */

    /* PDF Modal Styles (if used on this page) */
    .pdf-modal-overlay { /* ... */ }
    .pdf-modal-content { /* ... */ }
    .pdf-modal-close-button { /* ... */ }

</style>
@endpush

{{-- ... @push('scripts') ... --}}
@push('scripts')
{{-- JavaScript for Tab Switching --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('.service-tab-item[data-tab-target]');
        const tabContents = document.querySelectorAll('.tab-content-panel[data-tab-content]');

        if (tabs.length > 0 && tabContents.length > 0) {
            tabs.forEach(tab => {
                tab.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetContentId = tab.dataset.tabTarget;

                    // Update Content
                    tabContents.forEach(content => {
                        content.classList.toggle('active', content.dataset.tabContent === targetContentId);
                    });

                    // Update Tabs
                    tabs.forEach(t => {
                        t.classList.toggle('active', t.dataset.tabTarget === targetContentId);
                    });
                });
            });

            // Activate the first tab marked as active in HTML on initial load
             const initiallyActiveTab = document.querySelector('.service-tab-item.active');
             const initiallyActiveContent = document.querySelector('.tab-content-panel.active');
             if (!initiallyActiveTab && tabs.length > 0) {
                 // If no tab is marked active, activate the first one
                  tabs[0].classList.add('active');
                 const firstTarget = tabs[0].dataset.tabTarget;
                 document.querySelector(`.tab-content-panel[data-tab-content="${firstTarget}"]`)?.classList.add('active');
             } else if (initiallyActiveTab && !initiallyActiveContent) {
                 // If tab is active but content isn't, activate corresponding content
                  const targetContentId = initiallyActiveTab.dataset.tabTarget;
                  document.querySelector(`.tab-content-panel[data-tab-content="${targetContentId}"]`)?.classList.add('active');
             } else if (!initiallyActiveTab && initiallyActiveContent) {
                  // If content is active but tab isn't, activate corresponding tab
                   const targetTabId = initiallyActiveContent.dataset.tabContent;
                  document.querySelector(`.service-tab-item[data-tab-target="${targetTabId}"]`)?.classList.add('active');
             }
        }
    });
</script>

{{-- Add Modal JS again if needed --}}
{{-- <script defer> ... Modal JS ... </script> --}}
@endpush