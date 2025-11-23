@extends('layouts.guest')

@section('title', 'Redefinir Senha')

@section('content')
<x-auth.auth-form-card
    title="Redefinir Senha"
    subtitle="Digite sua nova senha"
    icon="key"
    iconGradient="linear-gradient(135deg, #8b5cf6, #ec4899)"
>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div style="display: flex; flex-direction: column; gap: 16px;">
            <x-forms.input
                type="email"
                name="email"
                label="E-mail"
                :value="old('email', $email)"
                placeholder="seu@email.com"
                required
                autofocus
                borderColor="#e5e7eb"
                focusColor="#8b5cf6"
                backgroundGradient="white"
            />

            <x-forms.input
                type="password"
                name="password"
                id="password"
                label="Nova Senha"
                placeholder="Digite sua nova senha"
                required
                borderColor="#e5e7eb"
                focusColor="#8b5cf6"
                backgroundGradient="white"
            />

            <x-forms.input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                label="Confirmar Nova Senha"
                placeholder="Confirme sua nova senha"
                required
                borderColor="#e5e7eb"
                focusColor="#8b5cf6"
                backgroundGradient="white"
            />

            <div>
                <x-ui.button
                    type="submit"
                    variant="primary"
                    icon="save"
                    class="width: 100%; margin-top: 4px;"
                >
                    Redefinir Senha
                </x-ui.button>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <x-ui.button
            href="{{ route('login') }}"
            variant="link"
            icon="arrow-left"
            class="font-size: 13px; color: #6b7280;"
        >
            Voltar para login
        </x-ui.button>
    </x-slot>
</x-auth.auth-form-card>
@endsection

