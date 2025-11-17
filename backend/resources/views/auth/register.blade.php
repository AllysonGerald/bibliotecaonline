@extends('layouts.guest')

@section('title', 'Cadastro')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-8">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Criar Conta</h2>
        <p class="mt-2 text-gray-600">Cadastre-se na Biblioteca Online</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="space-y-6">
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Nome Completo
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                    placeholder="João Silva"
                >
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                    E-mail
                </label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
                    placeholder="seu@email.com"
                >
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="telefone" class="block text-sm font-medium text-gray-700 mb-2">
                    Telefone <span class="text-gray-400">(opcional)</span>
                </label>
                <input
                    type="text"
                    name="telefone"
                    id="telefone"
                    value="{{ old('telefone') }}"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('telefone') border-red-500 @enderror"
                    placeholder="(11) 98765-4321"
                >
                @error('telefone')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                    Senha
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror"
                    placeholder="••••••••"
                >
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                    Confirmar Senha
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    placeholder="••••••••"
                >
            </div>

            <div>
                <button
                    type="submit"
                    class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150"
                >
                    Criar Conta
                </button>
            </div>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            Já tem uma conta?
            <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                Faça login aqui
            </a>
        </p>
    </div>
</div>
@endsection

