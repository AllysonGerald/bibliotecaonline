<?php

declare(strict_types=1);

namespace App\Actions\Rentals;

use App\Models\Rental;
use App\Services\RentalService;

/**
 * Action responsável por remover um aluguel do sistema.
 */
final readonly class DeleteRentalAction
{
    public function __construct(
        private RentalService $rentalService,
    ) {
    }

    /**
     * Executa a remoção de um aluguel.
     *
     * @param Rental $rental Aluguel a ser removido
     * @return bool True se removido com sucesso
     */
    public function execute(Rental $rental): bool
    {
        return $this->rentalService->delete($rental);
    }
}
