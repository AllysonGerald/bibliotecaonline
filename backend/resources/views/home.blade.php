@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

<x-ui.page-header
    title="Olá, {{ $user->name }}!"
    subtitle="Bem-vindo de volta à Biblioteca Online"
/>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <x-ui.stat-card
        label="Aluguéis Ativos"
        :value="$activeRentals"
        icon="book"
        iconColor="#8b5cf6"
        borderColor="#e9d5ff"
        shadowColor="rgba(139, 92, 246, 0.15)"
        backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)"
    />

    <x-ui.stat-card
        label="Reservas Pendentes"
        :value="$pendingReservations"
        icon="clock"
        iconColor="#ec4899"
        borderColor="#fbcfe8"
        shadowColor="rgba(236, 72, 153, 0.15)"
        backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
    />

    <x-ui.stat-card
        label="Lista de Desejos"
        :value="$wishlistCount"
        icon="heart"
        iconColor="#f97316"
        borderColor="#fed7aa"
        shadowColor="rgba(249, 115, 22, 0.15)"
        backgroundGradient="linear-gradient(135deg, #fff1f2, #fff7ed, white)"
    />

    <x-ui.stat-card
        label="Avaliações Feitas"
        :value="$reviewsCount"
        icon="star"
        iconColor="#8b5cf6"
        borderColor="#e9d5ff"
        shadowColor="rgba(139, 92, 246, 0.15)"
        backgroundGradient="linear-gradient(135deg, #faf5ff, #f3e8ff, white)"
    />
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
    <!-- Livros em Destaque (Aleatórios) -->
    <x-books.featured-grid
        :books="$featuredBooks"
        title="Livros em Destaque"
        icon="star"
        iconColor="#8b5cf6"
        emptyMessage="Nenhum livro disponível no momento."
        viewRoute="livros.show"
        indexRoute="livros.index"
        layout="grid"
    />

    <!-- Últimas Atividades -->
    <x-ui.card
        title="Últimas Atividades"
        icon="clock"
        iconColor="#ec4899"
        borderColor="#fbcfe8"
        shadowColor="rgba(236, 72, 153, 0.15)"
        backgroundGradient="white"
        headerClass="display: flex; align-items: center; gap: 12px;"
    >
        @if($recentActivities->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 12px; max-height: 400px; overflow-y: auto; padding-right: 8px;">
                @foreach($recentActivities as $activity)
                    <x-activities.activity-item
                        :route="$activity['route']"
                        :icon="$activity['icon']"
                        :title="$activity['title']"
                        :type="$activity['type']"
                        :action="$activity['action']"
                        :date="$activity['date']"
                        :color="$activity['color']"
                    />
                @endforeach
            </div>
            <x-slot name="footer">
                <div style="display: flex; gap: 12px; flex-wrap: wrap; justify-content: center;">
                    <x-ui.button 
                        href="{{ route('meus-alugueis') }}" 
                        variant="secondary"
                        class="background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border-color: #e9d5ff;"
                    >
                        Meus Aluguéis
                    </x-ui.button>
                    <x-ui.button 
                        href="{{ route('minhas-reservas') }}" 
                        variant="secondary"
                        class="background: linear-gradient(135deg, #fce7f3, #fdf2f8); color: #ec4899; border-color: #fbcfe8;"
                    >
                        Minhas Reservas
                    </x-ui.button>
                    <x-ui.button 
                        href="{{ route('minhas-multas') }}" 
                        variant="secondary"
                        class="background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #ef4444; border-color: #fca5a5;"
                    >
                        Minhas Multas
                    </x-ui.button>
                    @if($user->isAdmin())
                        <x-ui.button href="{{ route('admin.alugueis.index') }}" variant="primary" icon="settings">
                            Gerenciar Aluguéis
                        </x-ui.button>
                    @endif
                </div>
            </x-slot>
        @else
            <x-ui.empty-state
                icon="activity"
                message="Nenhuma atividade recente."
                iconColor="#ec4899"
                backgroundGradient="linear-gradient(135deg, #fce7f3, #fff1f2)"
            >
                <div style="display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; margin-top: 24px;">
                    <x-ui.button 
                        href="{{ route('meus-alugueis') }}" 
                        variant="secondary"
                        class="background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border-color: #e9d5ff;"
                    >
                        Meus Aluguéis
                    </x-ui.button>
                    <x-ui.button 
                        href="{{ route('minhas-reservas') }}" 
                        variant="secondary"
                        class="background: linear-gradient(135deg, #fce7f3, #fdf2f8); color: #ec4899; border-color: #fbcfe8;"
                    >
                        Minhas Reservas
                    </x-ui.button>
                    <x-ui.button 
                        href="{{ route('minhas-multas') }}" 
                        variant="secondary"
                        class="background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #ef4444; border-color: #fca5a5;"
                    >
                        Minhas Multas
                    </x-ui.button>
                    @if($user->isAdmin())
                        <x-ui.button href="{{ route('admin.alugueis.index') }}" variant="primary" icon="settings">
                            Gerenciar Aluguéis
                        </x-ui.button>
                    @endif
                </div>
            </x-ui.empty-state>
        @endif
    </x-ui.card>
</div>
@endsection
