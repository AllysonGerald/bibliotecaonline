@extends('layouts.admin')

@section('title', 'Painel do Admin')

@section('content')
@php
    $user = auth()->user();
    $totalBooks = \App\Models\Book::count();
    $totalUsers = \App\Models\User::count();
    $totalRentals = \App\Models\Rental::where('status', \App\Enums\RentalStatus::ATIVO)->count();
    $totalReservations = \App\Models\Reservation::whereIn('status', [\App\Enums\ReservationStatus::PENDENTE, \App\Enums\ReservationStatus::CONFIRMADA])->count();
    $recentBooks = \App\Models\Book::latest()->take(3)->get();

    // Buscar todas as atividades recentes do sistema
    $activities = collect();

    // Aluguéis (criação e atualização)
    $rentals = \App\Models\Rental::with(['user', 'book'])->latest('updated_at')->take(10)->get();
    foreach ($rentals as $rental) {
        $isNew = $rental->created_at->equalTo($rental->updated_at);
        $activities->push([
            'type' => 'aluguel',
            'action' => $isNew ? 'criado' : 'atualizado',
            'title' => $rental->book->titulo ?? 'Livro removido',
            'user' => $rental->user->name ?? 'Usuário removido',
            'date' => $rental->updated_at,
            'route' => route('admin.alugueis.show', $rental),
            'icon' => 'book',
            'color' => '#8b5cf6',
        ]);
    }

    // Reservas (criação e atualização)
    $reservations = \App\Models\Reservation::with(['user', 'book'])->latest('updated_at')->take(10)->get();
    foreach ($reservations as $reservation) {
        $isNew = $reservation->created_at->equalTo($reservation->updated_at);
        $activities->push([
            'type' => 'reserva',
            'action' => $isNew ? 'criada' : 'atualizada',
            'title' => $reservation->book->titulo ?? 'Livro removido',
            'user' => $reservation->user->name ?? 'Usuário removido',
            'date' => $reservation->updated_at,
            'route' => route('admin.reservas.show', $reservation),
            'icon' => 'clock',
            'color' => '#ec4899',
        ]);
    }

    // Livros (criação e atualização)
    $books = \App\Models\Book::with(['author', 'category'])->latest('updated_at')->take(10)->get();
    foreach ($books as $book) {
        $isNew = $book->created_at->equalTo($book->updated_at);
        $activities->push([
            'type' => 'livro',
            'action' => $isNew ? 'criado' : 'atualizado',
            'title' => $book->titulo,
            'user' => 'Sistema',
            'date' => $book->updated_at,
            'route' => route('admin.livros.show', $book),
            'icon' => 'book-open',
            'color' => '#f97316',
        ]);
    }

    // Usuários (criação e atualização)
    $users = \App\Models\User::latest('updated_at')->take(10)->get();
    foreach ($users as $userItem) {
        $isNew = $userItem->created_at->equalTo($userItem->updated_at);
        $activities->push([
            'type' => 'usuario',
            'action' => $isNew ? 'criado' : 'atualizado',
            'title' => $userItem->name,
            'user' => 'Sistema',
            'date' => $userItem->updated_at,
            'route' => route('admin.usuarios.show', $userItem),
            'icon' => 'user',
            'color' => '#0ea5e9',
        ]);
    }

    // Autores (criação e atualização)
    $authors = \App\Models\Author::latest('updated_at')->take(10)->get();
    foreach ($authors as $author) {
        $isNew = $author->created_at->equalTo($author->updated_at);
        $activities->push([
            'type' => 'autor',
            'action' => $isNew ? 'criado' : 'atualizado',
            'title' => $author->nome,
            'user' => 'Sistema',
            'date' => $author->updated_at,
            'route' => route('admin.autores.show', $author),
            'icon' => 'pen-tool',
            'color' => '#10b981',
        ]);
    }

    // Categorias (criação e atualização)
    $categories = \App\Models\Category::latest('updated_at')->take(10)->get();
    foreach ($categories as $category) {
        $isNew = $category->created_at->equalTo($category->updated_at);
        $activities->push([
            'type' => 'categoria',
            'action' => $isNew ? 'criada' : 'atualizada',
            'title' => $category->nome,
            'user' => 'Sistema',
            'date' => $category->updated_at,
            'route' => route('admin.categorias.show', $category),
            'icon' => 'tag',
            'color' => '#8b5cf6',
        ]);
    }

    // Ordenar por data (mais recente primeiro) e pegar os 5 mais recentes
    $recentActivities = $activities->sortByDesc('date')->take(5)->values();
@endphp

<div style="margin-bottom: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 16px;">
        <div>
            <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Olá, {{ $user->name }}!</h1>
            <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Painel do Administrador</p>
        </div>
        <a href="{{ route('home') }}" style="display: inline-flex; align-items: center; padding: 12px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 15px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.15)';">
            <i data-lucide="arrow-left" style="width: 18px; height: 18px; margin-right: 8px;"></i>
            Home
        </a>
    </div>
</div>

<!-- Cards de Estatísticas -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 32px;">
    <!-- Card Aluguéis Ativos -->
    <a href="{{ route('admin.alugueis.index') }}" style="text-decoration: none; display: block;">
        <div style="background: linear-gradient(135deg, #f3e8ff, #faf5ff, white); border-radius: 16px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); transition: all 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(139, 92, 246, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(139, 92, 246, 0.15)';">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);">
                    <i data-lucide="book" style="width: 28px; height: 28px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Aluguéis Ativos</p>
                    <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $totalRentals }}</p>
                </div>
            </div>
        </div>
    </a>

    <!-- Card Reservas Pendentes -->
    <a href="{{ route('admin.reservas.index') }}" style="text-decoration: none; display: block;">
        <div style="background: linear-gradient(135deg, #fce7f3, #fdf2f8, white); border-radius: 16px; padding: 24px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15); transition: all 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(236, 72, 153, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(236, 72, 153, 0.15)';">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #ec4899, #f472b6); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(236, 72, 153, 0.3);">
                    <i data-lucide="clock" style="width: 28px; height: 28px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Reservas Pendentes</p>
                    <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $totalReservations }}</p>
                </div>
            </div>
        </div>
    </a>

    <!-- Card Total de Livros -->
    <a href="{{ route('admin.livros.index') }}" style="text-decoration: none; display: block;">
        <div style="background: linear-gradient(135deg, #fff1f2, #fff7ed, white); border-radius: 16px; padding: 24px; border: 3px solid #fed7aa; box-shadow: 0 10px 30px rgba(249, 115, 22, 0.15); transition: all 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(249, 115, 22, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(249, 115, 22, 0.15)';">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #f97316, #fb923c); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);">
                    <i data-lucide="book-open" style="width: 28px; height: 28px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Total de Livros</p>
                    <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $totalBooks }}</p>
                </div>
            </div>
        </div>
    </a>

    <!-- Card Total de Usuários -->
    <a href="{{ route('admin.usuarios.index') }}" style="text-decoration: none; display: block;">
        <div style="background: linear-gradient(135deg, #e0f2fe, #f0f9ff, white); border-radius: 16px; padding: 24px; border: 3px solid #bae6fd; box-shadow: 0 10px 30px rgba(14, 165, 233, 0.15); transition: all 0.3s; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(14, 165, 233, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(14, 165, 233, 0.15)';">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);">
                    <i data-lucide="users" style="width: 28px; height: 28px; color: white;"></i>
                </div>
                <div style="flex: 1;">
                    <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Total de Usuários</p>
                    <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>
    </a>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 24px;">
    <!-- Livros em Destaque -->
    <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);">
        <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #8b5cf6, #ec4899); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="star" style="width: 20px; height: 20px; color: white;"></i>
            </div>
            Livros em Destaque
        </h3>
        @if($recentBooks->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 16px;">
                @foreach($recentBooks as $book)
                    <a href="{{ route('admin.livros.show', $book) }}" style="display: flex; align-items: center; gap: 16px; padding: 16px; background: linear-gradient(135deg, #faf5ff, #f3e8ff); border: 2px solid #e9d5ff; border-radius: 12px; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #f3e8ff, #e9d5ff)'; this.style.borderColor='#8b5cf6'; this.style.transform='translateX(4px)';" onmouseout="this.style.background='linear-gradient(135deg, #faf5ff, #f3e8ff)'; this.style.borderColor='#e9d5ff'; this.style.transform='translateX(0)';">
                        <div style="width: 60px; height: 80px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            @if($book->imagem_capa)
                                <img src="{{ $book->imagem_capa }}" alt="{{ $book->titulo }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 8px;">
                            @else
                                <i data-lucide="book-open" style="width: 30px; height: 30px; color: #8b5cf6;"></i>
                            @endif
                        </div>
                        <div style="flex: 1; min-width: 0;">
                            <h4 style="font-size: 16px; font-weight: 900; color: #1f2937; margin-bottom: 4px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $book->titulo }}</h4>
                            <p style="font-size: 14px; color: #6b7280; font-weight: 600; margin-bottom: 4px;">{{ $book->author->nome }}</p>
                            <p style="font-size: 12px; color: #9ca3af;">{{ $book->category->nome }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
            <div style="margin-top: 20px;">
                <a href="{{ route('admin.livros.index') }}" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-weight: 700; text-decoration: none; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
                    <span>Explorar Catálogo</span>
                    <i data-lucide="arrow-right" style="width: 18px; height: 18px; margin-left: 8px;"></i>
                </a>
            </div>
        @else
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 0;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <i data-lucide="book-open" style="width: 40px; height: 40px; color: #8b5cf6;"></i>
                </div>
                <p style="font-size: 16px; color: #6b7280; text-align: center; margin-bottom: 24px; font-weight: 500;">Nenhum livro para exibir no momento.</p>
                <a href="{{ route('admin.livros.index') }}" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-weight: 700; text-decoration: none; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
                    <span>Explorar Catálogo</span>
                    <i data-lucide="arrow-right" style="width: 18px; height: 18px; margin-left: 8px;"></i>
                </a>
            </div>
        @endif
    </div>

    <!-- Últimas Atividades -->
    <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15);">
        <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ec4899, #f97316); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="clock" style="width: 20px; height: 20px; color: white;"></i>
            </div>
            Últimas Atividades
        </h3>
        @if($recentActivities->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 12px; max-height: 500px; overflow-y: auto; padding-right: 8px;">
                @foreach($recentActivities as $activity)
                    <a href="{{ $activity['route'] }}" style="display: block; text-decoration: none;">
                        <div style="padding: 16px; background: linear-gradient(135deg, #faf5ff, #fdf2f8); border: 2px solid #fbcfe8; border-radius: 12px; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #fce7f3, #fdf2f8)'; this.style.borderColor='#ec4899'; this.style.transform='translateX(4px)';" onmouseout="this.style.background='linear-gradient(135deg, #faf5ff, #fdf2f8)'; this.style.borderColor='#fbcfe8'; this.style.transform='translateX(0)';">
                            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                                <div style="flex: 1; display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 32px; background: linear-gradient(135deg, {{ $activity['color'] }}, {{ $activity['color'] }}); border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                        <i data-lucide="{{ $activity['icon'] }}" style="width: 18px; height: 18px; color: white;"></i>
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
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('admin.livros.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #fff1f2, #fff7ed); color: #f97316; border: 2px solid #fed7aa; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(249, 115, 22, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #f97316, #fb923c)'; this.style.color='white'; this.style.borderColor='#f97316'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(249, 115, 22, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #fff1f2, #fff7ed)'; this.style.color='#f97316'; this.style.borderColor='#fed7aa'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(249, 115, 22, 0.15)';" title="Gerenciar Livros">
                        <i data-lucide="book-open" style="width: 20px; height: 20px;"></i>
                    </a>
                    <a href="{{ route('admin.alugueis.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 2px solid #e9d5ff; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(139, 92, 246, 0.15)';" title="Gerenciar Aluguéis">
                        <i data-lucide="book" style="width: 20px; height: 20px;"></i>
                    </a>
                    <a href="{{ route('admin.reservas.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #fce7f3, #fdf2f8); color: #ec4899; border: 2px solid #fbcfe8; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(236, 72, 153, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #ec4899, #f472b6)'; this.style.color='white'; this.style.borderColor='#ec4899'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(236, 72, 153, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #fce7f3, #fdf2f8)'; this.style.color='#ec4899'; this.style.borderColor='#fbcfe8'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(236, 72, 153, 0.15)';" title="Gerenciar Reservas">
                        <i data-lucide="clock" style="width: 20px; height: 20px;"></i>
                    </a>
                    <a href="{{ route('admin.usuarios.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #e0f2fe, #f0f9ff); color: #0ea5e9; border: 2px solid #bae6fd; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(14, 165, 233, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #0ea5e9, #38bdf8)'; this.style.color='white'; this.style.borderColor='#0ea5e9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(14, 165, 233, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #e0f2fe, #f0f9ff)'; this.style.color='#0ea5e9'; this.style.borderColor='#bae6fd'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(14, 165, 233, 0.15)';" title="Gerenciar Usuários">
                        <i data-lucide="users" style="width: 20px; height: 20px;"></i>
                    </a>
                </div>
            </div>
        @else
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 0;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #fce7f3, #fff1f2); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                    <i data-lucide="activity" style="width: 40px; height: 40px; color: #ec4899;"></i>
                </div>
                <p style="font-size: 16px; color: #6b7280; text-align: center; margin-bottom: 24px; font-weight: 500;">Nenhuma atividade recente.</p>
                <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <a href="{{ route('admin.livros.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #fff1f2, #fff7ed); color: #f97316; border: 2px solid #fed7aa; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(249, 115, 22, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #f97316, #fb923c)'; this.style.color='white'; this.style.borderColor='#f97316'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(249, 115, 22, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #fff1f2, #fff7ed)'; this.style.color='#f97316'; this.style.borderColor='#fed7aa'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(249, 115, 22, 0.15)';" title="Gerenciar Livros">
                        <i data-lucide="book-open" style="width: 20px; height: 20px;"></i>
                    </a>
                    <a href="{{ route('admin.alugueis.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 2px solid #e9d5ff; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(139, 92, 246, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(139, 92, 246, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(139, 92, 246, 0.15)';" title="Gerenciar Aluguéis">
                        <i data-lucide="book" style="width: 20px; height: 20px;"></i>
                    </a>
                    <a href="{{ route('admin.reservas.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #fce7f3, #fdf2f8); color: #ec4899; border: 2px solid #fbcfe8; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(236, 72, 153, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #ec4899, #f472b6)'; this.style.color='white'; this.style.borderColor='#ec4899'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(236, 72, 153, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #fce7f3, #fdf2f8)'; this.style.color='#ec4899'; this.style.borderColor='#fbcfe8'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(236, 72, 153, 0.15)';" title="Gerenciar Reservas">
                        <i data-lucide="clock" style="width: 20px; height: 20px;"></i>
                    </a>
                    <a href="{{ route('admin.usuarios.index') }}" style="display: inline-flex; align-items: center; justify-content: center; width: 48px; height: 48px; background: linear-gradient(135deg, #e0f2fe, #f0f9ff); color: #0ea5e9; border: 2px solid #bae6fd; border-radius: 12px; text-decoration: none; transition: all 0.3s; box-shadow: 0 2px 5px rgba(14, 165, 233, 0.15);" onmouseover="this.style.background='linear-gradient(135deg, #0ea5e9, #38bdf8)'; this.style.color='white'; this.style.borderColor='#0ea5e9'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 10px rgba(14, 165, 233, 0.3)';" onmouseout="this.style.background='linear-gradient(135deg, #e0f2fe, #f0f9ff)'; this.style.color='#0ea5e9'; this.style.borderColor='#bae6fd'; this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 5px rgba(14, 165, 233, 0.15)';" title="Gerenciar Usuários">
                        <i data-lucide="users" style="width: 20px; height: 20px;"></i>
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
