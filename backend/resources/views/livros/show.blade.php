@extends('layouts.app')

@section('title', $livro->titulo)

@section('content')
<div style="margin-bottom: 24px;">
    <a href="{{ route('livros.index') }}" style="display: inline-flex; align-items: center; color: #6b7280; font-weight: 600; text-decoration: none; margin-bottom: 16px; transition: color 0.3s;" onmouseover="this.style.color='#8b5cf6';" onmouseout="this.style.color='#6b7280';">
        <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
        Voltar ao Catálogo
    </a>
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
                        <form method="POST" action="{{ route('alugueis.store', $livro) }}" style="width: 100%;">
                            @csrf
                            <button type="submit" style="width: 100%; padding: 14px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-size: 16px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
                                <i data-lucide="hand" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i>
                                Alugar Livro
                            </button>
                        </form>
                    @endif
                    
                    <form method="POST" action="{{ route('reservas.store', $livro) }}" style="width: 100%;">
                        @csrf
                        <button type="submit" style="width: 100%; padding: 14px 24px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff';">
                            <i data-lucide="clock" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i>
                            Reservar Livro
                        </button>
                    </form>

                    <form method="POST" action="{{ route('lista-desejos.store', $livro) }}" style="width: 100%;">
                        @csrf
                        <button type="submit" style="width: 100%; padding: 14px 24px; background: linear-gradient(135deg, #fff1f2, #fff7ed); color: #ec4899; border: 3px solid #fbcfe8; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #ec4899, #f472b6)'; this.style.color='white'; this.style.borderColor='#ec4899';" onmouseout="this.style.background='linear-gradient(135deg, #fff1f2, #fff7ed)'; this.style.color='#ec4899'; this.style.borderColor='#fbcfe8';">
                            <i data-lucide="heart" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i>
                            Adicionar à Lista de Desejos
                        </button>
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
                    <span style="font-size: 16px; color: #4b5563; font-weight: 600;">{{ $livro->author->nome }}</span>
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

        <!-- Formulário de Nova Avaliação -->
        @auth
            @if(!$userReview)
                <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); margin-bottom: 24px;">
                    <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 24px;">Avaliar este Livro</h3>
                    
                    <form method="POST" action="{{ route('avaliacoes.store', $livro) }}">
                        @csrf

                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 12px;">Sua Nota *</label>
                                <div style="display: flex; gap: 8px; align-items: center;">
                                    @for($i = 1; $i <= 5; $i++)
                                        <label style="cursor: pointer;">
                                            <input type="radio" name="nota" value="{{ $i }}" {{ old('nota') == $i ? 'checked' : '' }} required style="display: none;" onchange="updateStars({{ $i }})">
                                            <i data-lucide="star" id="star-{{ $i }}" style="width: 32px; height: 32px; color: {{ old('nota') >= $i ? '#f97316' : '#d1d5db' }}; {{ old('nota') >= $i ? 'fill: #f97316;' : '' }}; transition: all 0.2s;" onmouseover="hoverStar({{ $i }})" onmouseout="resetStars()"></i>
                                        </label>
                                    @endfor
                                </div>
                                @error('nota')
                                    <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="comentario" style="display: block; font-size: 14px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Comentário (opcional)</label>
                                <textarea
                                    name="comentario"
                                    id="comentario"
                                    rows="4"
                                    style="width: 100%; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 14px; font-family: inherit; resize: vertical; transition: all 0.3s; @error('comentario') border-color: #ef4444; @enderror"
                                    onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                                    placeholder="Compartilhe sua opinião sobre este livro..."
                                >{{ old('comentario') }}</textarea>
                                @error('comentario')
                                    <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <button type="submit" style="width: 100%; padding: 14px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-size: 16px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
                                    <i data-lucide="star" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i>
                                    Enviar Avaliação
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            @endif
        @endauth

        <!-- Avaliações -->
        @if($livro->reviews->count() > 0)
            <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);">
                <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 24px;">Avaliações ({{ $reviewsCount }})</h3>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    @foreach($livro->reviews->take(5) as $review)
                        @php
                            $isUserReview = auth()->check() && $userReview && $review->id === $userReview->id;
                            $wasEdited = $review->created_at->ne($review->updated_at);
                        @endphp
                        <div style="padding: 20px; background: linear-gradient(135deg, #faf5ff, #f3e8ff); border-radius: 16px; border: 2px solid #e9d5ff;" x-data="{ editing: false }">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                                <div style="flex: 1;">
                                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 4px;">
                                        <p style="font-size: 16px; font-weight: 900; color: #1f2937; margin: 0;">{{ $review->user->name }}</p>
                                        <span style="font-size: 12px; color: #6b7280;">{{ $review->created_at->format('d/m/Y') }}</span>
                                        @if($wasEdited)
                                            <span style="font-size: 11px; color: #0ea5e9; font-weight: 600; display: flex; align-items: center; gap: 4px;">
                                                <i data-lucide="edit-2" style="width: 12px; height: 12px;"></i>
                                                Editado
                                            </span>
                                        @endif
                                    </div>
                                    <div style="display: flex; gap: 4px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i data-lucide="star" style="width: 16px; height: 16px; color: {{ $i <= $review->nota ? '#f97316' : '#d1d5db' }}; {{ $i <= $review->nota ? 'fill: #f97316;' : '' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                @if($isUserReview)
                                    <div style="display: flex; gap: 8px; margin-left: 16px;">
                                        <button @click="editing = true" style="padding: 8px; background: linear-gradient(135deg, #0ea5e9, #0284c7); color: white; border-radius: 8px; border: none; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;" title="Editar avaliação" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 4px 12px rgba(14, 165, 233, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
                                            <i data-lucide="edit" style="width: 16px; height: 16px;"></i>
                                        </button>
                                        <form method="POST" action="{{ route('avaliacoes.destroy', $review) }}" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja remover sua avaliação?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="padding: 8px; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border: none; border-radius: 8px; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center;" title="Remover avaliação" onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 4px 12px rgba(239, 68, 68, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='none';">
                                                <i data-lucide="trash-2" style="width: 16px; height: 16px;"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Modo Visualização -->
                            <div x-show="!editing">
                                @if($review->comentario)
                                    <p style="font-size: 14px; color: #4b5563; line-height: 1.6;">{{ $review->comentario }}</p>
                                @endif
                            </div>

                            <!-- Modo Edição -->
                            @if($isUserReview)
                                <div x-show="editing" x-cloak style="margin-top: 16px;">
                                    <form method="POST" action="{{ route('avaliacoes.update', $review) }}" @submit="editing = false">
                                        @csrf
                                        @method('PUT')

                                        <div style="display: flex; flex-direction: column; gap: 16px;">
                                            <div>
                                                <label style="display: block; font-size: 13px; font-weight: 600; color: #4b5563; margin-bottom: 8px;">Sua Nota *</label>
                                                <div style="display: flex; gap: 6px; align-items: center;">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <label style="cursor: pointer;">
                                                            <input type="radio" name="nota" value="{{ $i }}" {{ old('nota', $review->nota) == $i ? 'checked' : '' }} required style="display: none;" onchange="updateStarsEdit({{ $i }}, '{{ $review->id }}')">
                                                            <i data-lucide="star" id="star-edit-{{ $review->id }}-{{ $i }}" style="width: 24px; height: 24px; color: {{ old('nota', $review->nota) >= $i ? '#f97316' : '#d1d5db' }}; {{ old('nota', $review->nota) >= $i ? 'fill: #f97316;' : '' }}; transition: all 0.2s;" onmouseover="hoverStarEdit({{ $i }}, '{{ $review->id }}')" onmouseout="resetStarsEdit('{{ $review->id }}')"></i>
                                                        </label>
                                                    @endfor
                                                </div>
                                                @error('nota')
                                                    <p style="margin-top: 6px; font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div>
                                                <label for="comentario-edit-{{ $review->id }}" style="display: block; font-size: 13px; font-weight: 600; color: #4b5563; margin-bottom: 6px;">Comentário (opcional)</label>
                                                <textarea
                                                    name="comentario"
                                                    id="comentario-edit-{{ $review->id }}"
                                                    rows="3"
                                                    style="width: 100%; padding: 10px 12px; border: 2px solid #e5e7eb; border-radius: 10px; font-size: 13px; font-family: inherit; resize: vertical; transition: all 0.3s; @error('comentario') border-color: #ef4444; @enderror"
                                                    onfocus="this.style.borderColor='#8b5cf6'; this.style.boxShadow='0 0 0 3px rgba(139, 92, 246, 0.1)';"
                                                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';"
                                                    placeholder="Compartilhe sua opinião sobre este livro..."
                                                >{{ old('comentario', $review->comentario) }}</textarea>
                                                @error('comentario')
                                                    <p style="margin-top: 6px; font-size: 12px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div style="display: flex; gap: 8px;">
                                                <button type="submit" style="flex: 1; padding: 10px 16px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 10px; font-size: 13px; font-weight: 700; border: none; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.02)';" onmouseout="this.style.transform='scale(1)';">
                                                    <i data-lucide="check" style="width: 14px; height: 14px; display: inline-block; margin-right: 6px; vertical-align: middle;"></i>
                                                    Salvar
                                                </button>
                                                <button type="button" @click="editing = false" style="padding: 10px 16px; background: linear-gradient(135deg, #f3f4f6, #e5e7eb); color: #4b5563; border: 2px solid #d1d5db; border-radius: 10px; font-size: 13px; font-weight: 700; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #e5e7eb, #d1d5db)';" onmouseout="this.style.background='linear-gradient(135deg, #f3f4f6, #e5e7eb)';">
                                                    <i data-lucide="x" style="width: 14px; height: 14px; display: inline-block; margin-right: 6px; vertical-align: middle;"></i>
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

<script>
    // Inicializar com o valor antigo (após validação) ou o valor da avaliação existente
    let selectedRating = {{ old('nota', $userReview?->nota ?? 0) }};

    // Funções para formulário de edição (suporta múltiplas avaliações)
    let selectedRatingsEdit = {};

    // Inicializar estrelas quando a página carregar
    document.addEventListener('DOMContentLoaded', function() {
        if (selectedRating > 0) {
            updateStars(selectedRating);
        }
        // Inicializar ratings de edição para cada avaliação do usuário
        @if($userReview)
            selectedRatingsEdit['{{ $userReview->id }}'] = {{ $userReview->nota }};
            updateStarsEdit({{ $userReview->nota }}, '{{ $userReview->id }}');
        @endif
    });

    // Funções para formulário de nova avaliação
    function updateStars(rating) {
        selectedRating = rating;
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById('star-' + i);
            if (star) {
                if (i <= rating) {
                    star.style.color = '#f97316';
                    star.style.fill = '#f97316';
                } else {
                    star.style.color = '#d1d5db';
                    star.style.fill = 'none';
                }
            }
        }
    }

    function hoverStar(rating) {
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById('star-' + i);
            if (star) {
                if (i <= rating) {
                    star.style.color = '#f97316';
                    star.style.fill = '#f97316';
                } else {
                    star.style.color = '#d1d5db';
                    star.style.fill = 'none';
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
            const star = document.getElementById('star-edit-' + reviewId + '-' + i);
            if (star) {
                if (i <= rating) {
                    star.style.color = '#f97316';
                    star.style.fill = '#f97316';
                } else {
                    star.style.color = '#d1d5db';
                    star.style.fill = 'none';
                }
            }
        }
    }

    function hoverStarEdit(rating, reviewId) {
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById('star-edit-' + reviewId + '-' + i);
            if (star) {
                if (i <= rating) {
                    star.style.color = '#f97316';
                    star.style.fill = '#f97316';
                } else {
                    star.style.color = '#d1d5db';
                    star.style.fill = 'none';
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

