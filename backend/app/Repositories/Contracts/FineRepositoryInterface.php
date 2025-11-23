<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Fine;
use Illuminate\Database\Eloquent\Collection;

/**
 * Interface para o repositório de multas.
 */
interface FineRepositoryInterface
{
    /**
     * Busca uma multa por ID.
     *
     * @param int $id ID da multa
     * @return Fine|null Multa encontrada ou null
     */
    public function findById(int $id): ?Fine;
    /**
     * Busca multas por usuário através do relacionamento com rentals.
     *
     * @param int $userId ID do usuário
     * @return Collection Multas do usuário
     */
    public function findByUser(int $userId): Collection;

    /**
     * Busca multas pagas por usuário.
     *
     * @param int $userId ID do usuário
     * @return Collection Multas pagas do usuário
     */
    public function findPaidByUser(int $userId): Collection;

    /**
     * Busca multas com solicitação de pagamento pendente.
     *
     * @return Collection Multas com pagamento solicitado
     */
    public function findPaymentRequests(): Collection;

    /**
     * Busca multas não pagas por usuário.
     *
     * @param int $userId ID do usuário
     * @return Collection Multas não pagas do usuário
     */
    public function findUnpaidByUser(int $userId): Collection;
}
