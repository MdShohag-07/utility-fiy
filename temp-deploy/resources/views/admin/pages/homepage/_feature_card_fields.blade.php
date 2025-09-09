{{-- resources/views/admin/pages/homepage/_feature_card_fields.blade.php --}}
{{-- Expects $num (1 or 2) and $slug ('features') --}}
@php
    $prefix = "hp_feat{$num}_"; // e.g., hp_feat1_
    $image_path_key = $prefix . 'image'; // Key where the path is stored (e.g., hp_feat1_image)
@endphp

<div class="form-group"> <label for="{{ $prefix }}title" class="form-label text-xs">Title</label> <input type="text" id="{{ $prefix }}title" name="{{ $prefix }}title" class="form-control text-sm @error($prefix.'title', $slug) input-error @enderror" value="{{ old($prefix.'title', $settings[$prefix.'title'] ?? '') }}"> @error($prefix.'title', $slug) <div class="error-message text-xs">{{ $message }}</div> @enderror </div>
<div class="form-group"> <label for="{{ $prefix }}text" class="form-label text-xs">Text</label> <textarea id="{{ $prefix }}text" name="{{ $prefix }}text" class="form-control text-sm @error($prefix.'text', $slug) input-error @enderror" rows="3">{{ old($prefix.'text', $settings[$prefix.'text'] ?? '') }}</textarea> @error($prefix.'text', $slug) <div class="error-message text-xs">{{ $message }}</div> @enderror </div>
<div class="form-group"> <label for="{{ $prefix }}btn_text" class="form-label text-xs">Button Text</label> <input type="text" id="{{ $prefix }}btn_text" name="{{ $prefix }}btn_text" class="form-control text-sm @error($prefix.'btn_text', $slug) input-error @enderror" value="{{ old($prefix.'btn_text', $settings[$prefix.'btn_text'] ?? '') }}"> @error($prefix.'btn_text', $slug) <div class="error-message text-xs">{{ $message }}</div> @enderror </div>
<div class="form-group"> <label for="{{ $prefix }}btn_url" class="form-label text-xs">Button URL</label> <input type="url" id="{{ $prefix }}btn_url" name="{{ $prefix }}btn_url" class="form-control text-sm @error($prefix.'btn_url', $slug) input-error @enderror" value="{{ old($prefix.'btn_url', $settings[$prefix.'btn_url'] ?? '') }}" placeholder="#"> @error($prefix.'btn_url', $slug) <div class="error-message text-xs">{{ $message }}</div> @enderror </div>
<div class="form-group">
    <label for="{{ $image_path_key }}" class="form-label text-xs">Image</label> {{-- Label uses the file input key --}}
    {{-- Check if the path key exists and has a value --}}
    @if(!empty($settings[$image_path_key]))
        <div class="mb-2">
             <div class="inline-block p-1 border rounded-md bg-gray-50 align-top">
                {{-- *** Use Storage::url() with the path key *** --}}
                <img src="{{ Storage::url($settings[$image_path_key]) }}?v={{ time() }}" alt="Current Feature {{ $num }} Image" class="h-16 max-w-xs block">
             </div>
            <div class="inline-block ml-3 align-top text-xs"> <p class="text-gray-500 mb-1">Current Image</p> </div>
        </div>
    @endif
    {{-- Input uses the file input key --}}
    <input type="file" id="{{ $image_path_key }}" name="{{ $image_path_key }}" class="form-input-file text-xs @error($image_path_key, $slug) input-error @enderror" accept="image/jpeg,image/png,image/webp,image/gif,image/svg+xml">
    <p class="form-text text-xs mt-1">Max 1MB. Leave blank to keep.</p>
     @error($image_path_key, $slug) <div class="error-message mt-1 text-xs">{{ $message }}</div> @enderror
</div>