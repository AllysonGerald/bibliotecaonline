@props([
    'type' => 'submit',
    'variant' => 'primary', // primary, secondary, danger, success, outline, link
    'icon' => null,
    'iconSize' => 18,
    'href' => null,
    'target' => null,
    'confirm' => false,
    'confirmMessage' => 'Tem certeza?',
    'class' => '',
    'style' => '',
])

@php
    $widthStyle = str_contains($class, 'width: 100%') || str_contains($class, 'w-full') ? 'width: 100%;' : '';
    $baseStyles = 'display: inline-flex; align-items: center; justify-content: center; padding: 12px 20px; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15); cursor: pointer; text-align: center; flex-shrink: 0; ' . $widthStyle;
    $variantStyles = [
        'primary' => 'background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border: 3px solid #8b5cf6;',
        'secondary' => 'background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff;',
        'danger' => 'background: linear-gradient(135deg, #ef4444, #f87171); color: white; border: 3px solid #ef4444;',
        'success' => 'background: linear-gradient(135deg, #10b981, #059669); color: white; border: 3px solid #10b981;',
        'outline' => 'background: transparent; color: #8b5cf6; border: 3px solid #e9d5ff;',
        'link' => 'background: transparent; color: #8b5cf6; border: none; padding: 0; box-shadow: none;',
    ];
    $hoverStyles = [
        'primary' => 'transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 20px rgba(139, 92, 246, 0.5);',
        'secondary' => 'transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 20px rgba(139, 92, 246, 0.4); background: linear-gradient(135deg, #8b5cf6, #a855f7); color: white; border-color: #8b5cf6;',
        'danger' => 'transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 20px rgba(239, 68, 68, 0.5);',
        'success' => 'transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 20px rgba(16, 185, 129, 0.5);',
        'outline' => 'transform: translateY(-3px) scale(1.02); box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); background: linear-gradient(135deg, #f3e8ff, #faf5ff);',
        'link' => 'text-decoration: underline; transform: translateX(2px);',
    ];
    $currentVariantStyles = $variantStyles[$variant] ?? $variantStyles['primary'];

    // Verificar se há background customizado na classe
    $hasCustomBackground = str_contains($class, 'background:') || str_contains($class, 'background-gradient:');
    $hasCustomColor = str_contains($class, 'color:');
    $hasCustomBorder = str_contains($class, 'border-color:');
    $hasCustomStyles = $hasCustomBackground || $hasCustomColor || $hasCustomBorder;
@endphp

@php
    // Remover atributos já processados dos $attributes
    $attributes = $attributes->except(['type', 'variant', 'icon', 'iconSize', 'href', 'target', 'confirm', 'confirmMessage', 'class', 'style']);
@endphp

@if ($href)
    <a
        href="{{ $href }}"
        @if ($target) target="{{ $target }}" @endif
        class="btn-hover-effect btn-{{ $variant }}{{ $hasCustomStyles ? ' btn-custom' : '' }}"
        style="{{ $baseStyles }} {{ $currentVariantStyles }} {{ $class }} {{ $style }}"
        @if ($confirm) onclick="return confirm('{{ $confirmMessage }}')" @endif
        {{ $attributes }}
    >
        @if ($icon)
            <x-ui.icon :name="$icon" :size="$iconSize" style="margin-right: 8px; transition: transform 0.3s;" class="btn-icon" />
        @endif
        {{ $slot }}
    </a>
@else
    <button
        type="{{ $type }}"
        class="btn-hover-effect btn-{{ $variant }}{{ $hasCustomStyles ? ' btn-custom' : '' }}"
        style="{{ $baseStyles }} {{ $currentVariantStyles }} {{ $class }} {{ $style }}"
        @if ($confirm) onclick="return confirm('{{ $confirmMessage }}')" @endif
        {{ $attributes }}
    >
        @if ($icon)
            <x-ui.icon :name="$icon" :size="$iconSize" style="margin-right: 8px; transition: transform 0.3s;" class="btn-icon" />
        @endif
        {{ $slot }}
    </button>
@endif

<style>
    .btn-hover-effect {
        position: relative;
        overflow: hidden;
        will-change: transform, box-shadow;
    }

    .btn-hover-effect::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.25);
        transform: translate(-50%, -50%);
        transition: width 0.5s ease-out, height 0.5s ease-out;
        pointer-events: none !important;
        z-index: 0;
    }

    .btn-hover-effect:hover::before {
        width: 400px;
        height: 400px;
    }

    .btn-hover-effect > * {
        position: relative;
        z-index: 1;
    }

    .btn-hover-effect:hover .btn-icon {
        transform: scale(1.2) rotate(8deg) !important;
    }

    .btn-secondary:hover:not(.btn-custom) {
        background: linear-gradient(135deg, #8b5cf6, #a855f7) !important;
        color: white !important;
        border-color: #8b5cf6 !important;
        transform: translateY(-4px) scale(1.03) !important;
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.5) !important;
    }

    .btn-secondary.btn-custom:hover {
        transform: translateY(-4px) scale(1.03) !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4) !important;
    }

    /* Hover para botões azuis */
    .btn-secondary.btn-custom[style*="#0ea5e9"]:hover,
    .btn-secondary.btn-custom[style*="#38bdf8"]:hover,
    .btn-secondary.btn-custom[style*="#e0f2fe"]:hover,
    .btn-secondary.btn-custom[style*="#f0f9ff"]:hover {
        background: linear-gradient(135deg, #0ea5e9, #38bdf8) !important;
        color: white !important;
        border-color: #0ea5e9 !important;
        box-shadow: 0 10px 30px rgba(14, 165, 233, 0.5) !important;
    }

    /* Hover específico para cada cor - será sobrescrito pelo JavaScript inline se necessário */
    .btn-secondary.btn-custom[style*="#8b5cf6"]:hover,
    .btn-secondary.btn-custom[style*="#f3e8ff"]:hover {
        background: linear-gradient(135deg, #8b5cf6, #a855f7) !important;
        color: white !important;
        border-color: #8b5cf6 !important;
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.5) !important;
    }

    .btn-secondary.btn-custom[style*="#ec4899"]:hover,
    .btn-secondary.btn-custom[style*="#fce7f3"]:hover {
        background: linear-gradient(135deg, #ec4899, #f472b6) !important;
        color: white !important;
        border-color: #ec4899 !important;
        box-shadow: 0 10px 30px rgba(236, 72, 153, 0.5) !important;
    }

    .btn-secondary.btn-custom[style*="#ef4444"]:hover,
    .btn-secondary.btn-custom[style*="#dc2626"]:hover,
    .btn-secondary.btn-custom[style*="#fee2e2"]:hover,
    .btn-secondary.btn-custom[style*="#fecaca"]:hover,
    .btn-secondary.btn-custom[style*="#991b1b"]:hover {
        background: linear-gradient(135deg, #ef4444, #dc2626) !important;
        color: white !important;
        border-color: #ef4444 !important;
        box-shadow: 0 10px 30px rgba(239, 68, 68, 0.5) !important;
    }

    .btn-secondary.btn-custom[style*="#fbbf24"]:hover,
    .btn-secondary.btn-custom[style*="#f59e0b"]:hover,
    .btn-secondary.btn-custom[style*="#fef3c7"]:hover,
    .btn-secondary.btn-custom[style*="#fde68a"]:hover {
        background: linear-gradient(135deg, #fbbf24, #f59e0b) !important;
        color: white !important;
        border-color: #fbbf24 !important;
        box-shadow: 0 10px 30px rgba(251, 191, 36, 0.5) !important;
    }

    .btn-secondary.btn-custom[style*="#10b981"]:hover,
    .btn-secondary.btn-custom[style*="#059669"]:hover,
    .btn-secondary.btn-custom[style*="#d1fae5"]:hover,
    .btn-secondary.btn-custom[style*="#a7f3d0"]:hover,
    .btn-secondary.btn-custom[style*="#065f46"]:hover {
        background: linear-gradient(135deg, #10b981, #059669) !important;
        color: white !important;
        border-color: #10b981 !important;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.5) !important;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #059669, #047857) !important;
        transform: translateY(-4px) scale(1.03) !important;
        box-shadow: 0 10px 30px rgba(16, 185, 129, 0.6) !important;
    }

    .btn-primary:hover {
        transform: translateY(-4px) scale(1.03) !important;
        box-shadow: 0 10px 30px rgba(139, 92, 246, 0.6) !important;
    }

    .btn-danger:hover {
        transform: translateY(-4px) scale(1.03) !important;
        box-shadow: 0 10px 30px rgba(239, 68, 68, 0.6) !important;
    }

    .btn-hover-effect:active {
        transform: translateY(-1px) scale(0.98) !important;
    }

</style>

