@extends('layouts.admin')

@section('title', 'Detalhes da Mensagem')

@section('content')
<x-ui.page-header 
    title="Detalhes da Mensagem" 
    subtitle="Visualize todas as informações da mensagem"
>
    <x-ui.button href="{{ route('admin.contatos.index') }}" variant="secondary" icon="arrow-left">Voltar</x-ui.button>
    @if(!$contato->lido)
        <form method="POST" action="{{ route('admin.contatos.mark-as-read', $contato) }}" style="display: inline;">
            @csrf
            <x-ui.button type="submit" variant="warning" icon="check">Marcar como Lida</x-ui.button>
        </form>
    @endif
    <button type="button" onclick="openDeleteModal(&quot;delete-contact-{{ $contato->id }}&quot;)" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #ef4444, #f87171); color: white; border: 3px solid #ef4444; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(239, 68, 68, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(239, 68, 68, 0.3)';">
        <x-ui.icon name="trash-2" size="18" style="margin-right: 8px;" />
        Excluir
    </button>
</x-ui.page-header>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
    <!-- Informações da Mensagem -->
    <x-ui.info-card 
        title="Informações da Mensagem"
        icon="mail"
        iconColor="#10b981"
        borderColor="#86efac"
        shadowColor="rgba(16, 185, 129, 0.15)"
        backgroundGradient="linear-gradient(135deg, #d1fae5, #ecfdf5, white)"
    >
        <x-ui.detail-row label="Status">
            @if($contato->lido)
                <x-ui.badge variant="success">
                    Lida em {{ $contato->lido_em->format('d/m/Y H:i') }}
                </x-ui.badge>
            @else
                <x-ui.badge variant="warning">
                    Não lida
                </x-ui.badge>
            @endif
        </x-ui.detail-row>

        <x-ui.detail-row label="Nome" :value="$contato->nome" />
        <x-ui.detail-row label="E-mail">
            <a href="mailto:{{ $contato->email }}" style="color: #10b981; text-decoration: none; font-weight: 600;">{{ $contato->email }}</a>
        </x-ui.detail-row>
        <x-ui.detail-row label="Assunto" :value="$contato->assunto" />
        <x-ui.detail-row label="Data de Envio" :value="$contato->created_at->format('d/m/Y H:i:s')" />
    </x-ui.info-card>

    <!-- Mensagem -->
    <x-ui.info-card 
        title="Mensagem"
        icon="message-square"
        iconColor="#10b981"
        borderColor="#86efac"
        shadowColor="rgba(16, 185, 129, 0.15)"
        backgroundGradient="linear-gradient(135deg, #d1fae5, #ecfdf5, white)"
        style="grid-column: 1 / -1;"
    >
        <div style="background: linear-gradient(135deg, #ecfdf5, #ffffff); border: 2px solid #86efac; border-radius: 12px; padding: 24px; min-height: 200px;">
            <p style="font-size: 15px; line-height: 1.8; color: #374151; white-space: pre-wrap;">{{ $contato->mensagem }}</p>
        </div>
    </x-ui.info-card>
</div>

<!-- Modal de Exclusão -->
<x-modals.delete-modal
    id="delete-contact-{{ $contato->id }}"
    title="Confirmar Exclusão"
    message="Tem certeza que deseja excluir esta mensagem? Esta ação não pode ser desfeita."
    :action="route('admin.contatos.destroy', $contato)"
    :itemName="$contato->assunto"
/>

<script>
    // Tornar a função global e simplificada
    window.openDeleteModal = function(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) {
            console.error('Modal not found:', modalId);
            return;
        }
        
        // Mostrar o modal
        modal.style.display = 'block';
        
        // Atualizar ícones Lucide
        if (typeof lucide !== 'undefined') {
            setTimeout(() => {
                lucide.createIcons();
            }, 100);
        }
    };

    // Fechar modal com ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modals = document.querySelectorAll('.modal-backdrop');
            modals.forEach(modal => {
                if (modal.style.display === 'block') {
                    modal.style.display = 'none';
                }
            });
        }
    });
</script>
<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
