@props([
    'name',
    'id' => null,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'label' => null,
    'error' => null,
    'helpText' => null,
    'mask' => null, // e.g., 'currency', 'phone', 'cpf'
    'min' => null,
    'max' => null,
    'accept' => null, // for type="file"
    'rows' => 4, // for textarea
    'class' => '',
    'borderColor' => '#fed7aa', // Cor padrão laranja (livros)
    'focusColor' => '#f97316', // Cor padrão laranja (livros)
    'backgroundGradient' => 'linear-gradient(135deg, #fff7ed, #ffffff)',
])

@php
    $id = $id ?? $name;
    $hasError = $error || $errors->has($name);
    $currentBorderColor = $hasError ? '#ef4444' : $borderColor;
    $currentFocusColor = $hasError ? '#ef4444' : $focusColor;
    $inputStyles = "width: 100%; padding: 12px 16px; border: 2px solid {$currentBorderColor}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: {$backgroundGradient}; box-sizing: border-box;";
    
    // Calcular rgba para o focus shadow
    $focusColorRgba = 'rgba(249, 115, 22, 0.1)'; // padrão laranja
    if (str_starts_with($currentFocusColor, '#')) {
        $hex = str_replace('#', '', $currentFocusColor);
        if (strlen($hex) === 6) {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
            $focusColorRgba = "rgba({$r}, {$g}, {$b}, 0.1)";
        }
    }
    $focusEvents = "onfocus=\"this.style.borderColor='{$currentFocusColor}'; this.style.boxShadow='0 0 0 3px {$focusColorRgba}';\"" . " onblur=\"this.style.borderColor='{$currentBorderColor}'; this.style.boxShadow='none';\"";
@endphp

<div>
    @if ($label || isset($label))
        <label for="{{ $id }}" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">
            @if(isset($label))
                {{ $label }}
            @else
                {{ $label }} @if ($required) * @endif
            @endif
        </label>
    @endif

    @if ($type === 'textarea')
        <textarea
            name="{{ $name }}"
            id="{{ $id }}"
            rows="{{ $rows }}"
            @if ($required) required @endif
            style="{{ $inputStyles }} resize: vertical; font-family: inherit; {{ $class }}"
            {{ $focusEvents }}
            placeholder="{{ $placeholder }}"
        >{{ old($name, $value) }}</textarea>
    @else
        <input
            type="{{ $type }}"
            name="{{ $name }}"
            id="{{ $id }}"
            value="{{ old($name, $value) }}"
            @if ($required) required @endif
            @if ($placeholder) placeholder="{{ $placeholder }}" @endif
            @if ($mask) data-mask="{{ $mask }}" @endif
            @if ($min !== null) min="{{ $min }}" @endif
            @if ($max !== null) max="{{ $max }}" @endif
            @if ($accept) accept="{{ $accept }}" @endif
            style="{{ $inputStyles }} {{ $class }}"
            {{ $focusEvents }}
        >
    @endif

    @if ($hasError)
        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $error ?? $errors->first($name) }}</p>
    @endif

    @if ($helpText)
        <p style="margin-top: 8px; font-size: 12px; color: #9ca3af;">{{ $helpText }}</p>
    @endif
</div>
