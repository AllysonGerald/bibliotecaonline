@props(['type' => 'success', 'message', 'dismissible' => true, 'timeout' => 5000, 'class' => ''])

@php
    $styles = [
        'success' => [
            'container' => 'margin-bottom: 24px; padding: 16px; background: linear-gradient(135deg, #d1fae5, #a7f3d0); border: 3px solid #86efac; border-radius: 12px; color: #065f46; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);',
            'icon' => 'check-circle',
            'icon_color' => '#10b981',
            'button_color' => '#065f46',
            'button_hover_color' => '#047857',
        ],
        'error' => [
            'container' => 'margin-bottom: 24px; padding: 16px; background: linear-gradient(135deg, #fee2e2, #fef2f2); border: 3px solid #fca5a5; border-radius: 12px; color: #991b1b; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.2);',
            'icon' => 'alert-circle',
            'icon_color' => '#ef4444',
            'button_color' => '#991b1b',
            'button_hover_color' => '#7f1d1d',
        ],
    ];
    $currentStyles = $styles[$type] ?? $styles['success'];
    $containerStyle = $currentStyles['container'];
    if ($class) {
        // Adicionar estilos customizados da classe
        $containerStyle .= ' ' . $class;
    }
@endphp

<div style="{{ $containerStyle }}" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
    <div style="display: flex; align-items: center; justify-content: space-between;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <x-ui.icon :name="$currentStyles['icon']" size="20" :style="'color: ' . $currentStyles['icon_color'] . ';'" />
            <span style="font-weight: 600;">{{ $message }}</span>
        </div>
        <button @click="show = false" style="background: transparent; border: none; cursor: pointer; color: {{ $currentStyles['button_color'] }}; padding: 4px;" onmouseover="this.style.color='{{ $currentStyles['button_hover_color'] }}';" onmouseout="this.style.color='{{ $currentStyles['button_color'] }}';">
            <x-ui.icon name="x" size="18" />
        </button>
    </div>
</div>
