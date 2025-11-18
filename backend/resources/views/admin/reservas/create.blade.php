@extends('layouts.admin')

@section('title', 'Nova Reserva')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #374151; margin-bottom: 8px;">Nova Reserva</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Crie uma nova reserva de livro</p>
        </div>
        <a href="{{ route('admin.reservas.index') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
            <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
            Voltar
        </a>
    </div>
</div>

<div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(236, 72, 153, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
    <div style="position: relative; z-index: 1;">
        <form method="POST" action="{{ route('admin.reservas.store') }}">
            @csrf

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <!-- Usuário e Livro -->
                <div>
                    <label for="usuario_id" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Usuário *</label>
                    <select
                        name="usuario_id"
                        id="usuario_id"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('usuario_id') ? '#ef4444' : '#fbcfe8' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fdf2f8, #ffffff); cursor: pointer; box-sizing: border-box; color: #374151;"
                        onfocus="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 0 3px rgba(236, 72, 153, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('usuario_id') ? '#ef4444' : '#fbcfe8' }}'; this.style.boxShadow='none';"
                    >
                        <option value="">Selecione um usuário</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('usuario_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('usuario_id')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="livro_id" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Livro *</label>
                    <select
                        name="livro_id"
                        id="livro_id"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('livro_id') ? '#ef4444' : '#fbcfe8' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fdf2f8, #ffffff); cursor: pointer; box-sizing: border-box; color: #374151;"
                        onfocus="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 0 3px rgba(236, 72, 153, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('livro_id') ? '#ef4444' : '#fbcfe8' }}'; this.style.boxShadow='none';"
                    >
                        <option value="">Selecione um livro</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ old('livro_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->titulo }} - {{ $book->author->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('livro_id')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Data de Reserva e Data de Expiração -->
                <div>
                    <label for="reservado_em" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Data de Reserva *</label>
                    <input
                        type="datetime-local"
                        name="reservado_em"
                        id="reservado_em"
                        value="{{ old('reservado_em', now()->format('Y-m-d\TH:i')) }}"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('reservado_em') ? '#ef4444' : '#fbcfe8' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fdf2f8, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 0 3px rgba(236, 72, 153, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('reservado_em') ? '#ef4444' : '#fbcfe8' }}'; this.style.boxShadow='none';"
                    >
                    @error('reservado_em')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="expira_em" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Data de Expiração *</label>
                    <input
                        type="datetime-local"
                        name="expira_em"
                        id="expira_em"
                        value="{{ old('expira_em', now()->addDays(7)->format('Y-m-d\TH:i')) }}"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('expira_em') ? '#ef4444' : '#fbcfe8' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fdf2f8, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 0 3px rgba(236, 72, 153, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('expira_em') ? '#ef4444' : '#fbcfe8' }}'; this.style.boxShadow='none';"
                    >
                    @error('expira_em')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Status *</label>
                    <select
                        name="status"
                        id="status"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('status') ? '#ef4444' : '#fbcfe8' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fdf2f8, #ffffff); cursor: pointer; box-sizing: border-box; color: #374151;"
                        onfocus="this.style.borderColor='#ec4899'; this.style.boxShadow='0 0 0 3px rgba(236, 72, 153, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('status') ? '#ef4444' : '#fbcfe8' }}'; this.style.boxShadow='none';"
                    >
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}" {{ old('status', 'pendente') == $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
                <a href="{{ route('admin.reservas.index') }}" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #fdf2f8, #ffffff); color: #ec4899; border: 3px solid #fbcfe8; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(236, 72, 153, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #ec4899, #f472b6)'; this.style.color='white'; this.style.borderColor='#ec4899'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(236, 72, 153, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #fdf2f8, #ffffff)'; this.style.color='#ec4899'; this.style.borderColor='#fbcfe8'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(236, 72, 153, 0.15)';">
                    Cancelar
                </a>
                <button type="submit" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #ec4899, #f97316); color: white; border: 3px solid #ec4899; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(236, 72, 153, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(236, 72, 153, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(236, 72, 153, 0.3)';">
                    <i data-lucide="calendar-plus" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                    Criar Reserva
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
