@extends('layouts.admin')

@section('title', 'Editar Livro')

@section('content')

<x-ui.page-header 
    title="Editar Livro" 
    subtitle="Atualize as informações do livro"
>
    <x-ui.button href="{{ route('admin.livros.index') }}" variant="secondary" icon="arrow-left">Voltar</x-ui.button>
</x-ui.page-header>

<x-ui.card
    borderColor="#fed7aa"
    shadowColor="rgba(249, 115, 22, 0.15)"
    backgroundGradient="linear-gradient(135deg, #fff7ed, #fff1f2, white)"
>
    <form method="POST" action="{{ route('admin.livros.update', $livro) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px;">
            <!-- Título (ocupa 2 colunas) -->
            <div style="grid-column: 1 / -1;">
                <x-forms.input
                    type="text"
                    name="titulo"
                    label="Título"
                    :value="old('titulo', $livro->titulo)"
                    required
                    borderColor="#fed7aa"
                    focusColor="#f97316"
                    backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                />
            </div>

            <!-- Descrição (ocupa 2 colunas) -->
            <div style="grid-column: 1 / -1;">
                <x-forms.input
                    type="textarea"
                    name="descricao"
                    label="Descrição"
                    :value="old('descricao', $livro->descricao)"
                    required
                    borderColor="#fed7aa"
                    focusColor="#f97316"
                    backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                />
            </div>

            <!-- Autor e Categoria -->
            <div>
                <label for="autor_id" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">
                    Autor <span style="color: #ef4444;">*</span>
                </label>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="flex: 1;">
                        <x-forms.select
                            name="autor_id"
                            :options="['' => 'Selecione um autor'] + $authors->pluck('nome', 'id')->toArray()"
                            :value="old('autor_id', $livro->autor_id)"
                            required
                            borderColor="#fed7aa"
                            focusColor="#f97316"
                            backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                        />
                    </div>
                    <button
                        type="button"
                        onclick="openAuthorModal()"
                        style="width: 44px; height: 44px; background: linear-gradient(135deg, #f97316, #fb923c); color: white; border: 2px solid #f97316; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s; box-shadow: 0 4px 10px rgba(249, 115, 22, 0.3); flex-shrink: 0;"
                        onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0 6px 15px rgba(249, 115, 22, 0.4)';"
                        onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 10px rgba(249, 115, 22, 0.3)';"
                        title="Adicionar novo autor"
                    >
                        <x-ui.icon name="plus" size="20" />
                    </button>
                </div>
                @error('autor_id')
                    <p style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600;">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-forms.select
                    name="categoria_id"
                    label="Categoria"
                    :options="['' => 'Selecione uma categoria'] + $categories->pluck('nome', 'id')->toArray()"
                    :value="old('categoria_id', $livro->categoria_id)"
                    required
                    borderColor="#fed7aa"
                    focusColor="#f97316"
                    backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                />
            </div>

            <!-- ISBN e Editora -->
            <div>
                <x-forms.input
                    type="text"
                    name="isbn"
                    label="ISBN"
                    :value="old('isbn', $livro->isbn)"
                    required
                    borderColor="#fed7aa"
                    focusColor="#f97316"
                    backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                />
            </div>

            <div>
                <x-forms.input
                    type="text"
                    name="editora"
                    label="Editora"
                    :value="old('editora', $livro->editora)"
                    required
                    borderColor="#fed7aa"
                    focusColor="#f97316"
                    backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                />
            </div>

            <!-- Ano de Publicação e Páginas -->
            <div>
                <x-forms.input
                    type="number"
                    name="ano_publicacao"
                    label="Ano de Publicação"
                    :value="old('ano_publicacao', $livro->ano_publicacao)"
                    required
                    min="1000"
                    :max="date('Y')"
                    borderColor="#fed7aa"
                    focusColor="#f97316"
                    backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                />
            </div>

            <div>
                <x-forms.input
                    type="number"
                    name="paginas"
                    label="Páginas"
                    :value="old('paginas', $livro->paginas)"
                    required
                    min="1"
                    borderColor="#fed7aa"
                    focusColor="#f97316"
                    backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                />
            </div>

            <!-- Preço e Quantidade -->
            <div>
                <x-forms.input
                    type="text"
                    name="preco"
                    label="Preço"
                    :value="old('preco', $livro->preco)"
                    placeholder="R$ 0,00"
                    mask="currency"
                    required
                    borderColor="#fed7aa"
                    focusColor="#f97316"
                    backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                />
            </div>

            <div>
                <x-forms.input
                    type="number"
                    name="quantidade"
                    label="Quantidade"
                    :value="old('quantidade', $livro->quantidade)"
                    required
                    min="0"
                    borderColor="#fed7aa"
                    focusColor="#f97316"
                    backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                />
            </div>

            <!-- Status e Imagem da Capa -->
            <div>
                <x-forms.select
                    name="status"
                    label="Status"
                    :options="collect(\App\Enums\BookStatus::cases())->mapWithKeys(fn($status) => [$status->value => $status->label()])->toArray()"
                    :value="old('status', $livro->status->value)"
                    required
                    borderColor="#fed7aa"
                    focusColor="#f97316"
                    backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                />
            </div>

            <div>
                <label for="imagem_capa" style="display: block; font-size: 14px; font-weight: 700; color: #6b7280; margin-bottom: 8px;">Imagem da Capa</label>
                @if($livro->imagem_capa)
                    <div style="margin-bottom: 12px;">
                        <img src="{{ asset('storage/' . $livro->imagem_capa) }}" alt="Capa atual" style="max-height: 120px; width: auto; border-radius: 12px; border: 2px solid #fed7aa;">
                    </div>
                @endif
                <x-forms.file-input
                    name="imagem_capa"
                    accept="image/*"
                    borderColor="#fed7aa"
                    focusColor="#f97316"
                    backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                />
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
            <x-ui.button href="{{ route('admin.livros.index') }}" variant="secondary">
                Cancelar
            </x-ui.button>
            <x-ui.button type="submit" variant="warning" icon="save">
                Atualizar Livro
            </x-ui.button>
        </div>
    </form>
</x-ui.card>

<!-- Modal para Cadastrar Novo Autor -->
<div id="authorModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.5); z-index: 1000; align-items: center; justify-content: center;" onclick="if(event.target === this) closeAuthorModal()">
    <div style="background: white; border-radius: 20px; padding: 32px; max-width: 512px; width: 90%; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3); position: relative;" onclick="event.stopPropagation();">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 24px; font-weight: 900; color: #1f2937; margin: 0;">Novo Autor</h2>
            <button
                type="button"
                onclick="closeAuthorModal()"
                style="width: 36px; height: 36px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #ef4444; border: 2px solid #fca5a5; border-radius: 50%; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.3s;"
                onmouseover="this.style.background='linear-gradient(135deg, #ef4444, #dc2626)'; this.style.color='white'; this.style.borderColor='#ef4444';"
                onmouseout="this.style.background='linear-gradient(135deg, #fee2e2, #fef2f2)'; this.style.color='#ef4444'; this.style.borderColor='#fca5a5';"
                title="Fechar"
            >
                <x-ui.icon name="x" size="20" />
            </button>
        </div>

        <form id="authorForm" onsubmit="submitAuthorForm(event)">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 20px;">
                <div>
                    <x-forms.input
                        type="text"
                        name="nome"
                        id="author_nome"
                        label="Nome"
                        required
                        placeholder="Digite o nome do autor"
                        borderColor="#fed7aa"
                        focusColor="#f97316"
                        backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                    />
                    <p id="author_nome_error" style="margin-top: 8px; font-size: 13px; color: #ef4444; font-weight: 600; display: none;"></p>
                </div>

                <div>
                    <x-forms.input
                        type="textarea"
                        name="biografia"
                        id="author_biografia"
                        label="Biografia (opcional)"
                        placeholder="Digite a biografia do autor"
                        borderColor="#fed7aa"
                        focusColor="#f97316"
                        backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                    />
                </div>

                <div>
                    <x-forms.input
                        type="date"
                        name="data_nascimento"
                        id="author_data_nascimento"
                        label="Data de Nascimento (opcional)"
                        :max="date('Y-m-d', strtotime('-1 day'))"
                        borderColor="#fed7aa"
                        focusColor="#f97316"
                        backgroundGradient="linear-gradient(135deg, #fff7ed, #ffffff)"
                    />
                </div>

                <div id="author_form_message" style="display: none; padding: 12px; border-radius: 12px; margin-bottom: 8px;"></div>

                <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 8px;">
                    <x-ui.button type="button" onclick="closeAuthorModal()" variant="secondary">
                        Cancelar
                    </x-ui.button>
                    <x-ui.button type="submit" id="author_submit_btn" variant="primary" icon="user-plus">
                        Criar Autor
                    </x-ui.button>
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
    submitBtn.innerHTML = '<i data-lucide="loader-2" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px; animation: spin 1s linear infinite;"></i> Criando...';
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    const formData = new FormData(form);
    
    fetch("{{ route('admin.autores.store') }}", {
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
            messageDiv.style.padding = '12px';
            messageDiv.style.borderRadius = '12px';
            messageDiv.innerHTML = '<i data-lucide="check-circle" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px;"></i> ' + (data.message || '');
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
            
            setTimeout(() => {
                closeAuthorModal();
            }, 1000);
        } else {
            throw new Error(data.message || 'Erro ao criar autor');
        }
    })
    .catch(error => {
        submitBtn.disabled = false;
        submitBtn.innerHTML = '<i data-lucide="user-plus" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px;"></i> Criar Autor';
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
        
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
                    messageDiv.style.padding = '12px';
                    messageDiv.style.borderRadius = '12px';
                    const errorMsg = (data.message || 'Erro ao criar autor').replace(/'/g, "\\'");
                    messageDiv.innerHTML = '<i data-lucide="alert-circle" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px;"></i> ' + errorMsg;
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                }
            });
        } else {
            messageDiv.style.display = 'block';
            messageDiv.style.background = 'linear-gradient(135deg, #fee2e2, #fef2f2)';
            messageDiv.style.border = '2px solid #fca5a5';
            messageDiv.style.color = '#991b1b';
            messageDiv.style.padding = '12px';
            messageDiv.style.borderRadius = '12px';
            messageDiv.innerHTML = '<i data-lucide="alert-circle" style="width: 18px; height: 18px; display: inline-block; margin-right: 8px;"></i> ' + (error.message || 'Erro ao criar autor');
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
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
</script>
<style>
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
@media (max-width: 768px) {
    div[style*="grid-template-columns: repeat(2, 1fr)"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection
