@extends('layouts.app')

@section('title', 'Minhas Multas')

@section('content')
<x-ui.page-header
    title="Minhas Multas"
    subtitle="Visualize suas multas pendentes e pagas"
/>

<!-- Resumo -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <x-ui.stat-card
        label="Multas Pendentes"
        :value="$unpaidFines->count()"
        icon="alert-circle"
        iconColor="#ef4444"
        backgroundGradient="linear-gradient(135deg, #fee2e2, #fef2f2, white)"
        borderColor="#fca5a5"
        shadowColor="rgba(239, 68, 68, 0.15)"
    />

    <x-ui.stat-card
        label="Multas Pagas"
        :value="$paidFines->count()"
        icon="check-circle"
        iconColor="#10b981"
        backgroundGradient="linear-gradient(135deg, #d1fae5, #f0fdf4, white)"
        borderColor="#86efac"
        shadowColor="rgba(16, 185, 129, 0.15)"
    />

    <x-ui.stat-card
        label="Total Pendente"
        :value="'R$ ' . number_format($unpaidFines->sum('valor'), 2, ',', '.')"
        icon="dollar-sign"
        iconColor="#8b5cf6"
        backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)"
        borderColor="#e9d5ff"
        shadowColor="rgba(139, 92, 246, 0.15)"
    />
</div>

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
            href="{{ route('minhas-multas') }}"
            variant="secondary"
            class="padding: 12px 24px; font-size: 14px; font-weight: 700; {{ !request('status') ? 'background: linear-gradient(135deg, #8b5cf6, #a855f7); color: white; border-color: #8b5cf6;' : 'background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border-color: #e9d5ff;' }}"
        >
            Todas ({{ $fines->count() }})
        </x-ui.button>
        <x-ui.button
            href="{{ route('minhas-multas', ['status' => 'pendente']) }}"
            variant="secondary"
            class="padding: 12px 24px; font-size: 14px; font-weight: 700; {{ request('status') === 'pendente' ? 'background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border-color: #ef4444;' : 'background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; border-color: #fecaca;' }}"
        >
            Pendentes ({{ $unpaidFines->count() }})
        </x-ui.button>
        <x-ui.button
            href="{{ route('minhas-multas', ['status' => 'paga']) }}"
            variant="secondary"
            class="padding: 12px 24px; font-size: 14px; font-weight: 700; {{ request('status') === 'paga' ? 'background: linear-gradient(135deg, #10b981, #059669); color: white; border-color: #10b981;' : 'background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; border-color: #a7f3d0;' }}"
        >
            Pagas ({{ $paidFines->count() }})
        </x-ui.button>
    </div>
</x-ui.card>

<!-- Lista de Multas -->
@if($fines->count() > 0)
    <div style="display: flex; flex-direction: column; gap: 24px;">
        @foreach($fines as $fine)
            <div class="fine-card-hover" data-paid="{{ $fine->paga ? 'true' : 'false' }}" style="background: white; border-radius: 20px; padding: 24px; border: 3px solid {{ $fine->paga ? '#e0f2fe' : '#fee2e2' }}; box-shadow: 0 10px 30px {{ $fine->paga ? 'rgba(14, 165, 233, 0.15)' : 'rgba(239, 68, 68, 0.15)' }}; transition: all 0.3s; position: relative; overflow: hidden;">
                <!-- Decorative top bar -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 6px; background: linear-gradient(90deg, {{ $fine->paga ? '#10b981, #059669' : '#ef4444, #dc2626' }});"></div>

                <!-- Decorative background -->
                <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba({{ $fine->paga ? '16, 185, 129' : '239, 68, 68' }}, 0.08); border-radius: 50%; filter: blur(40px); z-index: 0;"></div>

                <div style="position: relative; z-index: 1; display: grid; grid-template-columns: 1fr; gap: 24px; @media (min-width: 768px) { grid-template-columns: 140px 1fr auto; }">
                    <!-- Imagem do Livro -->
                    <div style="width: 100%; height: 180px; background: linear-gradient(135deg, {{ $fine->paga ? '#d1fae5, #a7f3d0' : '#fee2e2, #fecaca' }}); border-radius: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 4px 12px {{ $fine->paga ? 'rgba(16, 185, 129, 0.2)' : 'rgba(239, 68, 68, 0.2)' }}; @media (min-width: 768px) { width: 140px; height: 180px; }">
                        @if($fine->rental->book->imagem_capa)
                            <img src="{{ $fine->rental->book->imagem_capa }}" alt="{{ $fine->rental->book->titulo }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <x-ui.icon name="book-open" size="56" style="color: {{ $fine->paga ? '#10b981' : '#ef4444' }};" />
                        @endif
                    </div>

                    <!-- Informações da Multa -->
                    <div style="flex: 1; display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 8px; flex-wrap: wrap;">
                                <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin: 0; line-height: 1.3; flex: 1; min-width: 0;">{{ $fine->rental->book->titulo }}</h3>
                                <div style="display: flex; align-items: center; gap: 12px; flex-shrink: 0;">
                                    <x-ui.icon name="{{ $fine->paga ? 'check-circle' : ($fine->pagamento_solicitado ? 'clock' : 'alert-circle') }}" size="24" :style="'color: ' . ($fine->paga ? '#10b981' : ($fine->pagamento_solicitado ? '#f59e0b' : '#ef4444')) . '; flex-shrink: 0;'" />
                                    @if($fine->paga)
                                        <x-ui.badge variant="success" size="md">Paga</x-ui.badge>
                                    @elseif($fine->pagamento_solicitado)
                                        <x-ui.badge variant="warning" size="md">Pagamento Solicitado</x-ui.badge>
                                    @else
                                        <x-ui.badge variant="danger" size="md">Pendente</x-ui.badge>
                                    @endif
                                </div>
                            </div>
                            <p style="font-size: 16px; color: #6b7280; font-weight: 600; margin: 0;">{{ $fine->rental->book->author?->nome ?? 'Autor desconhecido' }}</p>
                        </div>

                        <!-- Valor da Multa -->
                        <div style="padding: 16px; background: linear-gradient(135deg, {{ $fine->paga ? '#d1fae5, #a7f3d0' : '#fee2e2, #fecaca' }}); border-radius: 12px; border: 2px solid {{ $fine->paga ? '#a7f3d0' : '#fecaca' }}; border-left: 4px solid {{ $fine->paga ? '#10b981' : '#ef4444' }};">
                            <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Valor da Multa</label>
                            <p style="font-size: 32px; font-weight: 900; color: {{ $fine->paga ? '#10b981' : '#ef4444' }}; margin: 0; line-height: 1;">R$ {{ number_format($fine->valor, 2, ',', '.') }}</p>
                        </div>

                        <!-- Informações do Aluguel -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; padding: 16px; background: linear-gradient(135deg, {{ $fine->paga ? '#f0fdf4, #d1fae5' : '#fef2f2, #fee2e2' }}); border-radius: 12px; border: 2px solid {{ $fine->paga ? '#a7f3d0' : '#fecaca' }};">
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">ID do Aluguel</label>
                                <p style="font-size: 15px; color: #1f2937; font-weight: 700; margin: 0;">#{{ $fine->rental->id }}</p>
                            </div>
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Alugado em</label>
                                <p style="font-size: 15px; color: #1f2937; font-weight: 700; margin: 0;">{{ $fine->rental->alugado_em->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Devolução prevista</label>
                                <p style="font-size: 15px; color: #1f2937; font-weight: 700; margin: 0;">{{ $fine->rental->data_devolucao->format('d/m/Y') }}</p>
                            </div>
                            @if($fine->rental->devolvido_em)
                                <div>
                                    <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Devolvido em</label>
                                    <p style="font-size: 15px; color: #1f2937; font-weight: 700; margin: 0;">{{ $fine->rental->devolvido_em->format('d/m/Y') }}</p>
                                </div>
                            @endif
                            @if($fine->pagamento_solicitado && $fine->pagamento_solicitado_em)
                                <div>
                                    <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Solicitado em</label>
                                    <p style="font-size: 15px; color: #1f2937; font-weight: 700; margin: 0;">{{ $fine->pagamento_solicitado_em->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif
                            @if($fine->paga && $fine->paga_em)
                                <div>
                                    <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Paga em</label>
                                    <p style="font-size: 15px; color: #1f2937; font-weight: 700; margin: 0;">{{ $fine->paga_em->format('d/m/Y H:i') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Ações -->
                    <div style="display: flex; flex-direction: column; gap: 12px; justify-content: center; @media (min-width: 768px) { align-items: flex-end; }">
                        <x-ui.button
                            href="{{ route('meus-alugueis') }}"
                            variant="secondary"
                            icon="book-open"
                            class="padding: 12px 24px; font-size: 14px; font-weight: 700; white-space: nowrap; background: linear-gradient(135deg, {{ $fine->paga ? '#d1fae5, #a7f3d0' : '#fee2e2, #fecaca' }}); color: {{ $fine->paga ? '#065f46' : '#991b1b' }}; border-color: {{ $fine->paga ? '#a7f3d0' : '#fecaca' }}; width: 100%; @media (min-width: 768px) { width: auto; }"
                        >
                            Ver Aluguel
                        </x-ui.button>
                        @if(!$fine->paga && !$fine->pagamento_solicitado)
                            <x-ui.button
                                type="button"
                                onclick="openPayFineModal('pay-fine-{{ $fine->id }}')"
                                variant="success"
                                icon="check-circle"
                                class="padding: 12px 24px; font-size: 14px; font-weight: 700; white-space: nowrap; width: 100%; @media (min-width: 768px) { width: auto; }"
                            >
                                Realizei Pagamento
                            </x-ui.button>

                            <!-- Modal de Confirmação de Pagamento -->
                            <x-modals.pay-fine-modal
                                id="pay-fine-{{ $fine->id }}"
                                title="Realizei Pagamento"
                                message="Ao informar que realizou o pagamento, o administrador será notificado e confirmará o recebimento. Deseja continuar?"
                                action="{{ route('multas.pay', $fine) }}"
                                :fineValue="'R$ ' . number_format($fine->valor, 2, ',', '.')"
                            />
                        @elseif($fine->pagamento_solicitado && !$fine->paga)
                            <div style="padding: 12px; background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 12px; border: 2px solid #fbbf24; text-align: center; display: flex; align-items: center; justify-content: center; width: 100%; @media (min-width: 768px) { width: auto; min-width: 280px; }">
                                <p style="font-size: 13px; font-weight: 700; color: #92400e; margin: 0; display: flex; align-items: center; justify-content: center; gap: 6px;">
                                    <x-ui.icon name="clock" size="16" style="color: #f59e0b; flex-shrink: 0;" />
                                    <span>Aguardando confirmação do administrador</span>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <style>
        .fine-card-hover:hover {
            transform: translateY(-4px);
        }
    </style>

    <script>
        (function() {
            const cards = document.querySelectorAll('.fine-card-hover');
            cards.forEach(function(card) {
                const isPaid = card.getAttribute('data-paid') === 'true';
                const originalBorder = isPaid ? '#e0f2fe' : '#fee2e2';
                const originalShadow = isPaid ? 'rgba(14, 165, 233, 0.15)' : 'rgba(239, 68, 68, 0.15)';

                card.addEventListener('mouseenter', function() {
                    this.style.boxShadow = '0 15px 40px ' + (isPaid ? 'rgba(16, 185, 129, 0.25)' : 'rgba(239, 68, 68, 0.25)') + ' !important';
                    this.style.borderColor = (isPaid ? '#10b981' : '#ef4444') + ' !important';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.boxShadow = '0 10px 30px ' + originalShadow + ' !important';
                    this.style.borderColor = originalBorder + ' !important';
                });
            });
        })();

        function openPayFineModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.style.display = 'block';
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            }
        }
    </script>
@else
    <x-ui.empty-state
        title="Nenhuma multa encontrada"
        :message="request('status') ? 'Não há multas com este status.' : 'Você não possui multas registradas.'"
        icon="check-circle"
        iconColor="#8b5cf6"
        backgroundGradient="linear-gradient(135deg, #f3e8ff, #fce7f3)"
    />
@endif
@endsection
