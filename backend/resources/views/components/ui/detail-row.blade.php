@props([
    'label',
    'value' => null,
    'icon' => null,
    'iconColor' => '#8b5cf6',
    'class' => '',
])

<div style="margin-bottom: 16px; {{ $class }}">
    @if($icon)
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 4px;">
            <x-ui.icon :name="$icon" size="16" :style="'color: ' . $iconColor . ';'" />
            <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">{{ $label }}</p>
        </div>
    @else
        <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">{{ $label }}</p>
    @endif
    @if($value !== null)
        <p style="font-size: 16px; font-weight: 700; color: #1f2937; margin: 0;">{{ $value }}</p>
    @else
        {{ $slot }}
    @endif
</div>

