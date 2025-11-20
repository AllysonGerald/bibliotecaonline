<?php

declare(strict_types=1);

namespace App\Actions\Reservations;

use App\DTOs\ReservationDTO;
use App\Models\Reservation;
use App\Services\ReservationService;

/**
 * Action responsável por atualizar uma reserva existente no sistema.
 */
final readonly class UpdateReservationAction
{
    public function __construct(
        private ReservationService $reservationService,
    ) {
    }

    /**
     * Executa a atualização de uma reserva existente.
     *
     * @param Reservation $reservation Reserva a ser atualizada
     * @param ReservationDTO $dto Novos dados da reserva
     * @return Reservation Reserva atualizada
     */
    public function execute(Reservation $reservation, ReservationDTO $dto): Reservation
    {
        return $this->reservationService->update($reservation, $dto);
    }
}
