@props([
    'headers' => [], // Array de ['label' => 'Título', 'align' => 'left']
    'collection' => null, // Para paginação automática
    'paginator' => null, // Para paginação automática (alias de collection)
    'borderColor' => '#fed7aa',
    'hoverColor' => 'linear-gradient(135deg, #fff7ed, #fff1f2)',
    'shadowColor' => 'rgba(249, 115, 22, 0.15)',
    'backgroundGradient' => 'linear-gradient(135deg, #fff7ed, #fff1f2, white)',
    'paginationPrimaryColor' => '#f97316',
    'paginationPrimaryColorLight' => '#fb923c',
    'paginationBorderColor' => '#fed7aa',
    'paginationBackgroundGradient' => 'linear-gradient(135deg, #fff7ed, #fff1f2)',
    'paginationBackgroundGradientHover' => 'linear-gradient(135deg, #f97316, #fb923c)',
])

@php
    $collection = $collection ?? $paginator;
@endphp

<x-ui.card :borderColor="$borderColor" :shadowColor="$shadowColor" :backgroundGradient="$backgroundGradient">
    <div style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="responsive-table" style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead>
                <tr style="border-bottom: 3px solid {{ $borderColor }};">
                    @foreach($headers as $header)
                        <th style="padding: 16px; text-align: {{ $header['align'] ?? 'left' }}; font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">
                            {{ $header['label'] }}
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                {{ $slot }}
            </tbody>
        </table>
    </div>

    @if(($collection ?? $paginator) && ($collection ?? $paginator)->hasPages())
        @php
            view()->share([
                'pagination_primaryColor' => $paginationPrimaryColor,
                'pagination_primaryColorLight' => $paginationPrimaryColorLight,
                'pagination_borderColor' => $paginationBorderColor,
                'pagination_backgroundGradient' => $paginationBackgroundGradient,
                'pagination_backgroundGradientHover' => $paginationBackgroundGradientHover,
            ]);
        @endphp
        <div style="margin-top: 24px;">
            {{ ($collection ?? $paginator)->links('components.pagination') }}
        </div>
    @endif
</x-ui.card>
