<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\BookDTO;
use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class BookService
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
    ) {
    }

    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
        ?int $categoryId = null,
        ?int $authorId = null,
    ): LengthAwarePaginator {
        $query = Book::with(['author', 'category', 'tags']);

        if ($search !== null) {
            $query->search($search);
        }

        if ($categoryId !== null) {
            $query->byCategory($categoryId);
        }

        if ($authorId !== null) {
            $query->byAuthor($authorId);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getById(int $id): ?Book
    {
        return $this->bookRepository->findById($id);
    }

    public function search(string $term): Collection
    {
        return $this->bookRepository->search($term);
    }

    public function filterByCategory(int $categoryId): Collection
    {
        return $this->bookRepository->findByCategory($categoryId);
    }

    public function filterByAuthor(int $authorId): Collection
    {
        return $this->bookRepository->findByAuthor($authorId);
    }

    public function create(BookDTO $dto): Book
    {
        $book = $this->bookRepository->create($dto->toArray());

        if ($dto->tags !== null) {
            $this->bookRepository->syncTags($book, $dto->tags);
        }

        return $book->load(['author', 'category', 'tags']);
    }

    public function update(Book $book, BookDTO $dto): Book
    {
        $updated = $this->bookRepository->update($book, $dto->toArray());

        if (!$updated) {
            throw new RuntimeException('Falha ao atualizar o livro.');
        }

        if ($dto->tags !== null) {
            $this->bookRepository->syncTags($book, $dto->tags);
        } else {
            $book->tags()->detach();
        }

        return $book->fresh(['author', 'category', 'tags']) ?? $book;
    }

    public function delete(Book $book): bool
    {
        return $this->bookRepository->delete($book);
    }
}
