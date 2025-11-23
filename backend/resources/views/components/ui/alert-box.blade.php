@props([
    'type' => 'info', // info, warning, danger, success
    'icon' => null,
    'title' => null,
    'message' => null,
    'iconColor' => '#8b5cf6',
    'borderColor' => '#e9d5ff',
    'backgroundGradient' => 'linear-gradient(135deg, #f3e8ff, #faf5ff)',
])

@php
    $styles = [
        'info' => [
            'icon' => $icon ?? 'info',
            'iconColor' => '#0ea5e9',
            'borderColor' => '#bae6fd',
            'backgroundGradient' => 'linear-gradient(135deg, #e0f2fe, #f0f9ff)',
            'titleColor' => '#0369a1',
            'textColor' => '#0c4a6e',
        ],
        'warning' => [
            'icon' => $icon ?? 'alert-triangle',
            'iconColor' => '#f59e0b',
            'borderColor' => '#fde047',
            'backgroundGradient' => 'linear-gradient(135deg, #fef3c7, #fffbeb)',
            'titleColor' => '#92400e',
            'textColor' => '#b45309',
        ],
        'danger' => [
            'icon' => $icon ?? 'alert-circle',
            'iconColor' => '#ef4444',
            'borderColor' => '#fca5a5',
            'backgroundGradient' => 'linear-gradient(135deg, #fee2e2, #fef2f2)',
            'titleColor' => '#991b1b',
            'textColor' => '#dc2626',
        ],
        'success' => [
            'icon' => $icon ?? 'check-circle',
            'iconColor' => '#10b981',
            'borderColor' => '#86efac',
            'backgroundGradient' => 'linear-gradient(135deg, #d1fae5, #ecfdf5)',
            'titleColor' => '#065f46',
            'textColor' => '#047857',
        ],
    ];
    $currentStyles = $styles[$type] ?? $styles['info'];
@endphp

<div style="padding: 20px; background: {{ $currentStyles['backgroundGradient'] }}; border: 2px solid {{ $currentStyles['borderColor'] }}; border-radius: 12px; margin-top: 24px;">
    <div style="display: flex; align-items: center; gap: 12px;">
        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, {{ $currentStyles['iconColor'] }}, {{ $currentStyles['iconColor'] }}cc); border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
            <x-ui.icon :name="$currentStyles['icon']" size="20" style="color: white;" />
        </div>
        <div style="flex: 1;">
            @if($title)
                <p style="font-size: 16px; font-weight: 900; color: {{ $currentStyles['titleColor'] }}; margin-bottom: 4px;">{{ $title }}</p>
            @endif
            @if($message)
                <p style="font-size: 14px; color: {{ $currentStyles['textColor'] }}; font-weight: 600; margin: 0;">{{ $message }}</p>
            @else
                {{ $slot }}
            @endif
        </div>
    </div>
</div>

