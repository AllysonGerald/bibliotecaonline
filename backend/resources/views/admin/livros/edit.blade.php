@extends('layouts.admin')

@section('title', 'Editar Livro')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.livros.index') }}" class="inline-flex items-center text-slate-600 hover:text-cyan-600 mb-4">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Voltar
    </a>
    <h2 class="text-2xl font-bold text-slate-900">Editar Livro</h2>
</div>

<div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
    <form method="POST" action="{{ route('admin.livros.update', $livro) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label for="titulo" class="block text-sm font-medium text-slate-700 mb-2">Título *</label>
                <input
                    type="text"
                    name="titulo"
                    id="titulo"
                    value="{{ old('titulo', $livro->titulo) }}"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('titulo') border-red-500 @enderror"
                >
                @error('titulo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label for="descricao" class="block text-sm font-medium text-slate-700 mb-2">Descrição *</label>
                <textarea
                    name="descricao"
                    id="descricao"
                    rows="4"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('descricao') border-red-500 @enderror"
                >{{ old('descricao', $livro->descricao) }}</textarea>
                @error('descricao')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="autor_id" class="block text-sm font-medium text-slate-700 mb-2">Autor *</label>
                <select
                    name="autor_id"
                    id="autor_id"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('autor_id') border-red-500 @enderror"
                >
                    <option value="">Selecione um autor</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ old('autor_id', $livro->autor_id) == $author->id ? 'selected' : '' }}>
                            {{ $author->nome }}
                        </option>
                    @endforeach
                </select>
                @error('autor_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="categoria_id" class="block text-sm font-medium text-slate-700 mb-2">Categoria *</label>
                <select
                    name="categoria_id"
                    id="categoria_id"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('categoria_id') border-red-500 @enderror"
                >
                    <option value="">Selecione uma categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('categoria_id', $livro->categoria_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->nome }}
                        </option>
                    @endforeach
                </select>
                @error('categoria_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="isbn" class="block text-sm font-medium text-slate-700 mb-2">ISBN *</label>
                <input
                    type="text"
                    name="isbn"
                    id="isbn"
                    value="{{ old('isbn', $livro->isbn) }}"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('isbn') border-red-500 @enderror"
                >
                @error('isbn')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="editora" class="block text-sm font-medium text-slate-700 mb-2">Editora *</label>
                <input
                    type="text"
                    name="editora"
                    id="editora"
                    value="{{ old('editora', $livro->editora) }}"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('editora') border-red-500 @enderror"
                >
                @error('editora')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="ano_publicacao" class="block text-sm font-medium text-slate-700 mb-2">Ano de Publicação *</label>
                <input
                    type="number"
                    name="ano_publicacao"
                    id="ano_publicacao"
                    value="{{ old('ano_publicacao', $livro->ano_publicacao) }}"
                    required
                    min="1000"
                    max="{{ date('Y') }}"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('ano_publicacao') border-red-500 @enderror"
                >
                @error('ano_publicacao')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="paginas" class="block text-sm font-medium text-slate-700 mb-2">Páginas *</label>
                <input
                    type="number"
                    name="paginas"
                    id="paginas"
                    value="{{ old('paginas', $livro->paginas) }}"
                    required
                    min="1"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('paginas') border-red-500 @enderror"
                >
                @error('paginas')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="preco" class="block text-sm font-medium text-slate-700 mb-2">Preço *</label>
                <input
                    type="number"
                    name="preco"
                    id="preco"
                    value="{{ old('preco', $livro->preco) }}"
                    required
                    step="0.01"
                    min="0"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('preco') border-red-500 @enderror"
                >
                @error('preco')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="quantidade" class="block text-sm font-medium text-slate-700 mb-2">Quantidade *</label>
                <input
                    type="number"
                    name="quantidade"
                    id="quantidade"
                    value="{{ old('quantidade', $livro->quantidade) }}"
                    required
                    min="0"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('quantidade') border-red-500 @enderror"
                >
                @error('quantidade')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status *</label>
                <select
                    name="status"
                    id="status"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('status') border-red-500 @enderror"
                >
                    @foreach(\App\Enums\BookStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ old('status', $livro->status->value) == $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="imagem_capa" class="block text-sm font-medium text-slate-700 mb-2">Imagem da Capa</label>
                @if($livro->imagem_capa)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $livro->imagem_capa) }}" alt="Capa atual" class="h-32 w-auto rounded-lg border border-slate-200">
                    </div>
                @endif
                <input
                    type="file"
                    name="imagem_capa"
                    id="imagem_capa"
                    accept="image/*"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('imagem_capa') border-red-500 @enderror"
                >
                @error('imagem_capa')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-slate-700 mb-2">Tags</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    @foreach($tags as $tag)
                        <label class="flex items-center">
                            <input
                                type="checkbox"
                                name="tags[]"
                                value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', $livro->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                                class="h-4 w-4 text-cyan-600 focus:ring-cyan-500 border-slate-300 rounded"
                            >
                            <span class="ml-2 text-sm text-slate-700">{{ $tag->nome }}</span>
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.livros.index') }}" class="px-6 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-colors font-medium">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors font-medium">
                Atualizar Livro
            </button>
        </div>
    </form>
</div>
@endsection

