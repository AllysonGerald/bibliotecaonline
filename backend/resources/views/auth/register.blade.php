@extends('layouts.guest')

@section('title', 'Criar Conta')

@section('content')
<x-auth.auth-form-card
    title="Criar Conta"
    subtitle="Cadastre-se na Biblioteca Online"
    icon="user-plus"
    iconGradient="linear-gradient(135deg, #ec4899, #f97316)"
>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="display: flex; flex-direction: column; gap: 16px;">
            <x-forms.input
                type="text"
                name="name"
                label="Nome Completo"
                :value="old('name')"
                placeholder="João Silva"
                required
                autofocus
                borderColor="#e5e7eb"
                focusColor="#ec4899"
                backgroundGradient="white"
            />

            <x-forms.input
                type="email"
                name="email"
                label="E-mail"
                :value="old('email')"
                placeholder="seu@email.com"
                required
                borderColor="#e5e7eb"
                focusColor="#ec4899"
                backgroundGradient="white"
            />

            <div>
                <label for="telefone" style="display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px;">
                    Telefone <span style="color: #9ca3af; font-weight: 400;">(opcional)</span>
                </label>
                <x-forms.input
                    type="text"
                    name="telefone"
                    id="telefone"
                    :value="old('telefone')"
                    placeholder="(11) 98765-4321"
                    mask="phone"
                    borderColor="#e5e7eb"
                    focusColor="#ec4899"
                    backgroundGradient="white"
                />
            </div>

            <x-forms.input
                type="password"
                name="password"
                label="Senha"
                placeholder="••••••••"
                required
                borderColor="#e5e7eb"
                focusColor="#ec4899"
                backgroundGradient="white"
            />

            <x-forms.input
                type="password"
                name="password_confirmation"
                label="Confirmar Senha"
                placeholder="••••••••"
                required
                borderColor="#e5e7eb"
                focusColor="#ec4899"
                backgroundGradient="white"
            />

            <div>
                <x-ui.button
                    type="submit"
                    variant="primary"
                    style="width: 100%; margin-top: 4px; background: linear-gradient(135deg, #ec4899, #f97316); border-color: #ec4899;"
                >
                    Criar Conta
                </x-ui.button>
            </div>
        </div>
    </form>

    <x-slot name="footer">
        <x-auth.auth-link
            href="{{ route('login') }}"
            text="Já tem uma conta?"
            linkText="Faça login aqui"
            color="#ec4899"
        />
        <x-ui.button
            href="{{ route('welcome') }}"
            variant="link"
            icon="arrow-left"
            style="font-size: 13px; color: #6b7280;"
        >
            Voltar para página inicial
        </x-ui.button>
    </x-slot>
</x-auth.auth-form-card>
@endsection
