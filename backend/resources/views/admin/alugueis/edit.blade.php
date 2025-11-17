@extends('layouts.admin')

@section('title', 'Editar Aluguel')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.alugueis.index') }}" class="inline-flex items-center text-slate-600 hover:text-cyan-600 mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
        Voltar
    </a>
    <h2 class="text-2xl font-bold text-slate-900">Editar Aluguel</h2>
</div>

<div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
    <form method="POST" action="{{ route('admin.alugueis.update', $aluguel) }}">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="usuario_id" class="block text-sm font-medium text-slate-700 mb-2">Usuário *</label>
                <select
                    name="usuario_id"
                    id="usuario_id"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('usuario_id') border-red-500 @enderror"
                >
                    <option value="">Selecione um usuário</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('usuario_id', $aluguel->usuario_id) == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
                @error('usuario_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="livro_id" class="block text-sm font-medium text-slate-700 mb-2">Livro *</label>
                <select
                    name="livro_id"
                    id="livro_id"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('livro_id') border-red-500 @enderror"
                >
                    <option value="">Selecione um livro</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ old('livro_id', $aluguel->livro_id) == $book->id ? 'selected' : '' }}>
                            {{ $book->titulo }} - {{ $book->author->nome }}
                        </option>
                    @endforeach
                </select>
                @error('livro_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="alugado_em" class="block text-sm font-medium text-slate-700 mb-2">Data de Aluguel *</label>
                <input
                    type="datetime-local"
                    name="alugado_em"
                    id="alugado_em"
                    value="{{ old('alugado_em', $aluguel->alugado_em->format('Y-m-d\TH:i')) }}"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('alugado_em') border-red-500 @enderror"
                >
                @error('alugado_em')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="data_devolucao" class="block text-sm font-medium text-slate-700 mb-2">Data de Devolução *</label>
                <input
                    type="datetime-local"
                    name="data_devolucao"
                    id="data_devolucao"
                    value="{{ old('data_devolucao', $aluguel->data_devolucao->format('Y-m-d\TH:i')) }}"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('data_devolucao') border-red-500 @enderror"
                >
                @error('data_devolucao')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="devolvido_em" class="block text-sm font-medium text-slate-700 mb-2">Data de Devolução Efetiva</label>
                <input
                    type="datetime-local"
                    name="devolvido_em"
                    id="devolvido_em"
                    value="{{ old('devolvido_em', $aluguel->devolvido_em ? $aluguel->devolvido_em->format('Y-m-d\TH:i') : '') }}"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('devolvido_em') border-red-500 @enderror"
                >
                @error('devolvido_em')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="taxa_atraso" class="block text-sm font-medium text-slate-700 mb-2">Taxa de Atraso (R$)</label>
                <input
                    type="number"
                    name="taxa_atraso"
                    id="taxa_atraso"
                    value="{{ old('taxa_atraso', $aluguel->taxa_atraso) }}"
                    step="0.01"
                    min="0"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('taxa_atraso') border-red-500 @enderror"
                >
                @error('taxa_atraso')
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
                    @foreach(\App\Enums\RentalStatus::cases() as $status)
                        <option value="{{ $status->value }}" {{ old('status', $aluguel->status->value) == $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-3">
            <a href="{{ route('admin.alugueis.index') }}" class="px-6 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-colors font-medium">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors font-medium">
                Atualizar Aluguel
            </button>
        </div>
    </form>
</div>
@endsection

