@extends('layouts.admin')

@section('title', 'Autores')

@section('content')

<x-ui.page-header 
    title="Gerenciar Autores" 
    subtitle="Gerencie os autores do catálogo"
>
    <x-ui.button href="{{ route('admin.autores.create') }}" variant="primary" icon="plus">Novo Autor</x-ui.button>
</x-ui.page-header>

<!-- Filtros - Cor Laranja para Autores -->
<x-forms.filter-form 
    :action="route('admin.autores.index')"
    title="Filtros"
    icon="filter"
    iconColor="#f97316"
    borderColor="#fed7aa"
    shadowColor="rgba(249, 115, 22, 0.15)"
    backgroundGradient="linear-gradient(135deg, #fff7ed, #fff1f2, white)"
    buttonVariant="warning"
>
    <x-forms.input
        type="text"
        name="search"
        label="Buscar"
        :value="request('search')"
        placeholder="Buscar por nome..."
        borderColor="#fed7aa"
        focusColor="#f97316"
        backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
    />
</x-forms.filter-form>

<!-- Tabela de Autores - Cor Laranja -->
@php
    $headers = [
        ['label' => 'Nome', 'align' => 'left'],
        ['label' => 'Data de Nascimento', 'align' => 'left'],
        ['label' => 'Livros', 'align' => 'left'],
        ['label' => 'Ações', 'align' => 'right'],
    ];
@endphp

<x-table.table 
    :headers="$headers" 
    borderColor="#fed7aa"
    hoverColor="linear-gradient(135deg, #fff7ed, #fff1f2)"
    shadowColor="rgba(249, 115, 22, 0.15)"
    backgroundGradient="linear-gradient(135deg, #fff7ed, #fff1f2, white)"
>
    @forelse($authors as $author)
        <x-table.row borderColor="#fff1f2" hoverColor="linear-gradient(135deg, #fff7ed, #fff1f2)">
            <td style="padding: 16px; white-space: nowrap;">
                <div style="font-size: 15px; font-weight: 700; color: #1f2937;">{{ $author->nome }}</div>
            </td>
            <td style="padding: 16px; white-space: nowrap;">
                <div style="font-size: 14px; color: #4b5563; font-weight: 600;">{{ $author->data_nascimento ? $author->data_nascimento->format('d/m/Y') : 'N/A' }}</div>
            </td>
            <td style="padding: 16px; white-space: nowrap;">
                <div style="font-size: 14px; color: #4b5563; font-weight: 600;">{{ $author->books_count ?? $author->books->count() }}</div>
            </td>
            <td style="padding: 16px; text-align: right; white-space: nowrap;">
                <x-table.action-buttons
                    :viewHref="route('admin.autores.show', $author)"
                    :editHref="route('admin.autores.edit', $author)"
                    :deleteModalId="'delete-author-' . $author->id"
                />
            </td>
        </x-table.row>
    @empty
        <tr>
            <td colspan="4" style="padding: 48px; text-align: center;">
                <x-ui.empty-state
                    icon="user"
                    message="Nenhum autor encontrado."
                />
            </td>
        </tr>
    @endforelse
</x-table.table>

@if($authors->hasPages())
    @php
        view()->share([
            'pagination_primaryColor' => '#f97316',
            'pagination_primaryColorLight' => '#fb923c',
            'pagination_borderColor' => '#fed7aa',
            'pagination_backgroundGradient' => 'linear-gradient(135deg, #fff1f2, #fff7ed)',
            'pagination_backgroundGradientHover' => 'linear-gradient(135deg, #f97316, #fb923c)',
        ]);
    @endphp
    <div style="margin-top: 24px;">
        {{ $authors->links('components.pagination') }}
    </div>
@endif

<!-- Modais de Exclusão -->
@foreach($authors as $author)
    <x-modals.delete-modal
        id="delete-author-{{ $author->id }}"
        title="Confirmar Exclusão"
        message="Tem certeza que deseja excluir este autor? Esta ação não pode ser desfeita."
        :action="route('admin.autores.destroy', $author)"
        :itemName="$author->nome"
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
@endsection
