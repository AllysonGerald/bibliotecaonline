@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
@php
    $user = auth()->user();
    $activeRentals = $user->rentals()->where('status', 'ativo')->count();
    $pendingReservations = $user->reservations()->whereIn('status', ['pendente', 'confirmada'])->count();
    $wishlistCount = $user->wishlists()->count();
    $reviewsCount = $user->reviews()->count();
@endphp

<div style="margin-bottom: 32px;">
    <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Olá, {{ $user->name }}!</h1>
    <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Bem-vindo de volta à Biblioteca Online</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 32px;">
    <!-- Card Aluguéis Ativos -->
    <div style="background: linear-gradient(135deg, #f3e8ff, #faf5ff, white); border-radius: 16px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(139, 92, 246, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(139, 92, 246, 0.15)';">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);">
                <i data-lucide="book" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Aluguéis Ativos</p>
                <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $activeRentals }}</p>
            </div>
        </div>
    </div>

    <!-- Card Reservas Pendentes -->
    <div style="background: linear-gradient(135deg, #fce7f3, #fdf2f8, white); border-radius: 16px; padding: 24px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(236, 72, 153, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(236, 72, 153, 0.15)';">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #ec4899, #f472b6); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(236, 72, 153, 0.3);">
                <i data-lucide="clock" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Reservas Pendentes</p>
                <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $pendingReservations }}</p>
            </div>
        </div>
    </div>

    <!-- Card Lista de Desejos -->
    <div style="background: linear-gradient(135deg, #fff1f2, #fff7ed, white); border-radius: 16px; padding: 24px; border: 3px solid #fed7aa; box-shadow: 0 10px 30px rgba(249, 115, 22, 0.15); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(249, 115, 22, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(249, 115, 22, 0.15)';">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #f97316, #fb923c); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);">
                <i data-lucide="heart" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Lista de Desejos</p>
                <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $wishlistCount }}</p>
            </div>
        </div>
    </div>

    <!-- Card Avaliações Feitas -->
    <div style="background: linear-gradient(135deg, #faf5ff, #f3e8ff, white); border-radius: 16px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(139, 92, 246, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(139, 92, 246, 0.15)';">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);">
                <i data-lucide="star" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Avaliações Feitas</p>
                <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $reviewsCount }}</p>
            </div>
        </div>
    </div>
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
        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 0;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i data-lucide="book-open" style="width: 40px; height: 40px; color: #8b5cf6;"></i>
            </div>
            <p style="font-size: 16px; color: #6b7280; text-align: center; margin-bottom: 24px; font-weight: 500;">Nenhum livro para exibir no momento.</p>
            <a href="{{ route('livros.index') }}" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-weight: 700; text-decoration: none; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
                <span>Explorar Catálogo</span>
                <i data-lucide="arrow-right" style="width: 18px; height: 18px; margin-left: 8px;"></i>
            </a>
        </div>
    </div>

    <!-- Últimas Atividades -->
    <div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15);">
        <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin-bottom: 24px; display: flex; align-items: center; gap: 12px;">
            <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #ec4899, #f97316); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                <i data-lucide="clock" style="width: 20px; height: 20px; color: white;"></i>
            </div>
            Últimas Atividades
        </h3>
        <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 48px 0;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #fce7f3, #fff1f2); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 20px;">
                <i data-lucide="activity" style="width: 40px; height: 40px; color: #ec4899;"></i>
            </div>
            <p style="font-size: 16px; color: #6b7280; text-align: center; margin-bottom: 24px; font-weight: 500;">Nenhuma atividade recente.</p>
            <div style="display: flex; gap: 12px; flex-wrap: wrap; justify-content: center;">
                <a href="{{ route('meus-alugueis') }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 2px solid #e9d5ff; border-radius: 10px; font-weight: 700; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff';">
                    Meus Aluguéis
                </a>
                <a href="{{ route('minhas-reservas') }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: linear-gradient(135deg, #fce7f3, #fdf2f8); color: #ec4899; border: 2px solid #fbcfe8; border-radius: 10px; font-weight: 700; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='linear-gradient(135deg, #ec4899, #f472b6)'; this.style.color='white'; this.style.borderColor='#ec4899';" onmouseout="this.style.background='linear-gradient(135deg, #fce7f3, #fdf2f8)'; this.style.color='#ec4899'; this.style.borderColor='#fbcfe8';">
                    Minhas Reservas
                </a>
                @if($user->isAdmin())
                    <a href="{{ route('admin.alugueis.index') }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border: 2px solid transparent; border-radius: 10px; font-weight: 700; text-decoration: none; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 6px 20px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 4px 15px rgba(139, 92, 246, 0.3)';">
                        <i data-lucide="settings" style="width: 16px; height: 16px; margin-right: 6px;"></i>
                        Gerenciar Aluguéis
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
