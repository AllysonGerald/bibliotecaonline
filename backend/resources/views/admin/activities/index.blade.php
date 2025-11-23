@extends('layouts.admin')

@section('title', 'Todas as Atividades')

@section('content')
<x-ui.page-header
    title="Todas as Atividades"
    subtitle="Visualize todas as atividades do sistema"
>
    <x-ui.button href="{{ route('admin.dashboard') }}" variant="secondary" icon="arrow-left">Voltar ao Dashboard</x-ui.button>
</x-ui.page-header>


<!-- Lista de Atividades -->
<x-ui.card
    title="Atividades do Sistema"
    icon="activity"
    iconColor="#ec4899"
    borderColor="#fbcfe8"
    shadowColor="rgba(236, 72, 153, 0.15)"
    backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
>
    @if($activities->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @foreach($activities as $activity)
                <a href="{{ $activity['route'] }}" style="display: block; text-decoration: none;">
                    <div class="activity-item" 
                         data-color="{{ $activity['color'] }}"
                         style="padding: 20px; background: linear-gradient(135deg, #faf5ff, #fdf2f8); border: 2px solid #fbcfe8; border-radius: 12px; transition: all 0.3s;">
                        <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap; gap: 12px;">
                            <div style="flex: 1; display: flex; align-items: center; gap: 16px; min-width: 0;">
                                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, {{ $activity['color'] }}, {{ $activity['color'] }}); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                                    <x-ui.icon :name="$activity['icon']" size="24" style="color: white;" />
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <p style="font-size: 16px; font-weight: 900; color: #1f2937; margin-bottom: 6px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $activity['title'] }}</p>
                                    <p style="font-size: 13px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">
                                        <span style="color: {{ $activity['color'] }}; font-weight: 700;">{{ ucfirst($activity['type']) }}</span> {{ $activity['action'] }} por <span style="font-weight: 700;">{{ $activity['user'] }}</span>
                                    </p>
                                    <p style="font-size: 12px; color: #9ca3af; margin: 0;">{{ $activity['date']->format('d/m/Y H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <style>
            .activity-item:hover {
                background: linear-gradient(135deg, #fce7f3, #fdf2f8) !important;
                transform: translateX(4px);
                box-shadow: 0 4px 15px rgba(236, 72, 153, 0.2) !important;
            }
        </style>

        <script>
            (function() {
                const items = document.querySelectorAll('.activity-item');
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

        <!-- Paginação -->
        @if(isset($paginator) && $paginator->hasPages())
            @php
                view()->share([
                    'pagination_primaryColor' => '#ec4899',
                    'pagination_primaryColorLight' => '#f472b6',
                    'pagination_borderColor' => '#fbcfe8',
                    'pagination_backgroundGradient' => 'linear-gradient(135deg, #fce7f3, #fdf2f8)',
                    'pagination_backgroundGradientHover' => 'linear-gradient(135deg, #ec4899, #f472b6)',
                ]);
            @endphp
            {{ $paginator->links('components.pagination') }}
        @endif
    @else
        <x-ui.empty-state
            icon="activity"
            message="Nenhuma atividade encontrada."
            iconColor="#ec4899"
            backgroundGradient="linear-gradient(135deg, #fce7f3, #fff1f2)"
        />
    @endif
</x-ui.card>
@endsection

