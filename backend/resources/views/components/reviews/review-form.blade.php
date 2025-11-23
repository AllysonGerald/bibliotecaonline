@props([
    'action',
    'method' => 'POST',
    'review' => null,
    'submitLabel' => 'Enviar Avaliação',
    'cancelAction' => null,
    'starSize' => 32,
    'formId' => null,
])

@php
    $formId = $formId ?? ($review ? 'review-edit-' . $review->id : 'review-new');
    $ratingId = $review ? 'rating-stars-edit-' . $review->id : 'rating-stars';
    $currentRating = old('nota', $review?->nota ?? 0);
    $currentComment = old('comentario', $review?->comentario ?? '');
@endphp

<form method="{{ $method === 'PUT' ? 'POST' : $method }}" action="{{ $action }}" id="{{ $formId }}" @if($cancelAction && $method === 'PUT') @submit="editing = false" @endif onsubmit="return validateReviewForm{{ $formId }}(event);">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <div style="display: flex; flex-direction: column; gap: 20px;">
        <div>
            <label style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 12px;">Sua Nota *</label>
            <div style="display: flex; gap: 8px; align-items: center; position: relative;" id="{{ $ratingId }}">
                @for($i = 1; $i <= 5; $i++)
                    <label 
                        for="nota-{{ $formId }}-{{ $i }}"
                        style="cursor: pointer; display: inline-block; position: relative;"
                        onclick="(function(e) { const inputId = 'nota-{{ $formId }}-{{ $i }}'; const input = document.getElementById(inputId); if (input) { input.checked = true; input.dispatchEvent(new Event('change', { bubbles: true })); const errorMsg = document.getElementById('nota-error-{{ $formId }}'); if (errorMsg) errorMsg.style.display = 'none'; } })(event);"
                    >
                        <input 
                            type="radio" 
                            name="nota" 
                            value="{{ $i }}" 
                            id="nota-{{ $formId }}-{{ $i }}"
                            {{ $currentRating == $i ? 'checked' : '' }} 
                            required 
                            style="position: absolute; opacity: 0; width: 1px; height: 1px; margin: -1px; padding: 0; border: 0; clip: rect(0, 0, 0, 0); overflow: hidden;" 
                            @if($review)
                                onchange="updateStarsEdit({{ $i }}, {{ $review->id }})"
                            @else
                                onchange="updateStars({{ $i }})"
                            @endif
                        >
                        <i 
                            data-lucide="star" 
                            id="star-{{ $review ? 'edit-' . $review->id . '-' : '' }}{{ $i }}" 
                            data-rating="{{ $i }}" 
                            style="width: {{ $starSize }}px; height: {{ $starSize }}px; color: {{ $currentRating >= $i ? '#f97316' : '#d1d5db' }}; {{ $currentRating >= $i ? 'fill: #f97316;' : '' }}; transition: all 0.2s; cursor: pointer; pointer-events: none;" 
                            @if($review)
                                onmouseover="hoverStarEdit({{ $i }}, {{ $review->id }})"
                                onmouseout="resetStarsEdit({{ $review->id }})"
                            @else
                                onmouseover="hoverStar({{ $i }})"
                                onmouseout="resetStars()"
                            @endif
                        ></i>
                    </label>
                @endfor
                <div id="nota-error-{{ $formId }}" style="display: none; position: absolute; top: -35px; left: 0; background: #ef4444; color: white; padding: 8px 12px; border-radius: 8px; font-size: 12px; font-weight: 600; white-space: nowrap; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); z-index: 10;">
                    <span style="display: flex; align-items: center; gap: 6px;">
                        <i data-lucide="alert-circle" style="width: 14px; height: 14px;"></i>
                        Selecione uma das opções.
                    </span>
                </div>
            </div>
            @error('nota')
                <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="comentario-{{ $formId }}" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Comentário (opcional)</label>
            <textarea
                name="comentario"
                id="comentario-{{ $formId }}"
                rows="4"
                style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; font-family: inherit; resize: vertical; transition: all 0.3s; @error('comentario') border-color: #ef4444; @enderror"
                onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                placeholder="Compartilhe sua opinião sobre este livro..."
            >{{ $currentComment }}</textarea>
            @error('comentario')
                <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
            @enderror
        </div>

        <div style="display: flex; gap: 12px;">
            <x-ui.button type="submit" variant="primary" icon="{{ $review ? 'check' : 'star' }}" class="flex: 1; padding: 14px 24px; font-size: 16px;">
                {{ $submitLabel }}
            </x-ui.button>
            @if($cancelAction)
                <x-ui.button type="button" variant="outline" @click="{{ $cancelAction }}" class="padding: 14px 24px; font-size: 16px; background: linear-gradient(135deg, #f3f4f6, #e5e7eb); color: #4b5563; border-color: #d1d5db;">
                    Cancelar
                </x-ui.button>
            @endif
        </div>
    </div>
</form>

<script>
    function validateReviewForm{{ $formId }}(event) {
        const form = event.target;
        const notaInputs = form.querySelectorAll('input[name="nota"]');
        let notaSelected = false;
        
        notaInputs.forEach(input => {
            if (input.checked) {
                notaSelected = true;
            }
        });
        
        if (!notaSelected) {
            event.preventDefault();
            const errorMsg = document.getElementById('nota-error-{{ $formId }}');
            if (errorMsg) {
                errorMsg.style.display = 'block';
                setTimeout(() => {
                    errorMsg.style.display = 'none';
                }, 3000);
            }
            return false;
        }
        
        return true;
    }
</script>
