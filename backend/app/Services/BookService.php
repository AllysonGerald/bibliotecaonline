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

    public function create(BookDTO $dto): Book
    {
        $book = $this->bookRepository->create($dto->toArray());

        if ($dto->tags !== null) {
            $this->bookRepository->syncTags($book, $dto->tags);
        }

        return $book->load(['author', 'category', 'tags']);
    }

    public function delete(Book $book): bool
    {
        return $this->bookRepository->delete($book);
    }

    public function filterByAuthor(int $authorId): Collection
    {
        return $this->bookRepository->findByAuthor($authorId);
    }

    public function filterByCategory(int $categoryId): Collection
    {
        return $this->bookRepository->findByCategory($categoryId);
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

    /**
     * Busca os livros mais alugados (para área admin)
     * Ordena por quantidade total de aluguéis (histórico completo) e retorna os mais populares
     */
    public function getMostRentedBooks(int $limit = 6): Collection
    {
        return $this->bookRepository->findMostRented($limit);
    }

    /**
     * Busca livros aleatórios disponíveis (para área de usuário)
     * Retorna apenas livros disponíveis de forma aleatória
     */
    public function getRandomAvailableBooks(int $limit = 6): Collection
    {
        $books = $this->bookRepository->findRandomAvailable($limit);

        // Filtro adicional de disponibilidade (lógica de negócio)
        return $books->filter(static fn ($book) => $book->isAvailable());
    }

    public function search(string $term): Collection
    {
        return $this->bookRepository->search($term);
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
}
