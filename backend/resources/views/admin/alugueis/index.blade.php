@extends('layouts.admin')

@section('title', 'Aluguéis')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Gerenciar Aluguéis</h2>
        <p class="text-slate-600 mt-1">Gerencie os aluguéis de livros</p>
    </div>
    <a href="{{ route('admin.alugueis.create') }}" class="inline-flex items-center px-4 py-2 bg-cyan-600 text-white rounded-lg hover:bg-cyan-700 transition-colors font-medium">
        <i data-lucide="plus" class="w-5 h-5 mr-2"></i>
        Novo Aluguel
    </a>
</div>

<div class="bg-white rounded-lg shadow-md border border-slate-200">
    <div class="p-6 border-b border-slate-200">
        <form method="GET" action="{{ route('admin.alugueis.index') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
            <div class="flex items-end">
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
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Alugado em</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Devolução</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-slate-500 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-slate-200">
                @forelse($rentals as $rental)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-slate-900">{{ $rental->user->name }}</div>
                            <div class="text-sm text-slate-500">{{ $rental->user->email }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-slate-900">{{ $rental->book->titulo }}</div>
                            <div class="text-sm text-slate-500">{{ $rental->book->author->nome }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-900">{{ $rental->alugado_em->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-slate-900">{{ $rental->data_devolucao->format('d/m/Y') }}</div>
                            @if($rental->devolvido_em)
                                <div class="text-sm text-slate-500">Devolvido: {{ $rental->devolvido_em->format('d/m/Y H:i') }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'ativo' => 'bg-blue-100 text-blue-800',
                                    'devolvido' => 'bg-emerald-100 text-emerald-800',
                                    'atrasado' => 'bg-red-100 text-red-800',
                                ];
                                $color = $statusColors[$rental->status->value] ?? 'bg-slate-100 text-slate-800';
                            @endphp
                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $color }}">
                                {{ $rental->status->label() }}
                            </span>
                            @if($rental->taxa_atraso > 0)
                                <div class="text-xs text-red-600 mt-1">Taxa: R$ {{ number_format($rental->taxa_atraso, 2, ',', '.') }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <a href="{{ route('admin.alugueis.show', $rental) }}" class="text-cyan-600 hover:text-cyan-800" title="Ver">
                                    <i data-lucide="eye" class="w-5 h-5"></i>
                                </a>
                                <a href="{{ route('admin.alugueis.edit', $rental) }}" class="text-slate-600 hover:text-slate-800" title="Editar">
                                    <i data-lucide="edit" class="w-5 h-5"></i>
                                </a>
                                <form action="{{ route('admin.alugueis.destroy', $rental) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este aluguel?');">
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
                            <i data-lucide="book-open" class="mx-auto h-12 w-12 text-slate-400"></i>
                            <p class="mt-4 text-sm text-slate-500">Nenhum aluguel encontrado.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($rentals->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $rentals->links() }}
        </div>
    @endif
</div>
@endsection

