@extends('layouts.app')

@section('title', 'Catálogo de Livros')

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Catálogo de Livros</h1>
    <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Explore nossa coleção completa de livros</p>
</div>

<!-- Filtros -->
<div style="background: white; border-radius: 20px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); margin-bottom: 32px;">
    <form method="GET" action="{{ route('livros.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <div>
            <label for="search" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Buscar</label>
            <input
                type="text"
                name="search"
                id="search"
                value="{{ request('search') }}"
                placeholder="Título, autor..."
                style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; transition: all 0.3s;"
                onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
            >
        </div>
        <div>
            <label for="categoria_id" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Categoria</label>
            <select
                name="categoria_id"
                id="categoria_id"
                style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; background: white; transition: all 0.3s;"
                onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
            >
                <option value="">Todas</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ request('categoria_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->nome }}
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="autor_id" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Autor</label>
            <select
                name="autor_id"
                id="autor_id"
                style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; background: white; transition: all 0.3s;"
                onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
            >
                <option value="">Todos</option>
                @foreach($authors as $author)
                    <option value="{{ $author->id }}" {{ request('autor_id') == $author->id ? 'selected' : '' }}>
                        {{ $author->nome }}
                    </option>
                @endforeach
            </select>
        </div>
        <div style="display: flex; align-items: flex-end;">
            <button type="submit" style="width: 100%; padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
                <i data-lucide="search" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i>
                Buscar
            </button>
        </div>
    </form>
</div>

<!-- Grid de Livros -->
@if($books->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px; margin-bottom: 32px; align-items: stretch;">
        @foreach($books as $book)
            <div style="background: white; border-radius: 20px; padding: 20px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); transition: all 0.3s; position: relative; overflow: hidden; display: flex; flex-direction: column; height: 100%;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(139, 92, 246, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(139, 92, 246, 0.15)';">
                <!-- Decorative background -->
                <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(139, 92, 246, 0.1); border-radius: 50%; filter: blur(40px); z-index: 0;"></div>
                
                <div style="position: relative; z-index: 1; display: flex; flex-direction: column; height: 100%;">
                    <!-- Imagem do Livro -->
                    <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 16px; margin-bottom: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
                        @if($book->imagem_capa)
                            <img src="{{ $book->imagem_capa }}" alt="{{ $book->titulo }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i data-lucide="book-open" style="width: 64px; height: 64px; color: #8b5cf6;"></i>
                        @endif
                    </div>

                    <!-- Informações do Livro -->
                    <div style="margin-bottom: 12px; flex: 1;">
                        <h3 style="font-size: 18px; font-weight: 900; color: #1f2937; margin-bottom: 8px; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; min-height: 50px;">{{ $book->titulo }}</h3>
                        <p style="font-size: 14px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">{{ $book->author->nome }}</p>
                        <p style="font-size: 12px; color: #9ca3af;">{{ $book->category->nome }}</p>
                    </div>

                    <!-- Status e Ações -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 16px; border-top: 2px solid #f3e8ff; flex-shrink: 0;">
                        <div>
                            @if($book->isAvailable())
                                <span style="display: inline-block; padding: 6px 12px; background: linear-gradient(135deg, #dcfce7, #f0fdf4); color: #166534; border-radius: 8px; font-size: 12px; font-weight: 700; border: 2px solid #86efac;">
                                    Disponível
                                </span>
                            @else
                                <span style="display: inline-block; padding: 6px 12px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border-radius: 8px; font-size: 12px; font-weight: 700; border: 2px solid #fca5a5;">
                                    Indisponível
                                </span>
                            @endif
                        </div>
                        <a href="{{ route('livros.show', $book) }}" style="display: inline-flex; align-items: center; padding: 8px 16px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 10px; font-size: 14px; font-weight: 700; text-decoration: none; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 6px 20px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(139, 92, 246, 0.3)';">
                            Ver Detalhes
                            <i data-lucide="arrow-right" style="width: 16px; height: 16px; margin-left: 6px;"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Paginação -->
    @if($books->hasPages())
        <div style="display: flex; justify-content: center; margin-top: 32px;">
            {{ $books->links('components.pagination') }}
        </div>
    @endif
@else
    <div style="background: white; border-radius: 20px; padding: 64px 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); text-align: center;">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <i data-lucide="book-open" style="width: 40px; height: 40px; color: #8b5cf6;"></i>
        </div>
        <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 12px;">Nenhum livro encontrado</h3>
        <p style="font-size: 16px; color: #6b7280; font-weight: 500;">Tente ajustar os filtros de busca.</p>
    </div>
@endif
@endsection

