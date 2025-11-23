@props(['name', 'class' => '', 'size' => 24, 'style' => null])

@php
    $iconStyle = $style ?? "width: {$size}px; height: {$size}px;";
@endphp

<i data-lucide="{{ $name }}" class="{{ $class }}" style="{{ $iconStyle }}"></i>

