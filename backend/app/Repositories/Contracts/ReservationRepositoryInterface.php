<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Reservation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ReservationRepositoryInterface
{
    public function create(array $data): Reservation;

    public function delete(Reservation $reservation): bool;

    public function findActive(): Collection;

    public function findAll(): Collection;

    public function findAllPaginated(
        int $perPage = 15,
        ?string $search = null,
        ?int $userId = null,
        ?int $bookId = null,
        ?string $status = null,
    ): LengthAwarePaginator;

    public function findByBook(int $bookId): Collection;

    public function findById(int $id): ?Reservation;

    public function findByUser(int $userId): Collection;

    public function findExpired(): Collection;

    public function findPaginated(int $perPage = 15): LengthAwarePaginator;

    public function getPendingOrConfirmedCount(): int;

    public function search(string $term): Collection;

    public function update(Reservation $reservation, array $data): bool;
}
