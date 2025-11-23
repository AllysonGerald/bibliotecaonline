@props([
    'book',
    'showRoute' => 'livros.show',
    'borderColor' => '#e9d5ff',
    'shadowColor' => 'rgba(139, 92, 246, 0.15)',
    'backgroundGradient' => 'white',
    'hoverShadowColor' => 'rgba(139, 92, 246, 0.25)',
])

<div class="book-card-hover"
     data-shadow-color="{{ $shadowColor }}"
     data-hover-shadow-color="{{ $hoverShadowColor }}"
     style="background: {{ $backgroundGradient }}; border-radius: 20px; padding: 20px 20px 24px 20px; border: 3px solid {{ $borderColor }}; box-shadow: 0 10px 30px {{ $shadowColor }}; transition: all 0.3s; position: relative; overflow: hidden; display: flex; flex-direction: column; min-height: 100%;">
    <!-- Decorative background -->
    <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(139, 92, 246, 0.1); border-radius: 50%; filter: blur(40px); z-index: 0; pointer-events: none;"></div>
    
    <div style="position: relative; z-index: 1; display: flex; flex-direction: column; flex: 1; min-height: 0;">
        <!-- Imagem do Livro -->
        <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 16px; margin-bottom: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; flex-shrink: 0;">
            @if($book->imagem_capa)
                <img src="{{ $book->imagem_capa }}" alt="{{ $book->titulo }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                <x-ui.icon name="book-open" size="64" style="color: #8b5cf6;" />
            @endif
        </div>

        <!-- Informações do Livro -->
        <div style="margin-bottom: 0; flex: 1; display: flex; flex-direction: column; gap: 10px; min-height: 0; overflow: hidden;">
            <h3 style="font-size: 18px; font-weight: 900; color: #1f2937; margin: 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; word-break: break-word;">{{ $book->titulo }}</h3>
            <div style="display: flex; flex-direction: column; gap: 6px; flex-shrink: 0;">
                <p style="font-size: 14px; color: #6b7280; font-weight: 600; margin: 0; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis;">{{ $book->author?->nome ?? 'Autor desconhecido' }}</p>
                <p style="font-size: 12px; color: #9ca3af; margin: 0; line-height: 1.4;">{{ $book->category->nome }}</p>
            </div>
        </div>

        <!-- Status e Ações -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 24px; padding-top: 16px; border-top: 2px solid #f3e8ff; flex-shrink: 0; gap: 12px;">
            <div style="flex-shrink: 0;">
                @if($book->isAvailable())
                    <x-ui.badge variant="success">Disponível</x-ui.badge>
                @else
                    <x-ui.badge variant="danger">Indisponível</x-ui.badge>
                @endif
            </div>
            <x-ui.button
                href="{{ route($showRoute, $book) }}"
                variant="primary"
                icon="arrow-right"
                class="padding: 10px 16px; font-size: 13px; flex-shrink: 0; white-space: nowrap; min-width: fit-content;"
            >
                Ver Detalhes
            </x-ui.button>
        </div>
    </div>
</div>

<style>
    .book-card-hover:hover {
        transform: translateY(-8px);
    }
</style>

<script>
    (function() {
        const cards = document.querySelectorAll('.book-card-hover');
        cards.forEach(function(card) {
            const shadowColor = card.getAttribute('data-shadow-color');
            const hoverShadowColor = card.getAttribute('data-hover-shadow-color');
            card.addEventListener('mouseenter', function() {
                this.style.boxShadow = '0 15px 40px ' + hoverShadowColor;
            });
            card.addEventListener('mouseleave', function() {
                this.style.boxShadow = '0 10px 30px ' + shadowColor;
            });
        });
    })();
</script>

