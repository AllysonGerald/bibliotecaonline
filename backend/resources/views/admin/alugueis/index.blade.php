@extends('layouts.admin')

@section('title', 'Aluguéis')

@section('content')
<x-ui.page-header 
    title="Gerenciar Aluguéis" 
    subtitle="Gerencie os aluguéis de livros"
>
    <x-ui.button href="{{ route('admin.dashboard') }}" variant="secondary" icon="arrow-left">Painel do Admin</x-ui.button>
    <x-ui.button href="{{ route('admin.alugueis.create') }}" variant="primary" icon="plus">Novo Aluguel</x-ui.button>
</x-ui.page-header>

<!-- Filtros -->
<x-forms.filter-form
    action="{{ route('admin.alugueis.index') }}"
    method="GET"
    title="Filtros"
    icon="filter"
    iconColor="#8b5cf6"
    borderColor="#e9d5ff"
    shadowColor="rgba(139, 92, 246, 0.15)"
    backgroundGradient="linear-gradient(135deg, #faf5ff, #f3e8ff, white)"
    buttonVariant="primary"
>
    <x-forms.input
        type="text"
        name="search"
        label="Buscar"
        :value="request('search')"
        placeholder="Usuário, livro..."
        borderColor="#e9d5ff"
        focusColor="#8b5cf6"
        backgroundGradient="linear-gradient(135deg, #faf5ff, #ffffff)"
    />
</x-forms.filter-form>

<!-- Tabela de Aluguéis -->
@if($rentals->count() > 0)
    <x-table.table
        :headers="[
            ['label' => 'Usuário', 'align' => 'left'],
            ['label' => 'Livro', 'align' => 'left'],
            ['label' => 'Alugado em', 'align' => 'left'],
            ['label' => 'Devolução', 'align' => 'left'],
            ['label' => 'Status', 'align' => 'left'],
            ['label' => 'Ações', 'align' => 'right'],
        ]"
        borderColor="#e9d5ff"
        hoverColor="linear-gradient(135deg, #faf5ff, #f3e8ff)"
        shadowColor="rgba(139, 92, 246, 0.15)"
        backgroundGradient="linear-gradient(135deg, #faf5ff, #f3e8ff, white)"
        :paginator="$rentals"
    >
        @foreach($rentals as $rental)
            <x-table.row borderColor="#f3e8ff" hoverColor="linear-gradient(135deg, #faf5ff, #f3e8ff)">
                <td style="padding: 16px;">
                    <div style="font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $rental->user->name }}</div>
                    <div style="font-size: 13px; color: #6b7280;">{{ $rental->user->email }}</div>
                </td>
                <td style="padding: 16px;">
                    <div style="font-size: 14px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $rental->book->titulo }}</div>
                    <div style="font-size: 13px; color: #6b7280;">{{ $rental->book->author?->nome ?? 'Autor desconhecido' }}</div>
                </td>
                <td style="padding: 16px;">
                    <div style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $rental->alugado_em->format('d/m/Y H:i') }}</div>
                </td>
                <td style="padding: 16px;">
                    <div style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $rental->data_devolucao->format('d/m/Y H:i') }}</div>
                    @if($rental->devolvido_em)
                        <div style="font-size: 12px; color: #10b981; margin-top: 4px; font-weight: 600;">Devolvido: {{ $rental->devolvido_em->format('d/m/Y H:i') }}</div>
                    @endif
                </td>
                <td style="padding: 16px;">
                    @php
                        $statusVariants = [
                            'ativo' => 'info',
                            'devolvido' => 'success',
                            'atrasado' => 'danger',
                        ];
                        $statusVariant = $statusVariants[$rental->status->value] ?? 'default';
                    @endphp
                    <x-ui.badge :variant="$statusVariant">
                        {{ $rental->status->label() }}
                    </x-ui.badge>
                    @if($rental->taxa_atraso > 0)
                        <div style="font-size: 12px; color: #ef4444; margin-top: 6px; font-weight: 600;">Taxa: R$ {{ number_format($rental->taxa_atraso, 2, ',', '.') }}</div>
                    @endif
                </td>
                <td style="padding: 16px; text-align: right;">
                    <x-table.action-buttons
                        :viewHref="route('admin.alugueis.show', $rental)"
                        :editHref="route('admin.alugueis.edit', $rental)"
                        :deleteModalId="'delete-rental-' . $rental->id"
                    />
                </td>
            </x-table.row>
        @endforeach
    </x-table.table>

    <!-- Modais de Exclusão -->
    @foreach($rentals as $rental)
        <x-modals.delete-modal
            id="delete-rental-{{ $rental->id }}"
            title="Confirmar Exclusão"
            message="Tem certeza que deseja excluir este aluguel? Esta ação não pode ser desfeita."
            :action="route('admin.alugueis.destroy', $rental)"
            :itemName="'Aluguel de ' . $rental->book->titulo . ' por ' . $rental->user->name"
        />
    @endforeach
@else
    <x-ui.empty-state
        icon="book-open"
        title="Nenhum aluguel encontrado"
        :message="request('search') ? 'Não há aluguéis que correspondam à sua busca.' : 'Ainda não há aluguéis registrados no sistema.'"
        :actionHref="route('admin.alugueis.create')"
        actionText="Criar Primeiro Aluguel"
        iconColor="#8b5cf6"
    />
@endif

<script>
    function openDeleteModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            if (typeof Alpine !== 'undefined') {
                Alpine.initTree(modal);
                const alpineData = Alpine.$data(modal);
                if (alpineData) {
                    alpineData.open = true;
                }
            }
        }
    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop')) {
            e.target.style.display = 'none';
            if (typeof Alpine !== 'undefined') {
                const alpineData = Alpine.$data(e.target);
                if (alpineData) {
                    alpineData.open = false;
                }
            }
        }
    });
</script>
<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
