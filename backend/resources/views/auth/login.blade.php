@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<x-auth.auth-form-card
    title="Entrar"
    subtitle="Acesse sua conta na Biblioteca Online"
    icon="user"
    iconGradient="linear-gradient(135deg, #8b5cf6, #ec4899)"
>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="display: flex; flex-direction: column; gap: 16px;">
            <x-forms.input
                type="email"
                name="email"
                label="E-mail"
                :value="old('email')"
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
                label="Senha"
                placeholder="••••••••"
                required
                borderColor="#e5e7eb"
                focusColor="#8b5cf6"
                backgroundGradient="white"
            />

            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center;">
                    <input
                        id="remember"
                        name="remember"
                        type="checkbox"
                        style="width: 16px; height: 16px; accent-color: #8b5cf6; cursor: pointer;"
                    >
                    <label for="remember" style="margin-left: 8px; font-size: 13px; color: #6b7280; font-weight: 500; cursor: pointer;">
                        Lembrar-me
                    </label>
                </div>
                <a href="{{ route('password.request') }}" class="forgot-password-link" style="font-size: 13px; color: #8b5cf6; font-weight: 600; text-decoration: none; transition: color 0.3s;">
                    Esqueceu a senha?
                </a>
            </div>

            <div>
                <x-ui.button
                    type="submit"
                    variant="primary"
                    class="width: 100%; margin-top: 4px;"
                >
                    Entrar
                </x-ui.button>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <x-auth.auth-link
            href="{{ route('register') }}"
            text="Não tem uma conta?"
            linkText="Criar conta"
            color="#8b5cf6"
        />
        <x-ui.button
            href="{{ route('welcome') }}"
            variant="link"
            icon="arrow-left"
            class="font-size: 13px; color: #6b7280;"
        >
            Voltar para página inicial
        </x-ui.button>
    </x-slot>
</x-auth.auth-form-card>

<style>
    .forgot-password-link:hover {
        color: #a855f7 !important;
        text-decoration: underline !important;
    }
</style>
@endsection
