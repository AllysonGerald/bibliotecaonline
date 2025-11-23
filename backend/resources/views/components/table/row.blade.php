@props([
    'borderColor' => '#fff1f2',
    'hoverColor' => 'linear-gradient(135deg, #fff7ed, #fff1f2)',
])

@php
    $hoverColorEscaped = str_replace("'", "\\'", $hoverColor);
@endphp

<tr class="table-row-hover" style="border-bottom: 2px solid {{ $borderColor }}; transition: all 0.3s;" data-hover-color="{{ $hoverColor }}">
    {{ $slot }}
</tr>

<style>
    .table-row-hover:hover {
        background: var(--hover-color, linear-gradient(135deg, #fff7ed, #fff1f2)) !important;
    }
</style>

<script>
    (function() {
        const rows = document.querySelectorAll('.table-row-hover');
        rows.forEach(function(row) {
            const hoverColor = row.getAttribute('data-hover-color');
            row.addEventListener('mouseenter', function() {
                this.style.background = hoverColor;
            });
            row.addEventListener('mouseleave', function() {
                this.style.background = 'transparent';
            });
        });
    })();
</script>

