<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\RentalDTO;
use App\Models\Rental;
use App\Repositories\Contracts\RentalRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class RentalService
{
    public function __construct(
        private readonly RentalRepositoryInterface $rentalRepository,
    ) {
    }

    public function create(RentalDTO $dto): Rental
    {
        return $this->rentalRepository->create($dto->toArray());
    }

    public function delete(Rental $rental): bool
    {
        return $this->rentalRepository->delete($rental);
    }

    public function getActive(): Collection
    {
        return $this->rentalRepository->findActive();
    }

    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
    ): LengthAwarePaginator {
        $query = Rental::with(['user', 'book.author', 'book.category']);

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

        return $query->latest('alugado_em')->paginate($perPage);
    }

    public function getByBook(int $bookId): Collection
    {
        return $this->rentalRepository->findByBook($bookId);
    }

    public function getById(int $id): ?Rental
    {
        return $this->rentalRepository->findById($id);
    }

    public function getByUser(int $userId): Collection
    {
        return $this->rentalRepository->findByUser($userId);
    }

    public function getOverdue(): Collection
    {
        return $this->rentalRepository->findOverdue();
    }

    public function search(string $term): Collection
    {
        return $this->rentalRepository->search($term);
    }

    public function update(Rental $rental, RentalDTO $dto): Rental
    {
        $updated = $this->rentalRepository->update($rental, $dto->toArray());

        if (!$updated) {
            throw new RuntimeException('Falha ao atualizar o aluguel.');
        }

        return $rental->fresh(['user', 'book.author', 'book.category', 'fine']) ?? $rental;
    }
}
