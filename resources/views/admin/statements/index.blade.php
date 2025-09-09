@extends('layouts.admin') {{-- Your admin layout --}}
@section('title', 'Manage Statements')

@section('content')
<section class="admin-content px-4 py-4 md:px-6 md:py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl md:text-2xl font-semibold text-gray-700">
            <i class="fas fa-file-invoice-dollar fa-fw mr-2 text-blue-500"></i> Manage Statements
        </h1>
        <a href="{{ route('admin.statements.create') }}" class="btn btn-primary text-sm">
            <i class="fas fa-plus fa-fw mr-1"></i> Create New Statement
        </a>
    </div>
    <hr class="mb-5">

    @if(session('status')) <div class="alert alert-success mb-4 p-3 rounded-md text-sm">{{ session('status') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">{{ session('error') }}</div> @endif

    {{-- Quick Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="widget-stat">
            <div class="stat-icon bg-blue-500"><i class="fas fa-file-alt"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $statements->total() }}</div>
                <div class="stat-label">Total Statements</div>
            </div>
        </div>
        <div class="widget-stat">
            <div class="stat-icon bg-green-500"><i class="fas fa-users"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $usersWithStatementsCount ?? 0 }}</div>
                <div class="stat-label">Users with Statements</div>
            </div>
        </div>
        <div class="widget-stat">
            <div class="stat-icon bg-yellow-500"><i class="fas fa-calendar-alt"></i></div>
            <div class="stat-info">
                <div class="stat-number">{{ $latestStatDateFormatted ?? 'N/A' }}</div>
                <div class="stat-label">Latest Statement Date</div>
            </div>
        </div>
    </div>


    <div class="widget-card shadow-md border border-gray-100 rounded-lg overflow-hidden">
        <div class="widget-header bg-gray-50 border-b border-gray-200 p-3 md:p-4">
            <h3 class="text-base font-medium text-gray-700">All Statements</h3>
        </div>
        <div class="widget-content bg-white p-0">
            @if($statements->isEmpty())
                <p class="p-4 text-gray-600">No statements found.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statement Date</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Amount</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($statements as $statement)
                            <tr>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">#{{ $statement->id }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                                    @if($statement->user)
                                        <a href="{{ route('admin.users.edit', $statement->user->id) }}" class="text-blue-600 hover:underline">
                                            {{ $statement->user->display_name }}
                                        </a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $statement->formatted_statement_date }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $statement->formatted_due_date }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 font-medium">${{ number_format($statement->total_amount, 2) }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm">
                                    <span class="badge badge-{{ $statement->status === 'paid' ? 'success' : ($statement->status === 'overdue' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($statement->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('admin.statements.show', $statement->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-2" title="View"><i class="fas fa-eye"></i></a>
                                    <a href="{{ route('admin.statements.downloadPdf', $statement->id) }}" class="text-green-600 hover:text-green-900 mr-2" title="Download PDF"><i class="fas fa-file-pdf"></i></a>
                                    {{-- <a href="{{ route('admin.statements.edit', $statement->id) }}" class="text-yellow-600 hover:text-yellow-900 mr-2" title="Edit"><i class="fas fa-edit"></i></a> --}}
                                    <form action="{{ route('admin.statements.destroy', $statement->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this statement?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" title="Delete"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                 <div class="p-4 bg-gray-50 border-t">
                    {{ $statements->links() }}
                </div>
            @endif
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .widget-stat { background-color: white; padding: 1.25rem; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px 0 rgba(0,0,0,.06); display: flex; align-items: center; }
    .stat-icon { width: 3rem; height: 3rem; border-radius: 9999px; display: flex; align-items: center; justify-content: center; color: white; margin-right: 1rem; font-size: 1.25rem; }
    .stat-number { font-size: 1.5rem; font-weight: 600; color: #1f2937; }
    .stat-label { font-size: 0.875rem; color: #6b7280; }
    .badge { padding: 0.25em 0.6em; font-size: 75%; font-weight: 700; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: 0.25rem; }
    .badge-success { color: #059669; background-color: #d1fae5; }
    .badge-warning { color: #d97706; background-color: #fef3c7; }
    .badge-danger { color: #dc2626; background-color: #fee2e2; }
    .alert { border: 1px solid transparent; }
    .alert-danger { background-color: #fee2e2; border-color: #fecaca; color: #991b1b; }
    .alert-success { background-color: #d1fae5; border-color: #a7f3d0; color: #065f46; }
</style>
@endpush