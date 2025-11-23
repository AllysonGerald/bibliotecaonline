@extends('layouts.app')

@section('title', 'Catálogo de Livros')

@section('content')

<x-ui.page-header
    title="Catálogo de Livros"
    subtitle="Explore nossa coleção completa de livros"
/>

<!-- Filtros -->
<x-forms.filter-form
    :action="route('livros.index')"
    title="Filtros"
    icon="filter"
    iconColor="#8b5cf6"
    borderColor="#e9d5ff"
    shadowColor="rgba(139, 92, 246, 0.15)"
    backgroundGradient="white"
    buttonVariant="primary"
>
    <x-forms.input
        type="text"
        name="search"
        label="Buscar"
        :value="request('search')"
        placeholder="Título, autor..."
        borderColor="#e5e7eb"
        focusColor="#8b5cf6"
        backgroundGradient="white"
    />
    
    <x-forms.select
        name="categoria_id"
        label="Categoria"
        :options="['' => 'Todas'] + $categories->pluck('nome', 'id')->toArray()"
        :value="request('categoria_id')"
        borderColor="#e5e7eb"
        focusColor="#8b5cf6"
        backgroundGradient="white"
    />
    
    <x-forms.select
        name="autor_id"
        label="Autor"
        :options="['' => 'Todos'] + $authors->pluck('nome', 'id')->toArray()"
        :value="request('autor_id')"
        borderColor="#e5e7eb"
        focusColor="#8b5cf6"
        backgroundGradient="white"
    />
</x-forms.filter-form>

<!-- Grid de Livros -->
@if($books->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; margin-bottom: 32px; align-items: stretch;">
        @foreach($books as $book)
            <x-books.book-card
                :book="$book"
                showRoute="livros.show"
            />
        @endforeach
    </div>

    <!-- Paginação -->
    @if($books->hasPages())
        <x-ui.card
            borderColor="#e9d5ff"
            shadowColor="rgba(139, 92, 246, 0.15)"
            backgroundGradient="white"
        >
            @php
                view()->share([
                    'pagination_primaryColor' => '#8b5cf6',
                    'pagination_primaryColorLight' => '#a855f7',
                    'pagination_borderColor' => '#e9d5ff',
                    'pagination_backgroundGradient' => 'linear-gradient(135deg, #f3e8ff, #faf5ff)',
                    'pagination_backgroundGradientHover' => 'linear-gradient(135deg, #8b5cf6, #a855f7)',
                ]);
            @endphp
            {{ $books->links('components.pagination') }}
        </x-ui.card>
    @endif
@else
    <x-ui.empty-state
        icon="book-open"
        title="Nenhum livro encontrado"
        message="Tente ajustar os filtros de busca."
        iconColor="#8b5cf6"
        backgroundGradient="linear-gradient(135deg, #f3e8ff, #fce7f3)"
    />
@endif
@endsection

