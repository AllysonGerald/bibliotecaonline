<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Reservations\CreateReservationAction;
use App\DTOs\ReservationDTO;
use App\Enums\ReservationStatus;
use App\Models\Book;
use App\Services\ReservationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserReservationController extends Controller
{
    public function __construct(
        private readonly ReservationService $reservationService,
        private readonly CreateReservationAction $createReservationAction,
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

    public function store(Request $request, Book $livro): RedirectResponse
    {
        $user = auth()->user();

        // Recarregar o livro para garantir que temos os dados atualizados
        $livro->refresh();

        // Verificar se o usuário já tem uma reserva ativa deste livro
        $existingReservation = $this->reservationService->getByUser($user->id)
            ->where('livro_id', $livro->id)
            ->whereIn('status', [ReservationStatus::PENDENTE, ReservationStatus::CONFIRMADA])
            ->first();

        if ($existingReservation) {
            return redirect()->back()
                ->with('error', 'Você já possui uma reserva ativa deste livro.')
            ;
        }

        // Criar a reserva (prazo padrão: 7 dias)
        $reservadoEm = now();
        $expiraEm = $reservadoEm->copy()->addDays(7);

        $dto = new ReservationDTO(
            usuarioId: $user->id,
            livroId: $livro->id,
            reservadoEm: $reservadoEm,
            expiraEm: $expiraEm,
            status: ReservationStatus::PENDENTE,
        );

        $this->createReservationAction->execute($dto);

        return redirect()->route('minhas-reservas')
            ->with('success', 'Livro reservado com sucesso! A reserva expira em '.$expiraEm->format('d/m/Y'))
        ;
    }
}
