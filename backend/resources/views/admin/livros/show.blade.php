@extends('layouts.admin')

@section('title', 'Detalhes do Livro')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #374151; margin-bottom: 8px;">Detalhes do Livro</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Visualize todas as informações do livro</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.livros.index') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Voltar
            </a>
            <a href="{{ route('admin.livros.edit', $livro) }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border: 3px solid #8b5cf6; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.3)';">
                <i data-lucide="edit" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Editar
            </a>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
    <!-- Informações do Livro -->
    <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(139, 92, 246, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
        <div style="position: relative; z-index: 1;">
            <h3 style="font-size: 28px; font-weight: 900; color: #374151; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i data-lucide="book-open" style="width: 24px; height: 24px; color: white;"></i>
                </div>
                {{ $livro->titulo }}
            </h3>
            
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Descrição</label>
                    <p style="font-size: 15px; color: #4b5563; line-height: 1.6;">{{ $livro->descricao }}</p>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Autor</label>
                        <p style="font-size: 16px; font-weight: 700; color: #374151;">{{ $livro->author->nome }}</p>
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Categoria</label>
                        <p style="font-size: 16px; font-weight: 700; color: #374151;">{{ $livro->category->nome }}</p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">ISBN</label>
                        <p style="font-size: 16px; color: #4b5563;">{{ $livro->isbn ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Editora</label>
                        <p style="font-size: 16px; color: #4b5563;">{{ $livro->editora ?? 'N/A' }}</p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Ano de Publicação</label>
                        <p style="font-size: 16px; color: #4b5563;">{{ $livro->ano_publicacao ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Páginas</label>
                        <p style="font-size: 16px; color: #4b5563;">{{ $livro->paginas ?? 'N/A' }}</p>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Preço</label>
                        <p style="font-size: 18px; font-weight: 900; color: #8b5cf6;">R$ {{ number_format($livro->preco, 2, ',', '.') }}</p>
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Quantidade</label>
                        <p style="font-size: 18px; font-weight: 900; color: #374151;">{{ $livro->quantidade ?? 'N/A' }}</p>
                    </div>
                </div>

                <div>
                    <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Status</label>
                    @php
                        $statusStyles = [
                            'disponivel' => 'background: linear-gradient(135deg, #dcfce7, #f0fdf4); color: #166534; border: 2px solid #86efac;',
                            'reservado' => 'background: linear-gradient(135deg, #fef3c7, #fffbeb); color: #92400e; border: 2px solid #fde047;',
                            'alugado' => 'background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border: 2px solid #fca5a5;',
                            'indisponivel' => 'background: linear-gradient(135deg, #f3f4f6, #ffffff); color: #6b7280; border: 2px solid #e5e7eb;',
                        ];
                        $statusStyle = $statusStyles[$livro->status->value] ?? 'background: linear-gradient(135deg, #f3f4f6, #ffffff); color: #6b7280; border: 2px solid #e5e7eb;';
                    @endphp
                    <span style="display: inline-block; padding: 8px 16px; border-radius: 10px; font-size: 14px; font-weight: 700; {{ $statusStyle }}">
                        {{ $livro->status->label() }}
                    </span>
                </div>

                @if($livro->tags->count() > 0)
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 12px; text-transform: uppercase; letter-spacing: 0.5px;">Tags</label>
                        <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                            @foreach($livro->tags as $tag)
                                <span style="display: inline-block; padding: 8px 16px; background: linear-gradient(135deg, #e0f2fe, #f0f9ff); color: #0ea5e9; border: 2px solid #bae6fd; border-radius: 10px; font-size: 13px; font-weight: 700;">
                                    {{ $tag->nome }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Imagem e Informações Adicionais -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Imagem da Capa -->
        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(236, 72, 153, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
            <div style="position: relative; z-index: 1;">
                <h3 style="font-size: 20px; font-weight: 900; color: #374151; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ec4899, #f97316); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="image" style="width: 20px; height: 20px; color: white;"></i>
                    </div>
                    Capa do Livro
                </h3>
                @if($livro->imagem_capa)
                    <div style="width: 100%; border-radius: 16px; overflow: hidden; border: 3px solid #fbcfe8; box-shadow: 0 8px 20px rgba(236, 72, 153, 0.2);">
                        <img src="{{ asset('storage/' . $livro->imagem_capa) }}" alt="Capa do livro" style="width: 100%; height: auto; display: block;">
                    </div>
                @else
                    <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #fce7f3, #fff1f2); border-radius: 16px; border: 3px solid #fbcfe8; display: flex; align-items: center; justify-content: center;">
                        <div style="text-align: center;">
                            <i data-lucide="book-open" style="width: 64px; height: 64px; color: #ec4899; margin: 0 auto 16px; display: block;"></i>
                            <p style="font-size: 14px; color: #6b7280; font-weight: 600;">Sem imagem de capa</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Informações Adicionais -->
        <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #bae6fd; box-shadow: 0 10px 30px rgba(14, 165, 233, 0.15); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(14, 165, 233, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
            <div style="position: relative; z-index: 1;">
                <h3 style="font-size: 20px; font-weight: 900; color: #374151; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                        <i data-lucide="info" style="width: 20px; height: 20px; color: white;"></i>
                    </div>
                    Informações Adicionais
                </h3>
                
                <div style="display: flex; flex-direction: column; gap: 16px;">
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Criado em</label>
                        <p style="font-size: 15px; color: #4b5563; font-weight: 600;">{{ $livro->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label style="display: block; font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.5px;">Atualizado em</label>
                        <p style="font-size: 15px; color: #4b5563; font-weight: 600;">{{ $livro->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
