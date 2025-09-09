{{-- resources/views/admin/statements/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Create New Statement')

@section('content')
<section class="admin-content px-4 py-4 md:px-6 md:py-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl md:text-2xl font-semibold text-gray-700">
            <i class="fas fa-file-invoice-dollar fa-fw mr-2 text-blue-500"></i> Create New Statement
        </h1>
        <a href="{{ route('admin.statements.index') }}" class="btn btn-secondary text-sm">
            <i class="fas fa-arrow-left fa-fw mr-1"></i> Back to Statements List
        </a>
    </div>
    <hr class="mb-5">

    @if ($errors->any())
        <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">
            <strong class="font-semibold">Creation Failed!</strong> Check the errors below.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if(session('status')) <div class="alert alert-success mb-4 p-3 rounded-md text-sm">{{ session('status') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">{{ session('error') }}</div> @endif

    <div class="widget-card shadow-md border border-gray-100 rounded-lg overflow-hidden">
        <div class="widget-header bg-gray-50 border-b border-gray-200 p-3 md:p-4">
            <h3 class="text-base font-medium text-gray-700">Statement Details</h3>
        </div>
        <form action="{{ route('admin.statements.store') }}" method="POST" class="widget-content bg-white p-4 md:p-6 space-y-4">
            @csrf

            {{-- User Selection (Multiple) --}}
            <div>
                <label for="user_ids" class="block text-sm font-medium text-gray-700 mb-1">Select User(s) <span class="text-red-500">*</span></label>
                <select name="user_ids[]" id="user_ids" class="form-select w-full rounded-md border-gray-300 shadow-sm" multiple required>
                    {{-- $usersForSelect should be passed from StatementController@create --}}
                    {{-- It should be an array like [id => 'Display Name', ...] --}}
                    @forelse($usersForSelect ?? [] as $id => $displayName)
                        <option value="{{ $id }}" {{ (is_array(old('user_ids')) && in_array($id, old('user_ids'))) ? 'selected' : '' }}>
                            {{ $displayName }}
                        </option>
                    @empty
                        <option value="" disabled>No users available.</option>
                    @endforelse
                </select>
                @error('user_ids') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('user_ids.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Statement Date & Due Date --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="statement_date" class="block text-sm font-medium text-gray-700 mb-1">Statement Date <span class="text-red-500">*</span></label>
                    <input type="date" name="statement_date" id="statement_date" value="{{ old('statement_date', now()->format('Y-m-d')) }}" class="form-input" required>
                    @error('statement_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="due_date" class="block text-sm font-medium text-gray-700 mb-1">Due Date <span class="text-red-500">*</span></label>
                    <input type="date" name="due_date" id="due_date" value="{{ old('due_date', now()->addDays(14)->format('Y-m-d')) }}" class="form-input" required>
                    @error('due_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Line Items Section --}}
            <div class="border-t border-gray-200 pt-4 mt-4">
                <div class="flex justify-between items-center mb-2">
                    <h4 class="text-md font-medium text-gray-700">Line Items <span class="text-red-500">*</span></h4>
                    <button type="button" id="add-item-btn" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-plus fa-fw mr-1"></i> Add Item
                    </button>
                </div>
                <div id="line-items-container" class="space-y-3">
                    {{-- Existing items from old input (if validation fails) --}}
                    @if(old('items'))
                        @foreach(old('items') as $index => $item)
                            <div class="line-item grid grid-cols-12 gap-2 items-center p-2 border rounded-md">
                                <div class="col-span-5">
                                    <input type="text" name="items[{{ $index }}][description]" placeholder="Description" value="{{ $item['description'] ?? '' }}" class="form-input text-sm" required>
                                </div>
                                <div class="col-span-2">
                                    <input type="number" name="items[{{ $index }}][quantity]" placeholder="Qty" value="{{ $item['quantity'] ?? '' }}" class="form-input text-sm item-quantity" min="1" required>
                                </div>
                                <div class="col-span-3">
                                    <input type="number" name="items[{{ $index }}][unit_price]" placeholder="Unit Price" value="{{ $item['unit_price'] ?? '' }}" class="form-input text-sm item-unit-price" step="0.01" min="0" required>
                                </div>
                                <div class="col-span-1 text-sm item-amount text-right pr-1">
                                    {{-- Calculated amount (optional display) --}}
                                    ${{ number_format(($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0), 2) }}
                                </div>
                                <div class="col-span-1">
                                    <button type="button" class="btn btn-sm btn-danger remove-item-btn"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Default first item --}}
                        <div class="line-item grid grid-cols-12 gap-2 items-center p-2 border rounded-md">
                            <div class="col-span-5">
                                <input type="text" name="items[0][description]" placeholder="Description" class="form-input text-sm" required>
                            </div>
                            <div class="col-span-2">
                                <input type="number" name="items[0][quantity]" placeholder="Qty" value="1" class="form-input text-sm item-quantity" min="1" required>
                            </div>
                            <div class="col-span-3">
                                <input type="number" name="items[0][unit_price]" placeholder="Unit Price" class="form-input text-sm item-unit-price" step="0.01" min="0" required>
                            </div>
                            <div class="col-span-1 text-sm item-amount text-right pr-1">
                                $0.00 {{-- Placeholder --}}
                            </div>
                            <div class="col-span-1">
                                {{-- No remove button for the first item initially, or hide if only one item --}}
                                <button type="button" class="btn btn-sm btn-danger remove-item-btn" style="display:none;"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                    @endif
                </div>
                @error('items') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                @error('items.*.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror {{-- Catchall for item array errors --}}
            </div>


            <div class="pt-3 text-right">
                <button type="submit" class="btn btn-primary shadow-md hover:shadow-lg">
                    <i class="fas fa-save fa-fw mr-1"></i> Create Statement(s)
                </button>
            </div>
        </form>
    </div>
</section>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
    .form-input, .form-select { border: 1px solid #d1d5db; padding: 0.5rem 0.75rem; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); width: 100%;}
    .form-input:focus, .form-select:focus { outline: none; border-color: var(--primary-color, #6366f1); box-shadow: 0 0 0 2px var(--primary-color-light, #a5b4fc); }
    .alert { border: 1px solid transparent; }
    .alert-danger { background-color: #fee2e2; border-color: #fecaca; color: #991b1b; }
    .alert-success { background-color: #d1fae5; border-color: #a7f3d0; color: #065f46; }
    /* Select2 specific styles if needed */
    .select2-container .select2-selection--multiple { min-height: 38px !important; border: 1px solid #d1d5db !important; }
    .select2-container--default .select2-selection--multiple .select2-selection__choice { background-color: #e0e7ff; border-color: #c7d2fe; color: #3730a3; }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove { color: #4338ca; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
$(document).ready(function() {
    $('#user_ids').select2({
        placeholder: "-- Please select user(s) --",
        allowClear: true
    });

    let itemIndex = {{ old('items') ? count(old('items')) : 1 }}; // Start index for new items

    // Function to update item amount and total
    function updateAmounts(itemRow) {
        const quantity = parseFloat($(itemRow).find('.item-quantity').val()) || 0;
        const unitPrice = parseFloat($(itemRow).find('.item-unit-price').val()) || 0;
        const amount = quantity * unitPrice;
        $(itemRow).find('.item-amount').text('$' + amount.toFixed(2));
        // You could also calculate a grand total here if needed
    }

    // Add new item row
    $('#add-item-btn').on('click', function() {
        const newItemHtml = `
        <div class="line-item grid grid-cols-12 gap-2 items-center p-2 border rounded-md">
            <div class="col-span-5">
                <input type="text" name="items[${itemIndex}][description]" placeholder="Description" class="form-input text-sm" required>
            </div>
            <div class="col-span-2">
                <input type="number" name="items[${itemIndex}][quantity]" placeholder="Qty" value="1" class="form-input text-sm item-quantity" min="1" required>
            </div>
            <div class="col-span-3">
                <input type="number" name="items[${itemIndex}][unit_price]" placeholder="Unit Price" class="form-input text-sm item-unit-price" step="0.01" min="0" required>
            </div>
             <div class="col-span-1 text-sm item-amount text-right pr-1">
                $0.00
            </div>
            <div class="col-span-1">
                <button type="button" class="btn btn-sm btn-danger remove-item-btn"><i class="fas fa-trash"></i></button>
            </div>
        </div>`;
        $('#line-items-container').append(newItemHtml);
        itemIndex++;
        toggleRemoveButtons();
    });

    // Remove item row
    $('#line-items-container').on('click', '.remove-item-btn', function() {
        if ($('#line-items-container .line-item').length > 1) {
            $(this).closest('.line-item').remove();
        }
        toggleRemoveButtons();
    });

    // Calculate amount on quantity or unit price change
    $('#line-items-container').on('input', '.item-quantity, .item-unit-price', function() {
        updateAmounts($(this).closest('.line-item'));
    });

    // Initial calculation for pre-filled items (e.g., on validation error)
    $('#line-items-container .line-item').each(function() {
        updateAmounts(this);
    });

    function toggleRemoveButtons() {
        const items = $('#line-items-container .line-item');
        if (items.length <= 1) {
            items.find('.remove-item-btn').hide();
        } else {
            items.find('.remove-item-btn').show();
        }
    }
    toggleRemoveButtons(); // Initial check
});
</script>
@endpush