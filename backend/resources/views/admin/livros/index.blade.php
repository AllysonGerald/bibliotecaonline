@extends('layouts.admin')

@section('title', 'Livros')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Gerenciar Livros</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Gerencie o catálogo de livros</p>
        </div>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="{{ route('admin.dashboard') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
                <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Painel do Admin
            </a>
            <a href="{{ route('admin.livros.create') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border: 3px solid #8b5cf6; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.3)';">
                <i data-lucide="plus" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                Novo Livro
            </a>
        </div>
    </div>
</div>

<!-- Filtros -->
<div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fed7aa; box-shadow: 0 10px 30px rgba(249, 115, 22, 0.15); margin-bottom: 24px; position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(249, 115, 22, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
    <div style="position: relative; z-index: 1;">
        <h3 style="font-size: 20px; font-weight: 900; color: #1f2937; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #f97316, #fb923c, #fdba74, #fed7aa); border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(249, 115, 22, 0.3);">
                <i data-lucide="filter" style="width: 20px; height: 20px; color: white;"></i>
            </div>
            Filtros
        </h3>
        <form method="GET" action="{{ route('admin.livros.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
            <div>
                <label for="search" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Buscar</label>
                <input
                    type="text"
                    name="search"
                    id="search"
                    value="{{ request('search') }}"
                    placeholder="Título, autor..."
                    style="width: 100%; padding: 12px 16px; border: 2px solid #fed7aa; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box;"
                    onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                    onblur="this.style.borderColor='#fed7aa'; this.style.boxShadow='none';"
                >
            </div>
            <div>
                <label for="categoria_id" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Categoria</label>
                <select
                    name="categoria_id"
                    id="categoria_id"
                    style="width: 100%; padding: 12px 16px; border: 2px solid #fed7aa; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); cursor: pointer; box-sizing: border-box;"
                    onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                    onblur="this.style.borderColor='#fed7aa'; this.style.boxShadow='none';"
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
                <label for="autor_id" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Autor</label>
                <select
                    name="autor_id"
                    id="autor_id"
                    style="width: 100%; padding: 12px 16px; border: 2px solid #fed7aa; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); cursor: pointer; box-sizing: border-box;"
                    onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                    onblur="this.style.borderColor='#fed7aa'; this.style.boxShadow='none';"
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
                <button type="submit" style="width: 100%; padding: 12px 20px; background: linear-gradient(135deg, #f97316, #fb923c, #fdba74, #fed7aa); color: white; border: 3px solid #f97316; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(249, 115, 22, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(249, 115, 22, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(249, 115, 22, 0.3)';">
                    <i data-lucide="search" style="width: 18px; height: 18px; margin-right: 8px; display: inline-block; vertical-align: middle;"></i>
                    Filtrar
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Tabela de Livros -->
<div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fed7aa; box-shadow: 0 10px 30px rgba(249, 115, 22, 0.15); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(249, 115, 22, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
    <div style="position: relative; z-index: 1;">
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 3px solid #fed7aa;">
                        <th style="padding: 16px; text-align: left; font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Título</th>
                        <th style="padding: 16px; text-align: left; font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Autor</th>
                        <th style="padding: 16px; text-align: left; font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Categoria</th>
                        <th style="padding: 16px; text-align: left; font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Status</th>
                        <th style="padding: 16px; text-align: left; font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Quantidade</th>
                        <th style="padding: 16px; text-align: right; font-size: 13px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($books as $book)
                        <tr style="border-bottom: 2px solid #fff1f2; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #fff7ed, #fff1f2)';" onmouseout="this.style.background='transparent';">
                            <td style="padding: 16px;">
                                <div style="font-size: 15px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $book->titulo }}</div>
                                @if($book->isbn)
                                    <div style="font-size: 12px; color: #9ca3af; font-weight: 500;">ISBN: {{ $book->isbn }}</div>
                                @endif
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-size: 14px; color: #4b5563; font-weight: 600;">{{ $book->author->nome }}</div>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-size: 14px; color: #4b5563; font-weight: 600;">{{ $book->category->nome }}</div>
                            </td>
                            <td style="padding: 16px;">
                                @php
                                    $statusStyles = [
                                        'disponivel' => 'background: linear-gradient(135deg, #dcfce7, #f0fdf4); color: #166534; border: 2px solid #86efac;',
                                        'reservado' => 'background: linear-gradient(135deg, #fef3c7, #fffbeb); color: #92400e; border: 2px solid #fde047;',
                                        'alugado' => 'background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border: 2px solid #fca5a5;',
                                        'indisponivel' => 'background: linear-gradient(135deg, #f3f4f6, #ffffff); color: #6b7280; border: 2px solid #e5e7eb;',
                                    ];
                                    $statusStyle = $statusStyles[$book->status->value] ?? 'background: linear-gradient(135deg, #f3f4f6, #ffffff); color: #6b7280; border: 2px solid #e5e7eb;';
                                @endphp
                                <span style="display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; {{ $statusStyle }}">
                                    {{ $book->status->label() }}
                                </span>
                            </td>
                            <td style="padding: 16px;">
                                <div style="font-size: 14px; color: #4b5563; font-weight: 600;">{{ $book->quantidade ?? 'N/A' }}</div>
                            </td>
                            <td style="padding: 16px; text-align: right;">
                                <div style="display: flex; justify-content: flex-end; gap: 8px;">
                                    <a href="{{ route('admin.livros.show', $book) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, #e0f2fe, #f0f9ff); color: #0ea5e9; border: 2px solid #bae6fd; border-radius: 10px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(14, 165, 233, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #0ea5e9, #38bdf8)'; this.style.color='white'; this.style.borderColor='#0ea5e9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(14, 165, 233, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #e0f2fe, #f0f9ff)'; this.style.color='#0ea5e9'; this.style.borderColor='#bae6fd'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(14, 165, 233, 0.15)';" title="Ver">
                                        <i data-lucide="eye" style="width: 18px; height: 18px;"></i>
                                    </a>
                                    <a href="{{ route('admin.livros.edit', $book) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 2px solid #e9d5ff; border-radius: 10px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(139, 92, 246, 0.15)';" title="Editar">
                                        <i data-lucide="edit" style="width: 18px; height: 18px;"></i>
                                    </a>
                                    <button type="button" onclick="openDeleteModal('delete-book-{{ $book->id }}')" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #ef4444; border: 2px solid #fca5a5; border-radius: 10px; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 5px rgba(239, 68, 68, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #ef4444, #f87171)'; this.style.color='white'; this.style.borderColor='#ef4444'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(239, 68, 68, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #fee2e2, #fef2f2)'; this.style.color='#ef4444'; this.style.borderColor='#fca5a5'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(239, 68, 68, 0.15)';" title="Excluir">
                                        <i data-lucide="trash-2" style="width: 18px; height: 18px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="padding: 48px; text-align: center;">
                                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #fff1f2, #fff7ed); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                    <i data-lucide="book-open" style="width: 40px; height: 40px; color: #f97316;"></i>
                                </div>
                                <p style="font-size: 16px; color: #6b7280; font-weight: 500;">Nenhum livro encontrado.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($books->hasPages())
            {{ $books->links('components.pagination') }}
        @endif
    </div>
</div>

<!-- Modais de Exclusão -->
@foreach($books as $book)
    <x-delete-modal
        id="delete-book-{{ $book->id }}"
        title="Confirmar Exclusão"
        message="Tem certeza que deseja excluir este livro? Esta ação não pode ser desfeita."
        :action="route('admin.livros.destroy', $book)"
        :itemName="$book->titulo"
    />
@endforeach

<script>
    function openDeleteModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
            // Inicializar Alpine.js se necessário
            if (typeof Alpine !== 'undefined') {
                Alpine.initTree(modal);
                const alpineData = Alpine.$data(modal);
                if (alpineData) {
                    alpineData.open = true;
                }
            }
        }
    }
    
    // Fechar modal ao clicar no backdrop
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-backdrop')) {
            e.target.style.display = 'none';
            if (typeof Alpine !== 'undefined') {
                const alpineData = Alpine.$data(e.target);
                if (alpineData) {
                    alpineData.open = false;
                }
            }
        }
    });
</script>
<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
