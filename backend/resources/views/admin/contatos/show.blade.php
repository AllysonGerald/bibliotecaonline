@extends('layouts.admin')

@section('title', 'Detalhes da Mensagem')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Detalhes da Mensagem</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Visualize todas as informações da mensagem</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.contatos.index') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Voltar
            </a>
            @if(!$contato->lido)
                <form method="POST" action="{{ route('admin.contatos.mark-as-read', $contato) }}" style="display: inline;">
                    @csrf
                    <button type="submit" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #fef3c7, #fef9c3); color: #d97706; border: 3px solid #fde68a; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(217, 119, 6, 0.15);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(217, 119, 6, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(217, 119, 6, 0.15)';">
                        <i data-lucide="check" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                        Marcar como Lida
                    </button>
                </form>
            @endif
            <button type="button" onclick="openDeleteModal('delete-contact-{{ $contato->id }}')" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #ef4444; border: 3px solid #fca5a5; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.15);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(239, 68, 68, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(239, 68, 68, 0.15)';">
                <i data-lucide="trash-2" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Excluir
            </button>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
    <!-- Informações da Mensagem -->
    <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(139, 92, 246, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
        <div style="position: relative; z-index: 1;">
            <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="mail" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                Informações da Mensagem
            </h3>

            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Status</label>
                    @if($contato->lido)
                        <span style="display: inline-block; padding: 8px 16px; border-radius: 10px; font-size: 14px; font-weight: 700; background: linear-gradient(135deg, #dcfce7, #f0fdf4); color: #166534; border: 2px solid #86efac;">
                            Lida em {{ $contato->lido_em->format('d/m/Y H:i') }}
                        </span>
                    @else
                        <span style="display: inline-block; padding: 8px 16px; border-radius: 10px; font-size: 14px; font-weight: 700; background: linear-gradient(135deg, #fef3c7, #fef9c3); color: #d97706; border: 2px solid #fde68a;">
                            Não lida
                        </span>
                    @endif
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Nome</label>
                    <p style="font-size: 16px; font-weight: 700; color: #1f2937;">{{ $contato->nome }}</p>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">E-mail</label>
                    <p style="font-size: 16px; color: #4b5563;">
                        <a href="mailto:{{ $contato->email }}" style="color: #8b5cf6; text-decoration: none; font-weight: 600;">{{ $contato->email }}</a>
                    </p>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Assunto</label>
                    <p style="font-size: 16px; font-weight: 700; color: #1f2937;">{{ $contato->assunto }}</p>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Data de Envio</label>
                    <p style="font-size: 16px; color: #4b5563;">{{ $contato->created_at->format('d/m/Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mensagem -->
    <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); position: relative; overflow: hidden; grid-column: 1 / -1;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(139, 92, 246, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
        <div style="position: relative; z-index: 1;">
            <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="message-square" style="width: 20px; height: 20px; color: white;"></i>
                </div>
                Mensagem
            </h3>

            <div style="background: linear-gradient(135deg, #f9fafb, #ffffff); border: 2px solid #e5e7eb; border-radius: 12px; padding: 24px; min-height: 200px;">
                <p style="font-size: 15px; line-height: 1.8; color: #374151; white-space: pre-wrap;">{{ $contato->mensagem }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Exclusão -->
<x-delete-modal
    id="delete-contact-{{ $contato->id }}"
    title="Confirmar Exclusão"
    message="Tem certeza que deseja excluir esta mensagem? Esta ação não pode ser desfeita."
    :action="route('admin.contatos.destroy', $contato)"
    :itemName="$contato->assunto"
/>

<script>
    function openDeleteModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            if (typeof Alpine !== 'undefined') {
                Alpine.initTree(modal);
                const alpineData = Alpine.$data(modal);
                if (alpineData) {
                    alpineData.open = true;
                }
            }
        }
    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop')) {
            e.target.style.display = 'none';
            if (typeof Alpine !== 'undefined') {
                const alpineData = Alpine.$data(e.target);
                if (alpineData) {
                    alpineData.open = false;
                }
            }
        }
    });
</script>
<style>
    [x-cloak] { display: none !important; }
</style>
@endsection

