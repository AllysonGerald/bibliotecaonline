@props([
    'message' => 'Nenhum item encontrado.',
    'title' => null,
    'icon' => 'inbox',
    'iconColor' => '#f97316',
    'backgroundGradient' => 'linear-gradient(135deg, #fff1f2, #fff7ed)',
    'class' => '',
])

<div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 0; {{ $class }}">
    <div style="width: 80px; height: 80px; background: {{ $backgroundGradient }}; border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
        <x-ui.icon :name="$icon" size="40" :style="'color: ' . $iconColor . ';'" />
    </div>
    @if($title)
        <h3 style="font-size: 20px; font-weight: 900; color: #1f2937; margin-bottom: 8px; text-align: center;">{{ $title }}</h3>
    @endif
    <p style="font-size: 16px; color: #6b7280; text-align: center; font-weight: 500; margin: 0;">{{ $message }}</p>
</div>
