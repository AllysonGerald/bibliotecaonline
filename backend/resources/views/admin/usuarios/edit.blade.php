@extends('layouts.admin')

@section('title', 'Editar Usuário')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #374151; margin-bottom: 8px;">Editar Usuário</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Atualize as informações do usuário</p>
        </div>
        <a href="{{ route('admin.usuarios.index') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
            <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
            Voltar
        </a>
    </div>
</div>

<div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #bae6fd; box-shadow: 0 10px 30px rgba(14, 165, 233, 0.15); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(14, 165, 233, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
    <div style="position: relative; z-index: 1;">
        <form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <!-- Primeira Linha: Nome e Email -->
                <div>
                    <label for="name" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Nome Completo *</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $usuario->name) }}"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('name') ? '#ef4444' : '#bae6fd' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #f0f9ff, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 0 0 3px rgba(14, 165, 233, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('name') ? '#ef4444' : '#bae6fd' }}'; this.style.boxShadow='none';"
                    >
                    @error('name')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">E-mail *</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', $usuario->email) }}"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('email') ? '#ef4444' : '#bae6fd' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #f0f9ff, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 0 0 3px rgba(14, 165, 233, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('email') ? '#ef4444' : '#bae6fd' }}'; this.style.boxShadow='none';"
                    >
                    @error('email')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Segunda Linha: Senhas -->
                <div>
                    <label for="password" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Nova Senha</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        placeholder="Deixe em branco para manter a atual"
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('password') ? '#ef4444' : '#bae6fd' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #f0f9ff, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 0 0 3px rgba(14, 165, 233, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('password') ? '#ef4444' : '#bae6fd' }}'; this.style.boxShadow='none';"
                    >
                    @error('password')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Confirmar Nova Senha</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        placeholder="Confirme a nova senha"
                        style="width: 100%; padding: 12px 16px; border: 2px solid #bae6fd; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #f0f9ff, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 0 0 3px rgba(14, 165, 233, 0.1)';"
                        onblur="this.style.borderColor='#bae6fd'; this.style.boxShadow='none';"
                    >
                </div>

                <!-- Terceira Linha: Papel e Telefone -->
                <div>
                    <label for="papel" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Papel *</label>
                    <select
                        name="papel"
                        id="papel"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('papel') ? '#ef4444' : '#bae6fd' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #f0f9ff, #ffffff); cursor: pointer; box-sizing: border-box; color: #374151;"
                        onfocus="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 0 0 3px rgba(14, 165, 233, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('papel') ? '#ef4444' : '#bae6fd' }}'; this.style.boxShadow='none';"
                    >
                        @foreach($roles as $role)
                            <option value="{{ $role->value }}" {{ old('papel', $usuario->papel->value) == $role->value ? 'selected' : '' }}>
                                {{ $role->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('papel')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telefone" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Telefone</label>
                    <input
                        type="text"
                        name="telefone"
                        id="telefone"
                        value="{{ old('telefone', $usuario->telefone) }}"
                        placeholder="(00) 00000-0000"
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('telefone') ? '#ef4444' : '#bae6fd' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #f0f9ff, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#0ea5e9'; this.style.boxShadow='0 0 0 3px rgba(14, 165, 233, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('telefone') ? '#ef4444' : '#bae6fd' }}'; this.style.boxShadow='none';"
                    >
                    @error('telefone')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quarta Linha: Checkbox de Status -->
                <div style="grid-column: 1 / -1;">
                    <div style="display: flex; align-items: center; padding: 16px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); border: 2px solid #bae6fd; border-radius: 12px;">
                        <input
                            type="checkbox"
                            name="ativo"
                            id="ativo"
                            value="1"
                            {{ old('ativo', $usuario->ativo) ? 'checked' : '' }}
                            style="width: 20px; height: 20px; accent-color: #0ea5e9; cursor: pointer; flex-shrink: 0;"
                        >
                        <label for="ativo" style="margin-left: 12px; font-size: 14px; font-weight: 700; color: #6b7280; cursor: pointer;">Usuário Ativo</label>
                    </div>
                </div>
            </div>
            
            <style>
                @media (max-width: 768px) {
                    .form-grid {
                        grid-template-columns: 1fr !important;
                    }
                }
            </style>

            <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
                <a href="{{ route('admin.usuarios.index') }}" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #f0f9ff, #ffffff); color: #0ea5e9; border: 3px solid #bae6fd; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(14, 165, 233, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #0ea5e9, #38bdf8)'; this.style.color='white'; this.style.borderColor='#0ea5e9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(14, 165, 233, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f0f9ff, #ffffff)'; this.style.color='#0ea5e9'; this.style.borderColor='#bae6fd'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(14, 165, 233, 0.15)';">
                    Cancelar
                </a>
                <button type="submit" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); color: white; border: 3px solid #0ea5e9; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(14, 165, 233, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(14, 165, 233, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(14, 165, 233, 0.3)';">
                    <i data-lucide="save" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                    Atualizar Usuário
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
