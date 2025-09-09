{{-- resources/views/admin/pages/homepage/_resource_card_fields.blade.php --}}
{{-- Expects $num (1, 2, or 3) and $slug ('resources') --}}
@php
    $prefix = "hp_res{$num}_"; // e.g., hp_res1_
@endphp

<div class="form-group">
    <label for="{{ $prefix }}icon" class="form-label text-xs">Icon (FontAwesome Class)</label>
    <input type="text" id="{{ $prefix }}icon" name="{{ $prefix }}icon" class="form-control text-sm @error($prefix.'icon', $slug) input-error @enderror" value="{{ old($prefix.'icon', $settings[$prefix.'icon'] ?? '') }}" placeholder="fas fa-book">
    @error($prefix.'icon', $slug) <div class="error-message text-xs">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label for="{{ $prefix }}title" class="form-label text-xs">Title</label>
    <input type="text" id="{{ $prefix }}title" name="{{ $prefix }}title" class="form-control text-sm @error($prefix.'title', $slug) input-error @enderror" value="{{ old($prefix.'title', $settings[$prefix.'title'] ?? '') }}">
    @error($prefix.'title', $slug) <div class="error-message text-xs">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label for="{{ $prefix }}text" class="form-label text-xs">Text</label>
    <textarea id="{{ $prefix }}text" name="{{ $prefix }}text" class="form-control text-sm @error($prefix.'text', $slug) input-error @enderror" rows="3">{{ old($prefix.'text', $settings[$prefix.'text'] ?? '') }}</textarea>
    @error($prefix.'text', $slug) <div class="error-message text-xs">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label for="{{ $prefix }}btn_text" class="form-label text-xs">Button Text</label>
    <input type="text" id="{{ $prefix }}btn_text" name="{{ $prefix }}btn_text" class="form-control text-sm @error($prefix.'btn_text', $slug) input-error @enderror" value="{{ old($prefix.'btn_text', $settings[$prefix.'btn_text'] ?? '') }}">
    @error($prefix.'btn_text', $slug) <div class="error-message text-xs">{{ $message }}</div> @enderror
</div>
<div class="form-group">
    <label for="{{ $prefix }}btn_url" class="form-label text-xs">Button URL</label>
    <input type="url" id="{{ $prefix }}btn_url" name="{{ $prefix }}btn_url" class="form-control text-sm @error($prefix.'btn_url', $slug) input-error @enderror" value="{{ old($prefix.'btn_url', $settings[$prefix.'btn_url'] ?? '') }}" placeholder="#">
    @error($prefix.'btn_url', $slug) <div class="error-message text-xs">{{ $message }}</div> @enderror
</div>
{{-- Note: This section has no image --}}