<?php

declare(strict_types=1);

namespace App\Actions\Rentals;

use App\DTOs\RentalDTO;
use App\Models\Rental;
use App\Services\RentalService;

/**
 * Action responsável por criar um novo aluguel no sistema.
 */
final readonly class CreateRentalAction
{
    public function __construct(
        private RentalService $rentalService,
    ) {
    }

    /**
     * Executa a criação de um novo aluguel.
     *
     * @param RentalDTO $dto Dados do aluguel a ser criado
     * @return Rental Aluguel criado
     */
    public function execute(RentalDTO $dto): Rental
    {
        return $this->rentalService->create($dto);
    }
}
