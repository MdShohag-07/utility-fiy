{{-- resources/views/admin/pages/homepage/edit.blade.php --}}
@extends('layouts.admin')
@php use Illuminate\Support\Facades\Storage; @endphp

@section('title', 'Edit Homepage Content')

@section('content')
<section class="admin-content homepage-settings-page px-4 py-4 md:px-6 md:py-6">
    {{-- Header Row --}}
    <div class="dashboard-header-v3 mb-4">
         <div class="header-greeting">
             <h1 class="text-2xl md:text-3xl font-semibold text-[var(--primary-color)]"><i class="fas fa-home fa-fw mr-2 text-[var(--accent-color)]"></i> Edit Homepage Content</h1>
             <p class="text-gray-600 mt-1">Update text and images. Save each section individually.</p>
         </div>
    </div>
    <hr class="mb-5 border-gray-300">

    {{-- Global Session Status Messages --}}
    @if(session('status')) <div class="alert alert-success mb-4 p-3 rounded-md text-sm">{{ session('status') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger mb-4 p-3 rounded-md text-sm">{{ session('error') }}</div> @endif

    {{-- Section-Specific Alerts --}}
    @php
        $sections = [
            // 'hero' => 'Hero Section', // Hero section is assumed to be removed from forms
            'account' => 'Account Section',
            'internet' => 'Internet Section',
            // TODO: Add other section slugs and their friendly names here
            // 'resources' => 'Resources Section',
            // 'features' => 'Features Section',
            // 'careers' => 'Careers Section',
            // 'solutions' => 'Solutions Section',
            // 'news' => 'News Section',
        ];
    @endphp

    @foreach($sections as $slug => $friendlyName)
        @if(session('success_'.$slug))
            <div class="alert alert-success mb-4" role="alert">{{ session('success_'.$slug) }}</div>
        @endif
        @if(session('info_'.$slug))
            <div class="alert alert-info mb-4" role="alert">{{ session('info_'.$slug) }}</div>
        @endif
        @if(session('error_'.$slug)) {{-- For controller-flashed errors specific to a section --}}
            <div class="alert alert-danger mb-4" role="alert">{{ session('error_'.$slug) }}</div>
        @endif

        {{-- Display Validation Errors for this specific section's error bag --}}
        @if($errors->{$slug}->any())
          <div class="alert alert-danger my-2" role="alert">
              <strong class="font-semibold">Errors in {{ $friendlyName }}:</strong>
              <ul class="list-disc list-inside mt-1 pl-4 text-sm">
                  @foreach($errors->{$slug}->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif
    @endforeach

    {{-- ============================ --}}
    {{-- === Section: Account Promo === --}}
    {{-- ============================ --}}
    <div class="widget-card mb-6">
        <form action="{{ route('admin.pages.homepage.update.account') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PATCH')
            <div class="widget-header bg-gradient-to-r from-indigo-50 to-purple-50">
                <h3 class="widget-title text-indigo-800"><i class="fas fa-user-check fa-fw mr-2 text-purple-600"></i>Account Section</h3>
            </div>
            <div class="widget-content space-y-5">
                {{-- Headline --}}
                <div class="form-group">
                    <label for="hp_account_headline" class="form-label">Headline</label>
                    <input type="text" name="hp_account_headline" id="hp_account_headline" class="form-control @error('hp_account_headline', 'account') input-error @enderror" value="{{ old('hp_account_headline', $settings['hp_account_headline'] ?? '') }}">
                    @error('hp_account_headline', 'account') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                {{-- Subtext --}}
                <div class="form-group">
                    <label for="hp_account_subtext" class="form-label">Subtext</label>
                    <textarea name="hp_account_subtext" id="hp_account_subtext" class="form-control @error('hp_account_subtext', 'account') input-error @enderror" rows="3">{{ old('hp_account_subtext', $settings['hp_account_subtext'] ?? '') }}</textarea>
                    @error('hp_account_subtext', 'account') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                {{-- Create Username Button --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="hp_account_create_text" class="form-label">"Create Username" Button Text</label>
                        <input type="text" name="hp_account_create_text" id="hp_account_create_text" class="form-control @error('hp_account_create_text', 'account') input-error @enderror" value="{{ old('hp_account_create_text', $settings['hp_account_create_text'] ?? '') }}">
                        @error('hp_account_create_text', 'account') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="hp_account_create_url" class="form-label">"Create Username" Button URL</label>
                        <input type="url" name="hp_account_create_url" id="hp_account_create_url" class="form-control @error('hp_account_create_url', 'account') input-error @enderror" value="{{ old('hp_account_create_url', $settings['hp_account_create_url'] ?? '') }}" placeholder="https://...">
                        @error('hp_account_create_url', 'account') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                </div>
                {{-- Sign In Button Text --}}
                <div class="form-group">
                    <label for="hp_account_signin_text" class="form-label">"Sign In" Button Text</label>
                    <input type="text" name="hp_account_signin_text" id="hp_account_signin_text" class="form-control @error('hp_account_signin_text', 'account') input-error @enderror" value="{{ old('hp_account_signin_text', $settings['hp_account_signin_text'] ?? '') }}">
                    @error('hp_account_signin_text', 'account') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                {{-- Not Customer & Get Started --}}
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="form-group">
                        <label for="hp_account_notcustomer_text" class="form-label">"Not Customer" Text</label>
                        <input type="text" name="hp_account_notcustomer_text" id="hp_account_notcustomer_text" class="form-control @error('hp_account_notcustomer_text', 'account') input-error @enderror" value="{{ old('hp_account_notcustomer_text', $settings['hp_account_notcustomer_text'] ?? '') }}">
                        @error('hp_account_notcustomer_text', 'account') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="hp_account_getstarted_text" class="form-label">"Get Started" Text</label>
                        <input type="text" name="hp_account_getstarted_text" id="hp_account_getstarted_text" class="form-control @error('hp_account_getstarted_text', 'account') input-error @enderror" value="{{ old('hp_account_getstarted_text', $settings['hp_account_getstarted_text'] ?? '') }}">
                        @error('hp_account_getstarted_text', 'account') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="hp_account_getstarted_url" class="form-label">"Get Started" URL</label>
                        <input type="url" name="hp_account_getstarted_url" id="hp_account_getstarted_url" class="form-control @error('hp_account_getstarted_url', 'account') input-error @enderror" value="{{ old('hp_account_getstarted_url', $settings['hp_account_getstarted_url'] ?? '') }}" placeholder="https://...">
                        @error('hp_account_getstarted_url', 'account') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                </div>
                {{-- Image --}}
                <div class="form-group">
                    <label for="hp_account_image_input" class="form-label">Image</label> {{-- Changed id for clarity if needed --}}
                    @if(!empty($settings['hp_account_image_url_preview']))
                        <div class="mb-2 current-image-preview">
                            <img src="{{ $settings['hp_account_image_url_preview'] }}?v={{time()}}" alt="Current Account Image" class="h-20 rounded border p-1">
                            <div class="mt-1">
                                <input type="checkbox" name="remove_hp_account_image" value="1" id="remove_hp_account_image" class="form-checkbox">
                                <label for="remove_hp_account_image" class="text-xs text-gray-600 ml-1">Remove current image</label>
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-gray-500 mb-1">No current image.</p>
                    @endif
                    {{-- The name attribute here MUST match what the controller expects for file upload --}}
                    <input type="file" name="hp_account_image" id="hp_account_image_input" class="form-input-file @error('hp_account_image', 'account') input-error @enderror" accept="image/*">
                    <p class="form-text text-xs mt-1">Max 2MB. Leave blank to keep current image.</p>
                    @error('hp_account_image', 'account') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="widget-footer"> <button type="submit" class="btn btn-primary btn-sm">Save Account Section</button> </div>
        </form>
    </div>

    {{-- ================================================= --}}
    {{-- === Section: Internet Promo === --}}
    {{-- ================================================= --}}
    <div class="widget-card mb-6">
        <form action="{{ route('admin.pages.homepage.update.internet') }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PATCH')
            <div class="widget-header bg-gradient-to-r from-teal-50 to-blue-50">
                <h3 class="widget-title text-teal-800"><i class="fas fa-wifi fa-fw mr-2 text-blue-600"></i>Internet Section</h3>
            </div>
            <div class="widget-content space-y-5">
                {{-- Headline --}}
                <div class="form-group">
                    <label for="hp_internet_headline" class="form-label">Headline</label>
                    <input type="text" name="hp_internet_headline" id="hp_internet_headline" class="form-control @error('hp_internet_headline', 'internet') input-error @enderror" value="{{ old('hp_internet_headline', $settings['hp_internet_headline'] ?? '') }}">
                    @error('hp_internet_headline', 'internet') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                {{-- Subtext --}}
                <div class="form-group">
                    <label for="hp_internet_subtext" class="form-label">Subtext</label>
                    <textarea name="hp_internet_subtext" id="hp_internet_subtext" class="form-control @error('hp_internet_subtext', 'internet') input-error @enderror" rows="3">{{ old('hp_internet_subtext', $settings['hp_internet_subtext'] ?? '') }}</textarea>
                    @error('hp_internet_subtext', 'internet') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                {{-- Button --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="form-group">
                        <label for="hp_internet_button_text" class="form-label">Button Text</label>
                        <input type="text" name="hp_internet_button_text" id="hp_internet_button_text" class="form-control @error('hp_internet_button_text', 'internet') input-error @enderror" value="{{ old('hp_internet_button_text', $settings['hp_internet_button_text'] ?? '') }}">
                        @error('hp_internet_button_text', 'internet') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="hp_internet_button_url" class="form-label">Button URL</label>
                        <input type="url" name="hp_internet_button_url" id="hp_internet_button_url" class="form-control @error('hp_internet_button_url', 'internet') input-error @enderror" value="{{ old('hp_internet_button_url', $settings['hp_internet_button_url'] ?? '') }}" placeholder="https://...">
                        @error('hp_internet_button_url', 'internet') <div class="error-message">{{ $message }}</div> @enderror
                    </div>
                </div>
                {{-- Disclaimer --}}
                <div class="form-group">
                    <label for="hp_internet_disclaimer" class="form-label">Disclaimer Text</label>
                    <input type="text" name="hp_internet_disclaimer" id="hp_internet_disclaimer" class="form-control @error('hp_internet_disclaimer', 'internet') input-error @enderror" value="{{ old('hp_internet_disclaimer', $settings['hp_internet_disclaimer'] ?? '') }}">
                    @error('hp_internet_disclaimer', 'internet') <div class="error-message">{{ $message }}</div> @enderror
                </div>
                {{-- Background Image --}}
                <div class="form-group">
                    <label for="hp_internet_bg_image_input" class="form-label">Background Image</label> {{-- Changed id for clarity if needed --}}
                    @if(!empty($settings['hp_internet_bg_image_url_preview']))
                        <div class="mb-2 current-image-preview">
                            <img src="{{ $settings['hp_internet_bg_image_url_preview'] }}?v={{time()}}" alt="Current Internet BG" class="h-20 rounded border p-1">
                            <div class="mt-1">
                                <input type="checkbox" name="remove_hp_internet_bg_image" value="1" id="remove_hp_internet_bg_image" class="form-checkbox">
                                <label for="remove_hp_internet_bg_image" class="text-xs text-gray-600 ml-1">Remove current image</label>
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-gray-500 mb-1">No current image.</p>
                    @endif
                    {{-- The name attribute here MUST match what the controller expects for file upload --}}
                    <input type="file" name="hp_internet_bg_image" id="hp_internet_bg_image_input" class="form-input-file @error('hp_internet_bg_image', 'internet') input-error @enderror" accept="image/*">
                    <p class="form-text text-xs mt-1">Max 2MB. Leave blank to keep current image.</p>
                    @error('hp_internet_bg_image', 'internet') <div class="error-message">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="widget-footer"> <button type="submit" class="btn btn-primary btn-sm">Save Internet Section</button> </div>
        </form>
    </div>

    {{--
    TODO: Add forms for other sections:
    - Resources
    - Features
    - Careers
    - Solutions
    - News

    Each section should:
    1. Have its own <form action="{{ route('admin.pages.homepage.update.SECTION_SLUG') }}" method="POST" enctype="multipart/form-data">
    2. Use @csrf and @method('PATCH').
    3. Have a unique $errorBag slug (e.g., 'resources', 'features') for validation messages and success/error flashes.
    4. Input fields should have `name` attributes matching the keys defined in your HomepageController's validation rules
       and $allSettingKeys (e.g., `name="hp_resources_title"`).
    5. For image fields, use the `_url_preview` key from the $settings array for display, and provide
       a file input with the correct name (e.g., `name="hp_resources_main_image"`) and a "remove image" checkbox
       (e.g., `name="remove_hp_resources_main_image"`).
    6. A submit button for that specific section.
    --}}

</section>
@endsection

@push('styles')
<style>
    .widget-card { background-color: #fff; border-radius: 0.5rem; box-shadow: 0 1px 3px 0 rgba(0,0,0,.1), 0 1px 2px -1px rgba(0,0,0,.06); border: 1px solid #e5e7eb; }
    .widget-header { padding: 0.75rem 1.25rem; border-bottom: 1px solid #e5e7eb; }
    .widget-title { font-size: 1.125rem; font-weight: 600; color: #374151; }
    .widget-content { padding: 1.25rem; }
    .widget-footer { padding: 0.75rem 1.25rem; background-color: #f9fafb; border-top: 1px solid #e5e7eb; text-align: right; }
    .form-group { margin-bottom: 1.25rem; }
    .form-label { display: block; margin-bottom: 0.25rem; font-size: 0.875rem; font-weight: 500; color: #374151; }
    .form-control, .form-input-file { display: block; width: 100%; padding: 0.5rem 0.75rem; font-size: 0.875rem; line-height: 1.5; color: #374151; background-color: #fff; background-clip: padding-box; border: 1px solid #d1d5db; border-radius: 0.375rem; transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out; }
    .form-control:focus { border-color: #6366f1 /* Indigo-500 */; outline: 0; box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25); }
    .form-input-file { padding: 0.375rem 0.75rem; }
    .input-error { border-color: #ef4444 /* Red-500 */; }
    .error-message { color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem; }
    .form-text { color: #6b7280 /* Gray-500 */; }
    .btn { display: inline-block; font-weight: 500; color: #fff; text-align: center; vertical-align: middle; cursor: pointer; user-select: none; background-color: #4f46e5 /* Indigo-600 */; border: 1px solid transparent; padding: 0.5rem 1rem; font-size: 0.875rem; line-height: 1.5; border-radius: 0.375rem; transition: all .15s ease-in-out; }
    .btn:hover { background-color: #4338ca /* Indigo-700 */; }
    .btn-sm { padding: 0.375rem 0.75rem; font-size: 0.875rem; }
    .current-image-preview img { max-height: 5rem; /* 80px */ display: inline-block; vertical-align: middle; border-radius: 0.25rem; border: 1px solid #e5e7eb; padding: 0.25rem; }
    .current-image-preview .form-checkbox { vertical-align: middle; margin-left: 0.5rem; border-color: #d1d5db; border-radius: 0.25rem; }
    .alert { padding: 0.75rem 1.25rem; margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.375rem; }
    .alert-success { color: #0f5132; background-color: #d1e7dd; border-color: #badbcc; }
    .alert-danger { color: #842029; background-color: #f8d7da; border-color: #f5c2c7; }
    .alert-info { color: #055160; background-color: #cff4fc; border-color: #b6effb; }
</style>
@endpush

@push('scripts')
<script>
    // Optional: Add any page-specific JavaScript here if needed
    // For example, to show filename on file input
    document.querySelectorAll('.form-input-file').forEach(inputElement => {
        inputElement.addEventListener('change', function(e) {
            let fileName = e.target.files[0] ? e.target.files[0].name : 'No file chosen';
            let nextSibling = e.target.nextElementSibling;
            // A bit fragile, depends on DOM structure if you have a dedicated span for filename
            // For now, this is just an example if you had <input type="file"><span class="file-name"></span>
            // if(nextSibling && nextSibling.classList.contains('file-name-display')) {
            //     nextSibling.textContent = fileName;
            // }
        });
    });
</script>
@endpush