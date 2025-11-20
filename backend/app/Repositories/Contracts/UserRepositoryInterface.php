<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    public function create(array $data): User;

    public function delete(User $user): bool;

    public function findActive(): Collection;

    public function findAll(): Collection;

    public function findByEmail(string $email): ?User;

    public function findById(int $id): ?User;

    public function findByRole(string $role): Collection;

    public function findInactive(): Collection;

    public function findPaginated(int $perPage = 15): LengthAwarePaginator;

    public function search(string $term): Collection;

    public function update(User $user, array $data): bool;
}
