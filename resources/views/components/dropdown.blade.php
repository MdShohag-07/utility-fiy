{{-- resources/views/components/dropdown.blade.php --}}
@props(['align' => 'right', 'width' => '48', 'contentClasses' => '', 'dropdownClasses' => '']) {{-- Removed padding default --}}

@php
// Alignment and Width logic...
switch ($align) {
    case 'left': $alignmentClasses = 'origin-top-left left-0'; break;
    case 'top': $alignmentClasses = 'origin-top'; break;
    case 'right': default: $alignmentClasses = 'origin-top-right right-0'; break;
}
switch ($width) { case '48': $width = 'w-48'; break; }
@endphp

<div class="relative {{ $dropdownClasses }}" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">
        {{ $trigger }}
    </div>

    <div x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute z-50 mt-2 {{ $width }} rounded-md shadow-lg {{ $alignmentClasses }}" {{-- Base positioning/size --}}
            style="display: none;"
            @click="open = false">

        {{-- Apply themed class and pass content classes (padding etc) --}}
        {{-- Removed inline styles, relying on CSS rules now --}}
        <div class="themed-dropdown-panel {{ $contentClasses }}">
            {{ $content }}
        </div>
    </div>
</div>