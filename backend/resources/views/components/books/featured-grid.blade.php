@props([
    'books' => collect(),
    'title' => 'Livros em Destaque',
    'icon' => 'star',
    'iconColor' => '#8b5cf6',
    'emptyMessage' => 'Nenhum livro disponível no momento.',
    'viewRoute' => 'livros.show',
    'indexRoute' => 'livros.index',
    'layout' => 'grid', // 'grid' ou 'list'
])

<div style="background: linear-gradient(135deg, #f3e8ff, #faf5ff, white); border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(139, 92, 246, 0.15); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
    <div style="position: relative; z-index: 1;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; display: flex; align-items: center; gap: 12px; margin: 0;">
            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, {{ $iconColor }}, #ec4899); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="{{ $icon }}" style="width: 20px; height: 20px; color: white;"></i>
            </div>
            {{ $title }}
        </h3>
        @if($books->count() > 0)
            <a href="{{ route($indexRoute) }}" style="display: inline-flex; align-items: center; padding: 8px 16px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 10px; font-size: 14px; font-weight: 700; text-decoration: none; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 6px 20px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(139, 92, 246, 0.3)';">
                Explorar Catálogo
                <i data-lucide="arrow-right" style="width: 16px; height: 16px; margin-left: 6px;"></i>
            </a>
        @endif
    </div>

    @if($books->count() > 0)
        @if($layout === 'grid')
            <!-- Layout Grid (padrão para usuário) -->
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; max-height: 500px; overflow-y: auto; padding-right: 8px;">
                @foreach($books as $book)
                    <a href="{{ route($viewRoute, $book) }}" style="text-decoration: none; display: block;">
                        <div style="background: linear-gradient(135deg, #f3e8ff, #faf5ff); border-radius: 16px; padding: 16px; border: 2px solid #e9d5ff; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.1); transition: all 0.3s; min-height: 220px; display: flex; flex-direction: column;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 25px rgba(139, 92, 246, 0.2)'; this.style.borderColor='{{ $iconColor }}';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(139, 92, 246, 0.1)'; this.style.borderColor='#e9d5ff';">
                            <div style="width: 100%; height: 120px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 12px; margin-bottom: 12px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                @if($book->imagem_capa)
                                    <img src="{{ str_starts_with($book->imagem_capa, 'http') ? $book->imagem_capa : asset('storage/'.$book->imagem_capa) }}" alt="{{ $book->titulo }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i data-lucide="book-open" style="width: 48px; height: 48px; color: {{ $iconColor }};"></i>
                                @endif
                            </div>
                            <h4 style="font-size: 14px; font-weight: 900; color: #1f2937; margin-bottom: 6px; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">{{ $book->titulo }}</h4>
                            <p style="font-size: 12px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">{{ $book->author?->nome ?? 'Autor desconhecido' }}</p>
                            <p style="font-size: 11px; color: #9ca3af;">{{ $book->category->nome ?? 'Sem categoria' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <!-- Layout List (padrão para admin) -->
            <div style="display: flex; flex-direction: column; gap: 16px;">
                @foreach($books as $book)
                    <a href="{{ route($viewRoute, $book) }}" style="display: flex; align-items: center; gap: 16px; padding: 16px; background: linear-gradient(135deg, #faf5ff, #f3e8ff); border: 2px solid #e9d5ff; border-radius: 12px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #f3e8ff, #e9d5ff)'; this.style.borderColor='{{ $iconColor }}'; this.style.transform='translateX(4px)';" onmouseout="this.style.background='linear-gradient(135deg, #faf5ff, #f3e8ff)'; this.style.borderColor='#e9d5ff'; this.style.transform='translateX(0)';">
                        <div style="width: 60px; height: 80px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; overflow: hidden;">
                            @if($book->imagem_capa)
                                <img src="{{ str_starts_with($book->imagem_capa, 'http') ? $book->imagem_capa : asset('storage/'.$book->imagem_capa) }}" alt="{{ $book->titulo }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                            @else
                                <i data-lucide="book-open" style="width: 30px; height: 30px; color: {{ $iconColor }};"></i>
                            @endif
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="font-size: 16px; font-weight: 900; color: #1f2937; margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $book->titulo }}</h4>
                            <p style="font-size: 14px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">{{ $book->author?->nome ?? 'Autor desconhecido' }}</p>
                            <p style="font-size: 12px; color: #9ca3af;">{{ $book->category->nome ?? 'Sem categoria' }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    @else
        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 0;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i data-lucide="book-open" style="width: 40px; height: 40px; color: {{ $iconColor }};"></i>
            </div>
            <p style="font-size: 16px; color: #6b7280; text-align: center; margin-bottom: 24px; font-weight: 500;">{{ $emptyMessage }}</p>
            <a href="{{ route($indexRoute) }}" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-weight: 700; text-decoration: none; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
                <span>Explorar Catálogo</span>
                <i data-lucide="arrow-right" style="width: 18px; height: 18px; margin-left: 8px;"></i>
            </a>
        </div>
    @endif
    </div>
</div>

