@extends('layouts.admin')

@section('title', 'Mensagens de Contato')

@section('content')
<x-ui.page-header 
    title="Mensagens de Contato" 
    subtitle="Gerencie as mensagens recebidas"
>
    <x-ui.button href="{{ route('admin.dashboard') }}" variant="secondary" icon="arrow-left">Painel do Admin</x-ui.button>
    @if($unreadCount > 0)
        <span style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #fef3c7, #fef9c3); color: #d97706; border: 3px solid #fde68a; border-radius: 12px; font-size: 14px; font-weight: 700; box-shadow: 0 4px 10px rgba(217, 119, 6, 0.15);">
            <x-ui.icon name="mail" size="18" style="margin-right: 8px;" />
            {{ $unreadCount }} não lida(s)
        </span>
    @endif
</x-ui.page-header>

<!-- Filtros - Cor Verde para Contatos -->
<x-forms.filter-form 
    action="{{ route('admin.contatos.index') }}" 
    method="GET" 
    title="Filtros" 
    icon="filter" 
    iconColor="#10b981"
    borderColor="#86efac"
    shadowColor="rgba(16, 185, 129, 0.15)"
    backgroundGradient="linear-gradient(135deg, #d1fae5, #ecfdf5, white)"
    buttonVariant="success"
>
    <x-forms.input
        type="text"
        name="search"
        label="Buscar"
        :value="request('search')"
        placeholder="Nome, e-mail, assunto..."
        borderColor="#86efac"
        focusColor="#10b981"
        backgroundGradient="linear-gradient(135deg, #d1fae5, #ffffff)"
    />
</x-forms.filter-form>

<!-- Tabela de Mensagens - Cor Verde -->
@php
    $headers = [
        ['label' => 'Status', 'align' => 'left'],
        ['label' => 'Nome', 'align' => 'left'],
        ['label' => 'E-mail', 'align' => 'left'],
        ['label' => 'Assunto', 'align' => 'left'],
        ['label' => 'Data', 'align' => 'left'],
        ['label' => 'Ações', 'align' => 'right'],
    ];
@endphp

<x-table.table 
    :headers="$headers" 
    :collection="$contacts"
    borderColor="#86efac"
    hoverColor="linear-gradient(135deg, #ecfdf5, #d1fae5)"
    shadowColor="rgba(16, 185, 129, 0.15)"
    backgroundGradient="linear-gradient(135deg, #d1fae5, #ecfdf5, white)"
    paginationPrimaryColor="#10b981"
    paginationPrimaryColorLight="#34d399"
    paginationBorderColor="#86efac"
    paginationBackgroundGradient="linear-gradient(135deg, #d1fae5, #ecfdf5)"
    paginationBackgroundGradientHover="linear-gradient(135deg, #10b981, #34d399)"
>
    @forelse($contacts as $contact)
        <x-table.row 
            borderColor="#d1fae5" 
            hoverColor="linear-gradient(135deg, #ecfdf5, #d1fae5)"
            style="{{ !$contact->lido ? 'background: linear-gradient(135deg, #fef3c7, #fef9c3);' : '' }}"
        >
                            <td style="padding: 16px;">
                                <x-ui.badge :variant="$contact->lido ? 'success' : 'warning'">
                                    {{ $contact->lido ? 'Lida' : 'Não lida' }}
                                </x-ui.badge>
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
                                <x-table.action-buttons
                                    :viewHref="route('admin.contatos.show', $contact)"
                                    :deleteModalId="'delete-contact-' . $contact->id"
                                />
                            </td>
                        </x-table.row>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 48px; text-align: center;">
                                <x-ui.empty-state
                                    icon="mail"
                                    title="Nenhuma mensagem encontrada"
                                    message="Não há mensagens de contato no sistema."
                                    iconColor="#10b981"
                                    backgroundGradient="linear-gradient(135deg, #d1fae5, #ecfdf5)"
                                />
                            </td>
                        </tr>
                    @endforelse
</x-table.table>

<!-- Modais de Exclusão -->
@foreach($contacts as $contact)
    <x-modals.delete-modal
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

