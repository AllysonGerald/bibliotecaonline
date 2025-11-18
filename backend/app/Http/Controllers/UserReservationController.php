<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\ReservationStatus;
use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserReservationController extends Controller
{
    public function __construct(
        private readonly ReservationService $reservationService,
    ) {
    }

    public function index(Request $request): View
    {
        $user = auth()->user();

        $reservations = $this->reservationService->getByUser($user->id);

        // Filtrar por status se fornecido
        if ($request->filled('status')) {
            $reservations = $reservations->filter(fn ($reservation) => $reservation->status->value === $request->status);
        }

        // Separar em grupos
        $pendingReservations = $reservations->where('status', ReservationStatus::PENDENTE)->values();
        $confirmedReservations = $reservations->where('status', ReservationStatus::CONFIRMADA)->values();
        $cancelledReservations = $reservations->where('status', ReservationStatus::CANCELADA)->values();
        $expiredReservations = $reservations->filter(fn ($reservation) => $reservation->isExpired())->values();

        // Se houver filtro de status, usar apenas o grupo correspondente
        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === ReservationStatus::PENDENTE->value) {
                $reservations = $pendingReservations;
            } elseif ($status === ReservationStatus::CONFIRMADA->value) {
                $reservations = $confirmedReservations;
            } elseif ($status === ReservationStatus::CANCELADA->value) {
                $reservations = $cancelledReservations;
            }
        }

        return view('user.reservas', compact('reservations', 'pendingReservations', 'confirmedReservations', 'cancelledReservations', 'expiredReservations'));
    }
}
