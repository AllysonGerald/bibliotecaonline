@extends('layouts.admin')

@section('title', 'Reservas')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Gerenciar Reservas</h2>
        <p class="text-slate-600 mt-1">Gerencie as reservas de livros</p>
    </div>
    <a href="{{ route('admin.reservas.create') }}" class="inline-flex items-center px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors font-medium">
        <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
        Nova Reserva
    </a>
</div>

<div class="bg-white rounded-lg shadow-md border border-slate-200">
    <div class="p-6 border-b border-slate-200">
        <form method="GET" action="{{ route('admin.reservas.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-slate-700 mb-2">Buscar</label>
                <input
                    type="text"
                    name="search"
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="Usuário, livro..."
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                >
            </div>
            <div>
                <label for="usuario_id" class="block text-sm font-medium text-slate-700 mb-2">Usuário</label>
                <select
                    name="usuario_id"
                    id="usuario_id"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                >
                    <option value="">Todos</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('usuario_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="livro_id" class="block text-sm font-medium text-slate-700 mb-2">Livro</label>
                <select
                    name="livro_id"
                    id="livro_id"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                >
                    <option value="">Todos</option>
                    @foreach($books as $book)
                        <option value="{{ $book->id }}" {{ request('livro_id') == $book->id ? 'selected' : '' }}>
                            {{ $book->titulo }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-slate-700 mb-2">Status</label>
                <select
                    name="status"
                    id="status"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-cyan-500 focus:border-cyan-500"
                >
                    <option value="">Todos</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                            {{ $status->label() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end md:col-span-4">
                <button type="submit" class="w-full px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-800 transition-colors font-medium">
                    Filtrar
                </button>
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-slate-200">
            <thead class="bg-slate-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Usuário</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Livro</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Reservado em</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Expira em</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($reservations as $reservation)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-900">{{ $reservation->user->name }}</div>
                            <div class="text-sm text-slate-500">{{ $reservation->user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-slate-900">{{ $reservation->book->titulo }}</div>
                            <div class="text-sm text-slate-500">{{ $reservation->book->author->nome }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-900">{{ $reservation->reservado_em->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-900">{{ $reservation->expira_em->format('d/m/Y H:i') }}</div>
                            @if($reservation->isExpired())
                                <div class="text-xs text-red-600 mt-1">Expirada</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'pendente' => 'bg-yellow-100 text-yellow-800',
                                    'confirmada' => 'bg-green-100 text-green-800',
                                    'cancelada' => 'bg-red-100 text-red-800',
                                    'expirada' => 'bg-gray-100 text-gray-800',
                                ];
                                $color = $statusColors[$reservation->status->value] ?? 'bg-slate-100 text-slate-800';
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                {{ $reservation->status->label() }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.reservas.show', $reservation) }}" class="text-cyan-600 hover:text-cyan-800" title="Ver">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </a>
                                <a href="{{ route('admin.reservas.edit', $reservation) }}" class="text-slate-600 hover:text-slate-800" title="Editar">
                                    <i data-lucide="edit" class="w-5 h-5"></i>
                                </a>
                                <form action="{{ route('admin.reservas.destroy', $reservation) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir esta reserva?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Excluir">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <i data-lucide="clock" class="mx-auto h-12 w-12 text-slate-400"></i>
                            <p class="mt-4 text-sm text-slate-500">Nenhuma reserva encontrada.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reservations->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $reservations->links() }}
        </div>
    @endif
</div>
@endsection

