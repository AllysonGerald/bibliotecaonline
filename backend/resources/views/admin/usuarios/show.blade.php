@extends('layouts.admin')

@section('title', 'Detalhes do Usuário')

@section('content')
<x-ui.page-header 
    title="Detalhes do Usuário" 
    subtitle="Visualize todas as informações do usuário"
>
    <x-ui.button href="{{ route('admin.usuarios.index') }}" variant="secondary" icon="arrow-left">Voltar</x-ui.button>
    <x-ui.button href="{{ route('admin.usuarios.edit', $usuario) }}" variant="primary" icon="edit">Editar</x-ui.button>
</x-ui.page-header>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
    <!-- Informações do Usuário -->
    <x-ui.info-card 
        title="Informações do Usuário"
        icon="user"
        iconColor="#8b5cf6"
        borderColor="#e9d5ff"
        shadowColor="rgba(139, 92, 246, 0.15)"
        backgroundGradient="linear-gradient(135deg, #faf5ff, #f3e8ff, white)"
    >
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <x-ui.detail-row label="Nome Completo" :value="$usuario->name" />
            <x-ui.detail-row label="E-mail" :value="$usuario->email" />
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <x-ui.detail-row label="Papel">
                @php
                    $roleVariants = [
                        'admin' => 'primary',
                        'usuario' => 'info',
                    ];
                    $roleVariant = $roleVariants[$usuario->papel->value] ?? 'default';
                @endphp
                <x-ui.badge :variant="$roleVariant">
                    {{ $usuario->papel->label() }}
                </x-ui.badge>
            </x-ui.detail-row>
            <x-ui.detail-row label="Status">
                <x-ui.badge :variant="$usuario->ativo ? 'success' : 'danger'">
                    {{ $usuario->ativo ? 'Ativo' : 'Inativo' }}
                </x-ui.badge>
            </x-ui.detail-row>
        </div>

        <x-ui.detail-row label="Telefone" :value="$usuario->telefone ?? 'N/A'" />
    </x-ui.info-card>

    <!-- Estatísticas -->
    <x-ui.info-card 
        title="Estatísticas"
        icon="bar-chart"
        iconColor="#ec4899"
        borderColor="#fbcfe8"
        shadowColor="rgba(236, 72, 153, 0.15)"
        backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
    >
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
            <div style="text-align: center; padding: 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); border-radius: 12px; border: 2px solid #e9d5ff;">
                <div style="font-size: 32px; font-weight: 900; color: #8b5cf6; margin-bottom: 8px;">{{ $usuario->rentals->count() }}</div>
                <div style="font-size: 14px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Aluguéis</div>
            </div>
            <div style="text-align: center; padding: 20px; background: linear-gradient(135deg, #fce7f3, #fdf2f8); border-radius: 12px; border: 2px solid #fbcfe8;">
                <div style="font-size: 32px; font-weight: 900; color: #ec4899; margin-bottom: 8px;">{{ $usuario->reservations->count() }}</div>
                <div style="font-size: 14px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Reservas</div>
            </div>
            <div style="text-align: center; padding: 20px; background: linear-gradient(135deg, #fff1f2, #fff7ed); border-radius: 12px; border: 2px solid #fed7aa;">
                <div style="font-size: 32px; font-weight: 900; color: #f97316; margin-bottom: 8px;">{{ $usuario->reviews->count() }}</div>
                <div style="font-size: 14px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Avaliações</div>
            </div>
            <div style="text-align: center; padding: 20px; background: linear-gradient(135deg, #e0f2fe, #f0f9ff); border-radius: 12px; border: 2px solid #bae6fd;">
                <div style="font-size: 32px; font-weight: 900; color: #0ea5e9; margin-bottom: 8px;">{{ $usuario->wishlists->count() }}</div>
                <div style="font-size: 14px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Lista Desejos</div>
            </div>
        </div>
    </x-ui.info-card>
</div>

<!-- Informações Adicionais -->
<x-ui.info-card 
    title="Informações Adicionais"
    icon="info"
    iconColor="#0ea5e9"
    borderColor="#bae6fd"
    shadowColor="rgba(14, 165, 233, 0.15)"
    backgroundGradient="linear-gradient(135deg, #e0f2fe, #f0f9ff, white)"
    style="margin-top: 24px;"
>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px;">
        <x-ui.detail-row label="E-mail Verificado">
            @if($usuario->email_verified_at)
                <div style="display: flex; align-items: center; gap: 8px;">
                    <x-ui.icon name="check-circle" size="16" style="color: #166534;" />
                    <span style="font-size: 14px; color: #166534; font-weight: 600;">Sim - {{ $usuario->email_verified_at->format('d/m/Y H:i') }}</span>
                </div>
            @else
                <div style="display: flex; align-items: center; gap: 8px;">
                    <x-ui.icon name="x-circle" size="16" style="color: #991b1b;" />
                    <span style="font-size: 14px; color: #991b1b; font-weight: 600;">Não</span>
                </div>
            @endif
        </x-ui.detail-row>
        <x-ui.detail-row label="Cadastrado em" :value="$usuario->created_at->format('d/m/Y H:i')" icon="calendar" />
        <x-ui.detail-row label="Última atualização" :value="$usuario->updated_at->format('d/m/Y H:i')" icon="clock" />
    </div>

    @if($usuario->fines->where('paga', false)->count() > 0)
        <div style="margin-top: 32px; padding-top: 32px; border-top: 3px solid #e9d5ff;">
            <h4 style="font-size: 18px; font-weight: 900; color: #1f2937; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 36px; height: 36px; background: linear-gradient(135deg, #ef4444, #f87171); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <x-ui.icon name="alert-circle" size="18" style="color: white;" />
                </div>
                Multas Pendentes
            </h4>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                @foreach($usuario->fines->where('paga', false) as $fine)
                    <div style="padding: 16px; background: linear-gradient(135deg, #fee2e2, #fef2f2); border: 2px solid #fca5a5; border-radius: 12px;">
                        <p style="font-size: 18px; font-weight: 900; color: #991b1b; margin-bottom: 4px;">R$ {{ number_format($fine->valor, 2, ',', '.') }}</p>
                        <p style="font-size: 13px; color: #dc2626; font-weight: 600;">Aluguel #{{ $fine->aluguel_id }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-ui.info-card>
@endsection
