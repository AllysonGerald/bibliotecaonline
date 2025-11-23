@extends('layouts.admin')

@section('title', 'Categorias')

@section('content')

<x-ui.page-header 
    title="Gerenciar Categorias" 
    subtitle="Gerencie as categorias do catálogo"
>
    <x-ui.button href="{{ route('admin.categorias.create') }}" variant="primary" icon="plus">Nova Categoria</x-ui.button>
</x-ui.page-header>

<!-- Filtros - Cor Roxa para Categorias -->
<x-forms.filter-form 
    :action="route('admin.categorias.index')"
    title="Filtros"
    icon="filter"
    iconColor="#8b5cf6"
    borderColor="#e9d5ff"
    shadowColor="rgba(139, 92, 246, 0.15)"
    backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)"
    buttonVariant="primary"
>
    <x-forms.input
        type="text"
        name="search"
        label="Buscar"
        :value="request('search')"
        placeholder="Buscar por nome..."
        borderColor="#e9d5ff"
        focusColor="#8b5cf6"
        backgroundGradient="linear-gradient(135deg, #f3e8ff, #ffffff)"
    />
</x-forms.filter-form>

<!-- Tabela de Categorias - Cor Roxa -->
@php
    $headers = [
        ['label' => 'Nome', 'align' => 'left'],
        ['label' => 'Descrição', 'align' => 'left'],
        ['label' => 'Livros', 'align' => 'left'],
        ['label' => 'Ações', 'align' => 'right'],
    ];
@endphp

<x-table.table 
    :headers="$headers" 
    borderColor="#e9d5ff"
    hoverColor="linear-gradient(135deg, #f3e8ff, #faf5ff)"
    shadowColor="rgba(139, 92, 246, 0.15)"
    backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)"
>
    @forelse($categories as $category)
        <x-table.row borderColor="#f3e8ff" hoverColor="linear-gradient(135deg, #f3e8ff, #faf5ff)">
            <td style="padding: 16px; white-space: nowrap;">
                <div style="font-size: 15px; font-weight: 700; color: #1f2937;">{{ $category->nome }}</div>
            </td>
            <td style="padding: 16px;">
                <div style="font-size: 14px; color: #4b5563; font-weight: 600;">{{ Str::limit($category->descricao ?? 'N/A', 50) }}</div>
            </td>
            <td style="padding: 16px; white-space: nowrap;">
                <div style="font-size: 14px; color: #4b5563; font-weight: 600;">{{ $category->books_count ?? $category->books->count() }}</div>
            </td>
            <td style="padding: 16px; text-align: right; white-space: nowrap;">
                <x-table.action-buttons
                    :viewHref="route('admin.categorias.show', $category)"
                    :editHref="route('admin.categorias.edit', $category)"
                    :deleteModalId="'delete-category-' . $category->id"
                />
            </td>
        </x-table.row>
    @empty
        <tr>
            <td colspan="4" style="padding: 48px; text-align: center;">
                <x-ui.empty-state
                    icon="tag"
                    message="Nenhuma categoria encontrada."
                />
            </td>
        </tr>
    @endforelse
</x-table.table>

@if($categories->hasPages())
    @php
        view()->share([
            'pagination_primaryColor' => '#8b5cf6',
            'pagination_primaryColorLight' => '#a855f7',
            'pagination_borderColor' => '#e9d5ff',
            'pagination_backgroundGradient' => 'linear-gradient(135deg, #f3e8ff, #faf5ff)',
            'pagination_backgroundGradientHover' => 'linear-gradient(135deg, #8b5cf6, #a855f7)',
        ]);
    @endphp
    <div style="margin-top: 24px;">
        {{ $categories->links('components.pagination') }}
    </div>
@endif

<!-- Modais de Exclusão -->
@foreach($categories as $category)
    <x-modals.delete-modal
        id="delete-category-{{ $category->id }}"
        title="Confirmar Exclusão"
        message="Tem certeza que deseja excluir esta categoria? Esta ação não pode ser desfeita."
        :action="route('admin.categorias.destroy', $category)"
        :itemName="$category->nome"
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
