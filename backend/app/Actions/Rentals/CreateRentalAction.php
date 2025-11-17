<?php

declare(strict_types=1);

namespace App\Actions\Rentals;

use App\DTOs\RentalDTO;
use App\Models\Rental;
use App\Services\RentalService;

final readonly class CreateRentalAction
{
    public function __construct(
        private RentalService $rentalService,
    ) {
    }

    public function execute(RentalDTO $dto): Rental
    {
        return $this->rentalService->create($dto);
    }
}
