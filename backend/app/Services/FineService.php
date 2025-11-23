<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Contracts\FineRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Service responsável pela lógica de negócio relacionada a multas.
 */
class FineService
{
    public function __construct(
        private readonly FineRepositoryInterface $fineRepository,
    ) {
    }

    /**
     * Busca todas as multas com paginação e filtros.
     *
     * @param int $perPage Itens por página
     * @param string|null $status Status da multa ('pendente' ou 'paga')
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Multas paginadas
     */
    public function getAllPaginated(int $perPage = 15, ?string $status = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = \App\Models\Fine::with(['rental.book', 'rental.book.author', 'user'])
            ->latest()
        ;

        if ($status === 'pendente') {
            $query->where('paga', false);
        } elseif ($status === 'paga') {
            $query->where('paga', true);
        }

        return $query->paginate($perPage);
    }

    /**
     * Busca multas por usuário com filtro opcional de status.
     *
     * @param int $userId ID do usuário
     * @param string|null $status Status da multa ('pendente' ou 'paga')
     * @return Collection Multas do usuário
     */
    public function getByUser(int $userId, ?string $status = null): Collection
    {
        if ($status === 'pendente') {
            return $this->fineRepository->findUnpaidByUser($userId);
        }

        if ($status === 'paga') {
            return $this->fineRepository->findPaidByUser($userId);
        }

        return $this->fineRepository->findByUser($userId);
    }

    /**
     * Busca multas pagas por usuário.
     *
     * @param int $userId ID do usuário
     * @return Collection Multas pagas do usuário
     */
    public function getPaidByUser(int $userId): Collection
    {
        return $this->fineRepository->findPaidByUser($userId);
    }

    /**
     * Busca multas com solicitação de pagamento pendente.
     *
     * @return Collection Multas com pagamento solicitado
     */
    public function getPaymentRequests(): Collection
    {
        return $this->fineRepository->findPaymentRequests();
    }

    /**
     * Busca multas não pagas por usuário.
     *
     * @param int $userId ID do usuário
     * @return Collection Multas não pagas do usuário
     */
    public function getUnpaidByUser(int $userId): Collection
    {
        return $this->fineRepository->findUnpaidByUser($userId);
    }

    /**
     * Marca uma multa como paga (confirmação pelo admin).
     *
     * @param int $fineId ID da multa
     * @return bool True se marcada como paga com sucesso
     */
    public function markAsPaid(int $fineId): bool
    {
        $fine = $this->fineRepository->findById($fineId);

        if (!$fine) {
            return false;
        }

        $fine->markAsPaid();

        return true;
    }

    /**
     * Solicita o pagamento de uma multa (usuário solicita).
     *
     * @param int $fineId ID da multa
     * @return bool True se solicitação criada com sucesso
     */
    public function requestPayment(int $fineId): bool
    {
        $fine = $this->fineRepository->findById($fineId);

        if (!$fine) {
            return false;
        }

        $fine->requestPayment();

        return true;
    }
}
