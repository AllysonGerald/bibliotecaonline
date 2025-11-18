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
                        <button style="width: 100%; padding: 14px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-size: 16px; font-weight: 700; border: none; cursor: pointer; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.02)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
                            <i data-lucide="hand" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i>
                            Alugar Livro
                        </button>
                    @endif
                    
                    <button style="width: 100%; padding: 14px 24px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff';">
                        <i data-lucide="clock" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i>
                        Reservar Livro
                    </button>

                    <button style="width: 100%; padding: 14px 24px; background: linear-gradient(135deg, #fff1f2, #fff7ed); color: #ec4899; border: 3px solid #fbcfe8; border-radius: 12px; font-size: 16px; font-weight: 700; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #ec4899, #f472b6)'; this.style.color='white'; this.style.borderColor='#ec4899';" onmouseout="this.style.background='linear-gradient(135deg, #fff1f2, #fff7ed)'; this.style.color='#ec4899'; this.style.borderColor='#fbcfe8';">
                        <i data-lucide="heart" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i>
                        Adicionar à Lista de Desejos
                    </button>
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

        <!-- Avaliações -->
        @if($livro->reviews->count() > 0)
            <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);">
                <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 24px;">Avaliações ({{ $reviewsCount }})</h3>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    @foreach($livro->reviews->take(5) as $review)
                        <div style="padding: 20px; background: linear-gradient(135deg, #faf5ff, #f3e8ff); border-radius: 16px; border: 2px solid #e9d5ff;">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                                <div>
                                    <p style="font-size: 16px; font-weight: 900; color: #1f2937; margin-bottom: 4px;">{{ $review->user->name }}</p>
                                    <div style="display: flex; gap: 4px;">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i data-lucide="star" style="width: 16px; height: 16px; color: {{ $i <= $review->nota ? '#f97316' : '#d1d5db' }}; {{ $i <= $review->nota ? 'fill: #f97316;' : '' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <span style="font-size: 12px; color: #6b7280;">{{ $review->created_at->format('d/m/Y') }}</span>
                            </div>
                            @if($review->comentario)
                                <p style="font-size: 14px; color: #4b5563; line-height: 1.6;">{{ $review->comentario }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

