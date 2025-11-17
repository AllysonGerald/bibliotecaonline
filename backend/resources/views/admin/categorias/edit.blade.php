@extends('layouts.admin')

@section('title', 'Editar Categoria')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.categorias.index') }}" class="inline-flex items-center text-slate-600 hover:text-cyan-600 mb-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Voltar
    </a>
    <h2 class="text-2xl font-bold text-slate-900">Editar Categoria</h2>
</div>

<div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
    <form method="POST" action="{{ route('admin.categorias.update', $categoria) }}">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <div>
                <label for="nome" class="block text-sm font-medium text-slate-700 mb-2">Nome *</label>
                <input
                    type="text"
                    name="nome"
                    id="nome"
                    value="{{ old('nome', $categoria->nome) }}"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('nome') border-red-500 @enderror"
                >
                @error('nome')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="descricao" class="block text-sm font-medium text-slate-700 mb-2">Descrição</label>
                <textarea
                    name="descricao"
                    id="descricao"
                    rows="4"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('descricao') border-red-500 @enderror"
                >{{ old('descricao', $categoria->descricao) }}</textarea>
                @error('descricao')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="icone" class="block text-sm font-medium text-slate-700 mb-2">Ícone</label>
                <input
                    type="text"
                    name="icone"
                    id="icone"
                    value="{{ old('icone', $categoria->icone) }}"
                    placeholder="Nome do ícone ou classe CSS"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('icone') border-red-500 @enderror"
                >
                @error('icone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.categorias.index') }}" class="px-6 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-colors font-medium">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors font-medium">
                Atualizar Categoria
            </button>
        </div>
    </form>
</div>
@endsection

