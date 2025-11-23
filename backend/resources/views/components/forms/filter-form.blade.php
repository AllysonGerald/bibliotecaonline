@props([
    'action',
    'method' => 'GET',
    'title' => 'Filtros',
    'icon' => 'filter',
    'iconColor' => '#f97316',
    'borderColor' => '#fed7aa',
    'shadowColor' => 'rgba(249, 115, 22, 0.15)',
    'backgroundGradient' => 'linear-gradient(135deg, #fff7ed, #fff1f2, white)',
    'buttonVariant' => 'primary', // primary, success, info, warning
])

@php
    $buttonVariants = [
        'primary' => ['bg' => 'linear-gradient(135deg, #8b5cf6, #a855f7)', 'border' => '#8b5cf6', 'iconColor' => '#8b5cf6'],
        'success' => ['bg' => 'linear-gradient(135deg, #10b981, #34d399)', 'border' => '#10b981', 'iconColor' => '#10b981'],
        'info' => ['bg' => 'linear-gradient(135deg, #0ea5e9, #38bdf8)', 'border' => '#0ea5e9', 'iconColor' => '#0ea5e9'],
        'warning' => ['bg' => 'linear-gradient(135deg, #f97316, #fb923c)', 'border' => '#f97316', 'iconColor' => '#f97316'],
        'pink' => ['bg' => 'linear-gradient(135deg, #ec4899, #f472b6)', 'border' => '#ec4899', 'iconColor' => '#ec4899'],
    ];
    $buttonStyle = $buttonVariants[$buttonVariant] ?? $buttonVariants['primary'];
@endphp

<div style="margin-bottom: 48px;">
<x-ui.card :title="$title" :icon="$icon" :iconColor="$iconColor" :borderColor="$borderColor" :shadowColor="$shadowColor" :backgroundGradient="$backgroundGradient">
    <form method="{{ $method }}" action="{{ $action }}" class="filter-form-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
        {{ $slot }}
        <div style="display: flex; align-items: flex-end;">
            <button type="submit" 
                    class="filter-submit-btn" 
                    data-icon-color="{{ $buttonStyle['iconColor'] }}"
                    style="width: 100%; padding: 12px 20px; background: {{ $buttonStyle['bg'] }}; color: white; border: 3px solid {{ $buttonStyle['border'] }}; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px {{ $buttonStyle['iconColor'] }}30;">
                <x-ui.icon name="search" size="18" style="margin-right: 8px; display: inline-block; vertical-align: middle;" />
                Filtrar
            </button>
        </div>
    </form>
</x-ui.card>
</div>

<style>
    .filter-submit-btn:hover {
        transform: translateY(-2px);
    }
    @media (max-width: 768px) {
        .filter-form-grid {
            grid-template-columns: 1fr !important;
        }
    }
    @media (max-width: 640px) {
        .filter-form-grid {
            gap: 16px !important;
        }
    }
</style>

<script>
    (function() {
        const buttons = document.querySelectorAll('.filter-submit-btn');
        buttons.forEach(function(btn) {
            const iconColor = btn.getAttribute('data-icon-color');
            btn.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 6px 15px ' + iconColor + '40';
            });
            btn.addEventListener('mouseleave', function() {
                this.style.boxShadow = '0 4px 10px ' + iconColor + '30';
            });
        });
    })();
</script>
