{{-- resources/views/admin/users/link.blade.php --}}
@extends('layouts.admin')

@section('title', 'Link User Accounts')

@section('content')
<section class="admin-content user-link-page px-4 py-4 md:px-6 md:py-6">

    {{-- Header Row --}}
    <div class="dashboard-header-v3 mb-4">
        <div class="header-greeting">
            <h1 class="text-2xl md:text-3xl font-semibold text-[var(--primary-color)]">
                <i class="fas fa-link fa-fw mr-2 text-[var(--accent-color)]"></i> Link User Accounts
            </h1>
            <p class="text-gray-600 mt-1">Select two user accounts to link them for shared billing statements.</p>
        </div>
    </div>
    <hr class="mb-5">

    {{-- Session Status Messages & Validation Errors --}}
    @include('partials.admin_alerts')

    {{-- Linking Form Card --}}
    <div class="widget-card settings-form-widget shadow-lg border border-gray-100 rounded-lg overflow-hidden">
         <div class="widget-header bg-white border-b border-gray-200">
             <h3 class="text-base font-medium text-gray-700"><i class="fas fa-pencil-alt fa-fw mr-2 text-gray-400"></i> Select Users to Link</h3>
         </div>

         <form action="{{ route('admin.users.link.store') }}" method="POST">
             @csrf

             <div class="widget-content space-y-6">

                <p class="text-sm text-gray-700">Select the two user accounts you wish to appear on the same billing statement. Note: This functionality requires further backend implementation.</p>

                {{-- User Selection 1 --}}
                <div class="form-group">
                    <label for="user_id_1" class="form-label">First User Account <span class="text-red-500">*</span></label>
                    <select name="user_id_1" id="user_id_1" class="form-control @error('user_id_1') input-error @enderror" required>
                        <option value="">-- Select First User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id_1') == $user->id ? 'selected' : '' }}>
                                {{ $user->last_name }}, {{ $user->first_name }} ({{ $user->username }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id_1') <div class="error-message mt-1">{{ $message }}</div> @enderror
                     @error('user_id_2') {{-- Show 'different' error here too --}}
                         @if($message === 'The user id 2 and user id 1 must be different.')
                            <div class="error-message mt-1">Please select two different users.</div>
                         @endif
                     @enderror
                </div>

                {{-- User Selection 2 --}}
                <div class="form-group">
                    <label for="user_id_2" class="form-label">Second User Account <span class="text-red-500">*</span></label>
                     <select name="user_id_2" id="user_id_2" class="form-control @error('user_id_2') input-error @enderror" required>
                        <option value="">-- Select Second User --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id_2') == $user->id ? 'selected' : '' }}>
                                {{ $user->last_name }}, {{ $user->first_name }} ({{ $user->username }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id_2') <div class="error-message mt-1">{{ $message }}</div> @enderror
                </div>

             </div> {{-- End Widget Content --}}

             <div class="widget-footer bg-gray-50 p-3 border-t border-gray-200 flex justify-end">
                 <button type="submit" class="btn btn-primary">Link Selected Users</button>
             </div>
         </form> {{-- End Form --}}
    </div> {{-- End Widget Card --}}


     {{-- TODO: Add section to display currently linked users --}}

</section>
@endsection

{{-- Include relevant styles if not globally defined in app.css --}}
@push('styles')
<style>
    .form-label { display: block; margin-bottom: 0.4rem; font-weight: 500; font-size: 0.9rem; color: var(--dark-color); }
    .form-control, select.form-control { width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #d1d5db; border-radius: var(--border-radius, 6px); font-size: 0.95rem; transition: border-color 0.2s ease, box-shadow 0.2s ease; background-color: #f9fafb; }
    .form-control:focus, select.form-control:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(0, 94, 184, 0.15); background-color: #fff;}
    .form-control.input-error, select.form-control.input-error { border-color: var(--danger-color, #e74c3c); }
    .error-message { color: var(--danger-color, #e74c3c); font-size: 0.8rem; margin-top: 4px; }
    .alert { border-radius: var(--border-radius); border-width: 1px; }
</style>
@endpush