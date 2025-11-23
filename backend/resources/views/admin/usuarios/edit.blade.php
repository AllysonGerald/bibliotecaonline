@extends('layouts.admin')

@section('title', 'Editar Usuário')

@section('content')
<x-ui.page-header 
    title="Editar Usuário" 
    subtitle="Atualize as informações do usuário"
>
    <x-ui.button href="{{ route('admin.usuarios.index') }}" variant="secondary" icon="arrow-left">Voltar</x-ui.button>
</x-ui.page-header>

<x-ui.card 
    borderColor="#bae6fd"
    shadowColor="rgba(14, 165, 233, 0.15)"
    backgroundGradient="linear-gradient(135deg, #e0f2fe, #f0f9ff, white)"
>
    <form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
            <!-- Primeira Linha: Nome e Email -->
            <x-forms.input
                type="text"
                name="name"
                label="Nome Completo"
                :value="old('name', $usuario->name)"
                required
                borderColor="#bae6fd"
                focusColor="#0ea5e9"
                backgroundGradient="linear-gradient(135deg, #f0f9ff, #ffffff)"
            />

            <x-forms.input
                type="email"
                name="email"
                label="E-mail"
                :value="old('email', $usuario->email)"
                required
                borderColor="#bae6fd"
                focusColor="#0ea5e9"
                backgroundGradient="linear-gradient(135deg, #f0f9ff, #ffffff)"
            />

            <!-- Segunda Linha: Senhas -->
            <x-forms.input
                type="password"
                name="password"
                label="Nova Senha"
                placeholder="Deixe em branco para manter a atual"
                borderColor="#bae6fd"
                focusColor="#0ea5e9"
                backgroundGradient="linear-gradient(135deg, #f0f9ff, #ffffff)"
            />

            <x-forms.input
                type="password"
                name="password_confirmation"
                label="Confirmar Nova Senha"
                placeholder="Confirme a nova senha"
                borderColor="#bae6fd"
                focusColor="#0ea5e9"
                backgroundGradient="linear-gradient(135deg, #f0f9ff, #ffffff)"
            />

            <!-- Terceira Linha: Papel e Telefone -->
            <x-forms.select
                name="papel"
                label="Papel"
                :options="collect($roles)->mapWithKeys(fn($role) => [$role->value => $role->label()])->toArray()"
                :value="old('papel', $usuario->papel->value)"
                required
                borderColor="#bae6fd"
                focusColor="#0ea5e9"
                backgroundGradient="linear-gradient(135deg, #f0f9ff, #ffffff)"
            />

            <x-forms.input
                type="text"
                name="telefone"
                label="Telefone"
                :value="old('telefone', $usuario->telefone)"
                placeholder="(00) 00000-0000"
                mask="phone"
                borderColor="#bae6fd"
                focusColor="#0ea5e9"
                backgroundGradient="linear-gradient(135deg, #f0f9ff, #ffffff)"
            />

            <!-- Quarta Linha: Checkbox de Status -->
            <div style="grid-column: 1 / -1;">
                <div style="display: flex; align-items: center; padding: 16px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border: 2px solid #bae6fd; border-radius: 12px;">
                    <input
                        type="checkbox"
                        name="ativo"
                        id="ativo"
                        value="1"
                        {{ old('ativo', $usuario->ativo) ? 'checked' : '' }}
                        style="width: 20px; height: 20px; accent-color: #0ea5e9; cursor: pointer; flex-shrink: 0;"
                    >
                    <label for="ativo" style="margin-left: 12px; font-size: 14px; font-weight: 700; color: #6b7280; cursor: pointer;">Usuário Ativo</label>
                </div>
            </div>
        </div>

        <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
            <x-ui.button href="{{ route('admin.usuarios.index') }}" variant="secondary">
                Cancelar
            </x-ui.button>
            <x-ui.button type="submit" variant="info" icon="save">
                Atualizar Usuário
            </x-ui.button>
        </div>
    </form>
</x-ui.card>
@endsection
