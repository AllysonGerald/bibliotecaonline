@extends('layouts.admin')

@section('title', 'Reservas')

@section('content')
<x-ui.page-header 
    title="Gerenciar Reservas" 
    subtitle="Gerencie as reservas de livros"
>
    <x-ui.button href="{{ route('admin.dashboard') }}" variant="secondary" icon="arrow-left">Painel do Admin</x-ui.button>
    <x-ui.button href="{{ route('admin.reservas.create') }}" variant="primary" icon="plus">Nova Reserva</x-ui.button>
</x-ui.page-header>

<!-- Filtros - Cor Rosa para Reservas -->
<x-forms.filter-form 
    action="{{ route('admin.reservas.index') }}" 
    method="GET" 
    title="Filtros" 
    icon="filter" 
    iconColor="#ec4899"
    borderColor="#fbcfe8"
    shadowColor="rgba(236, 72, 153, 0.15)"
    backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
    buttonVariant="pink"
>
    <x-forms.input
        type="text"
        name="search"
        label="Buscar"
        :value="request('search')"
        placeholder="Usuário, livro..."
        borderColor="#fbcfe8"
        focusColor="#ec4899"
        backgroundGradient="linear-gradient(135deg, #fdf2f8, #ffffff)"
    />
    
    <x-forms.select
        name="usuario_id"
        label="Usuário"
        :options="['' => 'Todos'] + $users->pluck('name', 'id')->toArray()"
        :value="request('usuario_id')"
        borderColor="#fbcfe8"
        focusColor="#ec4899"
        backgroundGradient="linear-gradient(135deg, #fdf2f8, #ffffff)"
    />
    
    <x-forms.select
        name="livro_id"
        label="Livro"
        :options="['' => 'Todos'] + $books->pluck('titulo', 'id')->toArray()"
        :value="request('livro_id')"
        borderColor="#fbcfe8"
        focusColor="#ec4899"
        backgroundGradient="linear-gradient(135deg, #fdf2f8, #ffffff)"
    />
    
    <x-forms.select
        name="status"
        label="Status"
        :options="['' => 'Todos'] + collect($statuses)->mapWithKeys(fn($status) => [$status->value => $status->label()])->toArray()"
        :value="request('status')"
        borderColor="#fbcfe8"
        focusColor="#ec4899"
        backgroundGradient="linear-gradient(135deg, #fdf2f8, #ffffff)"
    />
</x-forms.filter-form>

<!-- Tabela de Reservas - Cor Rosa -->
@php
    $headers = [
        ['label' => 'Usuário', 'align' => 'left'],
        ['label' => 'Livro', 'align' => 'left'],
        ['label' => 'Reservado em', 'align' => 'left'],
        ['label' => 'Expira em', 'align' => 'left'],
        ['label' => 'Status', 'align' => 'left'],
        ['label' => 'Ações', 'align' => 'right'],
    ];
@endphp

<x-table.table 
    :headers="$headers" 
    :collection="$reservations"
    borderColor="#fbcfe8"
    hoverColor="linear-gradient(135deg, #fdf2f8, #fce7f3)"
    shadowColor="rgba(236, 72, 153, 0.15)"
    backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
    paginationPrimaryColor="#ec4899"
    paginationPrimaryColorLight="#f472b6"
    paginationBorderColor="#fbcfe8"
    paginationBackgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8)"
    paginationBackgroundGradientHover="linear-gradient(135deg, #ec4899, #f472b6)"
>
    @forelse($reservations as $reservation)
        <x-table.row borderColor="#fce7f3" hoverColor="linear-gradient(135deg, #fdf2f8, #fce7f3)">
                            <td style="padding: 16px;">
                                <div style="font-size: 15px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $reservation->user->name }}</div>
                                <div style="font-size: 13px; color: #9ca3af;">{{ $reservation->user->email }}</div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-size: 15px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $reservation->book->titulo }}</div>
                                <div style="font-size: 13px; color: #9ca3af; font-weight: 500;">{{ $reservation->book->author?->nome ?? 'Autor desconhecido' }}</div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-size: 14px; color: #4b5563; font-weight: 600;">{{ $reservation->reservado_em->format('d/m/Y H:i') }}</div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-size: 14px; color: #4b5563; font-weight: 600; margin-bottom: 4px;">{{ $reservation->expira_em->format('d/m/Y H:i') }}</div>
                                @if($reservation->isExpired())
                                    <span style="display: inline-block; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border: 2px solid #fca5a5;">
                                        Expirada
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 16px;">
                                @php
                                    $statusVariants = [
                                        'pendente' => 'warning',
                                        'confirmada' => 'success',
                                        'cancelada' => 'danger',
                                        'expirada' => 'default',
                                    ];
                                    $statusVariant = $statusVariants[$reservation->status->value] ?? 'default';
                                @endphp
                                <x-ui.badge :variant="$statusVariant">
                                    {{ $reservation->status->label() }}
                                </x-ui.badge>
                            </td>
                            <td style="padding: 16px; text-align: right;">
                                <x-table.action-buttons
                                    :viewHref="route('admin.reservas.show', $reservation)"
                                    :editHref="route('admin.reservas.edit', $reservation)"
                                    :deleteModalId="'delete-reservation-' . $reservation->id"
                                />
                            </td>
                        </x-table.row>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 48px; text-align: center;">
                                <x-ui.empty-state
                                    icon="clock"
                                    title="Nenhuma reserva encontrada"
                                    message="Não há reservas cadastradas no sistema."
                                    iconColor="#ec4899"
                                    backgroundGradient="linear-gradient(135deg, #fce7f3, #fff1f2)"
                                />
                            </td>
                        </tr>
                    @endforelse
</x-table.table>

<!-- Modais de Exclusão -->
@foreach($reservations as $reservation)
    @php
        $reservationName = 'Reserva de ' . $reservation->book->titulo . ' por ' . $reservation->user->name;
    @endphp
    <x-modals.delete-modal
        id="delete-reservation-{{ $reservation->id }}"
        title="Confirmar Exclusão"
        message="Tem certeza que deseja excluir esta reserva? Esta ação não pode ser desfeita."
        :action="route('admin.reservas.destroy', $reservation)"
        :itemName="$reservationName"
    />
@endforeach

<script>
    function openDeleteModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            // Inicializar Alpine.js se necessário
            if (typeof Alpine !== 'undefined') {
                Alpine.initTree(modal);
                const alpineData = Alpine.$data(modal);
                if (alpineData) {
                    alpineData.open = true;
                }
            }
        }
    }
    
    // Fechar modal ao clicar no backdrop
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
