@props(['review', 'showActions' => false])

@php
    $wasEdited = $review->created_at->ne($review->updated_at);
@endphp

<div style="padding: 20px; background: linear-gradient(135deg, #faf5ff, #f3e8ff); border-radius: 16px; border: 2px solid #e9d5ff;">
    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
        <p style="font-size: 16px; font-weight: 900; color: #1f2937; margin: 0;">{{ $review->user->name }}</p>
        <span style="font-size: 12px; color: #6b7280;">{{ $review->created_at->format('d/m/Y') }}</span>
        @if($wasEdited)
            <span style="font-size: 11px; color: #0ea5e9; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                <i data-lucide="edit-2" style="width: 12px; height: 12px;"></i>
                Editado
            </span>
        @endif
    </div>
    <div style="display: flex; gap: 4px; margin-bottom: 12px;">
        <x-reviews.star-rating :rating="$review->nota" size="16" />
    </div>
    @if($review->comentario)
        <p style="font-size: 14px; color: #4b5563; line-height: 1.6; margin: 0;">{{ $review->comentario }}</p>
    @endif
</div>

