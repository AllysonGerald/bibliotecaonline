@extends('layouts.app')

@section('title', 'Minhas Multas')

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Minhas Multas</h1>
    <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Visualize suas multas pendentes e pagas</p>
</div>

<!-- Resumo -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 32px;">
    <div style="background: linear-gradient(135deg, #fee2e2, #fef2f2, white); border-radius: 16px; padding: 24px; border: 3px solid #fca5a5; box-shadow: 0 10px 30px rgba(239, 68, 68, 0.15);">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #ef4444, #dc2626); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);">
                <i data-lucide="alert-circle" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Multas Pendentes</p>
                <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $unpaidFines->count() }}</p>
            </div>
        </div>
    </div>

    <div style="background: linear-gradient(135deg, #d1fae5, #f0fdf4, white); border-radius: 16px; padding: 24px; border: 3px solid #86efac; box-shadow: 0 10px 30px rgba(34, 197, 94, 0.15);">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);">
                <i data-lucide="check-circle" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Multas Pagas</p>
                <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $paidFines->count() }}</p>
            </div>
        </div>
    </div>

    <div style="background: linear-gradient(135deg, #f3e8ff, #faf5ff, white); border-radius: 16px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);">
                <i data-lucide="dollar-sign" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Total Pendente</p>
                <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">R$ {{ number_format($unpaidFines->sum('valor'), 2, ',', '.') }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Filtros -->
<div style="background: white; border-radius: 20px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); margin-bottom: 32px;">
    <form method="GET" action="{{ route('minhas-multas') }}" style="display: flex; gap: 12px; flex-wrap: wrap;">
        <a href="{{ route('minhas-multas') }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: {{ !request('status') ? 'linear-gradient(135deg, #8b5cf6, #ec4899)' : 'linear-gradient(135deg, #f3e8ff, #faf5ff)' }}; color: {{ !request('status') ? 'white' : '#8b5cf6' }}; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; border: {{ !request('status') ? 'none' : '3px solid #e9d5ff' }}; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
            Todas ({{ $fines->count() }})
        </a>
        <a href="{{ route('minhas-multas', ['status' => 'pendente']) }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: {{ request('status') === 'pendente' ? 'linear-gradient(135deg, #ef4444, #dc2626)' : 'linear-gradient(135deg, #fee2e2, #fef2f2)' }}; color: {{ request('status') === 'pendente' ? 'white' : '#991b1b' }}; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; border: {{ request('status') === 'pendente' ? 'none' : '3px solid #fca5a5' }}; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
            Pendentes ({{ $unpaidFines->count() }})
        </a>
        <a href="{{ route('minhas-multas', ['status' => 'paga']) }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: {{ request('status') === 'paga' ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #d1fae5, #a7f3d0)' }}; color: {{ request('status') === 'paga' ? 'white' : '#065f46' }}; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; border: {{ request('status') === 'paga' ? 'none' : '3px solid #86efac' }}; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
            Pagas ({{ $paidFines->count() }})
        </a>
    </form>
</div>

<!-- Lista de Multas -->
@if($fines->count() > 0)
    <div style="display: flex; flex-direction: column; gap: 20px;">
        @foreach($fines as $fine)
            <div style="background: white; border-radius: 20px; padding: 24px; border: 3px solid {{ $fine->paga ? '#86efac' : '#fca5a5' }}; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); transition: all 0.3s; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(139, 92, 246, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(139, 92, 246, 0.15)';">
                <!-- Decorative background -->
                <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(139, 92, 246, 0.1); border-radius: 50%; filter: blur(40px); z-index: 0;"></div>
                
                <div style="position: relative; z-index: 1; display: grid; grid-template-columns: 1fr; gap: 20px; @media (min-width: 768px) { grid-template-columns: 120px 1fr auto; }">
                    <!-- Ícone -->
                    <div style="width: 100%; height: 120px; background: linear-gradient(135deg, {{ $fine->paga ? '#d1fae5' : '#fee2e2' }}, {{ $fine->paga ? '#f0fdf4' : '#fef2f2' }}); border-radius: 16px; display: flex; align-items: center; justify-content: center; @media (min-width: 768px) { width: 120px; height: 120px; }">
                        <i data-lucide="{{ $fine->paga ? 'check-circle' : 'alert-circle' }}" style="width: 48px; height: 48px; color: {{ $fine->paga ? '#10b981' : '#ef4444' }};"></i>
                    </div>

                    <!-- Informações da Multa -->
                    <div style="flex: 1;">
                        <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">{{ $fine->rental->book->titulo }}</h3>
                        <p style="font-size: 16px; color: #6b7280; font-weight: 600; margin-bottom: 16px;">{{ $fine->rental->book->author->nome }}</p>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Valor da Multa</label>
                                <p style="font-size: 24px; font-weight: 900; color: {{ $fine->paga ? '#10b981' : '#ef4444' }};">R$ {{ number_format($fine->valor, 2, ',', '.') }}</p>
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Aluguel #</label>
                                <p style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $fine->rental->id }}</p>
                            </div>
                            @if($fine->paga && $fine->paga_em)
                                <div>
                                    <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Paga em</label>
                                    <p style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $fine->paga_em->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Status -->
                        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                            @if($fine->paga)
                                <span style="display: inline-block; padding: 8px 16px; background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; border-radius: 10px; font-size: 13px; font-weight: 700; border: 2px solid #86efac;">
                                    Paga
                                </span>
                            @else
                                <span style="display: inline-block; padding: 8px 16px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border-radius: 10px; font-size: 13px; font-weight: 700; border: 2px solid #fca5a5;">
                                    Pendente
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Ações -->
                    <div style="display: flex; flex-direction: column; gap: 12px; justify-content: center; @media (min-width: 768px) { align-items: flex-end; }">
                        <a href="{{ route('meus-alugueis') }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; white-space: nowrap;" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff';">
                            <i data-lucide="book-open" style="width: 16px; height: 16px; margin-right: 6px;"></i>
                            Ver Aluguel
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div style="background: white; border-radius: 20px; padding: 64px 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); text-align: center;">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <i data-lucide="check-circle" style="width: 40px; height: 40px; color: #8b5cf6;"></i>
        </div>
        <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 12px;">Nenhuma multa encontrada</h3>
        <p style="font-size: 16px; color: #6b7280; font-weight: 500; margin-bottom: 24px;">
            @if(request('status'))
                Não há multas com este status.
            @else
                Você não possui multas registradas.
            @endif
        </p>
    </div>
@endif
@endsection

