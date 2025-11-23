@props(['reviews', 'title' => 'Avaliações'])

@php
    // Obter excludeReviewId dos atributos se fornecido
    $excludeId = $attributes->get('excludeReviewId');
    $filteredReviews = $reviews->filter(function($review) use ($excludeId) {
        return $excludeId === null || $review->id !== $excludeId;
    })->take(5);
@endphp

@if($filteredReviews->count() > 0)
    <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);">
        <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 24px;">{{ $title }} ({{ $filteredReviews->count() }})</h3>
        <div style="display: flex; flex-direction: column; gap: 20px;">
            @foreach($filteredReviews as $review)
                <x-reviews.review-card :review="$review" />
            @endforeach
        </div>
    </div>
@endif

