@extends('layouts.admin')

@section('title', 'Novo Livro')

@section('content')
<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #374151; margin-bottom: 8px;">Novo Livro</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Crie um novo livro no catálogo</p>
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
        <form method="POST" action="{{ route('admin.livros.store') }}" enctype="multipart/form-data">
            @csrf

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
                <!-- Título (ocupa 2 colunas) -->
                <div style="grid-column: 1 / -1;">
                    <label for="titulo" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Título *</label>
                    <input
                        type="text"
                        name="titulo"
                        id="titulo"
                        value="{{ old('titulo') }}"
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
                    >{{ old('descricao') }}</textarea>
                    @error('descricao')
                        <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Autor e Categoria -->
                <div>
                    <label for="autor_id" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Autor *</label>
                    <select
                        name="autor_id"
                        id="autor_id"
                        required
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('autor_id') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); cursor: pointer; box-sizing: border-box; color: #374151;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('autor_id') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >
                        <option value="">Selecione um autor</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ old('autor_id') == $author->id ? 'selected' : '' }}>
                                {{ $author->nome }}
                            </option>
                        @endforeach
                    </select>
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
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('categoria_id') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); cursor: pointer; box-sizing: border-box; color: #374151;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('categoria_id') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >
                        <option value="">Selecione uma categoria</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('categoria_id') == $category->id ? 'selected' : '' }}>
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
                        value="{{ old('isbn') }}"
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
                        value="{{ old('editora') }}"
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
                        value="{{ old('ano_publicacao') }}"
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
                        value="{{ old('paginas') }}"
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
                        type="number"
                        name="preco"
                        id="preco"
                        value="{{ old('preco') }}"
                        required
                        step="0.01"
                        min="0"
                        placeholder="0.00"
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
                        value="{{ old('quantidade', 1) }}"
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
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('status') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); cursor: pointer; box-sizing: border-box; color: #374151;"
                        onfocus="this.style.borderColor='#f97316'; this.style.boxShadow='0 0 0 3px rgba(249, 115, 22, 0.1)';"
                        onblur="this.style.borderColor='{{ $errors->has('status') ? '#ef4444' : '#fed7aa' }}'; this.style.boxShadow='none';"
                    >
                        @foreach(\App\Enums\BookStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ old('status') == $status->value ? 'selected' : '' }}>
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
                    <input
                        type="file"
                        name="imagem_capa"
                        id="imagem_capa"
                        accept="image/*"
                        style="width: 100%; padding: 12px 16px; border: 2px solid {{ $errors->has('imagem_capa') ? '#ef4444' : '#fed7aa' }}; border-radius: 12px; font-size: 14px; transition: all 0.3s; background: linear-gradient(135deg, #fff7ed, #ffffff); box-sizing: border-box; cursor: pointer; color: #374151;"
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
                            <label style="display: flex; align-items: center; cursor: pointer; padding: 8px; border-radius: 8px; transition: all 0.3s;" onmouseover="this.style.background='rgba(249, 115, 22, 0.1)';" onmouseout="this.style.background='transparent';">
                                <input
                                    type="checkbox"
                                    name="tags[]"
                                    value="{{ $tag->id }}"
                                    {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}
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
                    <i data-lucide="book-plus" style="width: 18px; height: 18px; margin-right: 8px;"></i>
                    Criar Livro
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection
