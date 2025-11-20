<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Book;
use App\Repositories\Contracts\BookRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository responsável pelo acesso aos dados de livros.
 */
class BookRepository implements BookRepositoryInterface
{
    /**
     * Cria um novo registro de livro.
     *
     * @param array<string, mixed> $data Dados do livro
     * @return Book Livro criado
     */
    public function create(array $data): Book
    {
        return Book::create($data);
    }

    /**
     * Remove um livro do banco de dados.
     *
     * @param Book $book Livro a ser removido
     * @return bool True se removido com sucesso
     */
    public function delete(Book $book): bool
    {
        return (bool) $book->delete();
    }

    /**
     * Retorna todos os livros com relacionamentos carregados.
     *
     * @return Collection Todos os livros
     */
    public function findAll(): Collection
    {
        return Book::with(['author', 'category', 'tags'])->get();
    }

    /**
     * Retorna livros paginados com filtros opcionais.
     *
     * @param int $perPage Quantidade de itens por página
     * @param string|null $search Termo de busca
     * @param int|null $categoryId ID da categoria
     * @param int|null $authorId ID do autor
     * @return LengthAwarePaginator Resultados paginados
     */
    public function findAllPaginated(
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

    /**
     * Busca livros por autor.
     *
     * @param int $authorId ID do autor
     * @return Collection Livros do autor
     */
    public function findByAuthor(int $authorId): Collection
    {
        return Book::with(['author', 'category', 'tags'])
            ->byAuthor($authorId)
            ->get()
        ;
    }

    /**
     * Busca livros por categoria.
     *
     * @param int $categoryId ID da categoria
     * @return Collection Livros da categoria
     */
    public function findByCategory(int $categoryId): Collection
    {
        return Book::with(['author', 'category', 'tags'])
            ->byCategory($categoryId)
            ->get()
        ;
    }

    /**
     * Busca um livro por ID com todos os relacionamentos.
     *
     * @param int $id ID do livro
     * @return Book|null Livro encontrado ou null
     */
    public function findById(int $id): ?Book
    {
        return Book::with(['author', 'category', 'tags', 'reviews.user'])->find($id);
    }

    /**
     * Busca um livro por ISBN.
     *
     * @param string $isbn ISBN do livro
     * @return Book|null Livro encontrado ou null
     */
    public function findByIsbn(string $isbn): ?Book
    {
        return Book::where('isbn', $isbn)->first();
    }

    /**
     * Retorna os livros mais alugados ordenados por quantidade de aluguéis.
     *
     * @param int $limit Quantidade de livros a retornar
     * @return Collection Livros mais alugados
     */
    public function findMostRented(int $limit = 6): Collection
    {
        return Book::with(['author', 'category'])
            ->withCount('rentals as total_rentals')
            ->orderByDesc('total_rentals')
            ->orderByDesc('created_at')
            ->take($limit)
            ->get()
        ;
    }

    /**
     * Retorna livros paginados sem filtros.
     *
     * @param int $perPage Quantidade de itens por página
     * @return LengthAwarePaginator Resultados paginados
     */
    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Book::with(['author', 'category', 'tags'])
            ->latest()
            ->paginate($perPage)
        ;
    }

    /**
     * Retorna livros disponíveis de forma aleatória.
     *
     * @param int $limit Quantidade de livros a retornar
     * @return Collection Livros aleatórios disponíveis
     */
    public function findRandomAvailable(int $limit = 6): Collection
    {
        return Book::with(['author', 'category'])
            ->where('status', \App\Enums\BookStatus::DISPONIVEL)
            ->where(static function ($query): void {
                $query->whereNull('quantidade')
                    ->orWhere('quantidade', '>', 0)
                ;
            })
            ->inRandomOrder()
            ->take($limit)
            ->get()
        ;
    }

    /**
     * Retorna a quantidade total de livros no sistema.
     *
     * @return int Quantidade total de livros
     */
    public function getTotalCount(): int
    {
        return Book::count();
    }

    /**
     * Busca livros por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Livros encontrados
     */
    public function search(string $term): Collection
    {
        return Book::with(['author', 'category', 'tags'])
            ->search($term)
            ->get()
        ;
    }

    /**
     * Sincroniza tags de um livro.
     *
     * @param Book $book Livro a ter tags sincronizadas
     * @param array<int> $tagIds IDs das tags
     */
    public function syncTags(Book $book, array $tagIds): void
    {
        $book->tags()->sync($tagIds);
    }

    /**
     * Atualiza os dados de um livro.
     *
     * @param Book $book Livro a ser atualizado
     * @param array<string, mixed> $data Novos dados
     * @return bool True se atualizado com sucesso
     */
    public function update(Book $book, array $data): bool
    {
        return $book->update($data);
    }
}
