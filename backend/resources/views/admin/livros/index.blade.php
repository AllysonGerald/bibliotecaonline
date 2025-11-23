@extends('layouts.admin')

@section('title', 'Livros')

@section('content')

<x-ui.page-header 
    title="Gerenciar Livros" 
    subtitle="Gerencie o catálogo de livros"
>
    <x-ui.button href="{{ route('admin.dashboard') }}" variant="secondary" icon="arrow-left">Painel do Admin</x-ui.button>
    <x-ui.button href="{{ route('admin.livros.create') }}" variant="primary" icon="plus">Novo Livro</x-ui.button>
</x-ui.page-header>

<!-- Filtros - Cor Laranja para Livros -->
<x-forms.filter-form 
    :action="route('admin.livros.index')"
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
        placeholder="Título, autor..."
        borderColor="#fed7aa"
        focusColor="#f97316"
        backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
    />
    
    <x-forms.select
        name="categoria_id"
        label="Categoria"
        :options="['' => 'Todas'] + $categories->pluck('nome', 'id')->toArray()"
        :value="request('categoria_id')"
        borderColor="#fed7aa"
        focusColor="#f97316"
        backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
    />
    
    <x-forms.select
        name="autor_id"
        label="Autor"
        :options="['' => 'Todos'] + $authors->pluck('nome', 'id')->toArray()"
        :value="request('autor_id')"
        borderColor="#fed7aa"
        focusColor="#f97316"
        backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
    />
</x-forms.filter-form>

<!-- Tabela de Livros - Cor Laranja -->
@php
    $headers = [
        ['label' => 'Título', 'align' => 'left'],
        ['label' => 'Autor', 'align' => 'left'],
        ['label' => 'Categoria', 'align' => 'left'],
        ['label' => 'Status', 'align' => 'left'],
        ['label' => 'Quantidade', 'align' => 'left'],
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
    @forelse($books as $book)
        <x-table.row borderColor="#fff1f2" hoverColor="linear-gradient(135deg, #fff7ed, #fff1f2)">
            <td style="padding: 16px;">
                <div style="font-size: 15px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $book->titulo }}</div>
                @if($book->isbn)
                    <div style="font-size: 12px; color: #9ca3af; font-weight: 500;">ISBN: {{ $book->isbn }}</div>
                @endif
            </td>
            <td style="padding: 16px;">
                <div style="font-size: 14px; color: #4b5563; font-weight: 600;">{{ $book->author?->nome ?? 'Autor desconhecido' }}</div>
            </td>
            <td style="padding: 16px;">
                <div style="font-size: 14px; color: #4b5563; font-weight: 600;">{{ $book->category->nome }}</div>
            </td>
            <td style="padding: 16px;">
                @php
                    $statusVariants = [
                        'disponivel' => 'success',
                        'reservado' => 'warning',
                        'alugado' => 'danger',
                    ];
                    $statusVariant = $statusVariants[$book->status->value] ?? 'default';
                @endphp
                <x-ui.badge :variant="$statusVariant">
                    {{ $book->status->label() }}
                </x-ui.badge>
            </td>
            <td style="padding: 16px;">
                <div style="font-size: 14px; color: #4b5563; font-weight: 600;">{{ $book->quantidade ?? 'N/A' }}</div>
            </td>
            <td style="padding: 16px; text-align: right;">
                <x-table.action-buttons
                    :viewHref="route('admin.livros.show', $book)"
                    :editHref="route('admin.livros.edit', $book)"
                    :deleteModalId="'delete-book-' . $book->id"
                />
            </td>
        </x-table.row>
    @empty
        <tr>
            <td colspan="6" style="padding: 48px; text-align: center;">
                <x-ui.empty-state
                    icon="book-open"
                    message="Nenhum livro encontrado."
                />
            </td>
        </tr>
    @endforelse
</x-table.table>

@if($books->hasPages())
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
        {{ $books->links('components.pagination') }}
    </div>
@endif

<!-- Modais de Exclusão -->
@foreach($books as $book)
    <x-modals.delete-modal
        id="delete-book-{{ $book->id }}"
        title="Confirmar Exclusão"
        message="Tem certeza que deseja excluir este livro? Esta ação não pode ser desfeita."
        :action="route('admin.livros.destroy', $book)"
        :itemName="$book->titulo"
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
