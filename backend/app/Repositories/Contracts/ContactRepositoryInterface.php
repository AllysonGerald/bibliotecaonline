<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Contact;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ContactRepositoryInterface
{
    public function create(array $data): Contact;

    public function delete(Contact $contact): bool;

    public function findAll(): Collection;

    public function findAllPaginated(
        int $perPage = 15,
        ?string $search = null,
    ): LengthAwarePaginator;

    public function findById(int $id): ?Contact;

    public function findPaginated(int $perPage = 15): LengthAwarePaginator;

    public function getUnreadCount(): int;

    public function search(string $term): Collection;
}
