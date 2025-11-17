@extends('layouts.admin')

@section('title', 'Detalhes do Livro')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.livros.index') }}" class="inline-flex items-center text-slate-600 hover:text-cyan-600 mb-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Voltar
    </a>
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-900">Detalhes do Livro</h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.livros.edit', $livro) }}" class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors font-medium">
                Editar
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-4">{{ $livro->titulo }}</h3>
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Descrição</label>
                    <p class="text-slate-900">{{ $livro->descricao }}</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Autor</label>
                        <p class="text-slate-900">{{ $livro->author->nome }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Categoria</label>
                        <p class="text-slate-900">{{ $livro->category->nome }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">ISBN</label>
                        <p class="text-slate-900">{{ $livro->isbn ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Editora</label>
                        <p class="text-slate-900">{{ $livro->editora ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Ano de Publicação</label>
                        <p class="text-slate-900">{{ $livro->ano_publicacao ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Páginas</label>
                        <p class="text-slate-900">{{ $livro->paginas ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Preço</label>
                        <p class="text-slate-900">R$ {{ number_format($livro->preco, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Quantidade</label>
                        <p class="text-slate-900">{{ $livro->quantidade }}</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Status</label>
                    @php
                        $statusColors = [
                            'disponivel' => 'bg-emerald-100 text-emerald-800',
                            'reservado' => 'bg-amber-100 text-amber-800',
                            'alugado' => 'bg-red-100 text-red-800',
                        ];
                        $color = $statusColors[$livro->status->value] ?? 'bg-slate-100 text-slate-800';
                    @endphp
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $color }}">
                        {{ $livro->status->label() }}
                    </span>
                </div>

                @if($livro->tags->count() > 0)
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-2">Tags</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($livro->tags as $tag)
                                <span class="px-3 py-1 bg-cyan-100 text-cyan-800 rounded-full text-sm">
                                    {{ $tag->nome }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
            @if($livro->imagem_capa)
                <img src="{{ asset('storage/' . $livro->imagem_capa) }}" alt="Capa do livro" class="w-full rounded-lg border border-slate-200 mb-4">
            @else
                <div class="w-full h-64 bg-slate-100 rounded-lg border border-slate-200 flex items-center justify-center mb-4">
                    <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
            @endif

            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Criado em</label>
                    <p class="text-slate-900">{{ $livro->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Atualizado em</label>
                    <p class="text-slate-900">{{ $livro->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

