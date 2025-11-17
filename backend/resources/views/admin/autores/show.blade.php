@extends('layouts.admin')

@section('title', 'Detalhes do Autor')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.autores.index') }}" class="inline-flex items-center text-slate-600 hover:text-cyan-600 mb-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Voltar
    </a>
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-900">Detalhes do Autor</h2>
        <a href="{{ route('admin.autores.edit', $autor) }}" class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors font-medium">
            Editar
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-4">{{ $autor->nome }}</h3>
            
            <div class="space-y-4">
                @if($autor->biografia)
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Biografia</label>
                        <p class="text-slate-900 whitespace-pre-wrap">{{ $autor->biografia }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Data de Nascimento</label>
                        <p class="text-slate-900">{{ $autor->data_nascimento ? $autor->data_nascimento->format('d/m/Y') : 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Total de Livros</label>
                        <p class="text-slate-900">{{ $autor->books->count() }}</p>
                    </div>
                </div>
            </div>
        </div>

        @if($autor->books->count() > 0)
            <div class="bg-white rounded-lg shadow-md border border-slate-200 p-6 mt-6">
                <h4 class="text-lg font-semibold text-slate-900 mb-4">Livros do Autor</h4>
                <div class="space-y-2">
                    @foreach($autor->books as $book)
                        <a href="{{ route('admin.livros.show', $book) }}" class="block p-3 border border-slate-200 rounded-lg hover:bg-slate-50 transition-colors">
                            <div class="font-medium text-slate-900">{{ $book->titulo }}</div>
                            <div class="text-sm text-slate-500">{{ $book->category->nome }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <div>
        <div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
            @if($autor->foto)
                <img src="{{ $autor->foto }}" alt="Foto do autor" class="w-full rounded-lg border border-slate-200 mb-4" onerror="this.style.display='none'">
            @else
                <div class="w-full h-64 bg-slate-100 rounded-lg border border-slate-200 flex items-center justify-center mb-4">
                    <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
            @endif

            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Criado em</label>
                    <p class="text-slate-900">{{ $autor->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Atualizado em</label>
                    <p class="text-slate-900">{{ $autor->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

