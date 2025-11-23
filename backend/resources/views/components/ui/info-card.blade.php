@props([
    'title' => null,
    'icon' => null,
    'iconColor' => '#8b5cf6',
    'borderColor' => '#e9d5ff',
    'shadowColor' => 'rgba(139, 92, 246, 0.15)',
    'backgroundGradient' => 'linear-gradient(135deg, #f3e8ff, #faf5ff, white)',
    'class' => '',
])

<div style="background: {{ $backgroundGradient }}; border-radius: 20px; padding: 32px; border: 3px solid {{ $borderColor }}; box-shadow: 0 10px 30px {{ $shadowColor }}; position: relative; overflow: hidden; {{ $class }}">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: {{ $shadowColor }}; border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
    <div style="position: relative; z-index: 1;">
        @if ($title || $icon)
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                @if ($icon)
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, {{ $iconColor }}, {{ $iconColor }}cc); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px {{ $iconColor }}80;">
                        <x-ui.icon :name="$icon" size="20" style="color: white;" />
                    </div>
                @endif
                @if ($title)
                    <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin: 0;">{{ $title }}</h3>
                @endif
            </div>
        @endif

        <div>
            {{ $slot }}
        </div>
    </div>
</div>

