@props([
    'name',
    'label' => null,
    'accept' => null,
    'required' => false,
    'error' => null,
])

@php
    $hasError = $error !== null || ($errors->has($name) ?? false);
    $errorMessage = $error ?? ($errors->first($name) ?? null);
    $borderColor = $hasError ? '#ef4444' : '#fed7aa';
    $focusColor = '#f97316';
    $inputStyles = "width: 100%; padding: 12px 16px; border: 2px solid {$borderColor}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box; cursor: pointer;";
    $focusEvents = "onfocus=\"this.style.borderColor='{$focusColor}'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';\" onblur=\"this.style.borderColor='{$borderColor}'; this.style.boxShadow='none';\"";
@endphp

<div>
    @if($label)
        <label for="{{ $name }}" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">
            {{ $label }}
            @if($required)
                <span style="color: #ef4444;">*</span>
            @endif
        </label>
    @endif
    
    <input
        type="file"
        name="{{ $name }}"
        id="{{ $name }}"
        @if($accept) accept="{{ $accept }}" @endif
        @if($required) required @endif
        style="{{ $inputStyles }}"
        {{ $focusEvents }}
        {{ $attributes }}
    >
    
    @if($errorMessage)
        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $errorMessage }}</p>
    @endif
</div>
