@props([
    'title',
    'subtitle' => null,
    'icon' => 'user',
    'iconColor' => '#8b5cf6',
    'iconGradient' => 'linear-gradient(135deg, #8b5cf6, #ec4899)',
    'maxWidth' => '480px',
])

<div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 20px; padding: 32px; box-shadow: 0 20px 60px rgba(139, 92, 246, 0.3); border: 2px solid rgba(233, 213, 255, 0.5); max-width: {{ $maxWidth }}; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 28px;">
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; background: {{ $iconGradient }}; border-radius: 16px; margin-bottom: 16px; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.4);">
            <x-ui.icon :name="$icon" size="32" style="color: white; flex-shrink: 0;" />
        </div>
        <h2 style="font-size: 28px; font-weight: 900; color: #1f2937; margin-bottom: 6px;">{{ $title }}</h2>
        @if($subtitle)
            <p style="font-size: 14px; color: #6b7280; font-weight: 500;">{{ $subtitle }}</p>
        @endif
    </div>

    {{ $slot }}

    @isset($footer)
        <div style="margin-top: 24px; text-align: center; display: flex; flex-direction: column; gap: 12px;">
            {{ $footer }}
        </div>
    @endisset
</div>

