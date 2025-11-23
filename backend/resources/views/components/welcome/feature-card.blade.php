@props([
    'icon',
    'title',
    'iconGradient' => 'linear-gradient(135deg, #8b5cf6, #a855f7)',
    'backgroundGradient' => 'linear-gradient(135deg, #f3e8ff, #faf5ff, white)',
    'borderColor' => '#e9d5ff',
    'shadowColor' => 'rgba(139, 92, 246, 0.2)',
    'blurColor' => 'rgba(196, 181, 253, 0.3)',
])

<div style="position: relative; background: {{ $backgroundGradient }}; border-radius: 24px; padding: 40px; border: 4px solid {{ $borderColor }}; box-shadow: 0 20px 50px {{ $shadowColor }}; width: 100%; max-width: 400px; margin: 0 auto; display: flex; flex-direction: column; align-items: center; text-align: center;">
    <div style="position: absolute; top: 0; right: 0; width: 160px; height: 160px; background: {{ $blurColor }}; border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
    <div style="position: relative; z-index: 1; display: flex; align-items: center; justify-content: center; width: 80px; height: 80px; background: {{ $iconGradient }}; border-radius: 24px; margin-bottom: 32px; box-shadow: 0 10px 25px rgba(139, 92, 246, 0.4);">
        <x-ui.icon :name="$icon" size="40" style="color: white;" />
    </div>
    <h3 style="position: relative; z-index: 1; font-size: 28px; font-weight: 900; color: #1f2937; margin-bottom: 16px; text-align: center;">{{ $title }}</h3>
    <p style="position: relative; z-index: 1; font-size: 18px; color: #4b5563; line-height: 1.6; font-weight: 500; text-align: center;">
        {{ $slot }}
    </p>
</div>

