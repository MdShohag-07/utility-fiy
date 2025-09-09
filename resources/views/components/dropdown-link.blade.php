{{-- resources/views/components/dropdown-link.blade.php --}}
@props(['active' => false, 'icon' => null]) {{-- Added icon prop --}}

@php
// Base class for structure, styling handled by CSS targeting '.dropdown-link-item'
$classes = 'dropdown-link-item';
if ($active ?? false) {
    $classes .= ' active'; // Add 'active' class if needed (styling for active state defined in CSS)
}
@endphp

{{-- Anchor tag with the base class --}}
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{-- Render icon if provided --}}
    @if($icon)
        <i class="{{ $icon }}" aria-hidden="true"></i>
    @endif
    {{-- Link Text --}}
    <span>{{ $slot }}</span>
</a>