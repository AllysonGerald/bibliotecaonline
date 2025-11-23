@props([
    'text',
    'iconColor' => '#8b5cf6',
])

<li style="display: flex; align-items: start; gap: 12px;">
    <x-ui.icon name="check-circle" size="20" style="color: {{ $iconColor }}; flex-shrink: 0; margin-top: 2px;" />
    <span style="font-size: 14px; color: #4b5563; font-weight: 500;">{{ $text }}</span>
</li>

