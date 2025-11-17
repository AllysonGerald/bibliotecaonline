<?php

declare(strict_types=1);

namespace App\Actions\Rentals;

use App\Models\Rental;
use App\Services\RentalService;

final readonly class DeleteRentalAction
{
    public function __construct(
        private RentalService $rentalService,
    ) {
    }

    public function execute(Rental $rental): bool
    {
        return $this->rentalService->delete($rental);
    }
}
