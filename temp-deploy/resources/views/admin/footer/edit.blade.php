{{-- resources/views/admin/footer/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Footer Information')

@section('content')
<section class="admin-content footer-edit-page px-4 py-4 md:px-6 md:py-6">

    {{-- Header Row --}}
    <div class="dashboard-header-v3 mb-4">
        <div class="header-greeting">
            <h1 class="text-2xl md:text-3xl font-semibold text-[var(--primary-color)]">
                <i class="fas fa-shoe-prints fa-fw mr-2 text-[var(--accent-color)]"></i> Edit Footer Information
            </h1>
            <p class="text-gray-600 mt-1">Update copyright text, links, and social media URLs.</p>
        </div>
    </div>
    <hr class="mb-5">

    {{-- Include the Alert Partial --}}
    @include('partials.admin_alerts')


    {{-- Settings Form Card --}}
    <div class="widget-card settings-form-widget shadow-lg border border-gray-100 rounded-lg overflow-hidden">
         <div class="widget-header bg-white border-b border-gray-200">
             <h3 class="text-base font-medium text-gray-700"><i class="fas fa-pencil-alt fa-fw mr-2 text-gray-400"></i> Footer Content</h3>
         </div>

         <form action="{{ route('admin.footer.update') }}" method="POST">
             @csrf
             @method('PATCH')

             <div class="widget-content space-y-6">

                {{-- 1. Copyright Text --}}
                <div class="form-section border-b pb-6">
                    <h4 class="section-heading"><i class="far fa-copyright mr-2"></i>Copyright</h4>
                    <div class="form-group mt-3">
                        <label for="footer_copyright" class="form-label">Copyright Text</label>
                        <input type="text" id="footer_copyright" name="footer_copyright" class="form-control @error('footer_copyright') input-error @enderror" value="{{ old('footer_copyright', $settings['footer_copyright'] ?? '') }}" placeholder="e.g., © {{ date('Y') }} {{ config('app.name') }}. All Rights Reserved.">
                        @error('footer_copyright') <div class="error-message mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- 2. Link Columns --}}
                <div class="form-section border-b pb-6">
                    <h4 class="section-heading"><i class="fas fa-link mr-2"></i>Footer Link Columns</h4>
                    <p class="form-text mb-4">Edit the JSON array directly. Each link needs a "title" and a "url". Ensure valid JSON format.</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Column 1 Links --}}
                        <div class="form-group">
                            <label for="footer_col1_links_json" class="form-label">Column 1 Links (JSON)</label>
                            <textarea id="footer_col1_links_json" name="footer_col1_links_json" class="form-control code-input @error('footer_col1_links_json') input-error @enderror" rows="8">{{ old('footer_col1_links_json', $settings['footer_col1_links_json'] ?? "[\n    {\n        \"title\": \"Example Link\",\n        \"url\": \"#\"\n    }\n]") }}</textarea>
                            @error('footer_col1_links_json') <div class="error-message mt-1">{{ $message }}</div> @enderror
                            <p class="form-text text-xs mt-1">Example: [{"title": "News", "url": "/news"}]</p>
                        </div>
                         {{-- Column 2 Links --}}
                        <div class="form-group">
                             <label for="footer_col2_links_json" class="form-label">Column 2 Links (JSON)</label>
                            <textarea id="footer_col2_links_json" name="footer_col2_links_json" class="form-control code-input @error('footer_col2_links_json') input-error @enderror" rows="8">{{ old('footer_col2_links_json', $settings['footer_col2_links_json'] ?? "[]") }}</textarea>
                            @error('footer_col2_links_json') <div class="error-message mt-1">{{ $message }}</div> @enderror
                            <p class="form-text text-xs mt-1">Example: [{"title": "Privacy", "url": "/privacy"}]</p>
                        </div>
                    </div>
                </div>

                {{-- 3. Social Media Links --}}
                <div class="form-section border-b pb-6">
                      <h4 class="section-heading"><i class="fas fa-share-alt mr-2"></i>Social Media Links</h4>
                      <p class="form-text mb-4">Edit the JSON array. Each item needs "platform", "url", and Font Awesome "icon" class (e.g., "fab fa-facebook-f").</p>
                      <div class="form-group">
                            <label for="footer_social_links_json" class="form-label">Social Links (JSON)</label>
                            <textarea id="footer_social_links_json" name="footer_social_links_json" class="form-control code-input @error('footer_social_links_json') input-error @enderror" rows="8">{{ old('footer_social_links_json', $settings['footer_social_links_json'] ?? "[]") }}</textarea>
                            @error('footer_social_links_json') <div class="error-message mt-1">{{ $message }}</div> @enderror
                             <p class="form-text text-xs mt-1">Example: [{"platform": "facebook", "url": "#", "icon": "fab fa-facebook-f"}]</p>
                      </div>
                </div>

                 {{-- 4. Bottom Bar Links --}}
                <div class="form-section">
                     <h4 class="section-heading"><i class="fas fa-anchor mr-2"></i>Bottom Bar Links</h4>
                     <p class="form-text mb-4">Edit the JSON array for links appearing at the very bottom.</p>
                     <div class="form-group">
                            <label for="footer_bottom_links_json" class="form-label">Bottom Links (JSON)</label>
                            <textarea id="footer_bottom_links_json" name="footer_bottom_links_json" class="form-control code-input @error('footer_bottom_links_json') input-error @enderror" rows="5">{{ old('footer_bottom_links_json', $settings['footer_bottom_links_json'] ?? "[]") }}</textarea>
                            @error('footer_bottom_links_json') <div class="error-message mt-1">{{ $message }}</div> @enderror
                            <p class="form-text text-xs mt-1">Example: [{"title": "Terms", "url": "/terms"}]</p>
                      </div>
                </div>

             </div> {{-- End Widget Content --}}

             {{-- Widget Footer with Styled Button --}}
             <div class="widget-footer bg-gray-50 p-4 border-t border-gray-200 flex justify-end">
                 {{-- Applied btn btn-primary and shadow classes --}}
                 <button type="submit" class="btn btn-primary shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[var(--primary-color)]">
                     Save Footer Settings
                 </button>
             </div>
         </form> {{-- End Form --}}
    </div> {{-- End Widget Card --}}

</section>
@endsection

{{-- Styles Section - Ensure these styles or equivalents are in app.css --}}
@push('styles')
<style>
    .form-section { /* Add structure */ }
    .section-heading { font-size: 1.1rem; font-weight: 600; color: var(--primary-color); margin-bottom: 0.5rem; display: flex; align-items: center; }
    .section-heading i { color: var(--accent-color); font-size: 1rem; margin-right: 0.5rem; }
    .form-label { display: block; margin-bottom: 0.4rem; font-weight: 500; font-size: 0.9rem; color: var(--dark-color); }
    .form-control, textarea.form-control { width: 100%; padding: 0.6rem 0.8rem; border: 1px solid #d1d5db; border-radius: var(--border-radius, 6px); font-size: 0.95rem; transition: border-color 0.2s ease, box-shadow 0.2s ease; background-color: #f9fafb; }
    .form-control:focus, textarea.form-control:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(0, 94, 184, 0.15); background-color: #fff;}
    .form-control.input-error, textarea.form-control.input-error { border-color: var(--danger-color, #e74c3c); }
    .form-text { display: block; margin-top: 0.3rem; font-size: 0.8rem; color: #6b7280; }
    .error-message { color: var(--danger-color, #e74c3c); font-size: 0.8rem; margin-top: 4px; }
    .alert { border-radius: var(--border-radius); border-width: 1px; }
    hr { border: none; border-top: 1px solid #e5e7eb; margin-top: 1.5rem; margin-bottom: 1.5rem; }
    .code-input { font-family: monospace; font-size: 0.85rem; background-color: #f1f5f9; color: #475569; }
    /* Ensure .btn and .btn-primary styles (including gradient) are defined in app.css */
    /* Add shadow/focus utilities if using Tailwind, or define them here/in app.css */
     .shadow-md { box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1); }
     .hover\:shadow-lg:hover { box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1); }
     /* Basic focus ring (Tailwind adds more) */
     .focus\:outline-none:focus { outline: 2px solid transparent; outline-offset: 2px; }
     .focus\:ring-2:focus { --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color); --tw-ring-shadow: var(--tw-ring-inset) 0 0 0 calc(2px + var(--tw-ring-offset-width)) var(--tw-ring-color); box-shadow: var(--tw-ring-offset-shadow), var(--tw-ring-shadow), var(--tw-shadow, 0 0 #0000); }
     .focus\:ring-offset-2:focus { --tw-ring-offset-width: 2px; }
     .focus\:ring-\[var\(--primary-color\)\]:focus { --tw-ring-opacity: 1; --tw-ring-color: var(--primary-color); }

</style>
@endpush

{{-- No specific JS needed for this basic version --}}
{{-- @push('scripts') <script> // ... </script> @endpush --}}