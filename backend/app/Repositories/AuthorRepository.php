<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AuthorRepository implements AuthorRepositoryInterface
{
    public function create(array $data): Author
    {
        return Author::create($data);
    }

    public function delete(Author $author): bool
    {
        return (bool) $author->delete();
    }

    public function findAll(): Collection
    {
        return Author::with('books')->get();
    }

    public function findById(int $id): ?Author
    {
        return Author::with('books')->find($id);
    }

    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Author::with('books')
            ->latest()
            ->paginate($perPage)
        ;
    }

    public function search(string $term): Collection
    {
        return Author::with('books')
            ->where('nome', 'like', "%{$term}%")
            ->orWhere('biografia', 'like', "%{$term}%")
            ->get()
        ;
    }

    public function update(Author $author, array $data): bool
    {
        return $author->update($data);
    }
}
