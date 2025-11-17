<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Author;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AuthorRepositoryInterface
{
    public function findAll(): Collection;

    public function findPaginated(int $perPage = 15): LengthAwarePaginator;

    public function findById(int $id): ?Author;

    public function search(string $term): Collection;

    public function create(array $data): Author;

    public function update(Author $author, array $data): bool;

    public function delete(Author $author): bool;
}
