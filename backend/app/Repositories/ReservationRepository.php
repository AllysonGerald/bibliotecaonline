<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Reservation;
use App\Repositories\Contracts\ReservationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository responsável pelo acesso aos dados de reservas.
 */
class ReservationRepository implements ReservationRepositoryInterface
{
    /**
     * Cria um novo registro de reserva.
     *
     * @param array<string, mixed> $data Dados da reserva
     * @return Reservation Reserva criada
     */
    public function create(array $data): Reservation
    {
        return Reservation::create($data);
    }

    /**
     * Remove uma reserva do banco de dados.
     *
     * @param Reservation $reservation Reserva a ser removida
     * @return bool True se removida com sucesso
     */
    public function delete(Reservation $reservation): bool
    {
        return (bool) $reservation->delete();
    }

    /**
     * Retorna reservas ativas com relacionamentos carregados.
     *
     * @return Collection Reservas ativas
     */
    public function findActive(): Collection
    {
        return Reservation::with(['user', 'book.author', 'book.category'])
            ->active()
            ->latest('reservado_em')
            ->get()
        ;
    }

    /**
     * Retorna todas as reservas com relacionamentos carregados.
     *
     * @return Collection Todas as reservas
     */
    public function findAll(): Collection
    {
        return Reservation::with(['user', 'book.author', 'book.category'])->get();
    }

    /**
     * Retorna reservas paginadas com filtros opcionais.
     *
     * @param int $perPage Quantidade de itens por página
     * @param string|null $search Termo de busca (nome/email do usuário ou título do livro)
     * @param int|null $userId ID do usuário para filtrar
     * @param int|null $bookId ID do livro para filtrar
     * @param string|null $status Status da reserva para filtrar
     * @return LengthAwarePaginator Resultados paginados
     */
    public function findAllPaginated(
        int $perPage = 15,
        ?string $search = null,
        ?int $userId = null,
        ?int $bookId = null,
        ?string $status = null,
    ): LengthAwarePaginator {
        $query = Reservation::with(['user', 'book.author', 'book.category']);

        if ($search !== null) {
            $query->whereHas('user', static function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                ;
            })
                ->orWhereHas('book', static function ($q) use ($search): void {
                    $q->where('titulo', 'like', "%{$search}%");
                })
            ;
        }

        if ($userId !== null) {
            $query->where('usuario_id', $userId);
        }

        if ($bookId !== null) {
            $query->where('livro_id', $bookId);
        }

        if ($status !== null) {
            $query->where('status', $status);
        }

        return $query->latest('reservado_em')->paginate($perPage);
    }

    /**
     * Busca reservas por livro.
     *
     * @param int $bookId ID do livro
     * @return Collection Reservas do livro
     */
    public function findByBook(int $bookId): Collection
    {
        return Reservation::with(['user', 'book.author', 'book.category'])
            ->where('livro_id', $bookId)
            ->latest('reservado_em')
            ->get()
        ;
    }

    /**
     * Busca uma reserva por ID com relacionamentos carregados.
     *
     * @param int $id ID da reserva
     * @return Reservation|null Reserva encontrada ou null
     */
    public function findById(int $id): ?Reservation
    {
        return Reservation::with(['user', 'book.author', 'book.category'])->find($id);
    }

    /**
     * Busca reservas por usuário.
     *
     * @param int $userId ID do usuário
     * @return Collection Reservas do usuário
     */
    public function findByUser(int $userId): Collection
    {
        return Reservation::with(['user', 'book.author', 'book.category'])
            ->where('usuario_id', $userId)
            ->latest('reservado_em')
            ->get()
        ;
    }

    /**
     * Retorna reservas expiradas.
     *
     * @return Collection Reservas expiradas
     */
    public function findExpired(): Collection
    {
        return Reservation::with(['user', 'book.author', 'book.category'])
            ->expired()
            ->latest('expira_em')
            ->get()
        ;
    }

    /**
     * Retorna reservas paginadas sem filtros.
     *
     * @param int $perPage Quantidade de itens por página
     * @return LengthAwarePaginator Resultados paginados
     */
    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Reservation::with(['user', 'book.author', 'book.category'])
            ->latest('reservado_em')
            ->paginate($perPage)
        ;
    }

    /**
     * Retorna a quantidade de reservas pendentes ou confirmadas no sistema.
     *
     * @return int Quantidade de reservas pendentes/confirmadas
     */
    public function getPendingOrConfirmedCount(): int
    {
        return Reservation::whereIn('status', [\App\Enums\ReservationStatus::PENDENTE, \App\Enums\ReservationStatus::CONFIRMADA])->count();
    }

    /**
     * Busca reservas por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Reservas encontradas
     */
    public function search(string $term): Collection
    {
        return Reservation::with(['user', 'book.author', 'book.category'])
            ->whereHas('user', static function ($query) use ($term): void {
                $query->where('name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                ;
            })
            ->orWhereHas('book', static function ($query) use ($term): void {
                $query->where('titulo', 'like', "%{$term}%");
            })
            ->latest('reservado_em')
            ->get()
        ;
    }

    /**
     * Atualiza os dados de uma reserva.
     *
     * @param Reservation $reservation Reserva a ser atualizada
     * @param array<string, mixed> $data Novos dados
     * @return bool True se atualizada com sucesso
     */
    public function update(Reservation $reservation, array $data): bool
    {
        return $reservation->update($data);
    }
}
