@extends('layouts.app')

@section('title', 'Lista de Desejos')

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Lista de Desejos</h1>
    <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Seus livros favoritos</p>
</div>

<!-- Lista de Livros -->
@if($wishlists->count() > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
        @foreach($wishlists as $wishlist)
            <div style="background: white; border-radius: 20px; padding: 20px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); transition: all 0.3s; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-8px)'; this.style.boxShadow='0 15px 40px rgba(139, 92, 246, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(139, 92, 246, 0.15)';">
                <!-- Decorative background -->
                <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(139, 92, 246, 0.1); border-radius: 50%; filter: blur(40px); z-index: 0;"></div>
                
                <div style="position: relative; z-index: 1;">
                    <!-- Imagem do Livro -->
                    <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 16px; margin-bottom: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                        @if($wishlist->book->imagem_capa)
                            <img src="{{ $wishlist->book->imagem_capa }}" alt="{{ $wishlist->book->titulo }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i data-lucide="book-open" style="width: 64px; height: 64px; color: #8b5cf6;"></i>
                        @endif
                    </div>

                    <!-- Informações do Livro -->
                    <div style="margin-bottom: 12px;">
                        <h3 style="font-size: 18px; font-weight: 900; color: #1f2937; margin-bottom: 8px; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $wishlist->book->titulo }}</h3>
                        <p style="font-size: 14px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">{{ $wishlist->book->author?->nome ?? 'Autor desconhecido' }}</p>
                        <p style="font-size: 12px; color: #9ca3af;">{{ $wishlist->book->category->nome }}</p>
                    </div>

                    <!-- Status e Ações -->
                    <div style="display: flex; flex-direction: column; gap: 12px; margin-top: 16px; padding-top: 16px; border-top: 2px solid #f3e8ff;">
                        <div>
                            @if($wishlist->book->isAvailable())
                                <span style="display: inline-block; padding: 6px 12px; background: linear-gradient(135deg, #dcfce7, #f0fdf4); color: #166534; border-radius: 8px; font-size: 12px; font-weight: 700; border: 2px solid #86efac;">
                                    Disponível
                                </span>
                            @else
                                <span style="display: inline-block; padding: 6px 12px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border-radius: 8px; font-size: 12px; font-weight: 700; border: 2px solid #fca5a5;">
                                    Indisponível
                                </span>
                            @endif
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('livros.show', $wishlist->book) }}" style="flex: 1; display: inline-flex; align-items: center; justify-content: center; padding: 10px 16px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 10px; font-size: 14px; font-weight: 700; text-decoration: none; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 6px 20px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(139, 92, 246, 0.3)';">
                                Ver Detalhes
                            </a>
                            <form method="POST" action="{{ route('lista-desejos.destroy', $wishlist) }}" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja remover este livro da lista de desejos?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="display: inline-flex; align-items: center; justify-content: center; padding: 10px 16px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border: 2px solid #fca5a5; border-radius: 10px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #ef4444, #dc2626)'; this.style.color='white'; this.style.borderColor='#ef4444';" onmouseout="this.style.background='linear-gradient(135deg, #fee2e2, #fef2f2)'; this.style.color='#991b1b'; this.style.borderColor='#fca5a5';">
                                    <i data-lucide="heart-off" style="width: 18px; height: 18px;"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div style="background: white; border-radius: 20px; padding: 64px 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); text-align: center;">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <i data-lucide="heart" style="width: 40px; height: 40px; color: #8b5cf6;"></i>
        </div>
        <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 12px;">Sua lista de desejos está vazia</h3>
        <p style="font-size: 16px; color: #6b7280; font-weight: 500; margin-bottom: 24px;">
            Adicione livros que você deseja ler à sua lista de desejos.
        </p>
        <a href="{{ route('livros.index') }}" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-weight: 700; text-decoration: none; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
            <span>Explorar Catálogo</span>
            <i data-lucide="arrow-right" style="width: 18px; height: 18px; margin-left: 8px;"></i>
        </a>
    </div>
@endif
@endsection

