@extends('layouts.admin')

@section('title', 'Novo Aluguel')

@section('content')
<x-ui.page-header 
    title="Novo Aluguel" 
    subtitle="Crie um novo aluguel de livro"
>
    <x-ui.button href="{{ route('admin.alugueis.index') }}" variant="secondary" icon="arrow-left">Voltar</x-ui.button>
</x-ui.page-header>

<x-ui.card 
    borderColor="#e9d5ff"
    shadowColor="rgba(139, 92, 246, 0.15)"
    backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)"
>
    <form method="POST" action="{{ route('admin.alugueis.store') }}">
        @csrf

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
            <!-- Usuário e Livro -->
            <x-forms.select
                name="usuario_id"
                label="Usuário"
                :options="['' => 'Selecione um usuário'] + $users->mapWithKeys(fn($user) => [$user->id => $user->name . ' (' . $user->email . ')'])->toArray()"
                :value="old('usuario_id')"
                required
                borderColor="#e9d5ff"
                focusColor="#8b5cf6"
                backgroundGradient="linear-gradient(135deg, #faf5ff, #ffffff)"
            />

            <x-forms.select
                name="livro_id"
                label="Livro"
                :options="['' => 'Selecione um livro'] + $books->mapWithKeys(fn($book) => [$book->id => $book->titulo . ' - ' . ($book->author?->nome ?? 'Autor desconhecido')])->toArray()"
                :value="old('livro_id')"
                required
                borderColor="#e9d5ff"
                focusColor="#8b5cf6"
                backgroundGradient="linear-gradient(135deg, #faf5ff, #ffffff)"
            />

            <!-- Datas -->
            <x-forms.input
                type="datetime-local"
                name="alugado_em"
                label="Data de Aluguel"
                :value="old('alugado_em', now()->format('Y-m-d\TH:i'))"
                required
                borderColor="#e9d5ff"
                focusColor="#8b5cf6"
                backgroundGradient="linear-gradient(135deg, #faf5ff, #ffffff)"
            />

            <x-forms.input
                type="datetime-local"
                name="data_devolucao"
                label="Data de Devolução"
                :value="old('data_devolucao', now()->addDays(7)->format('Y-m-d\TH:i'))"
                required
                borderColor="#e9d5ff"
                focusColor="#8b5cf6"
                backgroundGradient="linear-gradient(135deg, #faf5ff, #ffffff)"
            />

            <x-forms.input
                type="datetime-local"
                name="devolvido_em"
                label="Data de Devolução Efetiva"
                :value="old('devolvido_em')"
                borderColor="#e9d5ff"
                focusColor="#8b5cf6"
                backgroundGradient="linear-gradient(135deg, #faf5ff, #ffffff)"
            />

            <!-- Taxa e Status -->
            <x-forms.input
                type="text"
                name="taxa_atraso"
                label="Taxa de Atraso (R$)"
                :value="old('taxa_atraso', 0)"
                placeholder="R$ 0,00"
                mask="currency"
                borderColor="#e9d5ff"
                focusColor="#8b5cf6"
                backgroundGradient="linear-gradient(135deg, #faf5ff, #ffffff)"
            />

            <x-forms.select
                name="status"
                label="Status"
                :options="collect(\App\Enums\RentalStatus::cases())->mapWithKeys(fn($status) => [$status->value => $status->label()])->toArray()"
                :value="old('status', 'ativo')"
                required
                borderColor="#e9d5ff"
                focusColor="#8b5cf6"
                backgroundGradient="linear-gradient(135deg, #faf5ff, #ffffff)"
            />
            </div>

            <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
                <x-ui.button href="{{ route('admin.alugueis.index') }}" variant="secondary">
                    Cancelar
                </x-ui.button>
                <x-ui.button type="submit" variant="primary" icon="plus">
                    Criar Aluguel
                </x-ui.button>
            </div>
        </form>
</x-ui.card>

<style>
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
