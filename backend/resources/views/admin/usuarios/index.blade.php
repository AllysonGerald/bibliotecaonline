@extends('layouts.admin')

@section('title', 'Usuários')

@section('content')
<x-ui.page-header 
    title="Gerenciar Usuários" 
    subtitle="Gerencie os usuários do sistema"
>
    <x-ui.button href="{{ route('admin.dashboard') }}" variant="secondary" icon="arrow-left">Painel do Admin</x-ui.button>
    <x-ui.button href="{{ route('admin.usuarios.create') }}" variant="primary" icon="plus">Novo Usuário</x-ui.button>
</x-ui.page-header>

<!-- Filtros - Cor Azul para Usuários -->
<x-forms.filter-form 
    action="{{ route('admin.usuarios.index') }}" 
    method="GET" 
    title="Filtros" 
    icon="filter" 
    iconColor="#0ea5e9"
    borderColor="#bae6fd"
    shadowColor="rgba(14, 165, 233, 0.15)"
    backgroundGradient="linear-gradient(135deg, #e0f2fe, #f0f9ff, white)"
    buttonVariant="info"
>
    <x-forms.input
        type="text"
        name="search"
        label="Buscar"
        :value="request('search')"
        placeholder="Nome, e-mail..."
        borderColor="#bae6fd"
        focusColor="#0ea5e9"
        backgroundGradient="linear-gradient(135deg, #f0f9ff, #ffffff)"
    />
    
    <x-forms.select
        name="papel"
        label="Papel"
        :options="['' => 'Todos'] + collect($roles)->mapWithKeys(fn($role) => [$role->value => $role->label()])->toArray()"
        :value="request('papel')"
        borderColor="#bae6fd"
        focusColor="#0ea5e9"
        backgroundGradient="linear-gradient(135deg, #f0f9ff, #ffffff)"
    />
    
    <x-forms.select
        name="ativo"
        label="Status"
        :options="['' => 'Todos', '1' => 'Ativo', '0' => 'Inativo']"
        :value="request('ativo')"
        borderColor="#bae6fd"
        focusColor="#0ea5e9"
        backgroundGradient="linear-gradient(135deg, #f0f9ff, #ffffff)"
    />
</x-forms.filter-form>

<!-- Tabela de Usuários - Cor Azul -->
@php
    $headers = [
        ['label' => 'Nome', 'align' => 'left'],
        ['label' => 'E-mail', 'align' => 'left'],
        ['label' => 'Papel', 'align' => 'left'],
        ['label' => 'Status', 'align' => 'left'],
        ['label' => 'Telefone', 'align' => 'left'],
        ['label' => 'Ações', 'align' => 'right'],
    ];
@endphp

<x-table.table 
    :headers="$headers" 
    :collection="$users"
    borderColor="#bae6fd"
    hoverColor="linear-gradient(135deg, #f0f9ff, #e0f2fe)"
    shadowColor="rgba(14, 165, 233, 0.15)"
    backgroundGradient="linear-gradient(135deg, #e0f2fe, #f0f9ff, white)"
    paginationPrimaryColor="#0ea5e9"
    paginationPrimaryColorLight="#38bdf8"
    paginationBorderColor="#bae6fd"
    paginationBackgroundGradient="linear-gradient(135deg, #e0f2fe, #f0f9ff)"
    paginationBackgroundGradientHover="linear-gradient(135deg, #0ea5e9, #38bdf8)"
>
    @forelse($users as $user)
        <x-table.row borderColor="#e0f2fe" hoverColor="linear-gradient(135deg, #f0f9ff, #e0f2fe)">
                            <td style="padding: 16px;">
                                <div style="font-size: 15px; font-weight: 700; color: #1f2937;">{{ $user->name }}</div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-size: 14px; color: #4b5563;">{{ $user->email }}</div>
                            </td>
                            <td style="padding: 16px;">
                                @php
                                    $roleVariants = [
                                        'admin' => 'primary',
                                        'usuario' => 'info',
                                    ];
                                    $roleVariant = $roleVariants[$user->papel->value] ?? 'default';
                                @endphp
                                <x-ui.badge :variant="$roleVariant">
                                    {{ $user->papel->label() }}
                                </x-ui.badge>
                            </td>
                            <td style="padding: 16px;">
                                <x-ui.badge :variant="$user->ativo ? 'success' : 'danger'">
                                    {{ $user->ativo ? 'Ativo' : 'Inativo' }}
                                </x-ui.badge>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-size: 14px; color: #4b5563; font-weight: 600;">{{ $user->telefone ?? 'N/A' }}</div>
                            </td>
                            <td style="padding: 16px; text-align: right;">
                                <x-table.action-buttons
                                    :viewHref="route('admin.usuarios.show', $user)"
                                    :editHref="route('admin.usuarios.edit', $user)"
                                    :deleteModalId="'delete-user-' . $user->id"
                                />
                            </td>
                        </x-table.row>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 48px; text-align: center;">
                                <x-ui.empty-state
                                    icon="users"
                                    title="Nenhum usuário encontrado"
                                    message="Não há usuários cadastrados no sistema."
                                    iconColor="#0ea5e9"
                                    backgroundGradient="linear-gradient(135deg, #e0f2fe, #f0f9ff)"
                                />
                            </td>
                        </tr>
                    @endforelse
</x-table.table>

<!-- Modais de Exclusão -->
@foreach($users as $user)
    <x-modals.delete-modal
        id="delete-user-{{ $user->id }}"
        title="Confirmar Exclusão"
        message="Tem certeza que deseja excluir este usuário? Esta ação não pode ser desfeita."
        :action="route('admin.usuarios.destroy', $user)"
        :itemName="$user->name"
    />
@endforeach

<script>
    function openDeleteModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            // Inicializar Alpine.js se necessário
            if (typeof Alpine !== 'undefined') {
                Alpine.initTree(modal);
                const alpineData = Alpine.$data(modal);
                if (alpineData) {
                    alpineData.open = true;
                }
            }
        }
    }

    // Fechar modal ao clicar no backdrop
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
