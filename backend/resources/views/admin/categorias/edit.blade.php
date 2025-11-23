@extends('layouts.admin')

@section('title', 'Editar Categoria')

@section('content')

<x-ui.page-header
    title="Editar Categoria"
    subtitle="Atualize as informações da categoria"
>
    <x-ui.button href="{{ route('admin.categorias.index') }}" variant="secondary" icon="arrow-left">Voltar</x-ui.button>
</x-ui.page-header>

<x-ui.card
    borderColor="#e9d5ff"
    shadowColor="rgba(139, 92, 246, 0.15)"
    backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)"
>
    <form method="POST" action="{{ route('admin.categorias.update', $categoria) }}">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 1fr; gap: 24px;">
            <x-forms.input
                type="text"
                name="nome"
                label="Nome"
                :value="old('nome', $categoria->nome)"
                required
                borderColor="#e9d5ff"
                focusColor="#8b5cf6"
                backgroundGradient="linear-gradient(135deg, #f3e8ff, #ffffff)"
            />

            <x-forms.input
                type="textarea"
                name="descricao"
                label="Descrição"
                :value="old('descricao', $categoria->descricao)"
                borderColor="#e9d5ff"
                focusColor="#8b5cf6"
                backgroundGradient="linear-gradient(135deg, #f3e8ff, #ffffff)"
            />

            <x-forms.input
                type="text"
                name="icone"
                label="Ícone"
                :value="old('icone', $categoria->icone)"
                placeholder="Nome do ícone ou classe CSS"
                borderColor="#e9d5ff"
                focusColor="#8b5cf6"
                backgroundGradient="linear-gradient(135deg, #f3e8ff, #ffffff)"
            />
        </div>

        <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
            <x-ui.button href="{{ route('admin.categorias.index') }}" variant="secondary">
                Cancelar
            </x-ui.button>
            <x-ui.button type="submit" variant="primary" icon="save">
                Atualizar Categoria
            </x-ui.button>
        </div>
    </form>
</x-ui.card>
@endsection

