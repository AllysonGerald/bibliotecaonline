@extends('layouts.admin')

@section('title', 'Novo Aluguel')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Novo Aluguel</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Crie um novo aluguel de livro</p>
        </div>
        <a href="{{ route('admin.alugueis.index') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
            <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
            Voltar
        </a>
    </div>
</div>

<div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(139, 92, 246, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
    <div style="position: relative; z-index: 1;">
        <form method="POST" action="{{ route('admin.alugueis.store') }}">
            @csrf

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <!-- Usuário e Livro -->
                <div>
                    <label for="usuario_id" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Usuário *</label>
                    <select
                        name="usuario_id"
                        id="usuario_id"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('usuario_id') ? '#ef4444' : '#e9d5ff' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #faf5ff, #ffffff); cursor: pointer; box-sizing: border-box;"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('usuario_id') ? '#ef4444' : '#e9d5ff' }}'; this.style.boxShadow='none';"
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
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('livro_id') ? '#ef4444' : '#e9d5ff' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #faf5ff, #ffffff); cursor: pointer; box-sizing: border-box;"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('livro_id') ? '#ef4444' : '#e9d5ff' }}'; this.style.boxShadow='none';"
                    >
                        <option value="">Selecione um livro</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}" {{ old('livro_id') == $book->id ? 'selected' : '' }}>
                                {{ $book->titulo }} - {{ $book->author?->nome ?? 'Autor desconhecido' }}
                            </option>
                        @endforeach
                    </select>
                    @error('livro_id')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Datas -->
                <div>
                    <label for="alugado_em" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Data de Aluguel *</label>
                    <input
                        type="datetime-local"
                        name="alugado_em"
                        id="alugado_em"
                        value="{{ old('alugado_em', now()->format('Y-m-d\TH:i')) }}"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('alugado_em') ? '#ef4444' : '#e9d5ff' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #faf5ff, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('alugado_em') ? '#ef4444' : '#e9d5ff' }}'; this.style.boxShadow='none';"
                    >
                    @error('alugado_em')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="data_devolucao" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Data de Devolução *</label>
                    <input
                        type="datetime-local"
                        name="data_devolucao"
                        id="data_devolucao"
                        value="{{ old('data_devolucao', now()->addDays(7)->format('Y-m-d\TH:i')) }}"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('data_devolucao') ? '#ef4444' : '#e9d5ff' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #faf5ff, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('data_devolucao') ? '#ef4444' : '#e9d5ff' }}'; this.style.boxShadow='none';"
                    >
                    @error('data_devolucao')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="devolvido_em" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Data de Devolução Efetiva</label>
                    <input
                        type="datetime-local"
                        name="devolvido_em"
                        id="devolvido_em"
                        value="{{ old('devolvido_em') }}"
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('devolvido_em') ? '#ef4444' : '#e9d5ff' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #faf5ff, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('devolvido_em') ? '#ef4444' : '#e9d5ff' }}'; this.style.boxShadow='none';"
                    >
                    @error('devolvido_em')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Taxa e Status -->
                <div>
                    <label for="taxa_atraso" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Taxa de Atraso (R$)</label>
                    <input
                        type="text"
                        name="taxa_atraso"
                        id="taxa_atraso"
                        value="{{ old('taxa_atraso', 0) }}"
                        data-mask="currency"
                        placeholder="R$ 0,00"
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('taxa_atraso') ? '#ef4444' : '#e9d5ff' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #faf5ff, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('taxa_atraso') ? '#ef4444' : '#e9d5ff' }}'; this.style.boxShadow='none';"
                    >
                    @error('taxa_atraso')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Status *</label>
                    <select
                        name="status"
                        id="status"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('status') ? '#ef4444' : '#e9d5ff' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #faf5ff, #ffffff); cursor: pointer; box-sizing: border-box;"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('status') ? '#ef4444' : '#e9d5ff' }}'; this.style.boxShadow='none';"
                    >
                        @foreach(\App\Enums\RentalStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ old('status', 'ativo') == $status->value ? 'selected' : '' }}>
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
                <a href="{{ route('admin.alugueis.index') }}" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
                    Cancelar
                </a>
                <button type="submit" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border: 3px solid #8b5cf6; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.3)';">
                    <i data-lucide="plus" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                    Criar Aluguel
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
