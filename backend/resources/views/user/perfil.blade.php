@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<x-ui.page-header 
    title="Meu Perfil" 
    subtitle="Gerencie suas informações pessoais"
/>

<div style="display: grid; grid-template-columns: 1fr; gap: 24px; @media (min-width: 1024px) { grid-template-columns: 1fr 1fr; }">
    <!-- Formulário de Edição -->
    <x-ui.card title="Informações Pessoais" icon="user" iconColor="#8b5cf6">
        <form method="POST" action="{{ route('perfil.update') }}">
            @csrf
            @method('PUT')

            <div style="display: flex; flex-direction: column; gap: 20px;">
                <x-forms.input
                    type="text"
                    name="name"
                    id="name"
                    label="Nome"
                    :value="old('name', $user->name)"
                    required
                    borderColor="#e5e7eb"
                    focusColor="#8b5cf6"
                    backgroundGradient="white"
                />

                <x-forms.input
                    type="email"
                    name="email"
                    id="email"
                    label="Email"
                    :value="old('email', $user->email)"
                    required
                    borderColor="#e5e7eb"
                    focusColor="#8b5cf6"
                    backgroundGradient="white"
                />

                <x-forms.input
                    type="text"
                    name="telefone"
                    id="telefone"
                    label="Telefone"
                    :value="old('telefone', $user->telefone)"
                    mask="phone"
                    borderColor="#e5e7eb"
                    focusColor="#8b5cf6"
                    backgroundGradient="white"
                />

                <hr style="border: none; border-top: 2px solid #e9d5ff; margin: 8px 0;">

                <x-forms.input
                    type="password"
                    name="password"
                    id="password"
                    label="Nova Senha"
                    placeholder="Deixe em branco para manter a senha atual"
                    borderColor="#e5e7eb"
                    focusColor="#8b5cf6"
                    backgroundGradient="white"
                />

                <x-forms.input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    label="Confirmar Nova Senha"
                    placeholder="Confirme a nova senha"
                    borderColor="#e5e7eb"
                    focusColor="#8b5cf6"
                    backgroundGradient="white"
                />

                <div style="display: flex; gap: 12px; margin-top: 8px;">
                    <x-ui.button
                        type="submit"
                        variant="primary"
                        icon="save"
                        class="flex: 1; padding: 14px 24px; font-size: 16px;"
                    >
                        Salvar Alterações
                    </x-ui.button>
                </div>
            </div>
        </form>
    </x-ui.card>

    <!-- Estatísticas do Usuário -->
    <div>
        <x-ui.card title="Estatísticas" icon="bar-chart" iconColor="#8b5cf6" class="margin-bottom: 24px;">
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); border-radius: 12px; border: 2px solid #e9d5ff;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <x-ui.icon name="book" size="20" style="color: white;" />
                        </div>
                        <span style="font-size: 14px; font-weight: 700; color: #4b5563;">Aluguéis</span>
                    </div>
                    <span style="font-size: 24px; font-weight: 900; color: #1f2937;">{{ $user->rentals->count() }}</span>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: linear-gradient(135deg, #fce7f3, #fdf2f8); border-radius: 12px; border: 2px solid #fbcfe8;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ec4899, #f472b6); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <x-ui.icon name="clock" size="20" style="color: white;" />
                        </div>
                        <span style="font-size: 14px; font-weight: 700; color: #4b5563;">Reservas</span>
                    </div>
                    <span style="font-size: 24px; font-weight: 900; color: #1f2937;">{{ $user->reservations->count() }}</span>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: linear-gradient(135deg, #fff1f2, #fff7ed); border-radius: 12px; border: 2px solid #fed7aa;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f97316, #fb923c); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <x-ui.icon name="heart" size="20" style="color: white;" />
                        </div>
                        <span style="font-size: 14px; font-weight: 700; color: #4b5563;">Lista de Desejos</span>
                    </div>
                    <span style="font-size: 24px; font-weight: 900; color: #1f2937;">{{ $user->wishlists->count() }}</span>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: linear-gradient(135deg, #faf5ff, #f3e8ff); border-radius: 12px; border: 2px solid #e9d5ff;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <x-ui.icon name="star" size="20" style="color: white;" />
                        </div>
                        <span style="font-size: 14px; font-weight: 700; color: #4b5563;">Avaliações</span>
                    </div>
                    <span style="font-size: 24px; font-weight: 900; color: #1f2937;">{{ $user->reviews->count() }}</span>
                </div>
            </div>
        </x-ui.card>

        <!-- Informações da Conta -->
        <x-ui.card title="Informações da Conta" icon="info" iconColor="#8b5cf6">
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Papel</label>
                    <p style="font-size: 16px; color: #1f2937; font-weight: 600;">{{ $user->papel->label() }}</p>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Status</label>
                    <x-ui.badge :variant="$user->ativo ? 'success' : 'danger'">
                        {{ $user->ativo ? 'Ativo' : 'Inativo' }}
                    </x-ui.badge>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Membro desde</label>
                    <p style="font-size: 16px; color: #1f2937; font-weight: 600;">{{ $user->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </x-ui.card>
    </div>
</div>
@endsection
