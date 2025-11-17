@extends('layouts.admin')

@section('title', 'Detalhes da Categoria')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.categorias.index') }}" class="inline-flex items-center text-slate-600 hover:text-cyan-600 mb-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Voltar
    </a>
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-900">Detalhes da Categoria</h2>
        <a href="{{ route('admin.categorias.edit', $categoria) }}" class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors font-medium">
            Editar
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-4">{{ $categoria->nome }}</h3>
            
            <div class="space-y-4">
                @if($categoria->descricao)
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Descrição</label>
                        <p class="text-slate-900">{{ $categoria->descricao }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Total de Livros</label>
                        <p class="text-slate-900">{{ $categoria->books->count() }}</p>
                    </div>
                    @if($categoria->icone)
                        <div>
                            <label class="block text-sm font-medium text-slate-500 mb-1">Ícone</label>
                            <p class="text-slate-900">{{ $categoria->icone }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if($categoria->books->count() > 0)
            <div class="bg-white rounded-lg shadow-md border border-slate-200 p-6 mt-6">
                <h4 class="text-lg font-semibold text-slate-900 mb-4">Livros desta Categoria</h4>
                <div class="space-y-2">
                    @foreach($categoria->books as $book)
                        <a href="{{ route('admin.livros.show', $book) }}" class="block p-3 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                            <div class="font-medium text-slate-900">{{ $book->titulo }}</div>
                            <div class="text-sm text-slate-500">{{ $book->author->nome }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div>
        <div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Criado em</label>
                    <p class="text-slate-900">{{ $categoria->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Atualizado em</label>
                    <p class="text-slate-900">{{ $categoria->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

