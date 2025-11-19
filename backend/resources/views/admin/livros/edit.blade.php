@extends('layouts.admin')

@section('title', 'Editar Livro')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Editar Livro</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Atualize as informações do livro</p>
        </div>
        <a href="{{ route('admin.livros.index') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
            <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
            Voltar
        </a>
    </div>
</div>

<div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fed7aa; box-shadow: 0 10px 30px rgba(249, 115, 22, 0.15); position: relative; overflow: hidden;">
    <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(249, 115, 22, 0.05); border-radius: 50%; filter: blur(60px); z-index: 0;"></div>
    <div style="position: relative; z-index: 1;">
        <form method="POST" action="{{ route('admin.livros.update', $livro) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <!-- Título (ocupa 2 colunas) -->
                <div style="grid-column: 1 / -1;">
                    <label for="titulo" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Título *</label>
                    <input
                        type="text"
                        name="titulo"
                        id="titulo"
                        value="{{ old('titulo', $livro->titulo) }}"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('titulo') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('titulo') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >
                    @error('titulo')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Descrição (ocupa 2 colunas) -->
                <div style="grid-column: 1 / -1;">
                    <label for="descricao" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Descrição *</label>
                    <textarea
                        name="descricao"
                        id="descricao"
                        rows="4"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('descricao') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box; resize: vertical; font-family: inherit;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('descricao') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >{{ old('descricao', $livro->descricao) }}</textarea>
                    @error('descricao')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Autor e Categoria -->
                <div>
                    <label for="autor_id" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Autor *</label>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <select
                            name="autor_id"
                            id="autor_id"
                            required
                            style="flex: 1; padding: 12px 16px; border: 2px solid {{ $errors->has('autor_id') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); cursor: pointer; box-sizing: border-box;"
                            onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                            onblur="this.style.borderColor='{{ $errors->has('autor_id') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                        >
                            <option value="">Selecione um autor</option>
                            @foreach($authors as $author)
                                <option value="{{ $author->id }}" {{ old('autor_id', $livro->autor_id) == $author->id ? 'selected' : '' }}>
                                    {{ $author->nome }}
                                </option>
                            @endforeach
                        </select>
                        <button
                            type="button"
                            onclick="openAuthorModal()"
                            style="width: 44px; height: 44px; border-radius: 50%; background: linear-gradient(135deg, #f97316, #fb923c); color: white; border: 2px solid #f97316; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s; box-shadow: 0 2px 8px rgba(249, 115, 22, 0.3); flex-shrink: 0;"
                            onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 4px 12px rgba(249, 115, 22, 0.4)';"
                            onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 2px 8px rgba(249, 115, 22, 0.3)';"
                            title="Adicionar novo autor"
                        >
                            <i data-lucide="plus" style="width: 20px; height: 20px;"></i>
                        </button>
                    </div>
                    @error('autor_id')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="categoria_id" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Categoria *</label>
                    <select
                        name="categoria_id"
                        id="categoria_id"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('categoria_id') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); cursor: pointer; box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('categoria_id') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >
                        <option value="">Selecione uma categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('categoria_id', $livro->categoria_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- ISBN e Editora -->
                <div>
                    <label for="isbn" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">ISBN *</label>
                    <input
                        type="text"
                        name="isbn"
                        id="isbn"
                        value="{{ old('isbn', $livro->isbn) }}"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('isbn') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('isbn') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >
                    @error('isbn')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="editora" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Editora *</label>
                    <input
                        type="text"
                        name="editora"
                        id="editora"
                        value="{{ old('editora', $livro->editora) }}"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('editora') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('editora') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >
                    @error('editora')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Ano de Publicação e Páginas -->
                <div>
                    <label for="ano_publicacao" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Ano de Publicação *</label>
                    <input
                        type="number"
                        name="ano_publicacao"
                        id="ano_publicacao"
                        value="{{ old('ano_publicacao', $livro->ano_publicacao) }}"
                        required
                        min="1000"
                        max="{{ date('Y') }}"
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('ano_publicacao') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('ano_publicacao') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >
                    @error('ano_publicacao')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="paginas" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Páginas *</label>
                    <input
                        type="number"
                        name="paginas"
                        id="paginas"
                        value="{{ old('paginas', $livro->paginas) }}"
                        required
                        min="1"
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('paginas') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('paginas') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >
                    @error('paginas')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preço e Quantidade -->
                <div>
                    <label for="preco" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Preço *</label>
                    <input
                        type="text"
                        name="preco"
                        id="preco"
                        value="{{ old('preco', $livro->preco) }}"
                        data-mask="currency"
                        required
                        placeholder="R$ 0,00"
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('preco') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('preco') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >
                    @error('preco')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="quantidade" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Quantidade *</label>
                    <input
                        type="number"
                        name="quantidade"
                        id="quantidade"
                        value="{{ old('quantidade', $livro->quantidade) }}"
                        required
                        min="0"
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('quantidade') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('quantidade') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >
                    @error('quantidade')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status e Imagem da Capa -->
                <div>
                    <label for="status" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Status *</label>
                    <select
                        name="status"
                        id="status"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('status') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); cursor: pointer; box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('status') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >
                        @foreach(\App\Enums\BookStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ old('status', $livro->status->value) == $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="imagem_capa" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Imagem da Capa</label>
                    @if($livro->imagem_capa)
                        <div style="margin-bottom: 12px;">
                            <img src="{{ asset('storage/' . $livro->imagem_capa) }}" alt="Capa atual" style="max-height: 120px; width: auto; border-radius: 12px; border: 2px solid #fed7aa;">
                        </div>
                    @endif
                    <input
                        type="file"
                        name="imagem_capa"
                        id="imagem_capa"
                        accept="image/*"
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('imagem_capa') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box; cursor: pointer;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('imagem_capa') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >
                    @error('imagem_capa')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tags (ocupa 2 colunas) -->
                <div style="grid-column: 1 / -1;">
                    <label style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 12px;">Tags</label>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 12px; padding: 20px; background: linear-gradient(135deg, #fff7ed, #fff1f2); border: 2px solid #fed7aa; border-radius: 12px;">
                        @foreach($tags as $tag)
                            <label style="display: flex; align-items: center; cursor: pointer; padding: 8px; border-radius: 8px; transition: all 0.3s;" onmouseover="this.style.background='rgba(139, 92, 246, 0.1)';" onmouseout="this.style.background='transparent';">
                                <input
                                    type="checkbox"
                                    name="tags[]"
                                    value="{{ $tag->id }}"
                                    {{ in_array($tag->id, old('tags', $livro->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                                    style="width: 18px; height: 18px; accent-color: #f97316; cursor: pointer; flex-shrink: 0;"
                                >
                                <span style="margin-left: 10px; font-size: 14px; font-weight: 600; color: #6b7280;">{{ $tag->nome }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <div style="margin-top: 32px; display: flex; justify-content: flex-end; gap: 12px; flex-wrap: wrap;">
                <a href="{{ route('admin.livros.index') }}" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #fff7ed, #ffffff); color: #f97316; border: 3px solid #fed7aa; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(249, 115, 22, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #f97316, #fb923c)'; this.style.color='white'; this.style.borderColor='#f97316'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(249, 115, 22, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #fff7ed, #ffffff)'; this.style.color='#f97316'; this.style.borderColor='#fed7aa'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(249, 115, 22, 0.15)';">
                    Cancelar
                </a>
                <button type="submit" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #f97316, #fb923c); color: white; border: 3px solid #f97316; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(249, 115, 22, 0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(249, 115, 22, 0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(249, 115, 22, 0.3)';">
                    <i data-lucide="save" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                    Atualizar Livro
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para Cadastrar Novo Autor -->
<div id="authorModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center;" onclick="if(event.target === this) closeAuthorModal()">
    <div style="background: white; border-radius: 20px; padding: 32px; max-width: 500px; width: 90%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); position: relative;" onclick="event.stopPropagation();">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 24px; font-weight: 900; color: #1f2937; margin: 0;">Novo Autor</h2>
            <button
                type="button"
                onclick="closeAuthorModal()"
                style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #ef4444; border: 2px solid #fca5a5; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s;"
                onmouseover="this.style.background='linear-gradient(135deg, #ef4444, #dc2626)'; this.style.color='white'; this.style.borderColor='#ef4444';"
                onmouseout="this.style.background='linear-gradient(135deg, #fee2e2, #fef2f2)'; this.style.color='#ef4444'; this.style.borderColor='#fca5a5';"
                title="Fechar"
            >
                <i data-lucide="x" style="width: 20px; height: 20px;"></i>
            </button>
        </div>

        <form id="authorForm" onsubmit="submitAuthorForm(event)">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div>
                    <label for="author_nome" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Nome *</label>
                    <input
                        type="text"
                        name="nome"
                        id="author_nome"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid #fed7aa; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='#fed7aa'; this.style.boxShadow='none';"
                        placeholder="Digite o nome do autor"
                    >
                    <p id="author_nome_error" style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600; display: none;"></p>
                </div>

                <div>
                    <label for="author_biografia" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Biografia (opcional)</label>
                    <textarea
                        name="biografia"
                        id="author_biografia"
                        rows="4"
                        style="width: 100%; padding: 12px 16px; border: 2px solid #fed7aa; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box; resize: vertical; font-family: inherit;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='#fed7aa'; this.style.boxShadow='none';"
                        placeholder="Digite a biografia do autor"
                    ></textarea>
                </div>

                <div>
                    <label for="author_data_nascimento" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Data de Nascimento (opcional)</label>
                    <input
                        type="date"
                        name="data_nascimento"
                        id="author_data_nascimento"
                        max="{{ date('Y-m-d', strtotime('-1 day')) }}"
                        style="width: 100%; padding: 12px 16px; border: 2px solid #fed7aa; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='#fed7aa'; this.style.boxShadow='none';"
                    >
                </div>

                <div id="author_form_message" style="display: none; padding: 12px; border-radius: 12px; margin-bottom: 8px;"></div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 8px;">
                    <button
                        type="button"
                        onclick="closeAuthorModal()"
                        style="padding: 12px 24px; background: linear-gradient(135deg, #fff7ed, #ffffff); color: #f97316; border: 3px solid #fed7aa; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s;"
                        onmouseover="this.style.background='linear-gradient(135deg, #f97316, #fb923c)'; this.style.color='white'; this.style.borderColor='#f97316';"
                        onmouseout="this.style.background='linear-gradient(135deg, #fff7ed, #ffffff)'; this.style.color='#f97316'; this.style.borderColor='#fed7aa';"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        id="author_submit_btn"
                        style="padding: 12px 24px; background: linear-gradient(135deg, #f97316, #fb923c); color: white; border: 3px solid #f97316; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; box-shadow: 0 4px 10px rgba(249, 115, 22, 0.3);"
                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(249, 115, 22, 0.4)';"
                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(249, 115, 22, 0.3)';"
                    >
                        <i data-lucide="user-plus" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i>
                        Criar Autor
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function openAuthorModal() {
    const modal = document.getElementById('authorModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
    setTimeout(() => {
        document.getElementById('author_nome').focus();
    }, 100);
}

function closeAuthorModal() {
    const modal = document.getElementById('authorModal');
    modal.style.display = 'none';
    document.body.style.overflow = '';
    document.getElementById('authorForm').reset();
    document.getElementById('author_nome_error').style.display = 'none';
    document.getElementById('author_form_message').style.display = 'none';
    document.getElementById('author_submit_btn').disabled = false;
}

function submitAuthorForm(event) {
    event.preventDefault();
    
    const form = event.target;
    const submitBtn = document.getElementById('author_submit_btn');
    const messageDiv = document.getElementById('author_form_message');
    const nomeError = document.getElementById('author_nome_error');
    
    messageDiv.style.display = 'none';
    nomeError.style.display = 'none';
    
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i data-lucide="loader-2" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle; animation: spin 1s linear infinite;"></i> Criando...';
    
    const formData = new FormData(form);
    
    fetch('{{ route("admin.autores.store") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
        },
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                throw { response: { json: () => Promise.resolve(data) } };
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const select = document.getElementById('autor_id');
            const option = document.createElement('option');
            option.value = data.author.id;
            option.textContent = data.author.nome;
            option.selected = true;
            select.appendChild(option);
            
            messageDiv.style.display = 'block';
            messageDiv.style.background = 'linear-gradient(135deg, #dcfce7, #f0fdf4)';
            messageDiv.style.border = '2px solid #86efac';
            messageDiv.style.color = '#166534';
            messageDiv.innerHTML = '<i data-lucide="check-circle" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i> ' + data.message;
            
            setTimeout(() => {
                closeAuthorModal();
            }, 1000);
        } else {
            throw new Error(data.message || 'Erro ao criar autor');
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i data-lucide="user-plus" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i> Criar Autor';
        
        if (error.response && error.response.json) {
            error.response.json().then(data => {
                if (data.errors && data.errors.nome) {
                    nomeError.textContent = data.errors.nome[0];
                    nomeError.style.display = 'block';
                } else {
                    messageDiv.style.display = 'block';
                    messageDiv.style.background = 'linear-gradient(135deg, #fee2e2, #fef2f2)';
                    messageDiv.style.border = '2px solid #fca5a5';
                    messageDiv.style.color = '#991b1b';
                    messageDiv.innerHTML = '<i data-lucide="alert-circle" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i> ' + (data.message || 'Erro ao criar autor');
                }
            });
        } else {
            messageDiv.style.display = 'block';
            messageDiv.style.background = 'linear-gradient(135deg, #fee2e2, #fef2f2)';
            messageDiv.style.border = '2px solid #fca5a5';
            messageDiv.style.color = '#991b1b';
            messageDiv.innerHTML = '<i data-lucide="alert-circle" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; vertical-align: middle;"></i> ' + (error.message || 'Erro ao criar autor');
        }
    });
}

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('authorModal');
        if (modal.style.display === 'flex') {
            closeAuthorModal();
        }
    }
});

document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
});
</script>

<style>
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
