@extends('layouts.app')

@section('title', 'Contato')

@section('content')
<x-ui.page-header
    title="Entre em Contato"
    subtitle="Tire suas dúvidas ou envie sugestões"
/>

<div class="contact-grid" style="display: grid; grid-template-columns: 1fr; gap: 32px;">
    <!-- Formulário de Contato -->
    <x-ui.card
        title="Envie sua Mensagem"
        borderColor="#e9d5ff"
        shadowColor="rgba(139, 92, 246, 0.15)"
        backgroundGradient="white"
    >
        <form method="POST" action="{{ route('contato.store') }}">
            @csrf

            <div style="display: flex; flex-direction: column; gap: 20px;">
                <x-forms.input
                    type="text"
                    name="nome"
                    label="Nome"
                    :value="old('nome', auth()->user()->name ?? '')"
                    required
                    borderColor="#e5e7eb"
                    focusColor="#8b5cf6"
                    backgroundGradient="white"
                />

                <x-forms.input
                    type="email"
                    name="email"
                    label="Email"
                    :value="old('email', auth()->user()->email ?? '')"
                    required
                    borderColor="#e5e7eb"
                    focusColor="#8b5cf6"
                    backgroundGradient="white"
                />

                <x-forms.input
                    type="text"
                    name="assunto"
                    label="Assunto"
                    :value="old('assunto')"
                    placeholder="Ex: Dúvida sobre aluguel, Sugestão de livro..."
                    required
                    borderColor="#e5e7eb"
                    focusColor="#8b5cf6"
                    backgroundGradient="white"
                />

                <x-forms.input
                    type="textarea"
                    name="mensagem"
                    label="Mensagem"
                    :value="old('mensagem')"
                    placeholder="Escreva sua mensagem aqui..."
                    rows="6"
                    required
                    borderColor="#e5e7eb"
                    focusColor="#8b5cf6"
                    backgroundGradient="white"
                />

                <div style="display: flex; gap: 12px; margin-top: 8px;">
                    <x-ui.button
                        type="submit"
                        variant="primary"
                        icon="send"
                        class="flex: 1;"
                    >
                        Enviar Mensagem
                    </x-ui.button>
                </div>
            </div>
        </form>
    </x-ui.card>

    <!-- Informações de Contato -->
    <div>
        <x-ui.card
            title="Informações de Contato"
            borderColor="#e9d5ff"
            shadowColor="rgba(139, 92, 246, 0.15)"
            backgroundGradient="white"
            class="margin-bottom: 24px;"
        >
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <x-contact.contact-info-item
                    icon="mail"
                    title="Email"
                    iconGradient="linear-gradient(135deg, #8b5cf6, #a855f7)"
                >
                    contato@biblioteca.com
                </x-contact.contact-info-item>

                <x-contact.contact-info-item
                    icon="phone"
                    title="Telefone"
                    iconGradient="linear-gradient(135deg, #ec4899, #f472b6)"
                >
                    (11) 1234-5678
                </x-contact.contact-info-item>

                <x-contact.contact-info-item
                    icon="clock"
                    title="Horário de Atendimento"
                    iconGradient="linear-gradient(135deg, #f97316, #fb923c)"
                >
                    <p style="margin: 0;">Segunda a Sexta: 9h às 18h</p>
                    <p style="margin: 0;">Sábado: 9h às 13h</p>
                </x-contact.contact-info-item>
            </div>
        </x-ui.card>

        <x-ui.card
            title="Por que entrar em contato?"
            borderColor="#e9d5ff"
            shadowColor="rgba(139, 92, 246, 0.15)"
            backgroundGradient="white"
        >
            <ul style="display: flex; flex-direction: column; gap: 12px; list-style: none; padding: 0; margin: 0;">
                <x-contact.contact-feature-item text="Tire dúvidas sobre nossos serviços" />
                <x-contact.contact-feature-item text="Sugira novos livros para o acervo" />
                <x-contact.contact-feature-item text="Reporte problemas técnicos" />
                <x-contact.contact-feature-item text="Envie feedback e sugestões" />
            </ul>
        </x-ui.card>
    </div>
</div>

<style>
    @media (min-width: 1024px) {
        .contact-grid {
            grid-template-columns: 1fr 1fr !important;
        }
    }
</style>
@endsection

