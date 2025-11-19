@extends('layouts.app')

@section('title', 'Meus Aluguéis')

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Meus Aluguéis</h1>
    <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Gerencie seus livros alugados</p>
</div>

<!-- Filtros -->
<div style="background: white; border-radius: 20px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); margin-bottom: 32px;">
    <form method="GET" action="{{ route('meus-alugueis') }}" style="display: flex; gap: 12px; flex-wrap: wrap;">
        <a href="{{ route('meus-alugueis') }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: {{ !request('status') ? 'linear-gradient(135deg, #8b5cf6, #ec4899)' : 'linear-gradient(135deg, #f3e8ff, #faf5ff)' }}; color: {{ !request('status') ? 'white' : '#8b5cf6' }}; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; border: {{ !request('status') ? 'none' : '3px solid #e9d5ff' }}; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
            Todos ({{ $rentals->count() }})
        </a>
        <a href="{{ route('meus-alugueis', ['status' => 'ativo']) }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: {{ request('status') === 'ativo' ? 'linear-gradient(135deg, #8b5cf6, #ec4899)' : 'linear-gradient(135deg, #f3e8ff, #faf5ff)' }}; color: {{ request('status') === 'ativo' ? 'white' : '#8b5cf6' }}; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; border: {{ request('status') === 'ativo' ? 'none' : '3px solid #e9d5ff' }}; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
            Ativos ({{ $activeRentals->count() }})
        </a>
        <a href="{{ route('meus-alugueis', ['status' => 'devolvido']) }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: {{ request('status') === 'devolvido' ? 'linear-gradient(135deg, #8b5cf6, #ec4899)' : 'linear-gradient(135deg, #f3e8ff, #faf5ff)' }}; color: {{ request('status') === 'devolvido' ? 'white' : '#8b5cf6' }}; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; border: {{ request('status') === 'devolvido' ? 'none' : '3px solid #e9d5ff' }}; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
            Devolvidos ({{ $returnedRentals->count() }})
        </a>
        <a href="{{ route('meus-alugueis', ['status' => 'atrasado']) }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: {{ request('status') === 'atrasado' ? 'linear-gradient(135deg, #ef4444, #dc2626)' : 'linear-gradient(135deg, #fee2e2, #fef2f2)' }}; color: {{ request('status') === 'atrasado' ? 'white' : '#991b1b' }}; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; border: {{ request('status') === 'atrasado' ? 'none' : '3px solid #fca5a5' }}; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
            Atrasados ({{ $overdueRentals->count() }})
        </a>
    </form>
</div>

<!-- Lista de Aluguéis -->
@if($rentals->count() > 0)
    <div style="display: flex; flex-direction: column; gap: 20px;">
        @foreach($rentals as $rental)
            <div style="background: white; border-radius: 20px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); transition: all 0.3s; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(139, 92, 246, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(139, 92, 246, 0.15)';">
                <!-- Decorative background -->
                <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(139, 92, 246, 0.1); border-radius: 50%; filter: blur(40px); z-index: 0;"></div>
                
                <div style="position: relative; z-index: 1; display: grid; grid-template-columns: 1fr; gap: 20px; @media (min-width: 768px) { grid-template-columns: 120px 1fr auto; }">
                    <!-- Imagem do Livro -->
                    <div style="width: 100%; height: 160px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; @media (min-width: 768px) { width: 120px; height: 160px; }">
                        @if($rental->book->imagem_capa)
                            <img src="{{ $rental->book->imagem_capa }}" alt="{{ $rental->book->titulo }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i data-lucide="book-open" style="width: 48px; height: 48px; color: #8b5cf6;"></i>
                        @endif
                    </div>

                    <!-- Informações do Aluguel -->
                    <div style="flex: 1;">
                        <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">{{ $rental->book->titulo }}</h3>
                        <p style="font-size: 16px; color: #6b7280; font-weight: 600; margin-bottom: 16px;">{{ $rental->book->author?->nome ?? 'Autor desconhecido' }}</p>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Alugado em</label>
                                <p style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $rental->alugado_em->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Devolução prevista</label>
                                <p style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $rental->data_devolucao->format('d/m/Y') }}</p>
                            </div>
                            @if($rental->devolvido_em)
                                <div>
                                    <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Devolvido em</label>
                                    <p style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $rental->devolvido_em->format('d/m/Y') }}</p>
                                </div>
                            @endif
                            @if($rental->taxa_atraso > 0)
                                <div>
                                    <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Taxa de atraso</label>
                                    <p style="font-size: 16px; color: #ef4444; font-weight: 900;">R$ {{ number_format($rental->taxa_atraso, 2, ',', '.') }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Status -->
                        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                            @php
                                $statusConfig = [
                                    'ativo' => ['bg' => 'linear-gradient(135deg, #dcfce7, #f0fdf4)', 'color' => '#166534', 'border' => '#86efac', 'label' => 'Ativo'],
                                    'devolvido' => ['bg' => 'linear-gradient(135deg, #dbeafe, #eff6ff)', 'color' => '#1e40af', 'border' => '#93c5fd', 'label' => 'Devolvido'],
                                    'atrasado' => ['bg' => 'linear-gradient(135deg, #fee2e2, #fef2f2)', 'color' => '#991b1b', 'border' => '#fca5a5', 'label' => 'Atrasado'],
                                ];
                                $status = $statusConfig[$rental->status->value] ?? $statusConfig['ativo'];
                            @endphp
                            <span style="display: inline-block; padding: 8px 16px; background: {{ $status['bg'] }}; color: {{ $status['color'] }}; border-radius: 10px; font-size: 13px; font-weight: 700; border: 2px solid {{ $status['border'] }};">
                                {{ $status['label'] }}
                            </span>
                            @if($rental->isOverdue())
                                <span style="display: inline-block; padding: 8px 16px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border-radius: 10px; font-size: 13px; font-weight: 700; border: 2px solid #fca5a5;">
                                    {{ $rental->daysOverdue() }} dia(s) de atraso
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Ações -->
                    <div style="display: flex; flex-direction: column; gap: 12px; justify-content: center; @media (min-width: 768px) { align-items: flex-end; }">
                        <a href="{{ route('livros.show', $rental->book) }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; white-space: nowrap;" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff';">
                            <i data-lucide="book-open" style="width: 16px; height: 16px; margin-right: 6px;"></i>
                            Ver Livro
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div style="background: white; border-radius: 20px; padding: 64px 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); text-align: center;">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <i data-lucide="book-open" style="width: 40px; height: 40px; color: #8b5cf6;"></i>
        </div>
        <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 12px;">Nenhum aluguel encontrado</h3>
        <p style="font-size: 16px; color: #6b7280; font-weight: 500; margin-bottom: 24px;">
            @if(request('status'))
                Não há aluguéis com este status.
            @else
                Você ainda não possui aluguéis registrados.
            @endif
        </p>
        <a href="{{ route('livros.index') }}" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-weight: 700; text-decoration: none; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
            <span>Explorar Catálogo</span>
            <i data-lucide="arrow-right" style="width: 18px; height: 18px; margin-left: 8px;"></i>
        </a>
    </div>
@endif
@endsection

