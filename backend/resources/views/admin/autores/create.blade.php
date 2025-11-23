@extends('layouts.admin')

@section('title', 'Novo Autor')

@section('content')

<x-ui.page-header 
    title="Novo Autor" 
    subtitle="Crie um novo autor no catálogo"
>
    <x-ui.button href="{{ route('admin.autores.index') }}" variant="secondary" icon="arrow-left">Voltar</x-ui.button>
</x-ui.page-header>

<x-ui.card 
    borderColor="#fed7aa"
    shadowColor="rgba(249, 115, 22, 0.15)"
    backgroundGradient="linear-gradient(135deg, #fff7ed, #fff1f2, white)"
>
    <form method="POST" action="{{ route('admin.autores.store') }}">
        @csrf

        <div style="display: grid; grid-template-columns: 1fr; gap: 24px;">
            <x-forms.input
                type="text"
                name="nome"
                label="Nome"
                :value="old('nome')"
                required
                borderColor="#fed7aa"
                focusColor="#f97316"
                backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
            />

            <x-forms.input
                type="textarea"
                name="biografia"
                label="Biografia"
                :value="old('biografia')"
                borderColor="#fed7aa"
                focusColor="#f97316"
                backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
            />

            <x-forms.input
                type="date"
                name="data_nascimento"
                label="Data de Nascimento"
                :value="old('data_nascimento')"
                :max="date('Y-m-d', strtotime('-1 day'))"
                borderColor="#fed7aa"
                focusColor="#f97316"
                backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
            />

            <x-forms.input
                type="text"
                name="foto"
                label="URL da Foto"
                :value="old('foto')"
                placeholder="https://exemplo.com/foto.jpg"
                borderColor="#fed7aa"
                focusColor="#f97316"
                backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
            />
        </div>

        <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
            <x-ui.button href="{{ route('admin.autores.index') }}" variant="secondary">
                Cancelar
            </x-ui.button>
            <x-ui.button type="submit" variant="primary" icon="user-plus">
                Criar Autor
            </x-ui.button>
        </div>
    </form>
</x-ui.card>
@endsection

