<?php

declare(strict_types=1);

namespace App\Repositories\Contracts;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BookRepositoryInterface
{
    public function create(array $data): Book;

    public function delete(Book $book): bool;

    public function findAll(): Collection;

    public function findByAuthor(int $authorId): Collection;

    public function findByCategory(int $categoryId): Collection;

    public function findById(int $id): ?Book;

    public function findByIsbn(string $isbn): ?Book;

    public function findPaginated(int $perPage = 15): LengthAwarePaginator;

    public function search(string $term): Collection;

    public function syncTags(Book $book, array $tagIds): void;

    public function update(Book $book, array $data): bool;
}
