@extends('layouts.admin')
@section('title', 'Statement #'.$statement->id)

@section('content')
<section class="admin-content px-4 py-4 md:px-6 md:py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl md:text-2xl font-semibold text-gray-700">
            Statement Details: #{{ $statement->id }}
        </h1>
        <a href="{{ route('admin.statements.index') }}" class="btn btn-secondary text-sm">
            <i class="fas fa-arrow-left fa-fw mr-1"></i> Back to List
        </a>
    </div>
    <hr class="mb-5">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Left Column: Statement Info --}}
        <div class="md:col-span-2 widget-card shadow-md border rounded-lg">
            <div class="widget-header bg-gray-50 p-4 border-b">
                <h3 class="text-lg font-medium">Statement for {{ $statement->user->display_name ?? 'N/A' }}</h3>
            </div>
            <div class="widget-content p-6 space-y-4">
                <p><strong>Statement Date:</strong> {{ $statement->formatted_statement_date }}</p>
                <p><strong>Due Date:</strong> {{ $statement->formatted_due_date }}</p>
                <p><strong>Status:</strong> <span class="badge badge-{{ $statement->status === 'paid' ? 'success' : 'warning' }}">{{ ucfirst($statement->status) }}</span></p>
                <p><strong>Total Amount:</strong> <span class="font-semibold text-xl">${{ number_format($statement->total_amount, 2) }}</span></p>

                <h4 class="text-md font-semibold pt-4 border-t mt-4">Line Items:</h4>
                @if($statement->items->isNotEmpty())
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="p-2 text-left">Description</th>
                                <th class="p-2 text-right">Qty</th>
                                <th class="p-2 text-right">Unit Price</th>
                                <th class="p-2 text-right">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($statement->items as $item)
                            <tr class="border-b">
                                <td class="p-2">{{ $item->description }}</td>
                                <td class="p-2 text-right">{{ $item->quantity }}</td>
                                <td class="p-2 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="p-2 text-right font-medium">${{ number_format($item->amount, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="font-semibold bg-gray-50">
                                <td colspan="3" class="p-2 text-right">Total:</td>
                                <td class="p-2 text-right">${{ number_format($statement->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <p class="text-gray-500">No line items for this statement.</p>
                @endif
            </div>
             <div class="widget-footer p-4 bg-gray-50 border-t text-right">
                <a href="{{ route('admin.statements.downloadPdf', $statement->id) }}" class="btn btn-primary">
                    <i class="fas fa-file-pdf mr-1"></i> Download PDF
                </a>
            </div>
        </div>

        {{-- Right Column: User Info --}}
        <div class="md:col-span-1 widget-card shadow-md border rounded-lg">
            <div class="widget-header bg-gray-50 p-4 border-b">
                <h3 class="text-lg font-medium">User Information</h3>
            </div>
            <div class="widget-content p-6 space-y-2">
                <p><strong>Name:</strong> {{ $statement->user->display_name ?? 'N/A' }}</p>
                <p><strong>Email:</strong> {{ $statement->user->email ?? 'N/A' }}</p>
                <p><strong>Account #:</strong> {{ $statement->user->account_number ?? 'N/A' }}</p>
                @if($statement->user->address)
                <p><strong>Address:</strong><br>
                    {{ $statement->user->address }}<br>
                    {{ $statement->user->city }}, {{ $statement->user->state }} {{ $statement->user->zip_code }}
                </p>
                @endif
                <div class="pt-3">
                     <a href="{{ route('admin.users.edit', $statement->user->id) }}" class="text-blue-600 hover:underline text-sm">
                        View/Edit User Profile <i class="fas fa-external-link-alt fa-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection