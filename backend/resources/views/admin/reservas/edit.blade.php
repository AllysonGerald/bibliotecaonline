@extends('layouts.admin')

@section('title', 'Editar Reserva')

@section('content')
<x-ui.page-header 
    title="Editar Reserva" 
    subtitle="Atualize as informações da reserva"
>
    <x-ui.button href="{{ route('admin.reservas.index') }}" variant="secondary" icon="arrow-left">Voltar</x-ui.button>
</x-ui.page-header>

<x-ui.card 
    borderColor="#fbcfe8"
    shadowColor="rgba(236, 72, 153, 0.15)"
    backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
>
    <form method="POST" action="{{ route('admin.reservas.update', $reserva) }}">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
            <!-- Usuário e Livro -->
            <x-forms.select
                name="usuario_id"
                label="Usuário"
                :options="['' => 'Selecione um usuário'] + $users->mapWithKeys(fn($user) => [$user->id => $user->name . ' (' . $user->email . ')'])->toArray()"
                :value="old('usuario_id', $reserva->usuario_id)"
                required
                borderColor="#fbcfe8"
                focusColor="#ec4899"
                backgroundGradient="linear-gradient(135deg, #fdf2f8, #ffffff)"
            />

            <x-forms.select
                name="livro_id"
                label="Livro"
                :options="['' => 'Selecione um livro'] + $books->mapWithKeys(fn($book) => [$book->id => $book->titulo . ' - ' . ($book->author?->nome ?? 'Autor desconhecido')])->toArray()"
                :value="old('livro_id', $reserva->livro_id)"
                required
                borderColor="#fbcfe8"
                focusColor="#ec4899"
                backgroundGradient="linear-gradient(135deg, #fdf2f8, #ffffff)"
            />

            <!-- Data de Reserva e Data de Expiração -->
            <x-forms.input
                type="datetime-local"
                name="reservado_em"
                label="Data de Reserva"
                :value="old('reservado_em', $reserva->reservado_em->format('Y-m-d\TH:i'))"
                required
                borderColor="#fbcfe8"
                focusColor="#ec4899"
                backgroundGradient="linear-gradient(135deg, #fdf2f8, #ffffff)"
            />

            <x-forms.input
                type="datetime-local"
                name="expira_em"
                label="Data de Expiração"
                :value="old('expira_em', $reserva->expira_em->format('Y-m-d\TH:i'))"
                required
                borderColor="#fbcfe8"
                focusColor="#ec4899"
                backgroundGradient="linear-gradient(135deg, #fdf2f8, #ffffff)"
            />

            <!-- Status -->
            <x-forms.select
                name="status"
                label="Status"
                :options="collect($statuses)->mapWithKeys(fn($status) => [$status->value => $status->label()])->toArray()"
                :value="old('status', $reserva->status->value)"
                required
                borderColor="#fbcfe8"
                focusColor="#ec4899"
                backgroundGradient="linear-gradient(135deg, #fdf2f8, #ffffff)"
            />
        </div>

        <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
            <x-ui.button href="{{ route('admin.reservas.index') }}" variant="secondary">
                Cancelar
            </x-ui.button>
            <x-ui.button type="submit" variant="primary" icon="save">
                Atualizar Reserva
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
