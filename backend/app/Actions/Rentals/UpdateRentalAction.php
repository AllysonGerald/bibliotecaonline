<?php

declare(strict_types=1);

namespace App\Actions\Rentals;

use App\DTOs\RentalDTO;
use App\Models\Rental;
use App\Services\RentalService;

final readonly class UpdateRentalAction
{
    public function __construct(
        private RentalService $rentalService,
    ) {
    }

    public function execute(Rental $rental, RentalDTO $dto): Rental
    {
        return $this->rentalService->update($rental, $dto);
    }
}
