{{-- resources/views/admin/menus/_form-fields.blade.php --}}
{{-- Expects $menuLink (optional) and $locations array --}}

{{-- Title Field --}}
<div>
    <label for="title" class="form-label">Title <span class="text-red-500">*</span></label>
    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $menuLink->title ?? '') }}" required>
    @error('title') <p class="error-message">{{ $message }}</p> @enderror
</div>

{{-- URL Field --}}
<div>
    <label for="url" class="form-label">URL <span class="text-red-500">*</span></label>
    <input type="text" name="url" id="url" class="form-control" value="{{ old('url', $menuLink->url ?? '') }}" required placeholder="e.g., /about-us or {{ route('home') }}">
    @error('url') <p class="error-message">{{ $message }}</p> @enderror
</div>

{{-- Target Field --}}
<div>
    <label for="target" class="form-label">Target</label>
    <select name="target" id="target" class="form-select">
        <option value="_self" {{ old('target', $menuLink->target ?? '_self') == '_self' ? 'selected' : '' }}>_self (Same Window)</option>
        <option value="_blank" {{ old('target', $menuLink->target ?? '') == '_blank' ? 'selected' : '' }}>_blank (New Window)</option>
    </select>
    @error('target') <p class="error-message">{{ $message }}</p> @enderror
</div>

{{-- Location Field --}}
<div>
    <label for="location" class="form-label">Location <span class="text-red-500">*</span></label>
    <select name="location" id="location" class="form-select" required>
        <option value="" disabled {{ !(old('location', $menuLink->location ?? '')) ? 'selected' : '' }}>-- Select Location --</option>
        @foreach($locations as $key => $label)
            <option value="{{ $key }}" {{ old('location', $menuLink->location ?? 'header') == $key ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    @error('location') <p class="error-message">{{ $message }}</p> @enderror
</div>

{{-- Icon Field (NEW) --}}
<div>
    <label for="icon" class="form-label">Icon Class (Optional)</label>
    <input type="text" name="icon" id="icon" class="form-control" value="{{ old('icon', $menuLink->icon ?? '') }}" placeholder="e.g., fas fa-home">
    <p class="form-text text-xs">Enter Font Awesome class like 'fas fa-user'. See Font Awesome website for icons.</p>
    @error('icon') <p class="error-message">{{ $message }}</p> @enderror
</div>

{{-- Order Field --}}
<div>
    <label for="order" class="form-label">Order</label>
    <input type="number" name="order" id="order" class="form-control" value="{{ old('order', $menuLink->order ?? 0) }}" min="0">
    <p class="form-text text-xs">Lower numbers appear first within the same location.</p>
    @error('order') <p class="error-message">{{ $message }}</p> @enderror
</div>