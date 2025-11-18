@extends('layouts.app')

@section('title', 'Minhas Reservas')

@section('content')
<div style="margin-bottom: 32px;">
    <h1 style="font-size: 36px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">Minhas Reservas</h1>
    <p style="font-size: 18px; color: #6b7280; font-weight: 500;">Gerencie suas reservas de livros</p>
</div>

<!-- Filtros -->
<div style="background: white; border-radius: 20px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); margin-bottom: 32px;">
    <form method="GET" action="{{ route('minhas-reservas') }}" style="display: flex; gap: 12px; flex-wrap: wrap;">
        <a href="{{ route('minhas-reservas') }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: {{ !request('status') ? 'linear-gradient(135deg, #8b5cf6, #ec4899)' : 'linear-gradient(135deg, #f3e8ff, #faf5ff)' }}; color: {{ !request('status') ? 'white' : '#8b5cf6' }}; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; border: {{ !request('status') ? 'none' : '3px solid #e9d5ff' }}; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
            Todos ({{ $reservations->count() }})
        </a>
        <a href="{{ route('minhas-reservas', ['status' => 'pendente']) }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: {{ request('status') === 'pendente' ? 'linear-gradient(135deg, #fbbf24, #f59e0b)' : 'linear-gradient(135deg, #fef3c7, #fde68a)' }}; color: {{ request('status') === 'pendente' ? 'white' : '#92400e' }}; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; border: {{ request('status') === 'pendente' ? 'none' : '3px solid #fde68a' }}; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
            Pendentes ({{ $pendingReservations->count() }})
        </a>
        <a href="{{ route('minhas-reservas', ['status' => 'confirmada']) }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: {{ request('status') === 'confirmada' ? 'linear-gradient(135deg, #10b981, #059669)' : 'linear-gradient(135deg, #d1fae5, #a7f3d0)' }}; color: {{ request('status') === 'confirmada' ? 'white' : '#065f46' }}; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; border: {{ request('status') === 'confirmada' ? 'none' : '3px solid #a7f3d0' }}; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
            Confirmadas ({{ $confirmedReservations->count() }})
        </a>
        <a href="{{ route('minhas-reservas', ['status' => 'cancelada']) }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: {{ request('status') === 'cancelada' ? 'linear-gradient(135deg, #ef4444, #dc2626)' : 'linear-gradient(135deg, #fee2e2, #fef2f2)' }}; color: {{ request('status') === 'cancelada' ? 'white' : '#991b1b' }}; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; border: {{ request('status') === 'cancelada' ? 'none' : '3px solid #fca5a5' }}; transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)';" onmouseout="this.style.transform='scale(1)';">
            Canceladas ({{ $cancelledReservations->count() }})
        </a>
    </form>
</div>

<!-- Lista de Reservas -->
@if($reservations->count() > 0)
    <div style="display: flex; flex-direction: column; gap: 20px;">
        @foreach($reservations as $reservation)
            <div style="background: white; border-radius: 20px; padding: 24px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); transition: all 0.3s; position: relative; overflow: hidden;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 15px 40px rgba(139, 92, 246, 0.25)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 30px rgba(139, 92, 246, 0.15)';">
                <!-- Decorative background -->
                <div style="position: absolute; top: -30px; right: -30px; width: 120px; height: 120px; background: rgba(139, 92, 246, 0.1); border-radius: 50%; filter: blur(40px); z-index: 0;"></div>
                
                <div style="position: relative; z-index: 1; display: grid; grid-template-columns: 1fr; gap: 20px; @media (min-width: 768px) { grid-template-columns: 120px 1fr auto; }">
                    <!-- Imagem do Livro -->
                    <div style="width: 100%; height: 160px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; @media (min-width: 768px) { width: 120px; height: 160px; }">
                        @if($reservation->book->imagem_capa)
                            <img src="{{ $reservation->book->imagem_capa }}" alt="{{ $reservation->book->titulo }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <i data-lucide="book-open" style="width: 48px; height: 48px; color: #8b5cf6;"></i>
                        @endif
                    </div>

                    <!-- Informações da Reserva -->
                    <div style="flex: 1;">
                        <h3 style="font-size: 22px; font-weight: 900; color: #1f2937; margin-bottom: 8px;">{{ $reservation->book->titulo }}</h3>
                        <p style="font-size: 16px; color: #6b7280; font-weight: 600; margin-bottom: 16px;">{{ $reservation->book->author->nome }}</p>
                        
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 16px;">
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Reservado em</label>
                                <p style="font-size: 14px; color: #1f2937; font-weight: 600;">{{ $reservation->reservado_em->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label style="display: block; font-size: 12px; font-weight: 700; color: #6b7280; margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.5px;">Expira em</label>
                                <p style="font-size: 14px; color: {{ $reservation->isExpired() ? '#ef4444' : '#1f2937' }}; font-weight: 600;">
                                    {{ $reservation->expira_em->format('d/m/Y') }}
                                    @if($reservation->isExpired())
                                        <span style="color: #ef4444; font-size: 12px;">(Expirada)</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Status -->
                        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                            @php
                                $statusConfig = [
                                    'pendente' => ['bg' => 'linear-gradient(135deg, #fef3c7, #fde68a)', 'color' => '#92400e', 'border' => '#fde68a', 'label' => 'Pendente'],
                                    'confirmada' => ['bg' => 'linear-gradient(135deg, #d1fae5, #a7f3d0)', 'color' => '#065f46', 'border' => '#a7f3d0', 'label' => 'Confirmada'],
                                    'cancelada' => ['bg' => 'linear-gradient(135deg, #fee2e2, #fef2f2)', 'color' => '#991b1b', 'border' => '#fca5a5', 'label' => 'Cancelada'],
                                    'expirada' => ['bg' => 'linear-gradient(135deg, #f3f4f6, #e5e7eb)', 'color' => '#374151', 'border' => '#d1d5db', 'label' => 'Expirada'],
                                ];
                                $status = $statusConfig[$reservation->status->value] ?? $statusConfig['pendente'];
                            @endphp
                            <span style="display: inline-block; padding: 8px 16px; background: {{ $status['bg'] }}; color: {{ $status['color'] }}; border-radius: 10px; font-size: 13px; font-weight: 700; border: 2px solid {{ $status['border'] }};">
                                {{ $status['label'] }}
                            </span>
                            @if($reservation->isExpired())
                                <span style="display: inline-block; padding: 8px 16px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border-radius: 10px; font-size: 13px; font-weight: 700; border: 2px solid #fca5a5;">
                                    Reserva Expirada
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Ações -->
                    <div style="display: flex; flex-direction: column; gap: 12px; justify-content: center; @media (min-width: 768px) { align-items: flex-end; }">
                        <a href="{{ route('livros.show', $reservation->book) }}" style="display: inline-flex; align-items: center; padding: 10px 20px; background: linear-gradient(135deg, #f3e8ff, #faf5ff); color: #8b5cf6; border: 3px solid #e9d5ff; border-radius: 12px; font-size: 14px; font-weight: 700; text-decoration: none; transition: all 0.3s; white-space: nowrap;" onmouseover="this.style.background='linear-gradient(135deg, #8b5cf6, #a855f7)'; this.style.color='white'; this.style.borderColor='#8b5cf6';" onmouseout="this.style.background='linear-gradient(135deg, #f3e8ff, #faf5ff)'; this.style.color='#8b5cf6'; this.style.borderColor='#e9d5ff';">
                            <i data-lucide="book-open" style="width: 16px; height: 16px; margin-right: 6px;"></i>
                            Ver Livro
                        </a>
                        @if($reservation->status === \App\Enums\ReservationStatus::PENDENTE || $reservation->status === \App\Enums\ReservationStatus::CONFIRMADA)
                            <form method="POST" action="#" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja cancelar esta reserva?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="display: inline-flex; align-items: center; padding: 10px 20px; background: linear-gradient(135deg, #fee2e2, #fef2f2); color: #991b1b; border: 3px solid #fca5a5; border-radius: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all 0.3s; white-space: nowrap;" onmouseover="this.style.background='linear-gradient(135deg, #ef4444, #dc2626)'; this.style.color='white'; this.style.borderColor='#ef4444';" onmouseout="this.style.background='linear-gradient(135deg, #fee2e2, #fef2f2)'; this.style.color='#991b1b'; this.style.borderColor='#fca5a5';">
                                    <i data-lucide="x-circle" style="width: 16px; height: 16px; margin-right: 6px;"></i>
                                    Cancelar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div style="background: white; border-radius: 20px; padding: 64px 32px; border: 3px solid #e9d5ff; box-shadow: 0 10px 30px rgba(139, 92, 246, 0.15); text-align: center;">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #f3e8ff, #fce7f3); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px;">
            <i data-lucide="clock" style="width: 40px; height: 40px; color: #8b5cf6;"></i>
        </div>
        <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 12px;">Nenhuma reserva encontrada</h3>
        <p style="font-size: 16px; color: #6b7280; font-weight: 500; margin-bottom: 24px;">
            @if(request('status'))
                Não há reservas com este status.
            @else
                Você ainda não possui reservas registradas.
            @endif
        </p>
        <a href="{{ route('livros.index') }}" style="display: inline-flex; align-items: center; padding: 12px 24px; background: linear-gradient(135deg, #8b5cf6, #ec4899); color: white; border-radius: 12px; font-weight: 700; text-decoration: none; box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 10px 25px rgba(139, 92, 246, 0.4)';" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 8px 20px rgba(139, 92, 246, 0.3)';">
            <span>Explorar Catálogo</span>
            <i data-lucide="arrow-right" style="width: 18px; height: 18px; margin-left: 8px;"></i>
        </a>
    </div>
@endif
@endsection

