@extends('layouts.admin')

@section('title', 'Todas as Atividades')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Todas as Atividades</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Visualize todas as atividades do sistema</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Voltar ao Dashboard
            </a>
        </div>
    </div>
</div>


<!-- Lista de Atividades -->
<div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15);">
    <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ec4899, #f97316); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
            <i data-lucide="activity" style="width: 20px; height: 20px; color: white;"></i>
        </div>
        Atividades do Sistema
    </h3>
    @if($activities->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 12px;">
            @foreach($activities as $activity)
                <a href="{{ $activity['route'] }}" style="display: block; text-decoration: none;">
                    <div style="padding: 20px; background: linear-gradient(135deg, #faf5ff, #fdf2f8); border: 2px solid #fbcfe8; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #fce7f3, #fdf2f8)'; this.style.borderColor='{{ $activity['color'] }}'; this.style.transform='translateX(4px)'; this.style.boxShadow='0 4px 15px rgba(236, 72, 153, 0.2)';" onmouseout="this.style.background='linear-gradient(135deg, #faf5ff, #fdf2f8)'; this.style.borderColor='#fbcfe8'; this.style.transform='translateX(0)'; this.style.boxShadow='none';">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div style="flex: 1; display: flex; align-items: center; gap: 16px;">
                                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, {{ $activity['color'] }}, {{ $activity['color'] }}); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                                    <i data-lucide="{{ $activity['icon'] }}" style="width: 24px; height: 24px; color: white;"></i>
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
        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 0;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #fce7f3, #fff1f2); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i data-lucide="activity" style="width: 40px; height: 40px; color: #ec4899;"></i>
            </div>
            <p style="font-size: 16px; color: #6b7280; text-align: center; margin-bottom: 24px; font-weight: 500;">Nenhuma atividade encontrada.</p>
        </div>
    @endif
</div>
@endsection

