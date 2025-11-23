@extends('layouts.admin')

@section('title', 'Solicitações de Pagamento')

@section('content')
<x-ui.page-header 
    title="Solicitações de Pagamento" 
    subtitle="Confirme ou rejeite solicitações de pagamento de multas" 
>
    <x-slot name="actions">
        <x-ui.button href="{{ route('admin.multas.index') }}" variant="secondary" icon="arrow-left">
            Voltar para Multas
        </x-ui.button>
    </x-slot>
</x-ui.page-header>

<!-- Lista de Solicitações -->
@if($paymentRequests->count() > 0)
    <div style="display: flex; flex-direction: column; gap: 24px;">
        @foreach($paymentRequests as $fine)
            <div class="payment-request-card" style="background: white; border-radius: 20px; padding: 24px; border: 3px solid #fbbf24; box-shadow: 0 10px 30px rgba(245, 158, 11, 0.15); transition: all 0.3s; position: relative; overflow: hidden;">
                <!-- Decorative top bar -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 6px; background: linear-gradient(90deg, #f59e0b, #d97706);"></div>
                
                <!-- Decorative background -->
                <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(245, 158, 11, 0.08); border-radius: 50%; filter: blur(40px); z-index: 0;"></div>

                <div style="position: relative; z-index: 1; display: grid; grid-template-columns: 1fr; gap: 24px; @media (min-width: 768px) { grid-template-columns: 140px 1fr auto; }">
                    <!-- Imagem do Livro -->
                    <div style="width: 100%; height: 180px; background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.2); @media (min-width: 768px) { width: 140px; height: 180px; }">
                        @if($fine->rental->book->imagem_capa)
                            <img src="{{ $fine->rental->book->imagem_capa }}" alt="{{ $fine->rental->book->titulo }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <x-ui.icon name="book-open" size="56" style="color: #f59e0b;" />
                        @endif
                    </div>

                    <!-- Informações da Solicitação -->
                    <div style="flex: 1; display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 8px; flex-wrap: wrap;">
                                <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin: 0; line-height: 1.3; flex: 1; min-width: 0;">{{ $fine->rental->book->titulo }}</h3>
                                <div style="display: flex; align-items: center; gap: 12px; flex-shrink: 0;">
                                    <x-ui.icon name="clock" size="24" style="color: #f59e0b; flex-shrink: 0;" />
                                    <x-ui.badge variant="warning" size="md">Aguardando Confirmação</x-ui.badge>
                                </div>
                            </div>
                            <p style="font-size: 16px; color: #6b7280; font-weight: 600; margin: 0;">{{ $fine->rental->book->author?->nome ?? 'Autor desconhecido' }}</p>
                        </div>

                        <!-- Informações do Usuário -->
                        <div style="padding: 16px; background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 12px; border: 2px solid #fbbf24;">
                            <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Usuário</label>
                            <p style="font-size: 18px; font-weight: 900; color: #92400e; margin: 0;">{{ $fine->user->name }}</p>
                            <p style="font-size: 14px; color: #6b7280; margin-top: 4px; margin-bottom: 0;">{{ $fine->user->email }}</p>
                        </div>

                        <!-- Valor da Multa -->
                        <div style="padding: 16px; background: linear-gradient(135deg, #fee2e2, #fecaca); border-radius: 12px; border: 2px solid #fecaca; border-left: 4px solid #ef4444;">
                            <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Valor da Multa</label>
                            <p style="font-size: 32px; font-weight: 900; color: #ef4444; margin: 0; line-height: 1;">R$ {{ number_format($fine->valor, 2, ',', '.') }}</p>
                        </div>

                        <!-- Informações do Aluguel -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; padding: 16px; background: linear-gradient(135deg, #fef2f2, #fee2e2); border-radius: 12px; border: 2px solid #fecaca;">
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">ID do Aluguel</label>
                                <p style="font-size: 15px; color: #1f2937; font-weight: 700; margin: 0;">#{{ $fine->rental->id }}</p>
                            </div>
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Solicitado em</label>
                                <p style="font-size: 15px; color: #1f2937; font-weight: 700; margin: 0;">{{ $fine->pagamento_solicitado_em->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Ações -->
                    <div style="display: flex; flex-direction: column; gap: 12px; justify-content: center; @media (min-width: 768px) { align-items: flex-end; }">
                        <x-ui.button
                            href="{{ route('admin.alugueis.show', $fine->rental) }}"
                            variant="secondary"
                            icon="book-open"
                            class="padding: 12px 24px; font-size: 14px; font-weight: 700; white-space: nowrap; background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; border-color: #fbbf24; width: 100%; @media (min-width: 768px) { width: auto; }"
                        >
                            Ver Aluguel
                        </x-ui.button>
                        <x-ui.button 
                            type="button" 
                            onclick="openPayFineModal('pay-fine-{{ $fine->id }}')" 
                            variant="success" 
                            icon="check-circle" 
                            class="padding: 12px 24px; font-size: 14px; font-weight: 700; white-space: nowrap; width: 100%; @media (min-width: 768px) { width: auto; }"
                        >
                            Confirmar Pagamento
                        </x-ui.button>
                        
                        <!-- Modal de Confirmação de Pagamento -->
                        <x-modals.pay-fine-modal
                            id="pay-fine-{{ $fine->id }}"
                            title="Confirmar Pagamento"
                            message="Tem certeza que deseja confirmar o pagamento desta multa? Ao confirmar, a taxa de atraso será zerada."
                            action="{{ route('admin.multas.pay', $fine) }}"
                            :fineValue="'R$ ' . number_format($fine->valor, 2, ',', '.')"
                        />
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <style>
        .payment-request-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(245, 158, 11, 0.25) !important;
            border-color: #f59e0b !important;
        }
    </style>

    <script>
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
    <x-ui.card 
        borderColor="#e9d5ff" 
        shadowColor="rgba(139, 92, 246, 0.15)" 
        backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)"
        class="text-align: center; padding: 64px 32px;"
    >
        <x-ui.empty-state
            title="Nenhuma solicitação de pagamento"
            message="Não há solicitações de pagamento pendentes no momento. Quando um usuário informar que realizou o pagamento de uma multa, ela aparecerá aqui para confirmação."
            icon="check-circle"
            iconColor="#8b5cf6"
            backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff)"
        />
        <div style="margin-top: 32px;">
            <x-ui.button 
                href="{{ route('admin.multas.index') }}" 
                variant="primary" 
                icon="arrow-right"
                class="padding: 14px 28px; font-size: 16px;"
            >
                Ver Todas as Multas
            </x-ui.button>
        </div>
    </x-ui.card>
@endif
@endsection

