<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ReservationDTO;
use App\Models\Reservation;
use App\Repositories\Contracts\ReservationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

/**
 * Service responsável pela lógica de negócio relacionada a reservas.
 */
class ReservationService
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservationRepository,
    ) {
    }

    /**
     * Cria uma nova reserva no sistema.
     *
     * @param ReservationDTO $dto Dados da reserva a ser criada
     * @return Reservation Reserva criada
     */
    public function create(ReservationDTO $dto): Reservation
    {
        return $this->reservationRepository->create($dto->toArray());
    }

    /**
     * Remove uma reserva do sistema.
     *
     * @param Reservation $reservation Reserva a ser removida
     * @return bool True se removida com sucesso
     */
    public function delete(Reservation $reservation): bool
    {
        return $this->reservationRepository->delete($reservation);
    }

    /**
     * Retorna reservas ativas.
     *
     * @return Collection Reservas ativas
     */
    public function getActive(): Collection
    {
        return $this->reservationRepository->findActive();
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
    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
        ?int $userId = null,
        ?int $bookId = null,
        ?string $status = null,
    ): LengthAwarePaginator {
        return $this->reservationRepository->findAllPaginated(
            perPage: $perPage,
            search: $search,
            userId: $userId,
            bookId: $bookId,
            status: $status,
        );
    }

    /**
     * Busca reservas por livro.
     *
     * @param int $bookId ID do livro
     * @return Collection Reservas do livro
     */
    public function getByBook(int $bookId): Collection
    {
        return $this->reservationRepository->findByBook($bookId);
    }

    /**
     * Busca uma reserva por ID.
     *
     * @param int $id ID da reserva
     * @return Reservation|null Reserva encontrada ou null
     */
    public function getById(int $id): ?Reservation
    {
        return $this->reservationRepository->findById($id);
    }

    /**
     * Busca reservas por usuário.
     *
     * @param int $userId ID do usuário
     * @return Collection Reservas do usuário
     */
    public function getByUser(int $userId): Collection
    {
        return $this->reservationRepository->findByUser($userId);
    }

    /**
     * Retorna reservas expiradas.
     *
     * @return Collection Reservas expiradas
     */
    public function getExpired(): Collection
    {
        return $this->reservationRepository->findExpired();
    }

    /**
     * Retorna a quantidade de reservas pendentes ou confirmadas no sistema.
     *
     * @return int Quantidade de reservas pendentes/confirmadas
     */
    public function getPendingOrConfirmedCount(): int
    {
        return $this->reservationRepository->getPendingOrConfirmedCount();
    }

    /**
     * Busca reservas por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Reservas encontradas
     */
    public function search(string $term): Collection
    {
        return $this->reservationRepository->search($term);
    }

    /**
     * Atualiza os dados de uma reserva existente.
     *
     * @param Reservation $reservation Reserva a ser atualizada
     * @param ReservationDTO $dto Novos dados da reserva
     * @return Reservation Reserva atualizada com relacionamentos carregados
     * @throws RuntimeException Se a atualização falhar
     */
    public function update(Reservation $reservation, ReservationDTO $dto): Reservation
    {
        $updated = $this->reservationRepository->update($reservation, $dto->toArray());

        if (!$updated) {
            throw new RuntimeException('Falha ao atualizar a reserva.');
        }

        return $reservation->fresh(['user', 'book.author', 'book.category']) ?? $reservation;
    }
}
