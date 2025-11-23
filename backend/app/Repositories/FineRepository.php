<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Fine;
use App\Repositories\Contracts\FineRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository responsável pelo acesso aos dados de multas.
 */
class FineRepository implements FineRepositoryInterface
{
    /**
     * Busca uma multa por ID.
     *
     * @param int $id ID da multa
     * @return Fine|null Multa encontrada ou null
     */
    public function findById(int $id): ?Fine
    {
        return Fine::with(['rental.book', 'rental.book.author'])->find($id);
    }
    /**
     * Busca multas por usuário através do relacionamento com rentals.
     * Busca tanto pelo usuario_id direto quanto através do relacionamento com rental.
     *
     * @param int $userId ID do usuário
     * @return Collection Multas do usuário
     */
    public function findByUser(int $userId): Collection
    {
        return Fine::with(['rental.book', 'rental.book.author'])
            ->where(static function ($query) use ($userId): void {
                $query->where('usuario_id', $userId)
                    ->orWhereHas('rental', static function ($q) use ($userId): void {
                        $q->where('usuario_id', $userId);
                    })
                ;
            })
            ->latest()
            ->get()
        ;
    }

    /**
     * Busca multas pagas por usuário.
     *
     * @param int $userId ID do usuário
     * @return Collection Multas pagas do usuário
     */
    public function findPaidByUser(int $userId): Collection
    {
        return Fine::with(['rental.book', 'rental.book.author'])
            ->where(static function ($query) use ($userId): void {
                $query->where('usuario_id', $userId)
                    ->orWhereHas('rental', static function ($q) use ($userId): void {
                        $q->where('usuario_id', $userId);
                    })
                ;
            })
            ->where('paga', true)
            ->latest()
            ->get()
        ;
    }

    /**
     * Busca multas com solicitação de pagamento pendente.
     *
     * @return Collection Multas com pagamento solicitado
     */
    public function findPaymentRequests(): Collection
    {
        return Fine::with(['rental.book', 'rental.book.author', 'user'])
            ->where('pagamento_solicitado', true)
            ->where('paga', false)
            ->latest('pagamento_solicitado_em')
            ->get()
        ;
    }

    /**
     * Busca multas não pagas por usuário.
     *
     * @param int $userId ID do usuário
     * @return Collection Multas não pagas do usuário
     */
    public function findUnpaidByUser(int $userId): Collection
    {
        return Fine::with(['rental.book', 'rental.book.author'])
            ->where(static function ($query) use ($userId): void {
                $query->where('usuario_id', $userId)
                    ->orWhereHas('rental', static function ($q) use ($userId): void {
                        $q->where('usuario_id', $userId);
                    })
                ;
            })
            ->where('paga', false)
            ->latest()
            ->get()
        ;
    }
}
