@extends('layouts.app')

@section('title', 'Minhas Reservas')

@section('content')
<x-ui.page-header
    title="Minhas Reservas"
    subtitle="Gerencie suas reservas de livros"
/>

<!-- Filtros -->
<x-ui.card
    title="Filtros"
    icon="filter"
    iconColor="#ec4899"
    borderColor="#fbcfe8"
    shadowColor="rgba(236, 72, 153, 0.15)"
    backgroundGradient="white"
    class="margin-bottom: 32px;"
>
    <div style="display: flex; gap: 12px; flex-wrap: wrap;">
        <x-ui.button
            href="{{ route('minhas-reservas') }}"
            variant="secondary"
            class="padding: 12px 24px; font-size: 14px; font-weight: 700; {{ !request('status') ? 'background: linear-gradient(135deg, #ec4899, #f472b6); color: white; border-color: #ec4899;' : 'background: linear-gradient(135deg, #fce7f3, #fdf2f8); color: #ec4899; border-color: #fbcfe8;' }}"
        >
            Todos ({{ $reservations->count() }})
        </x-ui.button>
        <x-ui.button
            href="{{ route('minhas-reservas', ['status' => 'pendente']) }}"
            variant="secondary"
            class="padding: 12px 24px; font-size: 14px; font-weight: 700; {{ request('status') === 'pendente' ? 'background: linear-gradient(135deg, #fbbf24, #f59e0b); color: white; border-color: #fbbf24;' : 'background: linear-gradient(135deg, #fef3c7, #fde68a); color: #92400e; border-color: #fde68a;' }}"
        >
            Pendentes ({{ $pendingReservations->count() }})
        </x-ui.button>
        <x-ui.button
            href="{{ route('minhas-reservas', ['status' => 'confirmada']) }}"
            variant="secondary"
            class="padding: 12px 24px; font-size: 14px; font-weight: 700; {{ request('status') === 'confirmada' ? 'background: linear-gradient(135deg, #10b981, #059669); color: white; border-color: #10b981;' : 'background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; border-color: #a7f3d0;' }}"
        >
            Confirmadas ({{ $confirmedReservations->count() }})
        </x-ui.button>
        <x-ui.button
            href="{{ route('minhas-reservas', ['status' => 'cancelada']) }}"
            variant="secondary"
            class="padding: 12px 24px; font-size: 14px; font-weight: 700; {{ request('status') === 'cancelada' ? 'background: linear-gradient(135deg, #ef4444, #dc2626); color: white; border-color: #ef4444;' : 'background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; border-color: #fecaca;' }}"
        >
            Canceladas ({{ $cancelledReservations->count() }})
        </x-ui.button>
    </div>
</x-ui.card>

<!-- Lista de Reservas -->
@if($reservations->count() > 0)
    <div style="display: flex; flex-direction: column; gap: 24px;">
        @foreach($reservations as $reservation)
            <div class="reservation-card-hover" style="background: white; border-radius: 20px; padding: 24px; border: 3px solid #fbcfe8; box-shadow: 0 10px 30px rgba(236, 72, 153, 0.15); transition: all 0.3s; position: relative; overflow: hidden;">
                <!-- Decorative top bar -->
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 6px; background: linear-gradient(90deg, #ec4899, #f472b6);"></div>
                
                <!-- Decorative background -->
                <div style="position: absolute; top: -50px; right: -50px; width: 150px; height: 150px; background: rgba(236, 72, 153, 0.08); border-radius: 50%; filter: blur(40px); z-index: 0;"></div>

                <div style="position: relative; z-index: 1; display: grid; grid-template-columns: 1fr; gap: 24px; @media (min-width: 768px) { grid-template-columns: 140px 1fr auto; }">
                    <!-- Imagem do Livro -->
                    <div style="width: 100%; height: 180px; background: linear-gradient(135deg, #fce7f3, #fdf2f8); border-radius: 16px; display: flex; align-items: center; justify-content: center; overflow: hidden; box-shadow: 0 4px 12px rgba(236, 72, 153, 0.2); @media (min-width: 768px) { width: 140px; height: 180px; }">
                        @if($reservation->book->imagem_capa)
                            <img src="{{ $reservation->book->imagem_capa }}" alt="{{ $reservation->book->titulo }}" style="width: 100%; height: 100%; object-fit: cover;">
                        @else
                            <x-ui.icon name="book-open" size="56" style="color: #ec4899;" />
                        @endif
                    </div>

                    <!-- Informações da Reserva -->
                    <div style="flex: 1; display: flex; flex-direction: column; gap: 16px;">
                        <div>
                            <h3 style="font-size: 24px; font-weight: 900; color: #1f2937; margin-bottom: 8px; line-height: 1.3;">{{ $reservation->book->titulo }}</h3>
                            <p style="font-size: 16px; color: #6b7280; font-weight: 600; margin: 0;">{{ $reservation->book->author?->nome ?? 'Autor desconhecido' }}</p>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 20px; padding: 16px; background: linear-gradient(135deg, #fce7f3, #fdf2f8); border-radius: 12px; border: 2px solid #fbcfe8;">
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Reservado em</label>
                                <p style="font-size: 15px; color: #1f2937; font-weight: 700; margin: 0;">{{ $reservation->reservado_em->format('d/m/Y') }}</p>
                            </div>
                            <div>
                                <label style="display: block; font-size: 11px; font-weight: 700; color: #9ca3af; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Expira em</label>
                                <p style="font-size: 15px; color: {{ $reservation->isExpired() ? '#ef4444' : '#1f2937' }}; font-weight: 700; margin: 0;">
                                    {{ $reservation->expira_em->format('d/m/Y') }}
                                    @if($reservation->isExpired())
                                        <span style="color: #ef4444; font-size: 12px; font-weight: 600;">(Expirada)</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <!-- Status -->
                        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
                            @php
                                $statusConfig = [
                                    'pendente' => ['variant' => 'warning', 'label' => 'Pendente'],
                                    'confirmada' => ['variant' => 'success', 'label' => 'Confirmada'],
                                    'cancelada' => ['variant' => 'danger', 'label' => 'Cancelada'],
                                    'expirada' => ['variant' => 'default', 'label' => 'Expirada'],
                                ];
                                $status = $statusConfig[$reservation->status->value] ?? $statusConfig['pendente'];
                            @endphp
                            <x-ui.badge :variant="$status['variant']">{{ $status['label'] }}</x-ui.badge>
                            @if($reservation->isExpired())
                                <x-ui.badge variant="danger">Reserva Expirada</x-ui.badge>
                            @endif
                        </div>
                    </div>

                    <!-- Ações -->
                    <div style="display: flex; flex-direction: column; gap: 12px; justify-content: center; @media (min-width: 768px) { align-items: flex-end; }">
                        <x-ui.button
                            href="{{ route('livros.show', $reservation->book) }}"
                            variant="secondary"
                            icon="book-open"
                            class="padding: 12px 24px; font-size: 14px; font-weight: 700; white-space: nowrap; background: linear-gradient(135deg, #fce7f3, #fdf2f8); color: #ec4899; border-color: #fbcfe8; width: 100%; @media (min-width: 768px) { width: auto; }"
                        >
                            Ver Livro
                        </x-ui.button>
                        @if($reservation->status === \App\Enums\ReservationStatus::PENDENTE || $reservation->status === \App\Enums\ReservationStatus::CONFIRMADA)
                            <form method="POST" action="#" style="display: inline; width: 100%; @media (min-width: 768px) { width: auto; }" onsubmit="return confirm('Tem certeza que deseja cancelar esta reserva?');">
                                @csrf
                                @method('DELETE')
                                <x-ui.button
                                    type="submit"
                                    variant="danger"
                                    icon="x-circle"
                                    class="padding: 12px 24px; font-size: 14px; font-weight: 700; white-space: nowrap; width: 100%; @media (min-width: 768px) { width: auto; }"
                                >
                                    Cancelar
                                </x-ui.button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <style>
        .reservation-card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 40px rgba(236, 72, 153, 0.25) !important;
            border-color: #ec4899 !important;
        }
    </style>
@else
    <x-ui.card
        class="text-align: center;"
        borderColor="#fbcfe8"
        shadowColor="rgba(236, 72, 153, 0.15)"
        backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8, white)"
    >
        <x-ui.empty-state
            title="Nenhuma reserva encontrada"
            :message="request('status') ? 'Não há reservas com este status.' : 'Você ainda não possui reservas registradas.'"
            icon="clock"
            iconColor="#ec4899"
            backgroundGradient="linear-gradient(135deg, #fce7f3, #fdf2f8)"
        />
        <div style="margin-top: 24px;">
            <x-ui.button
                href="{{ route('livros.index') }}"
                variant="primary"
                icon="arrow-right"
            >
                Explorar Catálogo
            </x-ui.button>
        </div>
    </x-ui.card>
@endif
@endsection
