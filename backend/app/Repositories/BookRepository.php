<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class BookRepository implements BookRepositoryInterface
{
    public function create(array $data): Book
    {
        return Book::create($data);
    }

    public function delete(Book $book): bool
    {
        return (bool) $book->delete();
    }

    public function findAll(): Collection
    {
        return Book::with(['author', 'category', 'tags'])->get();
    }

    public function findByAuthor(int $authorId): Collection
    {
        return Book::with(['author', 'category', 'tags'])
            ->byAuthor($authorId)
            ->get()
        ;
    }

    public function findByCategory(int $categoryId): Collection
    {
        return Book::with(['author', 'category', 'tags'])
            ->byCategory($categoryId)
            ->get()
        ;
    }

    public function findById(int $id): ?Book
    {
        return Book::with(['author', 'category', 'tags', 'reviews.user'])->find($id);
    }

    public function findByIsbn(string $isbn): ?Book
    {
        return Book::where('isbn', $isbn)->first();
    }

    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Book::with(['author', 'category', 'tags'])
            ->latest()
            ->paginate($perPage)
        ;
    }

    public function search(string $term): Collection
    {
        return Book::with(['author', 'category', 'tags'])
            ->search($term)
            ->get()
        ;
    }

    public function syncTags(Book $book, array $tagIds): void
    {
        $book->tags()->sync($tagIds);
    }

    public function update(Book $book, array $data): bool
    {
        return $book->update($data);
    }
}
