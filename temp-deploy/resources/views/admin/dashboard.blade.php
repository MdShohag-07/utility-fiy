{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin') {{-- Use your main admin layout --}}

@section('title', 'Admin Dashboard')

@section('content')
{{-- Use padding classes directly on the section or a container div --}}
<section class="admin-content dashboard-page-v3 px-4 py-4 md:px-6 md:py-6" id="dashboard">

    {{-- Header Row --}}
    <div class="dashboard-header-v3 mb-4">
        <div class="header-greeting">
            <h1 class="text-2xl md:text-3xl font-semibold text-[var(--primary-color)]">
                <i class="fas fa-tachometer-alt fa-fw mr-2 text-[var(--accent-color)]"></i> Admin Dashboard
            </h1>
            <p class="text-gray-600 mt-1">Welcome back, {{ Auth::user()?->getFullNameAttribute() ?? Auth::user()?->name ?? 'Admin' }}! Overview of site activity.</p>
        </div>
        <div class="header-quick-actions">
             <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-user-plus fa-fw mr-1"></i> Add User</a>
             <a href="{{ route('admin.statements.create') }}" class="btn btn-sm btn-success"><i class="fas fa-upload fa-fw mr-1"></i> Upload Statement</a>
             {{-- *** CORRECTED ROUTE NAME FOR SETTINGS BUTTON *** --}}
             <a href="{{ route('admin.settings.general.edit') }}" class="btn btn-sm btn-secondary"><i class="fas fa-cog fa-fw mr-1"></i> Settings</a>
        </div>
    </div>
    <hr class="mb-5">

    {{-- Quick Stats Row - Using Billing Style Classes --}}
    <div class="quick-stats-row-billing mb-6">
         {{-- Card 1: Total Site Users - Blue --}}
        <div class="mini-stat-card-billing stat-blue">
            <div class="stat-content">
                <span class="number">{{ $userCount ?? 'N/A' }}</span>
                <span class="label">Site Users</span>
            </div>
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <a href="{{ route('admin.users.index') }}" class="card-link-overlay" title="Manage Users"></a>
        </div>
        {{-- Card 2: Total Statements - Cyan --}}
        <div class="mini-stat-card-billing stat-cyan">
            <div class="stat-content">
                <span class="number">{{ $statementCount ?? '0' }}</span>
                <span class="label">Statements</span>
            </div>
            <div class="stat-icon"><i class="fas fa-file-alt"></i></div>
            <a href="{{ route('admin.statements.index') }}" class="card-link-overlay" title="Manage Statements"></a>
        </div>
        {{-- Card 3: Menu Links - Green --}}
        <div class="mini-stat-card-billing stat-green">
            <div class="stat-content">
                <span class="number">{{ $menuLinkCount ?? '0' }}</span>
                <span class="label">Menu Links</span>
            </div>
            <div class="stat-icon"><i class="fas fa-link"></i></div>
             <a href="{{ route('admin.menus.index') }}" class="card-link-overlay" title="Manage Menus"></a>
        </div>
    </div>


    {{-- Main Grid Layout (1 Row, 4 Columns on Large Screens) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4"> {{-- 1 col default, 2 on medium, 4 on large --}}

        {{-- Item 1 (Col 1) - Account Summary --}}
        <div class="widget-card account-summary-widget shadow-md border border-gray-100 rounded-lg overflow-hidden">
            <div class="widget-header bg-white border-b border-gray-200">
                <h3 class="text-base font-medium text-gray-700"><i class="fas fa-user-circle fa-fw mr-2 text-gray-400"></i> Your Account</h3>
            </div>
            <div class="widget-content">
                <div class="summary-item"><span>Admin User:</span><strong>{{ Auth::user()?->getFullNameAttribute() ?? Auth::user()?->name ?? 'N/A' }}</strong></div>
                <div class="summary-item"><span>Email:</span><strong>{{ Auth::user()?->email ?? 'N/A' }}</strong></div>
                <div class="summary-item"><span>Joined:</span><strong>{{ Auth::user() ? Auth::user()->created_at->format('M d, Y') : 'N/A' }}</strong></div>
            </div>
             <div class="widget-footer bg-gray-50 p-3 border-t border-gray-200 flex justify-end">
                 <a href="{{ route('profile.edit') }}" class="btn btn-xs btn-outline-secondary">Edit Your Profile</a>
            </div>
        </div>

        {{-- Item 2 (Col 2) - System Notifications --}}
        <div class="widget-card notifications-widget shadow-md border border-gray-100 rounded-lg overflow-hidden">
             <div class="widget-header bg-white border-b border-gray-200">
                <h3 class="text-base font-medium text-gray-700"><i class="fas fa-bell fa-fw mr-2 text-gray-400"></i> System Notifications</h3>
                <span class="badge bg-blue-500 text-white text-xs px-2 py-0.5 rounded-full">3 New</span>
            </div>
             <div class="widget-content">
                <ul class="notification-list space-y-3">
                    {{-- Placeholders --}}
                    <li class="notification-item flex items-start gap-3 pb-2 border-b border-gray-100"> <i class="fas fa-exclamation-triangle icon warning text-yellow-500 mt-1"></i> <div class="notification-text flex-grow text-sm"> Database backup failed. Needs attention. <span class="time block text-xs text-gray-500">1 hour ago</span> </div> </li>
                    <li class="notification-item flex items-start gap-3 py-2 border-b border-gray-100"> <i class="fas fa-upload icon info text-blue-500 mt-1"></i> <div class="notification-text flex-grow text-sm"> 5 new statements successfully uploaded. <span class="time block text-xs text-gray-500">3 hours ago</span> </div> </li>
                    <li class="notification-item flex items-start gap-3 pt-2"> <i class="fas fa-user-check icon success text-green-500 mt-1"></i> <div class="notification-text flex-grow text-sm"> New admin 'Jane Doe' added. <span class="time block text-xs text-gray-500">1 day ago</span> </div> </li>
                 </ul>
             </div>
             <div class="widget-footer bg-gray-50 p-3 border-t border-gray-200 text-right">
                    <a href="#" class="text-sm text-blue-600 hover:underline">View All Notifications</a>
             </div>
         </div>

        {{-- Item 3 (Col 3) - Recent Activity --}}
        <div class="widget-card activity-widget shadow-md border border-gray-100 rounded-lg overflow-hidden">
             <div class="widget-header bg-white border-b border-gray-200">
                <h3 class="text-base font-medium text-gray-700"><i class="fas fa-history fa-fw mr-2 text-gray-400"></i> Recent Activity</h3>
             </div>
             <div class="widget-content">
                 <ul class="activity-list-enhanced space-y-3 max-h-72 overflow-y-auto pr-2">
                     {{-- Placeholders --}}
                     <li class="activity-item flex items-center gap-3"> <div class="activity-icon login bg-blue-100 text-blue-600"><i class="fa-solid fa-right-to-bracket"></i></div> <div class="activity-details flex-grow"> <p><strong>Admin User</strong> logged in.</p> <span class="activity-time text-xs text-gray-500">15 minutes ago</span> </div> </li>
                     <li class="activity-item flex items-center gap-3"> <div class="activity-icon user-add bg-green-100 text-green-600"><i class="fa-solid fa-user-plus"></i></div> <div class="activity-details flex-grow"> <p>New user <strong>Jane Doe</strong> was created.</p> <span class="activity-time text-xs text-gray-500">2 hours ago</span> </div> </li>
                     <li class="activity-item flex items-center gap-3"> <div class="activity-icon statement-upload bg-purple-100 text-purple-600"><i class="fa-solid fa-file-arrow-up"></i></div> <div class="activity-details flex-grow"> <p>Statement uploaded for <strong>John Smith</strong>.</p> <span class="activity-time text-xs text-gray-500">Yesterday</span> </div> </li>
                     <li class="activity-item flex items-center gap-3"> <div class="activity-icon settings-update bg-yellow-100 text-yellow-600"><i class="fa-solid fa-palette"></i></div> <div class="activity-details flex-grow"> <p>Header color updated.</p> <span class="activity-time text-xs text-gray-500">2 days ago</span> </div> </li>
                     <li class="activity-item flex items-center gap-3"> <div class="activity-icon login bg-blue-100 text-blue-600"><i class="fa-solid fa-right-to-bracket"></i></div> <div class="activity-details flex-grow"> <p><strong>Admin User</strong> logged in.</p> <span class="activity-time text-xs text-gray-500">3 days ago</span> </div> </li>
                 </ul>
             </div>
              <div class="widget-footer bg-gray-50 p-3 border-t border-gray-200 text-right"> <a href="#" class="text-sm text-blue-600 hover:underline">View Full Activity Log</a> </div>
        </div>

         {{-- Item 4 (Col 4) - User Registration Trends Graph --}}
        <div class="widget-card usage-graph-widget shadow-md border border-gray-100 rounded-lg overflow-hidden">
            <div class="widget-header bg-white border-b border-gray-200">
                <h3 class="text-base font-medium text-gray-700"><i class="fas fa-chart-line fa-fw mr-2 text-gray-400"></i> User Registration Trends</h3>
                <span class="timeframe text-sm text-gray-500">(Last 30 Days)</span>
            </div>
             <div class="widget-content">
                <div class="chart-container-v3 relative h-72">
                     <canvas id="userRegistrationChart"></canvas>
                      <div class="chart-placeholder-text-v3 absolute inset-0 flex items-center justify-center text-gray-500 text-lg bg-gray-50/50 rounded-b-lg" id="userRegistrationChartPlaceholder">
                        <i class="fas fa-spinner fa-spin mr-2"></i> Loading Chart Data...
                     </div>
                </div>
            </div>
         </div>

    </div> {{-- End Grid --}}

</section>
@endsection

{{-- Styles Section --}}
@push('styles')
<style>
    /* Chart Canvas Visibility */
    #userRegistrationChart { visibility: hidden; height: 100%; width: 100%; }
    #userRegistrationChart.chart-loaded { visibility: visible; }
    #userRegistrationChart.chart-loaded + #userRegistrationChartPlaceholder { display: none; }

    /* Ensure ALL required CSS rules for admin layout, cards, stats, lists etc. */
    /* are defined in resources/css/app.css */

    /* --- Fallback styles if not in app.css --- */
    .quick-stats-row-billing { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; }
    .mini-stat-card-billing { border-radius: var(--border-radius, 8px); padding: 1.5rem; position: relative; overflow: hidden; color: #fff; box-shadow: var(--box-shadow-light); transition: all 0.3s ease; display: flex; justify-content: space-between; align-items: center; }
    .mini-stat-card-billing:hover { transform: translateY(-4px); box-shadow: var(--box-shadow-medium); }
    .mini-stat-card-billing .stat-content {}
    .mini-stat-card-billing .number { font-size: 2rem; font-weight: 700; display: block; line-height: 1; margin-bottom: 0.35rem; }
    .mini-stat-card-billing .label { font-size: 0.9rem; display: block; opacity: 0.9; }
    .mini-stat-card-billing .stat-icon i { font-size: 3rem; opacity: 0.2; }
    .mini-stat-card-billing.stat-blue { background-color: var(--primary-color, #005eb8); }
    .mini-stat-card-billing.stat-cyan { background-color: var(--accent-color, #00a9e0); }
    .mini-stat-card-billing.stat-green { background-color: var(--secondary-color, #8dc63f); }
    .card-link-overlay { position: absolute; inset: 0; z-index: 1; }
    .widget-card { background-color: var(--white-color, #fff); border-radius: var(--border-radius, 8px); margin-bottom: 0; /* Rely on grid gap */ box-shadow: var(--box-shadow-light); border: 1px solid #e5e7eb; display: flex; flex-direction: column;}
    .widget-header { padding: 0.75rem 1.25rem; background-color: #f9fafb; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center; border-top-left-radius: var(--border-radius, 8px); border-top-right-radius: var(--border-radius, 8px); }
    .widget-header h3 { margin-bottom: 0; font-size: 0.95rem; font-weight: 600; color: var(--dark-color); display: flex; align-items: center; }
    .widget-header h3 i { margin-right: 0.5rem; color: #9ca3af; font-size: 0.9rem;}
    .widget-content { padding: 1.25rem; flex-grow: 1; }
    .widget-footer { padding: 0.75rem 1.25rem; background-color: #f9fafb; border-top: 1px solid #e5e7eb; border-bottom-left-radius: var(--border-radius, 8px); border-bottom-right-radius: var(--border-radius, 8px); text-align: right;}
    .account-summary-widget .summary-item { display: flex; justify-content: space-between; padding: 0.4rem 0; border-bottom: 1px dashed #e5e7eb; font-size: 0.9rem; }
    .account-summary-widget .summary-item:last-child { border-bottom: none; }
    .account-summary-widget .summary-item span { color: #6b7280; }
    .account-summary-widget .summary-item strong { color: #374151; font-weight: 500; }
    .account-summary-widget .widget-footer { display: flex; justify-content: flex-end; gap: 0.5rem;}
    .btn-xs { padding: 0.25rem 0.6rem; font-size: 0.75rem; }
    .btn-outline-secondary { border: 1px solid #d1d5db; color: #6b7280; background-color: white;} .btn-outline-secondary:hover { background-color: #f3f4f6; }
    .btn-outline-primary { border: 1px solid var(--primary-color); color: var(--primary-color); background-color: white;} .btn-outline-primary:hover { background-color: #eef2ff; }
    .badge { display: inline-block; padding: 0.3em 0.6em; font-size: 75%; font-weight: 700; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: 0.375rem;}
    .bg-blue-500 { background-color: #3b82f6; }
    .notification-list { list-style: none; padding: 0; margin: 0; }
    .notification-item { display: flex; align-items: flex-start; gap: 0.75rem; padding-bottom: 0.75rem; margin-bottom: 0.75rem; border-bottom: 1px solid #f3f4f6; }
    .notification-item:last-child { border-bottom: none; padding-bottom: 0; margin-bottom: 0;}
    .notification-item .icon { font-size: 1rem; margin-top: 3px; width: 20px; text-align: center; }
    .notification-item .icon.warning { color: #f59e0b; }
    .notification-item .icon.info { color: #3b82f6; }
    .notification-item .icon.success { color: #22c55e; }
    .notification-item .icon.default { color: #6b7280; }
    .notification-text { font-size: 0.9rem; color: var(--dark-color); line-height: 1.4; flex-grow: 1; }
    .notification-text .time { display: block; font-size: 0.75rem; color: #9ca3af; margin-top: 3px; }
    .activity-widget .widget-content { padding: 0; }
    .activity-list-enhanced { list-style: none; padding: 0.75rem 1.25rem; margin: 0; max-height: 300px; overflow-y: auto; }
    .activity-item { display: flex; align-items: center; gap: 1rem; padding-bottom: 0.75rem; margin-bottom: 0.75rem; border-bottom: 1px solid #f3f4f6; }
    .activity-item:last-child { border-bottom: none; padding-bottom: 0; margin-bottom: 0;}
    .activity-icon { width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 0.85rem; }
    .activity-icon.login { background-color: #e0f2fe; color: #0ea5e9; }
    .activity-icon.user-add { background-color: #dcfce7; color: #22c55e; }
    .activity-icon.statement-upload { background-color: #f3e8ff; color: #a855f7; }
    .activity-icon.settings-update { background-color: #fef9c3; color: #eab308; }
    .activity-details p { font-size: 0.875rem; color: var(--dark-color); line-height: 1.4; margin-bottom: 0.1rem;}
    .activity-details p strong { font-weight: 500; }
    .activity-time { font-size: 0.75rem; color: #9ca3af; }

</style>
@endpush

{{-- Scripts Section --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    // Chart.js placeholder code
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('userRegistrationChart');
        const placeholder = document.getElementById('userRegistrationChartPlaceholder');
        if (ctx && Chart) {
            const labels = Array.from({ length: 30 }, (_, i) => { const d = new Date(); d.setDate(d.getDate() - (29 - i)); return d.toLocaleDateString('en-US', { month: 'short', day: 'numeric' }); });
            const registrationData = Array.from({ length: 30 }, () => Math.floor(Math.random() * 10) + 1);
            setTimeout(() => { try { let existingChart = Chart.getChart(ctx); if (existingChart) { existingChart.destroy(); } new Chart(ctx, { type: 'line', data: { labels: labels, datasets: [{ label: 'New Users', data: registrationData, borderColor: 'rgba(52, 152, 219, 1)', backgroundColor: 'rgba(52, 152, 219, 0.1)', borderWidth: 2.5, fill: true, tension: 0.4, pointBackgroundColor: 'rgba(52, 152, 219, 1)', pointRadius: 4, pointHoverRadius: 6 }] }, options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true, ticks: { precision: 0 } }, x: { grid: { display: false } } }, plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false, backgroundColor: 'rgba(44, 62, 80, 0.9)', titleFont: { weight: 'bold' }, bodyFont: { size: 13 }, padding: 10, cornerRadius: 4 } }, interaction: { mode: 'nearest', axis: 'x', intersect: false } } }); ctx.classList.add('chart-loaded'); } catch (error) { console.error("Chart.js Error:", error); if(placeholder) placeholder.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Chart Error'; } }, 600);
        } else { console.error("Chart canvas or Chart.js library not found."); if(placeholder) placeholder.innerHTML = '<i class="fas fa-exclamation-triangle"></i> Chart Error'; }
    });
</script>
@endpush