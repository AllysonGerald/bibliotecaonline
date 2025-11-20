<?php

declare(strict_types=1);

namespace App\Actions\Rentals;

use App\DTOs\RentalDTO;
use App\Models\Rental;
use App\Services\RentalService;

/**
 * Action responsável por atualizar um aluguel existente no sistema.
 */
final readonly class UpdateRentalAction
{
    public function __construct(
        private RentalService $rentalService,
    ) {
    }

    /**
     * Executa a atualização de um aluguel existente.
     *
     * @param Rental $rental Aluguel a ser atualizado
     * @param RentalDTO $dto Novos dados do aluguel
     * @return Rental Aluguel atualizado
     */
    public function execute(Rental $rental, RentalDTO $dto): Rental
    {
        return $this->rentalService->update($rental, $dto);
    }
}
