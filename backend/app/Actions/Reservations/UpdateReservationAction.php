<?php

declare(strict_types=1);

namespace App\Actions\Reservations;

use App\DTOs\ReservationDTO;
use App\Models\Reservation;
use App\Services\ReservationService;

final readonly class UpdateReservationAction
{
    public function __construct(
        private ReservationService $reservationService,
    ) {
    }

    public function execute(Reservation $reservation, ReservationDTO $dto): Reservation
    {
        return $this->reservationService->update($reservation, $dto);
    }
}
