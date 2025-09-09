{{-- resources/views/admin/menus/index.blade.php --}}
@extends('layouts.admin')
@section('title', 'Menu Management')

@section('content')
<section class="admin-content menu-index-page px-4 py-4 md:px-6 md:py-6">
    {{-- Header Row --}}
    <div class="dashboard-header-v3 mb-4">
        <div class="header-greeting">
            <h1 class="text-2xl md:text-3xl font-semibold text-[var(--primary-color)]">
                <i class="fas fa-list-ul fa-fw mr-2 text-[var(--accent-color)]"></i> Menu Manager
            </h1>
            <p class="text-gray-600 mt-1">Create, edit, reorder, and delete navigation links.</p>
        </div>
        <div class="header-quick-actions">
             {{-- Link to the create route --}}
             <a href="{{ route('admin.menus.create') }}" class="btn btn-primary shadow-md hover:shadow-lg">
                 <i class="fas fa-plus fa-fw mr-1"></i> Add New Menu Link
             </a>
        </div>
    </div>
    <hr class="mb-5">

    {{-- Session Status Messages --}}
    @if(session('status'))
        <div class="alert alert-success mb-4 p-3 rounded-md text-sm">{{ session('status') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">{{ session('error') }}</div>
    @endif

    {{-- Menu Links Table --}}
    <div class="widget-card menu-table-widget shadow-lg border border-gray-100 rounded-lg overflow-hidden">
         <div class="widget-header bg-white border-b border-gray-200 p-3 md:p-4">
             <h3 class="text-base font-medium text-gray-700"><i class="fas fa-bars fa-fw mr-2 text-gray-400"></i> Menu Links</h3>
         </div>
         <div class="widget-content p-0">
             <div class="overflow-x-auto">
                 <table class="menu-table min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200 bg-gray-50/50">
                            <th class="th-style-menus rounded-tl-md">Order</th>
                            <th class="th-style-menus">Title</th>
                            <th class="th-style-menus">URL</th>
                            <th class="th-style-menus">Target</th>
                            <th class="th-style-menus">Location</th>
                            <th class="th-style-menus text-center rounded-tr-md">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        {{-- Use $menuLinks from controller --}}
                        @forelse($menuLinks as $link)
                            <tr class="menu-table-row hover:bg-gray-50">
                                <td class="td-style-menus td-order">{{ $link->order }}</td>
                                <td class="td-style-menus td-title font-medium">{{ $link->title }}</td>
                                <td class="td-style-menus td-url">
                                    <a href="{{ $link->url }}" target="_blank" title="Visit Link: {{ $link->url }}" class="text-blue-600 hover:underline">
                                        {{ Str::limit($link->url, 40) }} <i class="fas fa-external-link-alt text-xs ml-1 opacity-60"></i>
                                    </a>
                                </td>
                                <td class="td-style-menus td-target"><span class="target-badge {{ $link->target === '_blank' ? 'blank' : 'self' }}">{{ $link->target }}</span></td>
                                <td class="td-style-menus td-location"><span class="location-badge {{ strtolower($link->location) }}">{{ ucfirst($link->location) }}</span></td>
                                <td class="td-style-menus td-actions text-center">
                                    {{-- Link to the edit route --}}
                                    <a href="{{ route('admin.menus.edit', $link) }}" class="action-btn edit" title="Edit Link">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    {{-- Form for the destroy route --}}
                                    <form action="{{ route('admin.menus.destroy', $link) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete menu link \'{{ $link->title }}\'?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="action-btn delete" title="Delete Link">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-gray-500 py-10">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-link-slash fa-3x mb-3 text-gray-400"></i>
                                        <span class="font-medium">No menu links created yet.</span>
                                         <a href="{{ route('admin.menus.create')}}" class="mt-2 text-sm text-blue-600 hover:underline">Add the first link?</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
             </div>
        </div>
    </div>
</section>
@endsection

{{-- Add CSS from previous steps for table styling --}}
@push('styles')
<style>
    /* Styles from your previous index.blade.php */
    .menu-table thead th.th-style-menus { background-color: #f8fafc; padding: 0.75rem 1rem; text-align: left; font-size: 0.7rem; font-weight: 600; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; border-bottom: 1px solid #e2e8f0; }
    .menu-table td.td-style-menus { padding: 0.75rem 1rem; font-size: 0.875rem; color: #2c3e50; vertical-align: middle; white-space: nowrap; }
    .menu-table td.td-order { text-align: center; width: 60px; color: #64748b; font-weight: 500; }
    .menu-table td.td-actions { width: 100px; }
    .menu-table .target-badge { padding: 0.2em 0.6em; font-size: 0.75rem; font-weight: 500; border-radius: 0.25rem; white-space: nowrap; border: 1px solid; display: inline-block; }
    .menu-table .target-badge.self { background-color: #eef2ff; color: #4f46e5; border-color: #c7d2fe; } /* Indigo */
    .menu-table .target-badge.blank { background-color: #fef9c3; color: #ca8a04; border-color: #fde68a; } /* Amber */
    .menu-table .location-badge { padding: 0.2em 0.6em; font-size: 0.75rem; font-weight: 500; border-radius: 0.25rem; white-space: nowrap; border: 1px solid; display: inline-block; }
    .menu-table .location-badge.header { background-color: #e0f2fe; color: #0284c7; border-color: #bae6fd;} /* Sky */
    .menu-table .location-badge.secondary { background-color: #f0fdf4; color: #16a34a; border-color: #bbf7d0;} /* Green */
    .menu-table .location-badge.footer { background-color: #f3f4f6; color: #4b5563; border-color: #d1d5db;} /* Gray */
    .action-btn { background: none; border: none; padding: 0.4rem; margin: 0 0.15rem; cursor: pointer; border-radius: 4px; transition: color 0.2s ease, background-color 0.2s ease; font-size: 0.9rem; line-height: 1; }
    .action-btn.edit { color: #6366f1; } .action-btn.edit:hover { background-color: #e0e7ff; color: #4f46e5; }
    .action-btn.delete { color: #9ca3af; } .action-btn.delete:hover { background-color: #fee2e2; color: #ef4444; }
    .alert { border: 1px solid transparent; }
    .alert-success { background-color: #d1fae5; border-color: #a7f3d0; color: #065f46; }
    .alert-danger { background-color: #fee2e2; border-color: #fecaca; color: #991b1b; }
</style>
@endpush