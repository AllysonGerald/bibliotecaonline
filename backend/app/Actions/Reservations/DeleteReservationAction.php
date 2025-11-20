<?php

declare(strict_types=1);

namespace App\Actions\Reservations;

use App\Models\Reservation;
use App\Services\ReservationService;

/**
 * Action responsável por remover uma reserva do sistema.
 */
final readonly class DeleteReservationAction
{
    public function __construct(
        private ReservationService $reservationService,
    ) {
    }

    /**
     * Executa a remoção de uma reserva.
     *
     * @param Reservation $reservation Reserva a ser removida
     * @return bool True se removida com sucesso
     */
    public function execute(Reservation $reservation): bool
    {
        return $this->reservationService->delete($reservation);
    }
}
