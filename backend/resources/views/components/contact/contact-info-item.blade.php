@props([
    'icon',
    'title',
    'iconGradient' => 'linear-gradient(135deg, #8b5cf6, #a855f7)',
])

<div style="display: flex; align-items: start; gap: 16px;">
    <div style="width: 48px; height: 48px; background: {{ $iconGradient }}; border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
        <x-ui.icon :name="$icon" size="24" style="color: white;" />
    </div>
    <div>
        <h3 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $title }}</h3>
        <div style="font-size: 14px; color: #6b7280; font-weight: 500;">
            {{ $slot }}
        </div>
    </div>
</div>

