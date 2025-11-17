@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-8">
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-900">Entrar</h2>
        <p class="mt-2 text-gray-600">Acesse sua conta na Biblioteca Online</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="space-y-6">
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
                    autofocus
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 @error('email') border-red-500 @enderror"
                    placeholder="seu@email.com"
                >
                @error('email')
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

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input
                        type="checkbox"
                        name="remember"
                        id="remember"
                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                    >
                    <label for="remember" class="ml-2 block text-sm text-gray-700">
                        Lembrar-me
                    </label>
                </div>
            </div>

            <div>
                <button
                    type="submit"
                    class="w-full bg-indigo-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150"
                >
                    Entrar
                </button>
            </div>
        </div>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600">
            Não tem uma conta?
            <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                Cadastre-se aqui
            </a>
        </p>
    </div>
</div>
@endsection

