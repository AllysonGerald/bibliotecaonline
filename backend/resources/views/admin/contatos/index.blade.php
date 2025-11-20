@extends('layouts.admin')

@section('title', 'Mensagens de Contato')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Mensagens de Contato</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Gerencie as mensagens recebidas</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Painel do Admin
            </a>
            @if($unreadCount > 0)
                <span style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #fef3c7, #fef9c3); color: #d97706; border: 3px solid #fde68a; border-radius: 12px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 10px rgba(217, 119, 6, 0.15);">
                    <i data-lucide="mail" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                    {{ $unreadCount }} não lida(s)
                </span>
            @endif
        </div>
    </div>
</div>

<!-- Filtros -->
<div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #86efac; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.15); margin-bottom: 24px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(16, 185, 129, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
    <div style="position: relative; z-index: 1;">
        <h3 style="font-size: 20px; font-weight: 900; color: #1f2937; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #10b981, #34d399, #6ee7b7, #a7f3d0); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);">
                <i data-lucide="filter" style="width: 20px; height: 20px; color: white;"></i>
            </div>
            Filtros
        </h3>
        <form method="GET" action="{{ route('admin.contatos.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div>
                <label for="search" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Buscar</label>
                <input
                    type="text"
                    name="search"
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="Nome, e-mail, assunto..."
                    style="width: 100%; padding: 12px 16px; border: 2px solid #86efac; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #d1fae5, #ffffff);"
                    onfocus="this.style.borderColor='#10b981'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.1)';"
                    onblur="this.style.borderColor='#86efac'; this.style.boxShadow='none';"
                >
            </div>
            <div style="display: flex; align-items: flex-end;">
                <button type="submit" style="width: 100%; padding: 12px 20px; background: linear-gradient(135deg, #10b981, #34d399, #6ee7b7, #a7f3d0); color: white; border: 3px solid #10b981; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(16, 185, 129, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(16, 185, 129, 0.3)';">
                    <i data-lucide="search" style="width: 18px; height: 18px; margin-right: 8px; display: inline-block; vertical-align: middle;"></i>
                    Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabela de Mensagens -->
<div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #86efac; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.15); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(16, 185, 129, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
    <div style="position: relative; z-index: 1;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 3px solid #86efac;">
                        <th style="padding: 16px; text-align: left; font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                        <th style="padding: 16px; text-align: left; font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Nome</th>
                        <th style="padding: 16px; text-align: left; font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">E-mail</th>
                        <th style="padding: 16px; text-align: left; font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Assunto</th>
                        <th style="padding: 16px; text-align: left; font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Data</th>
                        <th style="padding: 16px; text-align: right; font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($contacts as $contact)
                        <tr style="border-bottom: 2px solid #d1fae5; transition: all 0.3s; {{ !$contact->lido ? 'background: linear-gradient(135deg, #d1fae5, #ecfdf5);' : '' }}" onmouseover="this.style.background='linear-gradient(135deg, #bbf7d0, #d1fae5)';" onmouseout="this.style.background='{{ !$contact->lido ? 'linear-gradient(135deg, #d1fae5, #ecfdf5)' : 'transparent' }}';">
                            <td style="padding: 16px;">
                                @if($contact->lido)
                                    <span style="display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; background: linear-gradient(135deg, #dcfce7, #f0fdf4); color: #166534; border: 2px solid #86efac;">
                                        Lida
                                    </span>
                                @else
                                    <span style="display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; background: linear-gradient(135deg, #d1fae5, #ecfdf5); color: #10b981; border: 2px solid #86efac;">
                                        Não lida
                                    </span>
                                @endif
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-size: 15px; font-weight: 700; color: #1f2937;">{{ $contact->nome }}</div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-size: 14px; color: #4b5563;">{{ $contact->email }}</div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-size: 14px; color: #4b5563; max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $contact->assunto }}</div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-size: 14px; color: #4b5563;">{{ $contact->created_at->format('d/m/Y H:i') }}</div>
                            </td>
                            <td style="padding: 16px; text-align: right;">
                                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                    <a href="{{ route('admin.contatos.show', $contact) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, #e0f2fe, #f0f9ff); color: #0ea5e9; border: 2px solid #bae6fd; border-radius: 10px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(14, 165, 233, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #0ea5e9, #38bdf8)'; this.style.color='white'; this.style.borderColor='#0ea5e9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(14, 165, 233, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #e0f2fe, #f0f9ff)'; this.style.color='#0ea5e9'; this.style.borderColor='#bae6fd'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(14, 165, 233, 0.15)';" title="Ver">
                                        <i data-lucide="eye" style="width: 18px; height: 18px;"></i>
                                    </a>
                                    <button type="button" onclick="openDeleteModal('delete-contact-{{ $contact->id }}')" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #ef4444; border: 2px solid #fca5a5; border-radius: 10px; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 5px rgba(239, 68, 68, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #ef4444, #f87171)'; this.style.color='white'; this.style.borderColor='#ef4444'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(239, 68, 68, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #fee2e2, #fef2f2)'; this.style.color='#ef4444'; this.style.borderColor='#fca5a5'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(239, 68, 68, 0.15)';" title="Excluir">
                                        <i data-lucide="trash-2" style="width: 18px; height: 18px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 48px; text-align: center;">
                                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #d1fae5, #ecfdf5); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                    <i data-lucide="mail" style="width: 40px; height: 40px; color: #10b981;"></i>
                                </div>
                                <p style="font-size: 16px; color: #6b7280; font-weight: 500;">Nenhuma mensagem encontrada.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($contacts->hasPages())
            @php
                view()->share([
                    'pagination_primaryColor' => '#10b981',
                    'pagination_primaryColorLight' => '#34d399',
                    'pagination_borderColor' => '#86efac',
                    'pagination_backgroundGradient' => 'linear-gradient(135deg, #d1fae5, #ecfdf5)',
                    'pagination_backgroundGradientHover' => 'linear-gradient(135deg, #10b981, #34d399)',
                ]);
            @endphp
            {{ $contacts->links('components.pagination') }}
        @endif
    </div>
</div>

<!-- Modais de Exclusão -->
@foreach($contacts as $contact)
    <x-delete-modal
        id="delete-contact-{{ $contact->id }}"
        title="Confirmar Exclusão"
        message="Tem certeza que deseja excluir esta mensagem? Esta ação não pode ser desfeita."
        :action="route('admin.contatos.destroy', $contact)"
        :itemName="$contact->assunto"
    />
@endforeach

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

