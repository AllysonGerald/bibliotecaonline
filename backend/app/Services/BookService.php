<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\BookDTO;
use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

/**
 * Service responsável pela lógica de negócio relacionada a livros.
 */
class BookService
{
    public function __construct(
        private readonly BookRepositoryInterface $bookRepository,
    ) {
    }

    /**
     * Cria um novo livro no sistema.
     *
     * @param BookDTO $dto Dados do livro a ser criado
     * @return Book Livro criado com relacionamentos carregados
     */
    public function create(BookDTO $dto): Book
    {
        $book = $this->bookRepository->create($dto->toArray());

        if ($dto->tags !== null) {
            $this->bookRepository->syncTags($book, $dto->tags);
        }

        return $book->load(['author', 'category', 'tags']);
    }

    /**
     * Remove um livro do sistema.
     *
     * @param Book $book Livro a ser removido
     * @return bool True se removido com sucesso
     */
    public function delete(Book $book): bool
    {
        return $this->bookRepository->delete($book);
    }

    /**
     * Busca livros filtrados por autor.
     *
     * @param int $authorId ID do autor
     * @return Collection Coleção de livros do autor
     */
    public function filterByAuthor(int $authorId): Collection
    {
        return $this->bookRepository->findByAuthor($authorId);
    }

    /**
     * Busca livros filtrados por categoria.
     *
     * @param int $categoryId ID da categoria
     * @return Collection Coleção de livros da categoria
     */
    public function filterByCategory(int $categoryId): Collection
    {
        return $this->bookRepository->findByCategory($categoryId);
    }

    /**
     * Retorna livros paginados com filtros opcionais.
     *
     * @param int $perPage Quantidade de itens por página
     * @param string|null $search Termo de busca (título, descrição ou autor)
     * @param int|null $categoryId ID da categoria para filtrar
     * @param int|null $authorId ID do autor para filtrar
     * @return LengthAwarePaginator Resultados paginados
     */
    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
        ?int $categoryId = null,
        ?int $authorId = null,
    ): LengthAwarePaginator {
        return $this->bookRepository->findAllPaginated(
            perPage: $perPage,
            search: $search,
            categoryId: $categoryId,
            authorId: $authorId,
        );
    }

    /**
     * Retorna todos os livros com autor ordenados por título.
     * Utilizado para preencher dropdowns em formulários.
     *
     * @return Collection Todos os livros com autor ordenados
     */
    public function getAllWithAuthorOrdered(): Collection
    {
        return $this->bookRepository->findAll()->sortBy('titulo')->values();
    }

    /**
     * Busca um livro por ID.
     *
     * @param int $id ID do livro
     * @return Book|null Livro encontrado ou null
     */
    public function getById(int $id): ?Book
    {
        return $this->bookRepository->findById($id);
    }

    /**
     * Retorna os livros mais alugados do sistema.
     * Utilizado na área administrativa para exibir livros em destaque.
     *
     * @param int $limit Quantidade de livros a retornar
     * @return Collection Livros ordenados por quantidade de aluguéis
     */
    public function getMostRentedBooks(int $limit = 6): Collection
    {
        return $this->bookRepository->findMostRented($limit);
    }

    /**
     * Retorna livros disponíveis de forma aleatória.
     * Aplica filtro adicional de disponibilidade (lógica de negócio).
     * Utilizado na área do usuário para exibir livros em destaque.
     *
     * @param int $limit Quantidade de livros a retornar
     * @return Collection Livros aleatórios disponíveis
     */
    public function getRandomAvailableBooks(int $limit = 6): Collection
    {
        $books = $this->bookRepository->findRandomAvailable($limit);

        return $books->filter(static fn ($book) => $book->isAvailable());
    }

    /**
     * Retorna a quantidade total de livros no sistema.
     *
     * @return int Quantidade total de livros
     */
    public function getTotalCount(): int
    {
        return $this->bookRepository->getTotalCount();
    }

    /**
     * Busca livros por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Livros encontrados
     */
    public function search(string $term): Collection
    {
        return $this->bookRepository->search($term);
    }

    /**
     * Atualiza os dados de um livro existente.
     *
     * @param Book $book Livro a ser atualizado
     * @param BookDTO $dto Novos dados do livro
     * @return Book Livro atualizado com relacionamentos carregados
     * @throws RuntimeException Se a atualização falhar
     */
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
