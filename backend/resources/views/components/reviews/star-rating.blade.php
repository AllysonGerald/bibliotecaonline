@props(['rating', 'size' => 16])

@for($i = 1; $i <= 5; $i++)
    <i 
        data-lucide="star" 
        style="width: {{ $size }}px; height: {{ $size }}px; color: {{ $i <= $rating ? '#f97316' : '#d1d5db' }}; {{ $i <= $rating ? 'fill: #f97316;' : '' }}"
    ></i>
@endfor

