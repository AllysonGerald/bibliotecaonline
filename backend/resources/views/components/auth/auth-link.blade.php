@props([
    'href',
    'text',
    'linkText',
    'icon' => null,
    'color' => '#8b5cf6',
])

<p style="font-size: 13px; color: #6b7280;">
    {{ $text }}
    <a href="{{ $href }}" style="font-weight: 700; color: {{ $color }}; text-decoration: none; margin-left: 4px;">
        {{ $linkText }}
    </a>
</p>

