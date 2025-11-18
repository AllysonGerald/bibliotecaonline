@extends('layouts.admin')

@section('title', 'Detalhes da Reserva')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.reservas.index') }}" class="inline-flex items-center text-slate-600 hover:text-cyan-600 mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
        Voltar
    </a>
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-900">Detalhes da Reserva</h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.reservas.edit', $reserva) }}" class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors font-medium">
                Editar
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-4">Informações da Reserva</h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Usuário</label>
                        <p class="text-slate-900 font-medium">{{ $reserva->user->name }}</p>
                        <p class="text-sm text-slate-500">{{ $reserva->user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Livro</label>
                        <p class="text-slate-900 font-medium">{{ $reserva->book->titulo }}</p>
                        <p class="text-sm text-slate-500">{{ $reserva->book->author->nome }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Reservado em</label>
                        <p class="text-slate-900">{{ $reserva->reservado_em->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Expira em</label>
                        <p class="text-slate-900">{{ $reserva->expira_em->format('d/m/Y H:i') }}</p>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Status</label>
                    @php
                        $statusColors = [
                            'pendente' => 'bg-yellow-100 text-yellow-800',
                            'confirmada' => 'bg-green-100 text-green-800',
                            'cancelada' => 'bg-red-100 text-red-800',
                            'expirada' => 'bg-gray-100 text-gray-800',
                        ];
                        $color = $statusColors[$reserva->status->value] ?? 'bg-slate-100 text-slate-800';
                    @endphp
                    <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $color }}">
                        {{ $reserva->status->label() }}
                    </span>
                </div>

                @if($reserva->isExpired())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-red-600 mr-2"></i>
                            <div>
                                <p class="text-sm font-medium text-red-800">Reserva Expirada</p>
                                <p class="text-sm text-red-600">Esta reserva expirou em {{ $reserva->expira_em->format('d/m/Y H:i') }}.</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
            <h4 class="text-lg font-bold text-slate-900 mb-4">Informações do Livro</h4>
            
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Categoria</label>
                    <p class="text-slate-900">{{ $reserva->book->category->nome }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">ISBN</label>
                    <p class="text-slate-900">{{ $reserva->book->isbn ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Editora</label>
                    <p class="text-slate-900">{{ $reserva->book->editora ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-slate-200">
                <h4 class="text-lg font-bold text-slate-900 mb-4">Informações do Usuário</h4>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Telefone</label>
                        <p class="text-slate-900">{{ $reserva->user->telefone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Status da Conta</label>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $reserva->user->ativo ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                            {{ $reserva->user->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-slate-200">
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Criado em</label>
                        <p class="text-slate-900">{{ $reserva->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Atualizado em</label>
                        <p class="text-slate-900">{{ $reserva->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

