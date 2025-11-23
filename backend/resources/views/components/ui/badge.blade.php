@props([
    'variant' => 'default', // success, warning, danger, info, default
    'size' => 'md', // sm, md, lg
])

@php
    $variants = [
        'success' => 'background: linear-gradient(135deg, #dcfce7, #f0fdf4); color: #166534; border: 2px solid #86efac;',
        'warning' => 'background: linear-gradient(135deg, #fef3c7, #fffbeb); color: #92400e; border: 2px solid #fde047;',
        'danger' => 'background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border: 2px solid #fca5a5;',
        'info' => 'background: linear-gradient(135deg, #dbeafe, #eff6ff); color: #1e40af; border: 2px solid #93c5fd;',
        'default' => 'background: linear-gradient(135deg, #f3f4f6, #ffffff); color: #6b7280; border: 2px solid #e5e7eb;',
    ];
    
    $sizes = [
        'sm' => 'padding: 4px 8px; font-size: 11px;',
        'md' => 'padding: 6px 12px; font-size: 12px;',
        'lg' => 'padding: 8px 16px; font-size: 14px;',
    ];
    
    $variantStyle = $variants[$variant] ?? $variants['default'];
    $sizeStyle = $sizes[$size] ?? $sizes['md'];
    
    $badgeStyle = "display: inline-block; {$sizeStyle} {$variantStyle} border-radius: 8px; font-weight: 700;";
@endphp

<span style="{{ $badgeStyle }}" {{ $attributes }}>
    {{ $slot }}
</span>
