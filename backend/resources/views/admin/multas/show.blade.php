@extends('layouts.admin')

@section('title', 'Detalhes da Multa')

@section('content')
<x-ui.page-header 
    title="Detalhes da Multa" 
    subtitle="Visualize as informações completas da multa" 
>
    <x-slot name="actions">
        <x-ui.button href="{{ route('admin.multas.index') }}" variant="secondary" icon="arrow-left">
            Voltar
        </x-ui.button>
        @if(!$multa->paga)
            <x-ui.button 
                type="button" 
                onclick="openPayFineModal('pay-fine-{{ $multa->id }}')" 
                variant="success" 
                icon="check-circle"
            >
                Marcar como Paga
            </x-ui.button>
            
            <!-- Modal de Confirmação de Pagamento -->
            <x-modals.pay-fine-modal
                id="pay-fine-{{ $multa->id }}"
                title="Confirmar Pagamento"
                message="Tem certeza que deseja marcar esta multa como paga? Ao confirmar, a taxa de atraso será zerada."
                action="{{ route('admin.multas.pay', $multa) }}"
                :fineValue="'R$ ' . number_format($multa->valor, 2, ',', '.')"
            />
        @endif
    </x-slot>
</x-ui.page-header>

<div style="display: grid; grid-template-columns: 1fr; gap: 24px; @media (min-width: 1024px) { grid-template-columns: 2fr 1fr; }">
    <!-- Coluna Principal -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Informações da Multa -->
        <x-ui.card title="Informações da Multa" icon="dollar-sign" iconColor="#8b5cf6" borderColor="#e9d5ff" shadowColor="rgba(139, 92, 246, 0.15)" backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px;">
                <div style="padding: 20px; background: linear-gradient(135deg, {{ $multa->paga ? '#d1fae5' : '#fee2e2' }}, {{ $multa->paga ? '#ecfdf5' : '#fef2f2' }}); border-radius: 12px; border: 2px solid {{ $multa->paga ? '#86efac' : '#fca5a5' }}; border-left: 4px solid {{ $multa->paga ? '#10b981' : '#ef4444' }};">
                    <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Valor da Multa</label>
                    <p style="font-size: 32px; font-weight: 900; color: {{ $multa->paga ? '#10b981' : '#ef4444' }}; margin: 0; line-height: 1;">R$ {{ number_format($multa->valor, 2, ',', '.') }}</p>
                </div>
                <div style="padding: 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); border-radius: 12px; border: 2px solid #e9d5ff;">
                    <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Status</label>
                    <div style="margin-top: 4px;">
                        @if($multa->paga)
                            <x-ui.badge variant="success" size="lg">Paga</x-ui.badge>
                        @else
                            <x-ui.badge variant="danger" size="lg">Pendente</x-ui.badge>
                        @endif
                    </div>
                </div>
                @if($multa->paga && $multa->paga_em)
                    <div style="padding: 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); border-radius: 12px; border: 2px solid #e9d5ff;">
                        <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Paga em</label>
                        <p style="font-size: 16px; color: #1f2937; font-weight: 700; margin: 0;">{{ $multa->paga_em->format('d/m/Y H:i') }}</p>
                    </div>
                @endif
            </div>
        </x-ui.card>

        <!-- Informações do Aluguel -->
        <x-ui.card title="Aluguel Relacionado" icon="book-open" iconColor="#8b5cf6" borderColor="#e9d5ff" shadowColor="rgba(139, 92, 246, 0.15)" backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <x-ui.detail-row label="Livro" :value="$multa->rental->book->titulo" />
                <x-ui.detail-row label="Autor" :value="$multa->rental->book->author?->nome ?? 'Autor desconhecido'" />
                <x-ui.detail-row label="Alugado em" :value="$multa->rental->alugado_em->format('d/m/Y H:i')" />
                <x-ui.detail-row label="Data de Devolução" :value="$multa->rental->data_devolucao->format('d/m/Y H:i')" />
                @if($multa->rental->devolvido_em)
                    <x-ui.detail-row label="Devolvido em" :value="$multa->rental->devolvido_em->format('d/m/Y H:i')" />
                @endif
            </div>
            <div style="margin-top: 24px; padding-top: 24px; border-top: 2px solid #e9d5ff;">
                <x-ui.button href="{{ route('admin.alugueis.show', $multa->rental) }}" variant="secondary" icon="arrow-right">
                    Ver Detalhes do Aluguel
                </x-ui.button>
            </div>
        </x-ui.card>
    </div>

    <!-- Sidebar -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Informações do Usuário -->
        <x-ui.card title="Usuário" icon="user" iconColor="#8b5cf6" borderColor="#e9d5ff" shadowColor="rgba(139, 92, 246, 0.15)" backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)">
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <x-ui.detail-row label="Nome" :value="$multa->user->name" />
                <x-ui.detail-row label="E-mail" :value="$multa->user->email" />
            </div>
        </x-ui.card>
    </div>
</div>

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
@endsection

