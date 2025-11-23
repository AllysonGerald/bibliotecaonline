@extends('layouts.admin')

@section('title', 'Detalhes do Autor')

@section('content')

<x-ui.page-header 
    title="Detalhes do Autor" 
    subtitle="Visualize todas as informações do autor"
>
    <x-ui.button href="{{ route('admin.autores.index') }}" variant="secondary" icon="arrow-left">Voltar</x-ui.button>
    <x-ui.button href="{{ route('admin.autores.edit', $autor) }}" variant="primary" icon="edit">Editar</x-ui.button>
</x-ui.page-header>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
    <x-ui.info-card 
        title="{{ $autor->nome }}"
        icon="user"
        iconColor="#f97316"
        borderColor="#fed7aa"
        shadowColor="rgba(249, 115, 22, 0.15)"
        backgroundGradient="linear-gradient(135deg, #fff7ed, #fff1f2, white)"
    >
        @if($autor->biografia)
            <x-ui.detail-row label="Biografia" :value="$autor->biografia" />
        @endif

        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <x-ui.detail-row label="Data de Nascimento" :value="$autor->data_nascimento ? $autor->data_nascimento->format('d/m/Y') : 'N/A'" />
            <x-ui.detail-row label="Total de Livros" :value="$autor->books->count()" />
        </div>

        @if($autor->books->count() > 0)
            <div style="margin-top: 24px; padding-top: 24px; border-top: 2px solid #fed7aa;">
                <h4 style="font-size: 18px; font-weight: 900; color: #1f2937; margin-bottom: 16px;">Livros do Autor</h4>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($autor->books as $book)
                        <a href="{{ route('admin.livros.show', $book) }}" style="display: block; padding: 12px; background: linear-gradient(135deg, #fff7ed, #fff1f2); border: 2px solid #fed7aa; border-radius: 12px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #fff1f2, #fed7aa)'; this.style.borderColor='#f97316'; this.style.transform='translateX(4px)';" onmouseout="this.style.background='linear-gradient(135deg, #fff7ed, #fff1f2)'; this.style.borderColor='#fed7aa'; this.style.transform='translateX(0)';">
                            <div style="font-size: 15px; font-weight: 700; color: #1f2937; margin-bottom: 4px;">{{ $book->titulo }}</div>
                            <div style="font-size: 13px; color: #6b7280; font-weight: 600;">{{ $book->category->nome }}</div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </x-ui.info-card>

    <x-ui.info-card 
        title="Informações do Sistema"
        icon="clock"
        iconColor="#f97316"
        borderColor="#fed7aa"
        shadowColor="rgba(249, 115, 22, 0.15)"
        backgroundGradient="linear-gradient(135deg, #fff7ed, #fff1f2, white)"
    >
        @if($autor->foto)
            <div style="margin-bottom: 20px;">
                <img src="{{ $autor->foto }}" alt="Foto do autor" style="width: 100%; border-radius: 12px; border: 2px solid #fed7aa;" onerror="this.style.display='none'">
            </div>
        @else
            <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #fff7ed, #fff1f2); border-radius: 12px; border: 2px solid #fed7aa; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <x-ui.icon name="user" size="64" style="color: #f97316;" />
            </div>
        @endif

        <x-ui.detail-row label="Criado em" :value="$autor->created_at->format('d/m/Y H:i')" />
        <x-ui.detail-row label="Atualizado em" :value="$autor->updated_at->format('d/m/Y H:i')" />
    </x-ui.info-card>
</div>
@endsection

