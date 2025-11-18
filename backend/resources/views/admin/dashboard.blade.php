@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    $totalBooks = \App\Models\Book::count();
    $totalUsers = \App\Models\User::count();
    $totalRentals = \App\Models\Rental::where('status', \App\Enums\RentalStatus::ATIVO)->count();
    $totalReservations = \App\Models\Reservation::whereIn('status', [\App\Enums\ReservationStatus::PENDENTE, \App\Enums\ReservationStatus::CONFIRMADA])->count();
@endphp

<div style="margin-bottom: 32px;">
    <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Dashboard</h1>
    <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Visão geral do sistema</p>
</div>

<!-- Cards de Estatísticas -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 32px;">
    <!-- Card Total de Livros -->
    <div style="background: linear-gradient(135deg, #f3e8ff, #faf5ff, white); border-radius: 16px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(139, 92, 246, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(139, 92, 246, 0.15)';">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #8b5cf6, #a855f7); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);">
                <i data-lucide="book" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Total de Livros</p>
                <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $totalBooks }}</p>
            </div>
        </div>
    </div>

    <!-- Card Total de Usuários -->
    <div style="background: linear-gradient(135deg, #fce7f3, #fdf2f8, white); border-radius: 16px; padding: 24px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(236, 72, 153, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(236, 72, 153, 0.15)';">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #ec4899, #f472b6); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(236, 72, 153, 0.3);">
                <i data-lucide="users" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Total de Usuários</p>
                <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $totalUsers }}</p>
            </div>
        </div>
    </div>

    <!-- Card Aluguéis Ativos -->
    <div style="background: linear-gradient(135deg, #fff1f2, #fff7ed, white); border-radius: 16px; padding: 24px; border: 3px solid #fed7aa; box-shadow: 0 10px 30px rgba(249, 115, 22, 0.15); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(249, 115, 22, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(249, 115, 22, 0.15)';">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #f97316, #fb923c); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(249, 115, 22, 0.3);">
                <i data-lucide="book-open" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Aluguéis Ativos</p>
                <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $totalRentals }}</p>
            </div>
        </div>
    </div>

    <!-- Card Reservas Pendentes -->
    <div style="background: linear-gradient(135deg, #f0f9ff, #e0f2fe, white); border-radius: 16px; padding: 24px; border: 3px solid #bae6fd; box-shadow: 0 10px 30px rgba(14, 165, 233, 0.15); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(14, 165, 233, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(14, 165, 233, 0.15)';">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #0ea5e9, #38bdf8); border-radius: 14px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);">
                <i data-lucide="clock" style="width: 28px; height: 28px; color: white;"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: 13px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Reservas Pendentes</p>
                <p style="font-size: 32px; font-weight: 900; color: #1f2937; margin: 0;">{{ $totalReservations }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Links Rápidos -->
<div style="background: white; border-radius: 20px; padding: 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15);">
    <h2 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 24px;">Ações Rápidas</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <a href="{{ route('admin.livros.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 16px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; text-decoration: none; transition: all 0.3s; font-weight: 700;" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff'; this.style.transform='translateY(0)';">
            <i data-lucide="book" style="width: 24px; height: 24px;"></i>
            <span>Gerenciar Livros</span>
        </a>
        <a href="{{ route('admin.alugueis.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 16px; background: linear-gradient(135deg, #fce7f3, #fdf2f8); color: #ec4899; border: 3px solid #fbcfe8; border-radius: 12px; text-decoration: none; transition: all 0.3s; font-weight: 700;" onmouseover="this.style.background='linear-gradient(135deg, #ec4899, #f472b6)'; this.style.color='white'; this.style.borderColor='#ec4899'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='linear-gradient(135deg, #fce7f3, #fdf2f8)'; this.style.color='#ec4899'; this.style.borderColor='#fbcfe8'; this.style.transform='translateY(0)';">
            <i data-lucide="book-open" style="width: 24px; height: 24px;"></i>
            <span>Gerenciar Aluguéis</span>
        </a>
        <a href="{{ route('admin.reservas.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 16px; background: linear-gradient(135deg, #fff1f2, #fff7ed); color: #f97316; border: 3px solid #fed7aa; border-radius: 12px; text-decoration: none; transition: all 0.3s; font-weight: 700;" onmouseover="this.style.background='linear-gradient(135deg, #f97316, #fb923c)'; this.style.color='white'; this.style.borderColor='#f97316'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='linear-gradient(135deg, #fff1f2, #fff7ed)'; this.style.color='#f97316'; this.style.borderColor='#fed7aa'; this.style.transform='translateY(0)';">
            <i data-lucide="clock" style="width: 24px; height: 24px;"></i>
            <span>Gerenciar Reservas</span>
        </a>
        <a href="{{ route('admin.usuarios.index') }}" style="display: flex; align-items: center; gap: 12px; padding: 16px; background: linear-gradient(135deg, #f0f9ff, #e0f2fe); color: #0ea5e9; border: 3px solid #bae6fd; border-radius: 12px; text-decoration: none; transition: all 0.3s; font-weight: 700;" onmouseover="this.style.background='linear-gradient(135deg, #0ea5e9, #38bdf8)'; this.style.color='white'; this.style.borderColor='#0ea5e9'; this.style.transform='translateY(-2px)';" onmouseout="this.style.background='linear-gradient(135deg, #f0f9ff, #e0f2fe)'; this.style.color='#0ea5e9'; this.style.borderColor='#bae6fd'; this.style.transform='translateY(0)';">
            <i data-lucide="users" style="width: 24px; height: 24px;"></i>
            <span>Gerenciar Usuários</span>
        </a>
    </div>
</div>
@endsection

