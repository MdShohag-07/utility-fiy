{{-- resources/views/admin/billing/index.blade.php --}}
@extends('layouts.admin') {{-- Use your admin layout --}}

@section('title', 'Billing Management')

@section('content')
<section class="admin-content billing-index-page"> {{-- Add specific class if needed --}}

    {{-- Header Row (Similar to Dashboard) --}}
    <div class="dashboard-header-v3 mb-4"> {{-- Reuse header style --}}
        <div class="header-greeting">
            <h1>Billing Manager</h1>
            <p>Overview of billing activity and management tools.</p>
        </div>
        {{-- Optional: Add relevant quick actions here if needed --}}
        {{-- <div class="header-quick-actions">
            <a href="#" class="btn btn-sm btn-success"><i class="fas fa-file-invoice fa-fw"></i> Create Invoice</a>
        </div> --}}
    </div>

    {{-- Quick Stats Row (Using the same style as dashboard) --}}
    <div class="quick-stats-row mb-5">
        <div class="mini-stat-card bg-info text-white"> {{-- Example with background color --}}
            <i class="fas fa-dollar-sign"></i>
            <span class="number">${{ number_format($billingData['total_revenue_month'] ?? 0, 2) }}</span>
            <span class="label">Revenue (This Month)</span>
            {{-- <a href="#" class="card-link-overlay" title="View Revenue Details"></a> --}}
        </div>
        <div class="mini-stat-card bg-warning text-dark"> {{-- Example with background color --}}
            <i class="fas fa-clock"></i>
            <span class="number">{{ $billingData['pending_payments'] ?? 0 }}</span>
            <span class="label">Pending Payments</span>
            {{-- <a href="#" class="card-link-overlay" title="View Pending Payments"></a> --}}
        </div>
        <div class="mini-stat-card bg-danger text-white"> {{-- Example with background color --}}
            <i class="fas fa-exclamation-circle"></i>
            <span class="number">{{ $billingData['overdue_accounts'] ?? 0 }}</span>
            <span class="label">Overdue Accounts</span>
            {{-- <a href="#" class="card-link-overlay" title="View Overdue Accounts"></a> --}}
        </div>
    </div>

    {{-- Main Content Card (for table, filters, etc.) --}}
    <div class="widget-card"> {{-- Reuse widget card style --}}
        <div class="widget-header">
            <h3><i class="fas fa-list-alt fa-fw"></i> Billing History / Transactions</h3>
             {{-- Optional: Add search/filter form here --}}
        </div>
        <div class="widget-content">
            <p class="text-center text-muted py-5">
                Billing transaction table or other management tools will be implemented here.
            </p>
            {{-- TODO: Add table to display invoices or transactions --}}
            {{-- Example:
            <table class="table table-striped">
                <thead><tr><th>Invoice ID</th><th>User</th><th>Amount</th><th>Status</th><th>Date</th><th>Actions</th></tr></thead>
                <tbody>
                    <tr><td colspan="6">No transactions found.</td></tr>
                </tbody>
            </table>
            --}}
        </div>
         {{-- Optional: Add pagination if using a table --}}
         {{-- <div class="widget-footer">
             Pagination Links Here
         </div> --}}
    </div>

</section>
@endsection

@push('styles')
{{-- Add specific styles if the admin CSS doesn't cover everything --}}
<style>
    /* Ensure mini-stat-card styles from dashboard CSS are applied */
    /* Example overrides or additions if needed: */
    .quick-stats-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }
    .mini-stat-card {
        padding: 1.25rem;
        border-radius: var(--border-radius, 8px);
        position: relative;
        color: #fff; /* Default text color for colored cards */
        box-shadow: var(--box-shadow-light);
        transition: transform 0.2s ease;
    }
    .mini-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: var(--box-shadow-medium);
    }
    .mini-stat-card i {
        font-size: 2.5rem;
        opacity: 0.6;
        position: absolute;
        right: 1rem;
        top: 50%;
        transform: translateY(-50%);
    }
    .mini-stat-card .number {
        font-size: 1.8rem;
        font-weight: 600;
        display: block;
        margin-bottom: 0.25rem;
    }
    .mini-stat-card .label {
        font-size: 0.9rem;
        display: block;
    }
    /* Specific background colors (examples) */
    .mini-stat-card.bg-info { background-color: var(--accent-color, #00a9e0); }
    .mini-stat-card.bg-warning { background-color: #ffc107; color: #333; } /* Example warning color */
    .mini-stat-card.bg-danger { background-color: var(--danger-color, #e74c3c); }

    /* Ensure widget-card styles from dashboard CSS are applied */
    .widget-card { background-color: #fff; border-radius: var(--border-radius, 8px); margin-bottom: 1.5rem; box-shadow: var(--box-shadow-light); border: 1px solid #eee; margin-top: 20px;}
    .widget-header { padding: 0.75rem 1.25rem; background-color: #f8f9fa; border-bottom: 1px solid #eee; display: flex; justify-content: space-between; align-items: center; border-top-left-radius: var(--border-radius, 8px); border-top-right-radius: var(--border-radius, 8px); }
    .widget-header h3 { margin-bottom: 0; font-size: 1.1rem; font-weight: 600; color: var(--dark-color); }
    .widget-content { padding: 1.25rem; }
    .widget-footer { padding: 0.75rem 1.25rem; background-color: #f8f9fa; border-top: 1px solid #eee; border-bottom-left-radius: var(--border-radius, 8px); border-bottom-right-radius: var(--border-radius, 8px); }
</style>
@endpush