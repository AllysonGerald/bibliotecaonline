@extends('layouts.admin')

@section('title', 'Editar Reserva')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.reservas.index') }}" class="inline-flex items-center text-slate-600 hover:text-cyan-600 mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
        Voltar
    </a>
    <h2 class="text-2xl font-bold text-slate-900">Editar Reserva</h2>
</div>

<div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
    <form method="POST" action="{{ route('admin.reservas.update', $reserva) }}">
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
                        <option value="{{ $user->id }}" {{ old('usuario_id', $reserva->usuario_id) == $user->id ? 'selected' : '' }}>
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
                        <option value="{{ $book->id }}" {{ old('livro_id', $reserva->livro_id) == $book->id ? 'selected' : '' }}>
                            {{ $book->titulo }} - {{ $book->author->nome }}
                        </option>
                    @endforeach
                </select>
                @error('livro_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="reservado_em" class="block text-sm font-medium text-slate-700 mb-2">Data de Reserva *</label>
                <input
                    type="datetime-local"
                    name="reservado_em"
                    id="reservado_em"
                    value="{{ old('reservado_em', $reserva->reservado_em->format('Y-m-d\TH:i')) }}"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('reservado_em') border-red-500 @enderror"
                >
                @error('reservado_em')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="expira_em" class="block text-sm font-medium text-slate-700 mb-2">Data de Expiração *</label>
                <input
                    type="datetime-local"
                    name="expira_em"
                    id="expira_em"
                    value="{{ old('expira_em', $reserva->expira_em->format('Y-m-d\TH:i')) }}"
                    required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500 @error('expira_em') border-red-500 @enderror"
                >
                @error('expira_em')
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
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}" {{ old('status', $reserva->status->value) == $status->value ? 'selected' : '' }}>
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
            <a href="{{ route('admin.reservas.index') }}" class="px-6 py-2 border border-slate-300 rounded-lg text-slate-700 hover:bg-slate-50 transition-colors font-medium">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors font-medium">
                Atualizar Reserva
            </button>
        </div>
    </form>
</div>
@endsection

