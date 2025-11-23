@extends('layouts.app')

@section('title', $livro->titulo)

@section('content')
<div style="margin-bottom: 24px;">
    <x-ui.button
        href="{{ route('livros.index') }}"
        variant="secondary"
        icon="arrow-left"
        class="padding: 10px 20px; font-size: 14px;"
    >
        Voltar ao Catálogo
    </x-ui.button>
</div>

<div style="display: grid; grid-template-columns: 1fr; gap: 32px; @media (min-width: 1024px) { grid-template-columns: 1fr 2fr; }">
    <!-- Sidebar com Imagem e Ações -->
    <div>
        <div style="background: white; border-radius: 20px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); margin-bottom: 24px;">
            @if($livro->imagem_capa)
                <img src="{{ $livro->imagem_capa }}" alt="{{ $livro->titulo }}" style="width: 100%; border-radius: 16px; margin-bottom: 20px; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.2);">
            @else
                <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 16px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <i data-lucide="book-open" style="width: 80px; height: 80px; color: #8b5cf6;"></i>
                </div>
            @endif

            <div style="text-align: center;">
                @if($livro->isAvailable())
                    <span style="display: inline-block; padding: 10px 20px; background: linear-gradient(135deg, #dcfce7, #f0fdf4); color: #166534; border-radius: 12px; font-size: 14px; font-weight: 700; border: 3px solid #86efac; margin-bottom: 20px;">
                        Disponível
                    </span>
                @else
                    <span style="display: inline-block; padding: 10px 20px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border-radius: 12px; font-size: 14px; font-weight: 700; border: 3px solid #fca5a5; margin-bottom: 20px;">
                        Indisponível
                    </span>
                @endif

                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @if($livro->isAvailable())
                        <form method="POST" action="{{ route('alugueis.store', $livro) }}" style="width: 100%; margin: 0;">
                            @csrf
                            <x-ui.button type="submit" variant="primary" icon="hand" class="width: 100%; padding: 14px 24px; font-size: 16px;">
                                Alugar Livro
                            </x-ui.button>
                        </form>
                    @endif
                    
                    <form method="POST" action="{{ route('reservas.store', $livro) }}" style="width: 100%; margin: 0;">
                        @csrf
                        <x-ui.button type="submit" variant="secondary" icon="clock" class="width: 100%; padding: 14px 24px; font-size: 16px;">
                            Reservar Livro
                        </x-ui.button>
                    </form>

                    <form method="POST" action="{{ route('lista-desejos.store', $livro) }}" style="width: 100%; margin: 0;">
                        @csrf
                        <x-ui.button type="submit" variant="outline" icon="heart" class="width: 100%; padding: 14px 24px; font-size: 16px; background: linear-gradient(135deg, #fff1f2, #fff7ed); color: #ec4899; border-color: #fbcfe8;">
                            Adicionar à Lista de Desejos
                        </x-ui.button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Informações Rápidas -->
        <div style="background: white; border-radius: 20px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);">
            <h4 style="font-size: 18px; font-weight: 900; color: #1f2937; margin-bottom: 20px;">Informações</h4>
            <div style="display: flex; flex-direction: column; gap: 16px;">
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">ISBN</label>
                    <p style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $livro->isbn ?? 'N/A' }}</p>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Editora</label>
                    <p style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $livro->editora ?? 'N/A' }}</p>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Ano</label>
                    <p style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $livro->ano_publicacao ?? 'N/A' }}</p>
                </div>
                <div>
                    <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Páginas</label>
                    <p style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $livro->paginas ?? 'N/A' }}</p>
                </div>
                @if($livro->preco)
                    <div>
                        <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Preço</label>
                        <p style="font-size: 20px; color: #8b5cf6; font-weight: 900;">R$ {{ number_format($livro->preco, 2, ',', '.') }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Conteúdo Principal -->
    <div>
        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); margin-bottom: 24px;">
            <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 12px; line-height: 1.2;">{{ $livro->titulo }}</h1>
            
            <div style="display: flex; flex-wrap: wrap; gap: 16px; margin-bottom: 24px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="user" style="width: 18px; height: 18px; color: #8b5cf6;"></i>
                    <span style="font-size: 16px; color: #4b5563; font-weight: 600;">{{ $livro->author?->nome ?? 'Autor desconhecido' }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <i data-lucide="tag" style="width: 18px; height: 18px; color: #ec4899;"></i>
                    <span style="font-size: 16px; color: #4b5563; font-weight: 600;">{{ $livro->category->nome }}</span>
                </div>
                @if($averageRating > 0)
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i data-lucide="star" style="width: 18px; height: 18px; color: #f97316; fill: #f97316;"></i>
                        <span style="font-size: 16px; color: #4b5563; font-weight: 600;">{{ number_format($averageRating, 1) }} ({{ $reviewsCount }} avaliações)</span>
                    </div>
                @endif
            </div>

            <div style="margin-bottom: 32px;">
                <h3 style="font-size: 20px; font-weight: 900; color: #1f2937; margin-bottom: 16px;">Descrição</h3>
                <p style="font-size: 16px; color: #4b5563; line-height: 1.7; font-weight: 500;">{{ $livro->descricao ?? 'Sem descrição disponível.' }}</p>
            </div>

            @if($livro->tags->count() > 0)
                <div style="margin-bottom: 32px;">
                    <h3 style="font-size: 20px; font-weight: 900; color: #1f2937; margin-bottom: 16px;">Tags</h3>
                    <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                        @foreach($livro->tags as $tag)
                            <span style="display: inline-block; padding: 8px 16px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); color: #0369a1; border-radius: 10px; font-size: 14px; font-weight: 700; border: 2px solid #bae6fd;">
                                {{ $tag->nome }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Avaliação do Usuário ou Formulário de Nova Avaliação -->
        @auth
            @if($userReview)
                <x-reviews.user-review-section :review="$userReview" />
            @else
                <!-- Formulário de Nova Avaliação -->
                <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); margin-bottom: 24px;">
                    <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 24px;">Avaliar este Livro</h3>
                    <x-reviews.review-form 
                        :action="route('avaliacoes.store', $livro)"
                        method="POST"
                    />
                </div>
            @endif
        @endauth

        <!-- Outras Avaliações -->
        @php
            $otherReviews = $livro->reviews->filter(function($review) use ($userReview) {
                return !$userReview || $review->id !== $userReview->id;
            })->take(5);
        @endphp
        @if($otherReviews->count() > 0)
            <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);">
                <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 24px;">Outras Avaliações ({{ $otherReviews->count() }})</h3>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    @foreach($otherReviews as $review)
                        @php
                            $wasEdited = $review->created_at->ne($review->updated_at);
                        @endphp
                        <div style="padding: 20px; background: linear-gradient(135deg, #faf5ff, #f3e8ff); border-radius: 16px; border: 2px solid #e9d5ff;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                                <p style="font-size: 16px; font-weight: 900; color: #1f2937; margin: 0;">{{ $review->user->name }}</p>
                                <span style="font-size: 12px; color: #6b7280;">{{ $review->created_at->format('d/m/Y') }}</span>
                                @if($wasEdited)
                                    <span style="font-size: 11px; color: #0ea5e9; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                                        <i data-lucide="edit-2" style="width: 12px; height: 12px;"></i>
                                        Editado
                                    </span>
                                @endif
                            </div>
                            <div style="display: flex; gap: 4px; margin-bottom: 12px;">
                                @for($i = 1; $i <= 5; $i++)
                                    <i data-lucide="star" style="width: 16px; height: 16px; color: {{ $i <= $review->nota ? '#f97316' : '#d1d5db' }}; {{ $i <= $review->nota ? 'fill: #f97316;' : '' }}"></i>
                                @endfor
                            </div>
                            @if($review->comentario)
                                <p style="font-size: 14px; color: #4b5563; line-height: 1.6; margin: 0;">{{ $review->comentario }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>


<script>
    function openDeleteModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            const alpineData = Alpine.$data(modal.querySelector('[x-data]'));
            if (alpineData) {
                alpineData.open = true;
            }
        }
    }
</script>

<script>
    // Inicializar com o valor antigo (após validação) ou o valor da avaliação existente
    let selectedRating = {{ old('nota', $userReview?->nota ?? 0) }};

    // Funções para formulário de edição (suporta múltiplas avaliações)
    let selectedRatingsEdit = {};

    // Inicializar estrelas quando a página carregar
    document.addEventListener('DOMContentLoaded', function() {
        // Função para garantir que Lucide está inicializado
        function ensureLucideInitialized() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
                
                // Aguardar um pouco mais para garantir que os SVGs foram renderizados
                setTimeout(() => {
                    if (selectedRating > 0) {
                        updateStars(selectedRating);
                    }
                    // Inicializar ratings de edição para cada avaliação do usuário
                    @if($userReview)
                        selectedRatingsEdit[{{ $userReview->id }}] = {{ $userReview->nota }};
                        updateStarsEdit({{ $userReview->nota }}, {{ $userReview->id }});
                    @endif
                }, 300);
            } else {
                // Se Lucide ainda não carregou, tentar novamente
                setTimeout(ensureLucideInitialized, 100);
            }
        }
        
        ensureLucideInitialized();
    });

    // Funções para formulário de nova avaliação
    function updateStars(rating) {
        selectedRating = rating;
        for (let i = 1; i <= 5; i++) {
            const starElement = document.getElementById('star-' + i);
            if (starElement) {
                // Encontrar o SVG renderizado pelo Lucide
                const svg = starElement.querySelector('svg') || (starElement.nextElementSibling?.tagName === 'svg' ? starElement.nextElementSibling : null);
                const target = svg || starElement;
                
                if (i <= rating) {
                    target.style.color = '#f97316';
                    target.style.fill = '#f97316';
                    if (target.setAttribute) {
                        target.setAttribute('fill', '#f97316');
                    }
                } else {
                    target.style.color = '#d1d5db';
                    target.style.fill = 'none';
                    if (target.setAttribute) {
                        target.setAttribute('fill', 'none');
                    }
                }
            }
        }
    }

    function hoverStar(rating) {
        for (let i = 1; i <= 5; i++) {
            const starElement = document.getElementById('star-' + i);
            if (starElement) {
                const svg = starElement.querySelector('svg') || (starElement.nextElementSibling?.tagName === 'svg' ? starElement.nextElementSibling : null);
                const target = svg || starElement;
                
                if (i <= rating) {
                    target.style.color = '#f97316';
                    target.style.fill = '#f97316';
                    if (target.setAttribute) {
                        target.setAttribute('fill', '#f97316');
                    }
                } else {
                    target.style.color = '#d1d5db';
                    target.style.fill = 'none';
                    if (target.setAttribute) {
                        target.setAttribute('fill', 'none');
                    }
                }
            }
        }
    }

    function resetStars() {
        updateStars(selectedRating);
    }

    // Funções para formulário de edição (suporta múltiplas avaliações)
    function updateStarsEdit(rating, reviewId) {
        selectedRatingsEdit[reviewId] = rating;
        for (let i = 1; i <= 5; i++) {
            const starElement = document.getElementById('star-edit-' + reviewId + '-' + i);
            if (starElement) {
                const svg = starElement.querySelector('svg') || (starElement.nextElementSibling?.tagName === 'svg' ? starElement.nextElementSibling : null);
                const target = svg || starElement;
                
                if (i <= rating) {
                    target.style.color = '#f97316';
                    target.style.fill = '#f97316';
                    if (target.setAttribute) {
                        target.setAttribute('fill', '#f97316');
                    }
                } else {
                    target.style.color = '#d1d5db';
                    target.style.fill = 'none';
                    if (target.setAttribute) {
                        target.setAttribute('fill', 'none');
                    }
                }
            }
        }
    }

    function hoverStarEdit(rating, reviewId) {
        for (let i = 1; i <= 5; i++) {
            const starElement = document.getElementById('star-edit-' + reviewId + '-' + i);
            if (starElement) {
                const svg = starElement.querySelector('svg') || (starElement.nextElementSibling?.tagName === 'svg' ? starElement.nextElementSibling : null);
                const target = svg || starElement;
                
                if (i <= rating) {
                    target.style.color = '#f97316';
                    target.style.fill = '#f97316';
                    if (target.setAttribute) {
                        target.setAttribute('fill', '#f97316');
                    }
                } else {
                    target.style.color = '#d1d5db';
                    target.style.fill = 'none';
                    if (target.setAttribute) {
                        target.setAttribute('fill', 'none');
                    }
                }
            }
        }
    }

    function resetStarsEdit(reviewId) {
        if (selectedRatingsEdit[reviewId]) {
            updateStarsEdit(selectedRatingsEdit[reviewId], reviewId);
        }
    }
</script>
@endsection

