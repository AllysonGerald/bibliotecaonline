@extends('layouts.admin')

@section('title', 'Detalhes do Aluguel')

@section('content')
<x-ui.page-header 
    title="Detalhes do Aluguel" 
    subtitle="Visualize as informações completas do aluguel"
>
    <x-ui.button href="{{ route('admin.alugueis.index') }}" variant="secondary" icon="arrow-left">Voltar</x-ui.button>
    <x-ui.button href="{{ route('admin.alugueis.edit', $aluguel) }}" variant="primary" icon="edit">Editar Aluguel</x-ui.button>
</x-ui.page-header>

<div style="display: grid; grid-template-columns: 1fr; gap: 24px; @media (min-width: 1024px) { grid-template-columns: 2fr 1fr; }">
    <!-- Informações do Aluguel -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <x-ui.info-card 
            title="Informações do Aluguel"
            icon="book"
            iconColor="#8b5cf6"
            borderColor="#e9d5ff"
            shadowColor="rgba(139, 92, 246, 0.15)"
            backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)"
        >
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <x-ui.detail-row label="Usuário">
                    <div>
                        <p style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $aluguel->user->name }}</p>
                        <p style="font-size: 14px; color: #6b7280;">{{ $aluguel->user->email }}</p>
                    </div>
                </x-ui.detail-row>
                <x-ui.detail-row label="Livro">
                    <div>
                        <p style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $aluguel->book->titulo }}</p>
                        <p style="font-size: 14px; color: #6b7280;">{{ $aluguel->book->author?->nome ?? 'Autor desconhecido' }}</p>
                    </div>
                </x-ui.detail-row>
                <x-ui.detail-row label="Alugado em" :value="$aluguel->alugado_em->format('d/m/Y H:i')" />
                <x-ui.detail-row label="Data de Devolução" :value="$aluguel->data_devolucao->format('d/m/Y H:i')" />
                @if($aluguel->devolvido_em)
                    <x-ui.detail-row label="Devolvido em" :value="$aluguel->devolvido_em->format('d/m/Y H:i')" />
                @endif
                <x-ui.detail-row label="Status">
                    @php
                        $statusVariants = [
                            'ativo' => 'info',
                            'devolvido' => 'success',
                            'atrasado' => 'danger',
                        ];
                        $statusVariant = $statusVariants[$aluguel->status->value] ?? 'default';
                    @endphp
                    <x-ui.badge :variant="$statusVariant">
                        {{ $aluguel->status->label() }}
                    </x-ui.badge>
                </x-ui.detail-row>
                @if($aluguel->taxa_atraso > 0 && (!$aluguel->fine || !$aluguel->fine->paga))
                    <x-ui.detail-row label="Taxa de Atraso">
                        <p style="font-size: 18px; font-weight: 900; color: #ef4444; margin: 0;">R$ {{ number_format($aluguel->taxa_atraso, 2, ',', '.') }}</p>
                    </x-ui.detail-row>
                @endif
            </div>

            @if($aluguel->isOverdue())
                <x-ui.alert-box
                    type="danger"
                    icon="alert-triangle"
                    title="Aluguel Atrasado"
                    message="Este aluguel está {{ $aluguel->daysOverdue() }} dia(s) atrasado."
                />
            @endif

            @if($aluguel->fine)
                <x-ui.alert-box
                    :type="$aluguel->fine->paga ? 'success' : 'warning'"
                    :icon="$aluguel->fine->paga ? 'check-circle' : 'alert-circle'"
                    title="Multa Associada"
                >
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                        <div style="flex: 1; min-width: 0;">
                            <p style="font-size: 14px; color: {{ $aluguel->fine->paga ? '#065f46' : '#b45309' }}; font-weight: 600; margin: 4px 0;">Valor: R$ {{ number_format($aluguel->fine->valor, 2, ',', '.') }}</p>
                            <p style="font-size: 14px; color: {{ $aluguel->fine->paga ? '#065f46' : '#b45309' }}; font-weight: 600; margin: 0;">Status: {{ $aluguel->fine->paga ? 'Paga' : 'Pendente' }}</p>
                            @if($aluguel->fine->paga && $aluguel->fine->paga_em)
                                <p style="font-size: 12px; color: #6b7280; margin-top: 4px;">Paga em: {{ $aluguel->fine->paga_em->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>
                        @if(!$aluguel->fine->paga)
                            <div style="flex-shrink: 0;">
                                <x-ui.button 
                                    type="button" 
                                    onclick="openPayFineModal('pay-fine-{{ $aluguel->fine->id }}')" 
                                    variant="success" 
                                    icon="check-circle"
                                    class="padding: 10px 20px; font-size: 14px; font-weight: 700; white-space: nowrap;"
                                >
                                    Marcar como Paga
                                </x-ui.button>
                                
                                <!-- Modal de Pagamento -->
                                <x-modals.pay-fine-modal
                                    id="pay-fine-{{ $aluguel->fine->id }}"
                                    title="Confirmar Pagamento da Multa"
                                    message="Tem certeza que deseja marcar esta multa como paga? Ao confirmar, a taxa de atraso será zerada."
                                    action="{{ route('admin.multas.pay', $aluguel->fine) }}"
                                    :fineValue="'R$ ' . number_format($aluguel->fine->valor, 2, ',', '.')"
                                />
                            </div>
                        @endif
                    </div>
                </x-ui.alert-box>
            @endif
        </x-ui.info-card>
    </div>

    <!-- Sidebar com Informações Adicionais -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Informações do Livro -->
        <x-ui.info-card 
            title="Informações do Livro"
            icon="book-open"
            iconColor="#ec4899"
            borderColor="#fbcfe8"
            shadowColor="rgba(236, 72, 153, 0.15)"
            backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
        >
            <x-ui.detail-row label="Categoria" :value="$aluguel->book->category->nome" />
            <x-ui.detail-row label="ISBN" :value="$aluguel->book->isbn ?? 'N/A'" />
            <x-ui.detail-row label="Editora" :value="$aluguel->book->editora ?? 'N/A'" />
        </x-ui.info-card>

        <!-- Informações do Usuário -->
        <x-ui.info-card 
            title="Informações do Usuário"
            icon="user"
            iconColor="#0ea5e9"
            borderColor="#e0f2fe"
            shadowColor="rgba(14, 165, 233, 0.15)"
            backgroundGradient="linear-gradient(135deg, #e0f2fe, #f0f9ff, white)"
        >
            <x-ui.detail-row label="Telefone" :value="$aluguel->user->telefone ?? 'N/A'" />
            <x-ui.detail-row label="Status da Conta">
                <x-ui.badge :variant="$aluguel->user->ativo ? 'success' : 'danger'">
                    {{ $aluguel->user->ativo ? 'Ativo' : 'Inativo' }}
                </x-ui.badge>
            </x-ui.detail-row>
        </x-ui.info-card>

        <!-- Informações do Sistema -->
        <x-ui.info-card 
            title="Informações do Sistema"
            icon="clock"
            iconColor="#f97316"
            borderColor="#fed7aa"
            shadowColor="rgba(249, 115, 22, 0.15)"
            backgroundGradient="linear-gradient(135deg, #fff7ed, #fff1f2, white)"
        >
            <x-ui.detail-row label="Criado em" :value="$aluguel->created_at->format('d/m/Y H:i')" />
            <x-ui.detail-row label="Atualizado em" :value="$aluguel->updated_at->format('d/m/Y H:i')" />
        </x-ui.info-card>
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

