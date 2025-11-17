@extends('layouts.admin')

@section('title', 'Detalhes do Aluguel')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.alugueis.index') }}" class="inline-flex items-center text-slate-600 hover:text-cyan-600 mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
        Voltar
    </a>
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-900">Detalhes do Aluguel</h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.alugueis.edit', $aluguel) }}" class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors font-medium">
                Editar
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-4">Informações do Aluguel</h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Usuário</label>
                        <p class="text-slate-900 font-medium">{{ $aluguel->user->name }}</p>
                        <p class="text-sm text-slate-500">{{ $aluguel->user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Livro</label>
                        <p class="text-slate-900 font-medium">{{ $aluguel->book->titulo }}</p>
                        <p class="text-sm text-slate-500">{{ $aluguel->book->author->nome }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Alugado em</label>
                        <p class="text-slate-900">{{ $aluguel->alugado_em->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Data de Devolução</label>
                        <p class="text-slate-900">{{ $aluguel->data_devolucao->format('d/m/Y') }}</p>
                    </div>
                </div>

                @if($aluguel->devolvido_em)
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Devolvido em</label>
                        <p class="text-slate-900">{{ $aluguel->devolvido_em->format('d/m/Y H:i') }}</p>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Status</label>
                        @php
                            $statusColors = [
                                'ativo' => 'bg-blue-100 text-blue-800',
                                'devolvido' => 'bg-emerald-100 text-emerald-800',
                                'atrasado' => 'bg-red-100 text-red-800',
                            ];
                            $color = $statusColors[$aluguel->status->value] ?? 'bg-slate-100 text-slate-800';
                        @endphp
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $color }}">
                            {{ $aluguel->status->label() }}
                        </span>
                    </div>
                    @if($aluguel->taxa_atraso > 0)
                        <div>
                            <label class="block text-sm font-medium text-slate-500 mb-1">Taxa de Atraso</label>
                            <p class="text-slate-900 font-semibold text-red-600">R$ {{ number_format($aluguel->taxa_atraso, 2, ',', '.') }}</p>
                        </div>
                    @endif
                </div>

                @if($aluguel->isOverdue())
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-red-600 mr-2"></i>
                            <div>
                                <p class="text-sm font-medium text-red-800">Aluguel Atrasado</p>
                                <p class="text-sm text-red-600">Este aluguel está {{ $aluguel->daysOverdue() }} dia(s) atrasado.</p>
                            </div>
                        </div>
                    </div>
                @endif

                @if($aluguel->fine)
                    <div class="bg-amber-50 border border-amber-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-amber-800">Multa Associada</p>
                                <p class="text-sm text-amber-600">Valor: R$ {{ number_format($aluguel->fine->valor, 2, ',', '.') }}</p>
                                <p class="text-sm text-amber-600">Status: {{ $aluguel->fine->paga ? 'Paga' : 'Pendente' }}</p>
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
                    <p class="text-slate-900">{{ $aluguel->book->category->nome }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">ISBN</label>
                    <p class="text-slate-900">{{ $aluguel->book->isbn ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Editora</label>
                    <p class="text-slate-900">{{ $aluguel->book->editora ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-slate-200">
                <h4 class="text-lg font-bold text-slate-900 mb-4">Informações do Usuário</h4>
                
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Telefone</label>
                        <p class="text-slate-900">{{ $aluguel->user->telefone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Status da Conta</label>
                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full {{ $aluguel->user->ativo ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                            {{ $aluguel->user->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-6 pt-6 border-t border-slate-200">
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Criado em</label>
                        <p class="text-slate-900">{{ $aluguel->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Atualizado em</label>
                        <p class="text-slate-900">{{ $aluguel->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

