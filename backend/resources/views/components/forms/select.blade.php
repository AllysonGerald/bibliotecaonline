@props([
    'name',
    'id' => null,
    'options', // Array of ['value' => 'label'] or Eloquent Collection
    'selected' => null,
    'value' => null, // Alias para selected para compatibilidade
    'placeholder' => 'Selecione uma opção',
    'required' => false,
    'label' => null,
    'error' => null,
    'helpText' => null,
    'class' => '',
    'borderColor' => '#fed7aa', // Cor padrão laranja (livros)
    'focusColor' => '#f97316', // Cor padrão laranja (livros)
    'backgroundGradient' => 'linear-gradient(135deg, #fff7ed, #ffffff)',
])

@php
    $id = $id ?? $name;
    // Usar value se fornecido, senão usar selected
    $selectedValue = $value ?? $selected;
    // Se ainda não tiver valor, tentar pegar do old() ou do model
    if ($selectedValue === null) {
        $selectedValue = old($name);
    }
    $hasError = $error || $errors->has($name);
    $currentBorderColor = $hasError ? '#ef4444' : $borderColor;
    $currentFocusColor = $hasError ? '#ef4444' : $focusColor;
    $selectStyles = "width: 100%; padding: 12px 16px; border: 2px solid {$currentBorderColor}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: {$backgroundGradient}; cursor: pointer; box-sizing: border-box;";
    
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
    @if ($label)
        <label for="{{ $id }}" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">
            {{ $label }} @if ($required) * @endif
        </label>
    @endif

    <select
        name="{{ $name }}"
        id="{{ $id }}"
        @if ($required) required @endif
        style="{{ $selectStyles }} {{ $class }}"
        {{ $focusEvents }}
    >
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $optionValue => $optionLabel)
            @php
                $currentValue = old($name, $selectedValue);
                $isSelected = ($currentValue !== null && (string) $currentValue === (string) $optionValue);
            @endphp
            <option value="{{ $optionValue }}" {{ $isSelected ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
    </select>

    @if ($hasError)
        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $error ?? $errors->first($name) }}</p>
    @endif

    @if ($helpText)
        <p style="margin-top: 8px; font-size: 12px; color: #9ca3af;">{{ $helpText }}</p>
    @endif
</div>
