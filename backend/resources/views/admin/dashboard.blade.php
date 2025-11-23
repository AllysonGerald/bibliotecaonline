@extends('layouts.admin')

@section('title', 'Painel do Admin')

@section('content')

<x-ui.page-header 
    title="Olá, {{ $user->name }}!" 
    subtitle="Painel do Administrador"
>
    <x-ui.button href="{{ route('home') }}" variant="secondary" icon="arrow-left">Home</x-ui.button>
</x-ui.page-header>

<!-- Cards de Estatísticas -->
<div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <x-ui.stat-card
        label="Aluguéis Ativos"
        :value="$totalRentals"
        icon="book"
        iconColor="#8b5cf6"
        backgroundGradient="linear-gradient(135deg, #f3e8ff, #faf5ff, white)"
        borderColor="#e9d5ff"
        shadowColor="rgba(139, 92, 246, 0.15)"
        hoverShadowColor="rgba(139, 92, 246, 0.25)"
        :href="route('admin.alugueis.index')"
    />
    
    <x-ui.stat-card
        label="Reservas Pendentes"
        :value="$totalReservations"
        icon="clock"
        iconColor="#ec4899"
        backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
        borderColor="#fbcfe8"
        shadowColor="rgba(236, 72, 153, 0.15)"
        hoverShadowColor="rgba(236, 72, 153, 0.25)"
        :href="route('admin.reservas.index')"
    />
    
    <x-ui.stat-card
        label="Total de Livros"
        :value="$totalBooks"
        icon="book-open"
        iconColor="#f97316"
        backgroundGradient="linear-gradient(135deg, #fff1f2, #fff7ed, white)"
        borderColor="#fed7aa"
        shadowColor="rgba(249, 115, 22, 0.15)"
        hoverShadowColor="rgba(249, 115, 22, 0.25)"
        :href="route('admin.livros.index')"
    />
    
    <x-ui.stat-card
        label="Total de Usuários"
        :value="$totalUsers"
        icon="users"
        iconColor="#0ea5e9"
        backgroundGradient="linear-gradient(135deg, #e0f2fe, #f0f9ff, white)"
        borderColor="#bae6fd"
        shadowColor="rgba(14, 165, 233, 0.15)"
        hoverShadowColor="rgba(14, 165, 233, 0.25)"
        :href="route('admin.usuarios.index')"
    />
    
    <x-ui.stat-card
        label="Mensagens Não Lidas"
        :value="$totalUnreadContacts"
        icon="mail"
        iconColor="#10b981"
        backgroundGradient="linear-gradient(135deg, #d1fae5, #ecfdf5, white)"
        borderColor="#86efac"
        shadowColor="rgba(16, 185, 129, 0.15)"
        hoverShadowColor="rgba(16, 185, 129, 0.25)"
        :href="route('admin.contatos.index')"
    />
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
    <!-- Livros em Destaque (Mais Alugados) -->
    <x-books.featured-grid
        :books="$featuredBooks"
        title="Livros Mais Alugados"
        icon="trending-up"
        iconColor="#8b5cf6"
        emptyMessage="Nenhum livro para exibir no momento."
        viewRoute="admin.livros.show"
        indexRoute="admin.livros.index"
        layout="grid"
    />

    <!-- Últimas Atividades -->
    <x-ui.card title="Últimas Atividades" icon="clock" iconColor="#ec4899" borderColor="#fbcfe8" shadowColor="rgba(236, 72, 153, 0.15)" backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)">
        @if($recentActivities->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 12px; max-height: 500px; overflow-y: auto; padding-right: 8px;">
                @foreach($recentActivities as $activity)
                    <a href="{{ $activity['route'] }}" style="display: block; text-decoration: none;">
                        <div style="padding: 16px; background: linear-gradient(135deg, #faf5ff, #fdf2f8); border: 2px solid #fbcfe8; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #fce7f3, #fdf2f8)'; this.style.borderColor='#ec4899'; this.style.transform='translateX(4px)';" onmouseout="this.style.background='linear-gradient(135deg, #faf5ff, #fdf2f8)'; this.style.borderColor='#fbcfe8'; this.style.transform='translateX(0)';">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                <div style="flex: 1; display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, {{ $activity['color'] }}, {{ $activity['color'] }}); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <x-ui.icon :name="$activity['icon']" size="18" style="color: white;" />
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <p style="font-size: 14px; font-weight: 900; color: #1f2937; margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $activity['title'] }}</p>
                                        <p style="font-size: 12px; color: #6b7280; font-weight: 600;">{{ ucfirst($activity['type']) }} {{ $activity['action'] }} por {{ $activity['user'] }}</p>
                                    </div>
                                </div>
                                <span style="font-size: 11px; color: #9ca3af; white-space: nowrap; margin-left: 8px;">{{ $activity['date']->format('d/m/Y H:i') }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div style="margin-top: 20px;">
                <div style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
                    <a href="{{ route('admin.livros.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #fff1f2, #fff7ed); color: #f97316; border: 2px solid #fed7aa; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(249, 115, 22, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #f97316, #fb923c)'; this.style.color='white'; this.style.borderColor='#f97316'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(249, 115, 22, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #fff1f2, #fff7ed)'; this.style.color='#f97316'; this.style.borderColor='#fed7aa'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(249, 115, 22, 0.15)';" title="Gerenciar Livros">
                        <x-ui.icon name="book-open" size="20" />
                    </a>
                    <a href="{{ route('admin.alugueis.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 2px solid #e9d5ff; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(139, 92, 246, 0.15)';" title="Gerenciar Aluguéis">
                        <x-ui.icon name="book" size="20" />
                    </a>
                    <a href="{{ route('admin.reservas.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #fce7f3, #fdf2f8); color: #ec4899; border: 2px solid #fbcfe8; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(236, 72, 153, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #ec4899, #f472b6)'; this.style.color='white'; this.style.borderColor='#ec4899'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(236, 72, 153, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #fce7f3, #fdf2f8)'; this.style.color='#ec4899'; this.style.borderColor='#fbcfe8'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(236, 72, 153, 0.15)';" title="Gerenciar Reservas">
                        <x-ui.icon name="clock" size="20" />
                    </a>
                    <a href="{{ route('admin.usuarios.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #e0f2fe, #f0f9ff); color: #0ea5e9; border: 2px solid #bae6fd; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(14, 165, 233, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #0ea5e9, #38bdf8)'; this.style.color='white'; this.style.borderColor='#0ea5e9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(14, 165, 233, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #e0f2fe, #f0f9ff)'; this.style.color='#0ea5e9'; this.style.borderColor='#bae6fd'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(14, 165, 233, 0.15)';" title="Gerenciar Usuários">
                        <x-ui.icon name="users" size="20" />
                    </a>
                    <a href="{{ route('admin.contatos.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #d1fae5, #ecfdf5); color: #10b981; border: 2px solid #86efac; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(16, 185, 129, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #10b981, #34d399)'; this.style.color='white'; this.style.borderColor='#10b981'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(16, 185, 129, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #d1fae5, #ecfdf5)'; this.style.color='#10b981'; this.style.borderColor='#86efac'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(16, 185, 129, 0.15)';" title="Mensagens de Contato">
                        <x-ui.icon name="mail" size="20" />
                    </a>
                    <x-ui.button :href="route('admin.atividades.index')" variant="primary" icon="activity">
                        Ver Todas as Atividades
                    </x-ui.button>
                </div>
            </div>
        @else
            <x-ui.empty-state
                icon="activity"
                message="Nenhuma atividade recente."
            />
        @endif
    </x-ui.card>
</div>
@endsection
