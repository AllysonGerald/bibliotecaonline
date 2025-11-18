@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Meu Perfil</h1>
    <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Gerencie suas informações pessoais</p>
</div>

<div style="display: grid; grid-template-columns: 1fr; gap: 24px; @media (min-width: 1024px) { grid-template-columns: 1fr 1fr; }">
    <!-- Formulário de Edição -->
    <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);">
        <h2 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 24px;">Informações Pessoais</h2>
        
        <form method="POST" action="{{ route('perfil.update') }}">
            @csrf
            @method('PUT')

            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div>
                    <label for="name" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Nome *</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; transition: all 0.3s; @error('name') border-color: #ef4444; @enderror"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                    >
                    @error('name')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Email *</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; transition: all 0.3s; @error('email') border-color: #ef4444; @enderror"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                    >
                    @error('email')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telefone" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Telefone</label>
                    <input
                        type="text"
                        name="telefone"
                        id="telefone"
                        value="{{ old('telefone', $user->telefone) }}"
                        data-mask="phone"
                        style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; transition: all 0.3s; @error('telefone') border-color: #ef4444; @enderror"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                    >
                    @error('telefone')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <hr style="border: none; border-top: 2px solid #e9d5ff; margin: 8px 0;">

                <div>
                    <label for="password" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Nova Senha</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; transition: all 0.3s; @error('password') border-color: #ef4444; @enderror"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                        placeholder="Deixe em branco para manter a senha atual"
                    >
                    @error('password')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Confirmar Nova Senha</label>
                    <input
                        type="password"
                        name="password_confirmation"
                        id="password_confirmation"
                        style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; transition: all 0.3s;"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                        placeholder="Confirme a nova senha"
                    >
                </div>

                <div style="display: flex; gap: 12px; margin-top: 8px;">
                    <button type="submit" style="flex: 1; padding: 14px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-size: 16px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
                        <i data-lucide="save" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i>
                        Salvar Alterações
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Estatísticas do Usuário -->
    <div>
        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); margin-bottom: 24px;">
            <h2 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 24px;">Estatísticas</h2>
            
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); border-radius: 12px; border: 2px solid #e9d5ff;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="book" style="width: 20px; height: 20px; color: white;"></i>
                        </div>
                        <span style="font-size: 14px; font-weight: 700; color: #4b5563;">Aluguéis</span>
                    </div>
                    <span style="font-size: 24px; font-weight: 900; color: #1f2937;">{{ $user->rentals->count() }}</span>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: linear-gradient(135deg, #fce7f3, #fdf2f8); border-radius: 12px; border: 2px solid #fbcfe8;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ec4899, #f472b6); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="clock" style="width: 20px; height: 20px; color: white;"></i>
                        </div>
                        <span style="font-size: 14px; font-weight: 700; color: #4b5563;">Reservas</span>
                    </div>
                    <span style="font-size: 24px; font-weight: 900; color: #1f2937;">{{ $user->reservations->count() }}</span>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: linear-gradient(135deg, #fff1f2, #fff7ed); border-radius: 12px; border: 2px solid #fed7aa;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f97316, #fb923c); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="heart" style="width: 20px; height: 20px; color: white;"></i>
                        </div>
                        <span style="font-size: 14px; font-weight: 700; color: #4b5563;">Lista de Desejos</span>
                    </div>
                    <span style="font-size: 24px; font-weight: 900; color: #1f2937;">{{ $user->wishlists->count() }}</span>
                </div>

                <div style="display: flex; align-items: center; justify-content: space-between; padding: 16px; background: linear-gradient(135deg, #faf5ff, #f3e8ff); border-radius: 12px; border: 2px solid #e9d5ff;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i data-lucide="star" style="width: 20px; height: 20px; color: white;"></i>
                        </div>
                        <span style="font-size: 14px; font-weight: 700; color: #4b5563;">Avaliações</span>
                    </div>
                    <span style="font-size: 24px; font-weight: 900; color: #1f2937;">{{ $user->reviews->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Informações da Conta -->
        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);">
            <h2 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 24px;">Informações da Conta</h2>
            
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Papel</label>
                    <p style="font-size: 16px; color: #1f2937; font-weight: 600;">{{ $user->papel->label() }}</p>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Status</label>
                    <span style="display: inline-block; padding: 6px 12px; background: {{ $user->ativo ? 'linear-gradient(135deg, #dcfce7, #f0fdf4)' : 'linear-gradient(135deg, #fee2e2, #fef2f2)' }}; color: {{ $user->ativo ? '#166534' : '#991b1b' }}; border-radius: 8px; font-size: 13px; font-weight: 700; border: 2px solid {{ $user->ativo ? '#86efac' : '#fca5a5' }};">
                        {{ $user->ativo ? 'Ativo' : 'Inativo' }}
                    </span>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Membro desde</label>
                    <p style="font-size: 16px; color: #1f2937; font-weight: 600;">{{ $user->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

