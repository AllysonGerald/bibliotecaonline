@extends('layouts.app')

@section('title', 'Lista de Desejos')

@section('content')
<x-ui.page-header
    title="Lista de Desejos"
    subtitle="Seus livros favoritos"
/>

<!-- Lista de Livros -->
@if($wishlists->count() > 0)
    <div style="display: flex; flex-direction: column; gap: 24px;">
        @foreach($wishlists as $wishlist)
            <div class="wishlist-card-hover" style="background: white; border-radius: 20px; padding: 24px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15); transition: all 0.3s; position: relative; overflow: hidden;">
                <!-- Decorative top bar -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 6px; background: linear-gradient(90deg, #ec4899, #f472b6);"></div>
                
                <!-- Decorative background -->
                <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(236, 72, 153, 0.08); border-radius: 50%; filter: blur(40px); z-index: 0;"></div>

                <div style="position: relative; z-index: 1; display: grid; grid-template-columns: 1fr; gap: 24px; @media (min-width: 768px) { grid-template-columns: 140px 1fr auto; }">
                    <!-- Imagem do Livro -->
                    <div style="width: 100%; height: 180px; background: linear-gradient(135deg, #fce7f3, #fdf2f8); border-radius: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 4px 12px rgba(236, 72, 153, 0.2); @media (min-width: 768px) { width: 140px; height: 180px; }">
                        @if($wishlist->book->imagem_capa)
                            <img src="{{ $wishlist->book->imagem_capa }}" alt="{{ $wishlist->book->titulo }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <x-ui.icon name="book-open" size="56" style="color: #ec4899;" />
                        @endif
                    </div>

                    <!-- Informações do Livro -->
                    <div style="flex: 1; display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 8px; line-height: 1.3;">{{ $wishlist->book->titulo }}</h3>
                            <p style="font-size: 16px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">{{ $wishlist->book->author?->nome ?? 'Autor desconhecido' }}</p>
                            <p style="font-size: 14px; color: #9ca3af; font-weight: 500; margin: 0;">{{ $wishlist->book->category->nome }}</p>
                        </div>

                        <!-- Informações do Livro -->
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; padding: 16px; background: linear-gradient(135deg, #fce7f3, #fdf2f8); border-radius: 12px; border: 2px solid #fbcfe8;">
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Categoria</label>
                                <p style="font-size: 15px; color: #1f2937; font-weight: 700; margin: 0;">{{ $wishlist->book->category->nome }}</p>
                            </div>
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Status</label>
                                <div style="margin-top: 4px;">
                                    @if($wishlist->book->isAvailable())
                                        <x-ui.badge variant="success">Disponível</x-ui.badge>
                                    @else
                                        <x-ui.badge variant="danger">Indisponível</x-ui.badge>
                                    @endif
                                </div>
                            </div>
                            @if($wishlist->book->isbn)
                                <div>
                                    <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">ISBN</label>
                                    <p style="font-size: 15px; color: #1f2937; font-weight: 700; margin: 0;">{{ $wishlist->book->isbn }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Ações -->
                    <div style="display: flex; flex-direction: column; gap: 12px; justify-content: center; @media (min-width: 768px) { align-items: flex-end; }">
                        <x-ui.button
                            href="{{ route('livros.show', $wishlist->book) }}"
                            variant="secondary"
                            icon="book-open"
                            class="padding: 12px 24px; font-size: 14px; font-weight: 700; white-space: nowrap; background: linear-gradient(135deg, #fce7f3, #fdf2f8); color: #ec4899; border-color: #fbcfe8; width: 100%; @media (min-width: 768px) { width: auto; }"
                        >
                            Ver Detalhes
                        </x-ui.button>
                        <form method="POST" action="{{ route('lista-desejos.destroy', $wishlist) }}" style="display: inline; width: 100%; @media (min-width: 768px) { width: auto; }" onsubmit="return confirm('Tem certeza que deseja remover este livro da lista de desejos?');">
                            @csrf
                            @method('DELETE')
                            <x-ui.button
                                type="submit"
                                variant="danger"
                                icon="heart-off"
                                class="padding: 12px 24px; font-size: 14px; font-weight: 700; white-space: nowrap; width: 100%; @media (min-width: 768px) { width: auto; }"
                            >
                                Remover
                            </x-ui.button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <style>
        .wishlist-card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(236, 72, 153, 0.25) !important;
            border-color: #ec4899 !important;
        }
    </style>
@else
    <x-ui.card
        class="text-align: center;"
        borderColor="#fbcfe8"
        shadowColor="rgba(236, 72, 153, 0.15)"
        backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
    >
        <x-ui.empty-state
            title="Sua lista de desejos está vazia"
            message="Adicione livros que você deseja ler à sua lista de desejos."
            icon="heart"
            iconColor="#ec4899"
            backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8)"
        />
        <div style="margin-top: 24px;">
            <x-ui.button
                href="{{ route('livros.index') }}"
                variant="primary"
                icon="arrow-right"
            >
                Explorar Catálogo
            </x-ui.button>
        </div>
    </x-ui.card>
@endif
@endsection
