<?php

declare(strict_types=1);

namespace App\Actions\Reservations;

use App\Models\Reservation;
use App\Services\ReservationService;

final readonly class DeleteReservationAction
{
    public function __construct(
        private ReservationService $reservationService,
    ) {
    }

    public function execute(Reservation $reservation): bool
    {
        return $this->reservationService->delete($reservation);
    }
}
