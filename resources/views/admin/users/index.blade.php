{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<section class="admin-content user-index-page px-4 py-4 md:px-6 md:py-6">

    {{-- Header Row --}}
    <div class="dashboard-header-v3 mb-4">
        <div class="header-greeting">
            <h1 class="text-2xl md:text-3xl font-semibold text-[var(--primary-color)] flex items-center gap-2">
                <i class="fas fa-users-cog text-[var(--accent-color)]"></i> User Management
            </h1>
            <p class="text-gray-600 mt-1">Add, view, edit, and delete user accounts.</p>
        </div>
        <div class="header-quick-actions">
             <a href="{{ route('admin.users.create') }}" class="btn btn-primary shadow-md hover:shadow-lg">
                 <i class="fas fa-user-plus fa-fw mr-1"></i> Add New User
             </a>
        </div>
    </div>
    <hr class="mb-5">

    {{-- Session Status Messages --}}
    @if(session('status')) <div class="alert alert-success mb-4 p-3 rounded-md text-sm">{{ session('status') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">{{ session('error') }}</div> @endif

    {{-- Quick Stats Row --}}
    <div class="quick-stats-row-billing mb-6">
        {{-- Card 1: Total Users --}}
        <div class="mini-stat-card-billing stat-blue"> {{-- Specific color class --}}
            <div class="stat-content">
                <span class="number">{{ $totalUserCount ?? 'N/A' }}</span>
                <span class="label">Total Users</span>
            </div>
            <div class="stat-icon"><i class="fas fa-users"></i></div>
        </div>
        {{-- Card 2: Admin Users --}}
        <div class="mini-stat-card-billing stat-purple"> {{-- Specific color class --}}
            <div class="stat-content">
                 <span class="number">{{ $adminCount ?? 'N/A' }}</span>
                 <span class="label">Administrators</span>
            </div>
             <div class="stat-icon"><i class="fas fa-user-shield"></i></div>
        </div>
        {{-- Card 3: Regular Users --}}
        <div class="mini-stat-card-billing stat-green"> {{-- Specific color class --}}
             <div class="stat-content">
                <span class="number">{{ $regularUserCount ?? 'N/A' }}</span>
                <span class="label">Regular Users</span>
            </div>
             <div class="stat-icon"><i class="fas fa-user"></i></div>
        </div>
    </div>

    {{-- User Table Card --}}
    <div class="widget-card user-table-widget shadow-lg border border-gray-100 rounded-lg overflow-hidden">
         <div class="widget-header bg-white border-b border-gray-200">
             <h3 class="text-base font-medium text-gray-700"><i class="fas fa-list-ul fa-fw mr-2 text-gray-400"></i> Registered Users</h3>
              {{-- Optional: Add Filters/Search Form Here --}}
         </div>
         <div class="widget-content p-0">
             <div class="overflow-x-auto">
                 <table class="user-table min-w-full" style="border-collapse: separate; border-spacing: 0;">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50/50">
                            {{-- Include all requested columns --}}
                            <th class="th-style-users rounded-tl-md">ID</th>
                            <th class="th-style-users">First Name</th>
                            <th class="th-style-users">Last Name</th>
                            <th class="th-style-users">Username</th>
                            <th class="th-style-users">Email</th>
                            <th class="th-style-users">Role</th>
                            <th class="th-style-users">Phone</th>
                            <th class="th-style-users">City</th>
                            <th class="th-style-users">State</th>
                            {{-- Address and Zip might make table too wide - consider showing on Edit/Show page only --}}
                            {{-- <th class="th-style-users">Address</th> --}}
                            {{-- <th class="th-style-users">Zip</th> --}}
                            <th class="th-style-users text-center rounded-tr-md">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($users as $user)
                            <tr class="user-table-row">
                                <td class="td-style-users td-id">{{ $user->id }}</td>
                                <td class="td-style-users">{{ $user->first_name }}</td>
                                <td class="td-style-users">{{ $user->last_name }}</td>
                                <td class="td-style-users td-username">{{ $user->username }}</td>
                                <td class="td-style-users td-email"><a href="mailto:{{ $user->email }}" title="Email {{ $user->first_name }}">{{ $user->email }}</a></td>
                                <td class="td-style-users td-role">
                                    @if($user->role == 'admin')
                                        <span class="role-badge admin">{{ ucfirst($user->role) }}</span>
                                    @else
                                        <span class="role-badge user">{{ ucfirst($user->role) }}</span>
                                    @endif
                                </td>
                                <td class="td-style-users">{{ $user->phone_number ?? '--' }}</td>
                                <td class="td-style-users">{{ $user->city ?? '--' }}</td>
                                <td class="td-style-users">{{ $user->state ?? '--' }}</td>
                                {{-- <td class="td-style-users">{{ $user->address ?? '--' }}</td> --}}
                                {{-- <td class="td-style-users">{{ $user->zip_code ?? '--' }}</td> --}}
                                <td class="td-style-users td-actions text-center">
                                     <a href="{{ route('admin.users.edit', $user) }}" class="action-btn edit" title="Edit User">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    {{-- Prevent deleting self --}}
                                    @if(Auth::id() !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete user {{ $user->username }} permanently?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="action-btn delete" title="Delete User">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                     @else
                                         {{-- Optionally disable delete button for self --}}
                                         <button type="button" class="action-btn delete" title="Cannot delete yourself" disabled style="opacity: 0.3; cursor: not-allowed;">
                                             <i class="fas fa-trash-alt"></i>
                                         </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-gray-500 py-10"> {{-- Adjust colspan --}}
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-users-slash fa-3x mb-3 text-gray-400"></i>
                                        <span class="font-medium">No users found.</span>
                                         <a href="{{ route('admin.users.create')}}" class="mt-2 text-sm text-blue-600 hover:underline">Add the first user?</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
             </div>
        </div>
        {{-- Pagination Links --}}
         @if ($users->hasPages())
            <div class="widget-footer bg-gray-50 p-3 border-t border-gray-200">
                {{ $users->links() }}
            </div>
         @endif
    </div>

</section>
@endsection

@push('styles')
{{-- Styles for User Page specific elements --}}
<style>
    /* Ensure base styles for layout, buttons, alerts are in app.css */
    /* Ensure CSS variables like --primary-color etc. are defined */

    /* Stats Card Styles (from previous step - ensure they are in app.css or here) */
    .quick-stats-row-billing { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; }
    .mini-stat-card-billing { border-radius: var(--border-radius, 8px); padding: 1.5rem; position: relative; overflow: hidden; color: #fff; box-shadow: var(--box-shadow-light); transition: all 0.3s ease; display: flex; justify-content: space-between; align-items: center; }
    .mini-stat-card-billing:hover { transform: translateY(-4px); box-shadow: var(--box-shadow-medium); }
    .mini-stat-card-billing .stat-content {}
    .mini-stat-card-billing .number { font-size: 2rem; font-weight: 700; display: block; line-height: 1; margin-bottom: 0.35rem; }
    .mini-stat-card-billing .label { font-size: 0.9rem; display: block; opacity: 0.9; }
    .mini-stat-card-billing .stat-icon i { font-size: 3.5rem; opacity: 0.2; }
    /* Define specific colors for user stats */
    .mini-stat-card-billing.stat-blue { background-color: var(--primary-color, #005eb8); }
    .mini-stat-card-billing.stat-purple { background-color: #6f42c1; } /* Example purple */
    .mini-stat-card-billing.stat-green { background-color: var(--secondary-color, #8dc63f); }


    /* Refined User Table Styles */
    .user-table-widget .widget-header { background-color: #fff; }
    .user-table { border-collapse: separate; border-spacing: 0; width: 100%; }
    .user-table thead th.th-style-users { background-color: #f8fafc; padding: 0.75rem 1rem; text-align: left; font-size: 0.7rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0; }
    .user-table thead th.th-style-users:first-child { border-top-left-radius: var(--border-radius, 6px); }
    .user-table thead th.th-style-users:last-child { border-top-right-radius: var(--border-radius, 6px); }
    .user-table tbody tr.user-table-row { border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s ease-in-out; }
    .user-table tbody tr.user-table-row:last-child { border-bottom: 0; }
    .user-table tbody tr.user-table-row:hover { background-color: #f8fafc; }
    .user-table td.td-style-users { padding: 0.75rem 1rem; font-size: 0.875rem; color: var(--dark-color, #2c3e50); vertical-align: middle; white-space: nowrap; }
    .user-table td.td-id { color: var(--medium-gray); font-weight: 500; }
    .user-table td.td-email a { color: var(--primary-color); font-size: 0.85rem; }
    .user-table td.td-email a:hover { color: var(--secondary-color); }
    .user-table .td-role .role-badge { padding: 0.2em 0.6em; font-size: 0.75rem; font-weight: 500; border-radius: 0.25rem; white-space: nowrap; }
    .user-table .td-role .role-badge.admin { background-color: #e7f3fe; color: #3b82f6; border: 1px solid #bfdbfe; }
    .user-table .td-role .role-badge.user { background-color: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; }
    .user-table .td-actions { min-width: 100px; }

    /* Refined Action Buttons */
    .action-btn { background: none; border: none; padding: 0.4rem; margin: 0 0.15rem; cursor: pointer; border-radius: 4px; transition: color 0.2s ease, background-color 0.2s ease; font-size: 0.9rem; line-height: 1; }
    .action-btn.edit { color: #6366f1; } .action-btn.edit:hover { background-color: #e0e7ff; color: #4f46e5; } /* Indigo */
    .action-btn.delete { color: #9ca3af; } .action-btn.delete:hover { background-color: #fee2e2; color: #ef4444; } /* Red */

</style>
@endpush