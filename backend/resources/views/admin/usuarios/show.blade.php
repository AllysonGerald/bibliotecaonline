@extends('layouts.admin')

@section('title', 'Detalhes do Usuário')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.usuarios.index') }}" class="inline-flex items-center text-slate-600 hover:text-cyan-600 mb-4">
        <i data-lucide="arrow-left" class="w-4 h-4 mr-1"></i>
        Voltar
    </a>
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-slate-900">Detalhes do Usuário</h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors font-medium">
                Editar
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-4">Informações do Usuário</h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Nome Completo</label>
                        <p class="text-slate-900 font-medium">{{ $usuario->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">E-mail</label>
                        <p class="text-slate-900">{{ $usuario->email }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Papel</label>
                        @php
                            $roleColors = [
                                'admin' => 'bg-purple-100 text-purple-800',
                                'usuario' => 'bg-blue-100 text-blue-800',
                            ];
                            $color = $roleColors[$usuario->papel->value] ?? 'bg-slate-100 text-slate-800';
                        @endphp
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $color }}">
                            {{ $usuario->papel->label() }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-500 mb-1">Status</label>
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $usuario->ativo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $usuario->ativo ? 'Ativo' : 'Inativo' }}
                        </span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Telefone</label>
                    <p class="text-slate-900">{{ $usuario->telefone ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="mt-6 bg-white rounded-lg shadow-md border border-slate-200 p-6">
            <h3 class="text-xl font-bold text-slate-900 mb-4">Estatísticas</h3>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center p-4 bg-slate-50 rounded-lg">
                    <div class="text-2xl font-bold text-slate-900">{{ $usuario->rentals->count() }}</div>
                    <div class="text-sm text-slate-600 mt-1">Aluguéis</div>
                </div>
                <div class="text-center p-4 bg-slate-50 rounded-lg">
                    <div class="text-2xl font-bold text-slate-900">{{ $usuario->reservations->count() }}</div>
                    <div class="text-sm text-slate-600 mt-1">Reservas</div>
                </div>
                <div class="text-center p-4 bg-slate-50 rounded-lg">
                    <div class="text-2xl font-bold text-slate-900">{{ $usuario->reviews->count() }}</div>
                    <div class="text-sm text-slate-600 mt-1">Avaliações</div>
                </div>
                <div class="text-center p-4 bg-slate-50 rounded-lg">
                    <div class="text-2xl font-bold text-slate-900">{{ $usuario->wishlists->count() }}</div>
                    <div class="text-sm text-slate-600 mt-1">Lista Desejos</div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="bg-white rounded-lg shadow-md border border-slate-200 p-6">
            <h4 class="text-lg font-bold text-slate-900 mb-4">Informações Adicionais</h4>
            
            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">E-mail Verificado</label>
                    <p class="text-slate-900">
                        @if($usuario->email_verified_at)
                            <span class="text-green-600">Sim - {{ $usuario->email_verified_at->format('d/m/Y H:i') }}</span>
                        @else
                            <span class="text-red-600">Não</span>
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Cadastrado em</label>
                    <p class="text-slate-900">{{ $usuario->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-500 mb-1">Última atualização</label>
                    <p class="text-slate-900">{{ $usuario->updated_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            @if($usuario->fines->where('paga', false)->count() > 0)
                <div class="mt-6 pt-6 border-t border-slate-200">
                    <h4 class="text-lg font-bold text-slate-900 mb-4">Multas Pendentes</h4>
                    <div class="space-y-2">
                        @foreach($usuario->fines->where('paga', false) as $fine)
                            <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                                <p class="text-sm font-medium text-red-800">R$ {{ number_format($fine->valor, 2, ',', '.') }}</p>
                                <p class="text-xs text-red-600">Aluguel #{{ $fine->aluguel_id }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

