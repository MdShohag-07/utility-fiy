@extends('layouts.user_dashboard') {{-- Or your user dashboard layout --}}
@section('title', 'Billing Statements')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-semibold mb-6">Billing Statements</h1>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('error') }}
        </div>
    @endif

    {{-- Current Statement Section --}}
    <section class="mb-10">
        <h2 class="text-2xl font-medium mb-4">Current Statement</h2>
        @if ($currentStatement)
            <div class="bg-white shadow-md rounded-lg p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <p class="text-lg font-semibold">
                            Statement for {{ $currentStatement->formatted_statement_date }}
                        </p>
                        <p class="text-sm text-gray-600">
                            Due Date: {{ $currentStatement->formatted_due_date }}
                        </p>
                        <p class="text-lg font-semibold mt-1">
                            Amount Due: ${{ number_format($currentStatement->total_amount, 2) }}
                        </p>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        {{-- Ensure route name is correct for user download --}}
                        <a href="{{ route('my-account.billing.statement.downloadPdf', $currentStatement->id) }}"
                           class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-150 ease-in-out">
                            Download PDF
                        </a>
                    </div>
                </div>
            </div>
        @else
            <div class="bg-gray-100 border border-gray-300 text-gray-700 px-4 py-3 rounded">
                No current statement available.
            </div>
        @endif
    </section>

    {{-- Past Statements Section --}}
    <section>
        <h2 class="text-2xl font-medium mb-4">Past Statements</h2>
        @if ($pastStatements->isNotEmpty())
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Statement Date
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Due Date
                            </th>
                             <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Amount
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pastStatements as $statement)
                            <tr>
                                <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                    {{ $statement->formatted_statement_date }}
                                </td>
                                <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                    {{ $statement->formatted_due_date }}
                                </td>
                                <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                    ${{ number_format($statement->total_amount, 2) }}
                                </td>
                                <td class="px-5 py-4 border-b border-gray-200 bg-white text-sm">
                                    <a href="{{ route('my-account.billing.statement.downloadPdf', $statement->id) }}"
                                       class="text-indigo-600 hover:text-indigo-900 font-medium">
                                        Download
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $pastStatements->links() }}
            </div>
        @else
            <div class="bg-gray-100 border border-gray-300 text-gray-700 px-4 py-3 rounded">
                No past statements found.
            </div>
        @endif
    </section>
</div>
@endsection