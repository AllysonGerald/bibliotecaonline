<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Rental;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface RentalRepositoryInterface
{
    public function findAll(): Collection;

    public function findPaginated(int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): ?Rental;

    public function findByUser(int $userId): Collection;

    public function findByBook(int $bookId): Collection;

    public function search(string $term): Collection;

    public function findActive(): Collection;

    public function findOverdue(): Collection;

    public function create(array $data): Rental;

    public function update(Rental $rental, array $data): bool;

    public function delete(Rental $rental): bool;
}
