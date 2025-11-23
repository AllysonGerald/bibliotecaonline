@extends('layouts.app')

@section('title', 'Meus Aluguéis')

@section('content')
<x-ui.page-header 
    title="Meus Aluguéis" 
    subtitle="Gerencie seus livros alugados"
/>

<!-- Filtros -->
<x-ui.card
    title="Filtros"
    icon="filter"
    iconColor="#8b5cf6"
    borderColor="#e9d5ff"
    shadowColor="rgba(139, 92, 246, 0.15)"
    backgroundGradient="white"
    class="margin-bottom: 32px;"
>
    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
        <x-ui.button
            href="{{ route('meus-alugueis') }}"
            variant="secondary"
            class="padding: 12px 24px; font-size: 14px; font-weight: 700; {{ !request('status') ? 'background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; border-color: #0ea5e9;' : 'background: linear-gradient(135deg, #e0f2fe, #f0f9ff); color: #0369a1; border-color: #bae6fd;' }}"
        >
            Todos ({{ $rentals->count() }})
        </x-ui.button>
        <x-ui.button
            href="{{ route('meus-alugueis', ['status' => 'ativo']) }}"
            variant="secondary"
            class="padding: 12px 24px; font-size: 14px; font-weight: 700; {{ request('status') === 'ativo' ? 'background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; border-color: #0ea5e9;' : 'background: linear-gradient(135deg, #e0f2fe, #f0f9ff); color: #0369a1; border-color: #bae6fd;' }}"
        >
            Ativos ({{ $activeRentals->count() }})
        </x-ui.button>
        <x-ui.button
            href="{{ route('meus-alugueis', ['status' => 'devolvido']) }}"
            variant="secondary"
            class="padding: 12px 24px; font-size: 14px; font-weight: 700; {{ request('status') === 'devolvido' ? 'background: linear-gradient(135deg, #10b981, #059669); color: white; border-color: #10b981;' : 'background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; border-color: #a7f3d0;' }}"
        >
            Devolvidos ({{ $returnedRentals->count() }})
        </x-ui.button>
        <x-ui.button
            href="{{ route('meus-alugueis', ['status' => 'atrasado']) }}"
            variant="secondary"
            class="padding: 12px 24px; font-size: 14px; font-weight: 700; {{ request('status') === 'atrasado' ? 'background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border-color: #ef4444;' : 'background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; border-color: #fecaca;' }}"
        >
            Atrasados ({{ $overdueRentals->count() }})
        </x-ui.button>
    </div>
</x-ui.card>

<!-- Lista de Aluguéis -->
@if($rentals->count() > 0)
    <div style="display: flex; flex-direction: column; gap: 20px;">
        @foreach($rentals as $rental)
            <x-ui.card class="position: relative; overflow: hidden;">
                <!-- Decorative background -->
                <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(139, 92, 246, 0.1); border-radius: 50%; filter: blur(40px); z-index: 0;"></div>
                
                <div style="position: relative; z-index: 1; display: grid; grid-template-columns: 1fr; gap: 20px; @media (min-width: 768px) { grid-template-columns: 120px 1fr auto; }">
                    <!-- Imagem do Livro -->
                    <div style="width: 100%; height: 160px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; @media (min-width: 768px) { width: 120px; height: 160px; }">
                        @if($rental->book->imagem_capa)
                            <img src="{{ $rental->book->imagem_capa }}" alt="{{ $rental->book->titulo }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <x-ui.icon name="book-open" size="48" style="color: #8b5cf6;" />
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
                                    'ativo' => ['variant' => 'success', 'label' => 'Ativo'],
                                    'devolvido' => ['variant' => 'info', 'label' => 'Devolvido'],
                                    'atrasado' => ['variant' => 'danger', 'label' => 'Atrasado'],
                                ];
                                $status = $statusConfig[$rental->status->value] ?? $statusConfig['ativo'];
                            @endphp
                            <x-ui.badge :variant="$status['variant']">{{ $status['label'] }}</x-ui.badge>
                            @if($rental->isOverdue())
                                <x-ui.badge variant="danger">{{ $rental->daysOverdue() }} dia(s) de atraso</x-ui.badge>
                            @endif
                        </div>
                    </div>

                    <!-- Ações -->
                    <div style="display: flex; flex-direction: column; gap: 12px; justify-content: center; @media (min-width: 768px) { align-items: flex-end; }">
                        <x-ui.button
                            href="{{ route('livros.show', $rental->book) }}"
                            variant="secondary"
                            icon="book-open"
                            class="padding: 10px 20px; font-size: 14px; white-space: nowrap;"
                        >
                            Ver Livro
                        </x-ui.button>
                    </div>
                </div>
            </x-ui.card>
        @endforeach
    </div>
@else
    <x-ui.card class="text-align: center;">
        <x-ui.empty-state
            title="Nenhum aluguel encontrado"
            :message="request('status') ? 'Não há aluguéis com este status.' : 'Você ainda não possui aluguéis registrados.'"
            icon="book-open"
            iconColor="#8b5cf6"
            backgroundGradient="linear-gradient(135deg, #f3e8ff, #fce7f3)"
        />
        <div style="margin-top: 24px;">
            <x-ui.button
                href="{{ route('livros.index') }}"
                variant="primary"
                icon="arrow-right"
            >
                Explorar Catálogo
            </x-ui.button>
        </div>
    </x-ui.card>
@endif
@endsection
