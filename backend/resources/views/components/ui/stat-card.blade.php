@props([
    'label',
    'value',
    'icon',
    'iconColor' => '#8b5cf6',
    'backgroundGradient' => 'linear-gradient(135deg, #f3e8ff, #faf5ff, white)',
    'borderColor' => '#e9d5ff',
    'shadowColor' => 'rgba(139, 92, 246, 0.15)',
    'hoverShadowColor' => null,
    'href' => null,
])

@php
    $hoverShadowColor = $hoverShadowColor ?? str_replace('0.15', '0.25', $shadowColor);
@endphp

@if($href)
    <a href="{{ $href }}" style="text-decoration: none; display: block;">
@endif

<div
    class="stat-card-hover"
    data-shadow-color="{{ $shadowColor }}"
    data-hover-shadow-color="{{ $hoverShadowColor }}"
    style="background: {{ $backgroundGradient }}; border-radius: 16px; padding: 28px; border: 3px solid {{ $borderColor }}; box-shadow: 0 10px 30px {{ $shadowColor }}; transition: all 0.3s; @if($href) cursor: pointer; @endif"
>
    <div style="display: flex; align-items: center; gap: 18px;">
        <div style="width: 64px; height: 64px; background: linear-gradient(135deg, {{ $iconColor }}, {{ $iconColor }}cc); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px {{ $iconColor }}80; flex-shrink: 0;">
            <x-ui.icon :name="$icon" size="32" style="color: white;" />
        </div>
        <div style="flex: 1; min-width: 0;">
            <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px; line-height: 1.2;">{{ $label }}</p>
            <p style="font-size: 36px; font-weight: 900; color: #1f2937; margin: 0; line-height: 1;">{{ $value }}</p>
        </div>
    </div>
</div>

@if($href)
    </a>
@endif

<style>
    .stat-card-hover:hover {
        transform: translateY(-4px);
    }
</style>

<script>
    (function() {
        const cards = document.querySelectorAll('.stat-card-hover');
        cards.forEach(function(card) {
            const shadowColor = card.getAttribute('data-shadow-color');
            const hoverShadowColor = card.getAttribute('data-hover-shadow-color');
            card.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 15px 40px ' + hoverShadowColor;
            });
            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = '0 10px 30px ' + shadowColor;
            });
        });
    })();
</script>
