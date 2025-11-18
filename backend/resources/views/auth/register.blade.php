@extends('layouts.guest')

@section('title', 'Criar Conta')

@section('content')
<div style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-radius: 20px; padding: 32px; box-shadow: 0 20px 60px rgba(139, 92, 246, 0.3); border: 2px solid rgba(233, 213, 255, 0.5); max-width: 480px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 28px;">
        <div style="display: inline-flex; align-items: center; justify-content: center; width: 64px; height: 64px; background: linear-gradient(135deg, #ec4899, #f97316); border-radius: 16px; margin-bottom: 16px; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.4);">
            <i data-lucide="user-plus" style="width: 32px; height: 32px; color: white; display: block;"></i>
        </div>
        <h2 style="font-size: 28px; font-weight: 900; color: #1f2937; margin-bottom: 6px;">Criar Conta</h2>
        <p style="font-size: 14px; color: #6b7280; font-weight: 500;">Cadastre-se na Biblioteca Online</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="display: flex; flex-direction: column; gap: 16px;">
            <div>
                <label for="name" style="display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px;">
                    Nome Completo
                </label>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    style="width: 100%; padding: 12px 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.3s; box-sizing: border-box; @error('name') border-color: #ef4444; @enderror"
                    onfocus="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 0 3px rgba(236, 72, 153, 0.1)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                    placeholder="João Silva"
                >
                @error('name')
                    <p style="margin-top: 6px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" style="display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px;">
                    E-mail
                </label>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                    style="width: 100%; padding: 12px 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.3s; box-sizing: border-box; @error('email') border-color: #ef4444; @enderror"
                    onfocus="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 0 3px rgba(236, 72, 153, 0.1)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                    placeholder="seu@email.com"
                >
                @error('email')
                    <p style="margin-top: 6px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="telefone" style="display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px;">
                    Telefone <span style="color: #9ca3af; font-weight: 400;">(opcional)</span>
                </label>
                <input
                    type="text"
                    name="telefone"
                    id="telefone"
                    value="{{ old('telefone') }}"
                    data-mask="phone"
                    style="width: 100%; padding: 12px 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.3s; box-sizing: border-box; @error('telefone') border-color: #ef4444; @enderror"
                    onfocus="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 0 3px rgba(236, 72, 153, 0.1)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                    placeholder="(11) 98765-4321"
                >
                @error('telefone')
                    <p style="margin-top: 6px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" style="display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px;">
                    Senha
                </label>
                <input
                    type="password"
                    name="password"
                    id="password"
                    required
                    style="width: 100%; padding: 12px 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.3s; box-sizing: border-box; @error('password') border-color: #ef4444; @enderror"
                    onfocus="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 0 3px rgba(236, 72, 153, 0.1)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                    placeholder="••••••••"
                >
                @error('password')
                    <p style="margin-top: 6px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" style="display: block; font-size: 13px; font-weight: 700; color: #374151; margin-bottom: 6px;">
                    Confirmar Senha
                </label>
                <input
                    type="password"
                    name="password_confirmation"
                    id="password_confirmation"
                    required
                    style="width: 100%; padding: 12px 14px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 15px; transition: all 0.3s; box-sizing: border-box;"
                    onfocus="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 0 3px rgba(236, 72, 153, 0.1)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                    placeholder="••••••••"
                >
            </div>

            <div>
                <button
                    type="submit"
                    style="width: 100%; padding: 14px; background: linear-gradient(135deg, #ec4899, #f97316); color: white; border-radius: 10px; font-size: 16px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.4); transition: all 0.3s; margin-top: 4px;"
                    onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 15px 40px rgba(236, 72, 153, 0.5)';"
                    onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 10px 30px rgba(236, 72, 153, 0.4)';"
                >
                    Criar Conta
                </button>
            </div>
        </div>
    </form>

    <div style="margin-top: 24px; text-align: center; display: flex; flex-direction: column; gap: 12px;">
        <p style="font-size: 13px; color: #6b7280;">
            Já tem uma conta?
            <a href="{{ route('login') }}" style="font-weight: 700; color: #ec4899; text-decoration: none; margin-left: 4px;">
                Faça login aqui
            </a>
        </p>
        <a href="{{ route('welcome') }}" style="display: inline-flex; align-items: center; justify-content: center; font-size: 13px; color: #6b7280; font-weight: 600; text-decoration: none; transition: color 0.3s;" onmouseover="this.style.color='#ec4899';" onmouseout="this.style.color='#6b7280';">
            <i data-lucide="arrow-left" style="width: 16px; height: 16px; margin-right: 8px; vertical-align: middle;"></i>
            <span>Voltar para página inicial</span>
        </a>
    </div>
</div>
@endsection
