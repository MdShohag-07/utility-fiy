{{-- resources/views/admin/settings/edit-general.blade.php --}}
@extends('layouts.admin')
@php use Illuminate\Support\Facades\Storage; @endphp {{-- Import Storage facade --}}

@section('title', 'General Site Settings')

@section('content')
<section class="admin-content settings-page px-4 py-4 md:px-6 md:py-6">

    {{-- Header Row --}}
    <div class="dashboard-header-v3 mb-4">
        <div class="header-greeting">
            <h1 class="text-2xl md:text-3xl font-semibold text-[var(--primary-color)]">
                <i class="fas fa-cog fa-fw mr-2 text-[var(--accent-color)]"></i> General Site Settings
            </h1>
            <p class="text-gray-600 mt-1">Manage site logo and theme colors.</p>
        </div>
    </div>
    <hr class="mb-5">

    {{-- Session Status Messages & Validation Errors --}}
    @if(session('status')) <div class="alert alert-success mb-4 p-3 rounded-md text-sm">{{ session('status') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">{{ session('error') }}</div> @endif
    @if($errors->general->any()) {{-- Check specific error bag --}}
       <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">
           <strong class="font-semibold">Please check the form for errors:</strong>
           <ul> @foreach($errors->general->all() as $error) <li>{{ $error }}</li> @endforeach </ul>
       </div>
     @endif
    {{-- @include('partials.admin_alerts') --}}


    {{-- Settings Form Card --}}
    <div class="widget-card settings-form-widget shadow-lg border border-gray-100 rounded-lg overflow-hidden">
         <div class="widget-header bg-white border-b border-gray-200 p-3 md:p-4">
             <h3 class="text-base font-medium text-gray-700"><i class="fas fa-palette fa-fw mr-2 text-gray-400"></i> Edit General Settings</h3>
         </div>

         {{-- Form points to the correct update route --}}
         <form action="{{ route('admin.settings.general.update') }}" method="POST" enctype="multipart/form-data">
             @csrf
             @method('PATCH') {{-- Use PATCH for updates --}}

             <div class="widget-content p-4 md:p-6 space-y-6">

                {{-- Site Logo Upload --}}
                <div class="form-group">
                    <label for="site_logo" class="form-label">Site Logo</label>
                    {{-- *** Check the PATH key 'site_logo' *** --}}
                    @if(!empty($settings['site_logo']) && Storage::disk('public')->exists($settings['site_logo']))
                        <div class="current-logo mb-3 p-3 border rounded-md inline-block bg-gray-50">
                            <p class="text-xs text-gray-500 mb-2 font-medium uppercase tracking-wider">Current Logo:</p>
                            {{-- *** Generate URL from the PATH using Storage::url() *** --}}
                            <img src="{{ Storage::url($settings['site_logo']) }}?t={{ time() }}" alt="Current Logo" class="h-12 max-w-xs block">
                        </div>
                         <p class="text-sm text-gray-500 mb-1">Upload a new file below to replace the current logo.</p>
                    @else
                         <p class="text-sm text-gray-500 mb-1">No logo currently uploaded or file missing.</p>
                         {{-- Optional: Show warning if path exists but file doesn't --}}
                         @if(!empty($settings['site_logo']))
                             <p class="text-xs text-red-600">Warning: Path '{{ $settings['site_logo'] }}' set but file not found.</p>
                         @endif
                    @endif
                     {{-- Input name is 'site_logo' --}}
                     <input type="file" id="site_logo" name="site_logo" class="form-input-file mt-1" accept="image/png, image/jpeg, image/gif, image/svg+xml">
                     <p class="form-text mt-1">Recommended: PNG/SVG, max 2MB.</p>
                     {{-- Use the correct error bag --}}
                     @error('site_logo', 'general') <div class="error-message mt-1">{{ $message }}</div> @enderror
                </div>
                <hr>

                {{-- Header Background Color --}}
                <div class="form-group">
                    {{-- *** UPDATED label 'for' attribute *** --}}
                    <label for="header_bg_color" class="form-label">Header Background Color</label>
                    <div class="flex items-center gap-3">
                        {{-- Color picker updates the text input via JS --}}
                        {{-- Use the consistent 'header_bg_color' key for value/old --}}
                        <input type="color" id="header_color_picker" name="header_color_picker" value="{{ old('header_bg_color', $settings['header_bg_color'] ?? '#FFFFFF') }}" class="h-10 w-10 p-0.5 border border-gray-300 rounded-md cursor-pointer appearance-none">

                        {{-- *** UPDATED input name, id, value *** --}}
                        <input type="text" id="header_bg_color" name="header_bg_color" value="{{ old('header_bg_color', $settings['header_bg_color'] ?? '#FFFFFF') }}" class="form-control w-32 @error('header_bg_color', 'general') input-error @enderror" placeholder="#FFFFFF">
                    </div>
                    <p class="form-text mt-1">Enter a valid hex color code (e.g., #005eb8).</p>
                    {{-- *** UPDATED @error directive key and error bag *** --}}
                    @error('header_bg_color', 'general') <div class="error-message mt-1">{{ $message }}</div> @enderror
                </div>

                {{-- Add other general settings fields here as needed --}}

             </div> {{-- End Widget Content --}}

             <div class="widget-footer bg-gray-50 p-3 border-t border-gray-200 flex justify-end">
                 <button type="submit" class="btn btn-primary"> <i class="fas fa-save mr-1"></i> Save General Settings</button>
             </div>
         </form> {{-- End Form --}}
    </div> {{-- End Widget Card --}}

</section>
@endsection

{{-- Styles Section --}}
@push('styles')
<style>
    /* Styles from previous version */
    .form-label { display: block; margin-bottom: 0.4rem; font-weight: 500; font-size: 0.9rem; }
    .form-control { width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.95rem; transition: border-color 0.2s ease, box-shadow 0.2s ease; }
    .form-control:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(0, 94, 184, 0.15); }
    .form-control.input-error { border-color: var(--danger-color, #e74c3c); }
    .form-text { display: block; margin-top: 0.3rem; font-size: 0.8rem; color: #6b7280; }
    .error-message { color: var(--danger-color, #e74c3c); font-size: 0.8rem; margin-top: 4px; }
    .alert { border-radius: 6px; border-width: 1px; } /* Basic alert */
    .alert-success { background-color: #f0fdf4; color: #16a34a; border-color: #bbf7d0; padding: 0.75rem 1rem; margin-bottom: 1rem; font-size: 0.9rem;}
    .alert-danger { background-color: #fef2f2; color: #dc2626; border-color: #fecaca; padding: 0.75rem 1rem; margin-bottom: 1rem; font-size: 0.9rem;}
    hr { border: none; border-top: 1px solid #e5e7eb; margin-top: 1.5rem; margin-bottom: 1.5rem; }
    .form-input-file { display: block; width: 100%; padding: 0.5rem; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.9rem; }
    .form-input-file::file-selector-button { margin-right: 0.8rem; display: inline-block; font-weight: 500; color: var(--primary-color); background: #eef2ff; padding: 0.4rem 0.8rem; border: thin solid rgba(0, 0, 0, 0); border-radius: 4px; transition: background-color .2s ease-in-out; cursor: pointer; }
    .form-input-file::file-selector-button:hover { background-color: #e0e7ff; }
    .widget-card { background-color: #fff; border-radius: 8px; margin-bottom: 1.5rem; box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1); border: 1px solid #e5e7eb;}
    .widget-header { padding: 0.8rem 1.25rem; border-bottom: 1px solid #e5e7eb;} .widget-header h3 { font-size: 1rem; font-weight: 600; }
    .widget-content { padding: 1.5rem; } .widget-footer { padding: 0.75rem 1.25rem; background-color: #f9fafb; border-top: 1px solid #e5e7eb;}
    .btn { display: inline-flex; align-items: center; padding: 0.6rem 1.2rem; border: none; border-radius: 6px; font-size: 0.9rem; font-weight: 500; cursor: pointer; text-align: center; transition: all 0.2s ease; text-decoration: none; line-height: 1.25; } .btn i { margin-right: 0.4rem; } .btn-primary { background: linear-gradient(45deg, var(--primary-color, #005eb8), var(--accent-color, #00a9e0)); color: white; } .btn-primary:hover { opacity: 0.9; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
</style>
@endpush

{{-- Scripts Section --}}
@push('scripts')
<script>
    // Script to link color picker and text input
    document.addEventListener('DOMContentLoaded', function() {
        const colorPicker = document.getElementById('header_color_picker');
        // *** UPDATE ID to match text input ***
        const colorInput = document.getElementById('header_bg_color');

        if (colorPicker && colorInput) {
            // Update text input when color picker changes
            colorPicker.addEventListener('input', function(event) {
                colorInput.value = event.target.value;
            });
            // Update color picker when text input changes
            colorInput.addEventListener('input', function(event) {
                if (/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/.test(event.target.value)) {
                     colorPicker.value = event.target.value;
                 }
             });
        }
    });
</script>
@endpush