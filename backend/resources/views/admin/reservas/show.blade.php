@extends('layouts.admin')

@section('title', 'Detalhes da Reserva')

@section('content')
<x-ui.page-header 
    title="Detalhes da Reserva" 
    subtitle="Visualize as informações completas da reserva"
>
    <x-ui.button href="{{ route('admin.reservas.index') }}" variant="secondary" icon="arrow-left">Voltar</x-ui.button>
    <x-ui.button href="{{ route('admin.reservas.edit', $reserva) }}" variant="primary" icon="edit">Editar Reserva</x-ui.button>
</x-ui.page-header>

<div style="display: grid; grid-template-columns: 1fr; gap: 24px; @media (min-width: 1024px) { grid-template-columns: 2fr 1fr; }">
    <!-- Informações da Reserva -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <x-ui.info-card 
            title="Informações da Reserva"
            icon="calendar"
            iconColor="#ec4899"
            borderColor="#fbcfe8"
            shadowColor="rgba(236, 72, 153, 0.15)"
            backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
        >
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <x-ui.detail-row label="Usuário">
                    <div>
                        <p style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $reserva->user->name }}</p>
                        <p style="font-size: 14px; color: #6b7280;">{{ $reserva->user->email }}</p>
                    </div>
                </x-ui.detail-row>
                <x-ui.detail-row label="Livro">
                    <div>
                        <p style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $reserva->book->titulo }}</p>
                        <p style="font-size: 14px; color: #6b7280;">{{ $reserva->book->author?->nome ?? 'Autor desconhecido' }}</p>
                    </div>
                </x-ui.detail-row>
                <x-ui.detail-row label="Reservado em" :value="$reserva->reservado_em->format('d/m/Y H:i')" />
                <x-ui.detail-row label="Expira em" :value="$reserva->expira_em->format('d/m/Y H:i')" />
                <x-ui.detail-row label="Status">
                    @php
                        $statusVariants = [
                            'pendente' => 'warning',
                            'confirmada' => 'success',
                            'cancelada' => 'danger',
                            'expirada' => 'default',
                        ];
                        $statusVariant = $statusVariants[$reserva->status->value] ?? 'default';
                    @endphp
                    <x-ui.badge :variant="$statusVariant">
                        {{ $reserva->status->label() }}
                    </x-ui.badge>
                </x-ui.detail-row>
            </div>

            @if($reserva->isExpired())
                <x-ui.alert-box
                    type="danger"
                    icon="alert-triangle"
                    title="Reserva Expirada"
                    message="Esta reserva expirou em {{ $reserva->expira_em->format('d/m/Y H:i') }}."
                />
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
            <x-ui.detail-row label="Categoria" :value="$reserva->book->category->nome" />
            <x-ui.detail-row label="ISBN" :value="$reserva->book->isbn ?? 'N/A'" />
            <x-ui.detail-row label="Editora" :value="$reserva->book->editora ?? 'N/A'" />
        </x-ui.info-card>

        <!-- Informações do Usuário -->
        <x-ui.info-card 
            title="Informações do Usuário"
            icon="user"
            iconColor="#ec4899"
            borderColor="#fbcfe8"
            shadowColor="rgba(236, 72, 153, 0.15)"
            backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
        >
            <x-ui.detail-row label="Telefone" :value="$reserva->user->telefone ?? 'N/A'" />
            <x-ui.detail-row label="Status da Conta">
                <x-ui.badge :variant="$reserva->user->ativo ? 'success' : 'danger'">
                    {{ $reserva->user->ativo ? 'Ativo' : 'Inativo' }}
                </x-ui.badge>
            </x-ui.detail-row>
        </x-ui.info-card>

        <!-- Timestamps -->
        <x-ui.info-card 
            title="Informações do Sistema"
            icon="clock"
            iconColor="#ec4899"
            borderColor="#fbcfe8"
            shadowColor="rgba(236, 72, 153, 0.15)"
            backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
        >
            <x-ui.detail-row label="Criado em" :value="$reserva->created_at->format('d/m/Y H:i')" />
            <x-ui.detail-row label="Atualizado em" :value="$reserva->updated_at->format('d/m/Y H:i')" />
        </x-ui.info-card>
    </div>
</div>
@endsection
