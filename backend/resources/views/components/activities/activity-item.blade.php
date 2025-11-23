@props([
    'route',
    'icon',
    'title',
    'type',
    'action',
    'date',
    'color' => '#ec4899',
])

<a href="{{ $route }}" style="text-decoration: none; display: block;">
    <div class="activity-item-hover" 
         data-color="{{ $color }}"
         style="background: linear-gradient(135deg, #fce7f3, #fdf2f8); border-radius: 12px; padding: 16px; border: 2px solid #fbcfe8; transition: all 0.3s;">
        <div style="display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; background: {{ $color }}; border-radius: 10px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <x-ui.icon :name="$icon" size="20" style="color: white;" />
            </div>
            <div style="flex: 1; min-width: 0;">
                <p style="font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $title }}</p>
                <p style="font-size: 12px; color: #6b7280; margin-bottom: 4px;">
                    <span style="font-weight: 600; color: {{ $color }};">{{ ucfirst($type === 'wishlist' ? 'lista de desejos' : $type) }}</span> {{ $action }}
                </p>
                <p style="font-size: 11px; color: #9ca3af; margin: 0;">{{ $date->format('d/m/Y H:i') }}</p>
            </div>
        </div>
    </div>
</a>

<style>
    .activity-item-hover:hover {
        transform: translateX(4px);
        box-shadow: 0 4px 15px rgba(236, 72, 153, 0.2) !important;
    }
</style>

<script>
    (function() {
        const items = document.querySelectorAll('.activity-item-hover');
        items.forEach(function(item) {
            const color = item.getAttribute('data-color');
            item.addEventListener('mouseenter', function() {
                this.style.borderColor = color;
            });
            item.addEventListener('mouseleave', function() {
                this.style.borderColor = '#fbcfe8';
            });
        });
    })();
</script>

