<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\ReservationDTO;
use App\Models\Reservation;
use App\Repositories\Contracts\ReservationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class ReservationService
{
    public function __construct(
        private readonly ReservationRepositoryInterface $reservationRepository,
    ) {
    }

    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
        ?int $userId = null,
        ?int $bookId = null,
        ?string $status = null,
    ): LengthAwarePaginator {
        $query = Reservation::with(['user', 'book.author', 'book.category']);

        if ($search !== null) {
            $query->whereHas('user', function ($q) use ($search): void {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                ;
            })
                ->orWhereHas('book', function ($q) use ($search): void {
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

    public function getById(int $id): ?Reservation
    {
        return $this->reservationRepository->findById($id);
    }

    public function search(string $term): Collection
    {
        return $this->reservationRepository->search($term);
    }

    public function getActive(): Collection
    {
        return $this->reservationRepository->findActive();
    }

    public function getExpired(): Collection
    {
        return $this->reservationRepository->findExpired();
    }

    public function getByUser(int $userId): Collection
    {
        return $this->reservationRepository->findByUser($userId);
    }

    public function getByBook(int $bookId): Collection
    {
        return $this->reservationRepository->findByBook($bookId);
    }

    public function create(ReservationDTO $dto): Reservation
    {
        return $this->reservationRepository->create($dto->toArray());
    }

    public function update(Reservation $reservation, ReservationDTO $dto): Reservation
    {
        $updated = $this->reservationRepository->update($reservation, $dto->toArray());

        if (!$updated) {
            throw new RuntimeException('Falha ao atualizar a reserva.');
        }

        return $reservation->fresh(['user', 'book.author', 'book.category']) ?? $reservation;
    }

    public function delete(Reservation $reservation): bool
    {
        return $this->reservationRepository->delete($reservation);
    }
}
