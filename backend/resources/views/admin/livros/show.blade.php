@extends('layouts.admin')

@section('title', 'Detalhes do Livro')

@section('content')
<x-ui.page-header 
    title="Detalhes do Livro" 
    subtitle="Visualize todas as informações do livro"
>
    <x-ui.button href="{{ route('admin.livros.index') }}" variant="secondary" icon="arrow-left">Voltar</x-ui.button>
    <x-ui.button href="{{ route('admin.livros.edit', $livro) }}" variant="primary" icon="edit">Editar</x-ui.button>
</x-ui.page-header>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
    <!-- Informações do Livro -->
    <x-ui.info-card 
        :title="$livro->titulo"
        icon="book-open"
        iconColor="#8b5cf6"
        borderColor="#e9d5ff"
        shadowColor="rgba(139, 92, 246, 0.15)"
        backgroundGradient="linear-gradient(135deg, #faf5ff, #f3e8ff, white)"
        titleSize="28px"
    >
        <x-ui.detail-row label="Descrição">
            <p style="font-size: 15px; color: #4b5563; line-height: 1.6;">{{ $livro->descricao }}</p>
        </x-ui.detail-row>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <x-ui.detail-row label="Autor" :value="$livro->author?->nome ?? 'Autor desconhecido'" />
            <x-ui.detail-row label="Categoria" :value="$livro->category->nome" />
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <x-ui.detail-row label="ISBN" :value="$livro->isbn ?? 'N/A'" />
            <x-ui.detail-row label="Editora" :value="$livro->editora ?? 'N/A'" />
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <x-ui.detail-row label="Ano de Publicação" :value="$livro->ano_publicacao ?? 'N/A'" />
            <x-ui.detail-row label="Páginas" :value="$livro->paginas ?? 'N/A'" />
        </div>

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <x-ui.detail-row label="Preço">
                <p style="font-size: 18px; font-weight: 900; color: #8b5cf6;">R$ {{ number_format($livro->preco, 2, ',', '.') }}</p>
            </x-ui.detail-row>
            <x-ui.detail-row label="Quantidade" :value="$livro->quantidade ?? 'N/A'" />
        </div>

        <x-ui.detail-row label="Status">
            @php
                $statusVariants = [
                    'disponivel' => 'success',
                    'reservado' => 'warning',
                    'alugado' => 'danger',
                    'indisponivel' => 'default',
                ];
                $statusVariant = $statusVariants[$livro->status->value] ?? 'default';
            @endphp
            <x-ui.badge :variant="$statusVariant">
                {{ $livro->status->label() }}
            </x-ui.badge>
        </x-ui.detail-row>

        @if($livro->tags->count() > 0)
            <x-ui.detail-row label="Tags">
                <div style="display: flex; flex-wrap: wrap; gap: 8px;">
                    @foreach($livro->tags as $tag)
                        <x-ui.badge variant="info">
                            {{ $tag->nome }}
                        </x-ui.badge>
                    @endforeach
                </div>
            </x-ui.detail-row>
        @endif
    </x-ui.info-card>

    <!-- Imagem e Informações Adicionais -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        <!-- Imagem da Capa -->
        <x-ui.info-card 
            title="Capa do Livro"
            icon="image"
            iconColor="#ec4899"
            borderColor="#fbcfe8"
            shadowColor="rgba(236, 72, 153, 0.15)"
            backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
        >
            @if($livro->imagem_capa)
                <div style="width: 100%; border-radius: 16px; overflow: hidden; border: 3px solid #fbcfe8; box-shadow: 0 8px 20px rgba(236, 72, 153, 0.2);">
                    <img src="{{ asset('storage/' . $livro->imagem_capa) }}" alt="Capa do livro" style="width: 100%; height: auto; display: block;">
                </div>
            @else
                <div style="width: 100%; height: 300px; background: linear-gradient(135deg, #fce7f3, #fff1f2); border-radius: 16px; border: 3px solid #fbcfe8; display: flex; align-items: center; justify-content: center;">
                    <div style="text-align: center;">
                        <x-ui.icon name="book-open" size="64" style="color: #ec4899; margin: 0 auto 16px; display: block;" />
                        <p style="font-size: 14px; color: #6b7280; font-weight: 600;">Sem imagem de capa</p>
                    </div>
                </div>
            @endif
        </x-ui.info-card>

        <!-- Informações Adicionais -->
        <x-ui.info-card 
            title="Informações Adicionais"
            icon="info"
            iconColor="#0ea5e9"
            borderColor="#bae6fd"
            shadowColor="rgba(14, 165, 233, 0.15)"
            backgroundGradient="linear-gradient(135deg, #e0f2fe, #f0f9ff, white)"
        >
            <x-ui.detail-row label="Criado em" :value="$livro->created_at->format('d/m/Y H:i')" />
            <x-ui.detail-row label="Atualizado em" :value="$livro->updated_at->format('d/m/Y H:i')" />
        </x-ui.info-card>
    </div>
</div>
@endsection
