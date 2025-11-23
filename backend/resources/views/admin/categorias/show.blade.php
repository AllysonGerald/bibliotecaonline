@extends('layouts.admin')

@section('title', 'Detalhes da Categoria')

@section('content')

<x-ui.page-header 
    title="Detalhes da Categoria" 
    subtitle="Visualize todas as informações da categoria"
>
    <x-ui.button href="{{ route('admin.categorias.index') }}" variant="secondary" icon="arrow-left">Voltar</x-ui.button>
    <x-ui.button href="{{ route('admin.categorias.edit', $categoria) }}" variant="primary" icon="edit">Editar</x-ui.button>
</x-ui.page-header>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
    <x-ui.info-card 
        title="{{ $categoria->nome }}"
        icon="tag"
        iconColor="#8b5cf6"
        borderColor="#e9d5ff"
        shadowColor="rgba(139, 92, 246, 0.15)"
        backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)"
    >
        @if($categoria->descricao)
            <x-ui.detail-row label="Descrição" :value="$categoria->descricao" />
        @endif

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <x-ui.detail-row label="Total de Livros" :value="$categoria->books->count()" />
            @if($categoria->icone)
                <x-ui.detail-row label="Ícone" :value="$categoria->icone" />
            @endif
        </div>

        @if($categoria->books->count() > 0)
            <div style="margin-top: 24px; padding-top: 24px; border-top: 2px solid #e9d5ff;">
                <h4 style="font-size: 18px; font-weight: 900; color: #1f2937; margin-bottom: 16px;">Livros desta Categoria</h4>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($categoria->books as $book)
                        <a href="{{ route('admin.livros.show', $book) }}" style="display: block; padding: 12px; background: linear-gradient(135deg, #faf5ff, #f3e8ff); border: 2px solid #e9d5ff; border-radius: 12px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #f3e8ff, #e9d5ff)'; this.style.borderColor='#8b5cf6'; this.style.transform='translateX(4px)';" onmouseout="this.style.background='linear-gradient(135deg, #faf5ff, #f3e8ff)'; this.style.borderColor='#e9d5ff'; this.style.transform='translateX(0)';">
                            <div style="font-size: 15px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $book->titulo }}</div>
                            <div style="font-size: 13px; color: #6b7280; font-weight: 600;">{{ $book->author?->nome ?? 'Autor desconhecido' }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </x-ui.info-card>

    <x-ui.info-card 
        title="Informações do Sistema"
        icon="clock"
        iconColor="#8b5cf6"
        borderColor="#e9d5ff"
        shadowColor="rgba(139, 92, 246, 0.15)"
        backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)"
    >
        <x-ui.detail-row label="Criado em" :value="$categoria->created_at->format('d/m/Y H:i')" />
        <x-ui.detail-row label="Atualizado em" :value="$categoria->updated_at->format('d/m/Y H:i')" />
    </x-ui.info-card>
</div>
@endsection

