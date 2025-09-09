{{-- resources/views/admin/menus/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Add New Menu Link')

@section('content')
<section class="admin-content px-4 py-4 md:px-6 md:py-6">

    {{-- Header --}}
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl md:text-2xl font-semibold text-gray-700">
            <i class="fas fa-plus fa-fw mr-2 text-indigo-500"></i> Add New Menu Link
        </h1>
         <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary text-sm">
             <i class="fas fa-arrow-left fa-fw mr-1"></i> Back to Menu List
         </a>
    </div>
    <hr class="mb-5">

    {{-- Display Validation Errors --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">
            <strong class="font-semibold">Whoops!</strong> There were some problems with your input.<br><br>
            <ul class="list-disc list-inside pl-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Create Form --}}
    <div class="widget-card shadow-md border border-gray-100 rounded-lg overflow-hidden">
         <div class="widget-header bg-gray-50 border-b border-gray-200 p-3 md:p-4">
             <h3 class="text-base font-medium text-gray-700">Menu Link Details</h3>
         </div>
         <form action="{{ route('admin.menus.store') }}" method="POST" class="widget-content bg-white p-4 md:p-6 space-y-4">
            @csrf {{-- CSRF Protection --}}

            {{-- Include the shared form fields --}}
            {{-- The $locations variable is passed from MenuLinkController@create --}}
            @include('admin.menus._form-fields', ['locations' => $locations ?? []])

            <div class="pt-3 text-right">
                <button type="submit" class="btn btn-primary shadow-md hover:shadow-lg">
                    <i class="fas fa-save fa-fw mr-1"></i> Save Menu Link
                </button>
            </div>
        </form>
    </div>

</section>
@endsection

@push('styles')
{{-- Basic form input styling (ensure these or similar exist in your main admin CSS) --}}
<style>
    .form-label { display: block; margin-bottom: 0.25rem; font-weight: 500; font-size: 0.875rem; }
    .form-control, .form-select { width: 100%; padding: 0.5rem 0.75rem; border: 1px solid #d1d5db; border-radius: 0.375rem; box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05); font-size: 0.875rem;}
    .form-control:focus, .form-select:focus { outline: none; border-color: var(--primary-color, #6366f1); box-shadow: 0 0 0 2px var(--primary-color-light, #a5b4fc); }
    .error-message { color: var(--danger-color, #ef4444); font-size: 0.75rem; margin-top: 0.25rem; }
    .form-text {font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;}
    .alert { border-radius: 6px; border-width: 1px; }
    .alert-success { background-color: #f0fdf4; color: #16a34a; border-color: #bbf7d0; }
    .alert-danger { background-color: #fef2f2; color: #dc2626; border-color: #fecaca; }
    .btn { /* Ensure your button styles are defined */ }
</style>
@endpush