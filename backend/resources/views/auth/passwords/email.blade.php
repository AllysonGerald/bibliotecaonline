@extends('layouts.guest')

@section('title', 'Esqueci minha senha')

@section('content')
<x-auth.auth-form-card
    title="Esqueci minha senha"
    subtitle="Digite seu e-mail para receber o link de redefinição"
    icon="lock"
    iconGradient="linear-gradient(135deg, #8b5cf6, #ec4899)"
>
    @if (session('status'))
        <x-ui.alert type="success" :message="'Enviamos um link de redefinição de senha para seu e-mail!'" class="margin-bottom: 20px;" />
    @endif

    <form method="POST" action="{{ route('password.email') }}">
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

            <div>
                <x-ui.button
                    type="submit"
                    variant="primary"
                    icon="mail"
                    class="width: 100%; margin-top: 4px;"
                >
                    Enviar Link de Redefinição
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

