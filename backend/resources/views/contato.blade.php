@extends('layouts.app')

@section('title', 'Contato')

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Entre em Contato</h1>
    <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Tire suas dúvidas ou envie sugestões</p>
</div>

<div style="display: grid; grid-template-columns: 1fr; gap: 32px; @media (min-width: 1024px) { grid-template-columns: 1fr 1fr; }">
    <!-- Formulário de Contato -->
    <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);">
        <h2 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 24px;">Envie sua Mensagem</h2>
        
        <form method="POST" action="{{ route('contato.store') }}">
            @csrf

            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div>
                    <label for="nome" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Nome *</label>
                    <input
                        type="text"
                        name="nome"
                        id="nome"
                        value="{{ old('nome', auth()->user()->name ?? '') }}"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; transition: all 0.3s; @error('nome') border-color: #ef4444; @enderror"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                    >
                    @error('nome')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Email *</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email', auth()->user()->email ?? '') }}"
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
                    <label for="assunto" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Assunto *</label>
                    <input
                        type="text"
                        name="assunto"
                        id="assunto"
                        value="{{ old('assunto') }}"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; transition: all 0.3s; @error('assunto') border-color: #ef4444; @enderror"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                        placeholder="Ex: Dúvida sobre aluguel, Sugestão de livro..."
                    >
                    @error('assunto')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="mensagem" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Mensagem *</label>
                    <textarea
                        name="mensagem"
                        id="mensagem"
                        rows="6"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; font-family: inherit; resize: vertical; transition: all 0.3s; @error('mensagem') border-color: #ef4444; @enderror"
                        onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                        placeholder="Escreva sua mensagem aqui..."
                    >{{ old('mensagem') }}</textarea>
                    @error('mensagem')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div style="display: flex; gap: 12px; margin-top: 8px;">
                    <button type="submit" style="flex: 1; padding: 14px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-size: 16px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
                        <i data-lucide="send" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i>
                        Enviar Mensagem
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Informações de Contato -->
    <div>
        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); margin-bottom: 24px;">
            <h2 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 24px;">Informações de Contato</h2>
            
            <div style="display: flex; flex-direction: column; gap: 24px;">
                <div style="display: flex; align-items: start; gap: 16px;">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i data-lucide="mail" style="width: 24px; height: 24px; color: white;"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">Email</h3>
                        <p style="font-size: 14px; color: #6b7280; font-weight: 500;">contato@biblioteca.com</p>
                    </div>
                </div>

                <div style="display: flex; align-items: start; gap: 16px;">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #ec4899, #f472b6); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i data-lucide="phone" style="width: 24px; height: 24px; color: white;"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">Telefone</h3>
                        <p style="font-size: 14px; color: #6b7280; font-weight: 500;">(11) 1234-5678</p>
                    </div>
                </div>

                <div style="display: flex; align-items: start; gap: 16px;">
                    <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #f97316, #fb923c); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i data-lucide="clock" style="width: 24px; height: 24px; color: white;"></i>
                    </div>
                    <div>
                        <h3 style="font-size: 16px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">Horário de Atendimento</h3>
                        <p style="font-size: 14px; color: #6b7280; font-weight: 500;">Segunda a Sexta: 9h às 18h</p>
                        <p style="font-size: 14px; color: #6b7280; font-weight: 500;">Sábado: 9h às 13h</p>
                    </div>
                </div>
            </div>
        </div>

        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);">
            <h2 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 16px;">Por que entrar em contato?</h2>
            <ul style="display: flex; flex-direction: column; gap: 12px; list-style: none; padding: 0; margin: 0;">
                <li style="display: flex; align-items: start; gap: 12px;">
                    <i data-lucide="check-circle" style="width: 20px; height: 20px; color: #8b5cf6; flex-shrink: 0; margin-top: 2px;"></i>
                    <span style="font-size: 14px; color: #4b5563; font-weight: 500;">Tire dúvidas sobre nossos serviços</span>
                </li>
                <li style="display: flex; align-items: start; gap: 12px;">
                    <i data-lucide="check-circle" style="width: 20px; height: 20px; color: #8b5cf6; flex-shrink: 0; margin-top: 2px;"></i>
                    <span style="font-size: 14px; color: #4b5563; font-weight: 500;">Sugira novos livros para o acervo</span>
                </li>
                <li style="display: flex; align-items: start; gap: 12px;">
                    <i data-lucide="check-circle" style="width: 20px; height: 20px; color: #8b5cf6; flex-shrink: 0; margin-top: 2px;"></i>
                    <span style="font-size: 14px; color: #4b5563; font-weight: 500;">Reporte problemas técnicos</span>
                </li>
                <li style="display: flex; align-items: start; gap: 12px;">
                    <i data-lucide="check-circle" style="width: 20px; height: 20px; color: #8b5cf6; flex-shrink: 0; margin-top: 2px;"></i>
                    <span style="font-size: 14px; color: #4b5563; font-weight: 500;">Envie feedback e sugestões</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

