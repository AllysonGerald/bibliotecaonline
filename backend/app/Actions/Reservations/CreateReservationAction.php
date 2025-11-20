<?php

declare(strict_types=1);

namespace App\Actions\Reservations;

use App\DTOs\ReservationDTO;
use App\Models\Reservation;
use App\Services\ReservationService;

/**
 * Action responsável por criar uma nova reserva no sistema.
 */
final readonly class CreateReservationAction
{
    public function __construct(
        private ReservationService $reservationService,
    ) {
    }

    /**
     * Executa a criação de uma nova reserva.
     *
     * @param ReservationDTO $dto Dados da reserva a ser criada
     * @return Reservation Reserva criada
     */
    public function execute(ReservationDTO $dto): Reservation
    {
        return $this->reservationService->create($dto);
    }
}
