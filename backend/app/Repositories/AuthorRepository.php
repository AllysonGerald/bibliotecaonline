<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Author;
use App\Repositories\Contracts\AuthorRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository responsável pelo acesso aos dados de autores.
 */
class AuthorRepository implements AuthorRepositoryInterface
{
    /**
     * Cria um novo registro de autor.
     *
     * @param array<string, mixed> $data Dados do autor
     * @return Author Autor criado
     */
    public function create(array $data): Author
    {
        return Author::create($data);
    }

    /**
     * Remove um autor do banco de dados.
     *
     * @param Author $author Autor a ser removido
     * @return bool True se removido com sucesso
     */
    public function delete(Author $author): bool
    {
        return (bool) $author->delete();
    }

    /**
     * Retorna todos os autores com relacionamentos carregados.
     *
     * @return Collection Todos os autores
     */
    public function findAll(): Collection
    {
        return Author::with('books')->get();
    }

    /**
     * Retorna autores paginados com filtro opcional de busca.
     *
     * @param int $perPage Quantidade de itens por página
     * @param string|null $search Termo de busca (nome ou biografia)
     * @return LengthAwarePaginator Resultados paginados
     */
    public function findAllPaginated(
        int $perPage = 15,
        ?string $search = null,
    ): LengthAwarePaginator {
        $query = Author::with('books');

        if ($search !== null) {
            $query->where('nome', 'like', "%{$search}%")
                ->orWhere('biografia', 'like', "%{$search}%")
            ;
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Busca um autor por ID com relacionamentos carregados.
     *
     * @param int $id ID do autor
     * @return Author|null Autor encontrado ou null
     */
    public function findById(int $id): ?Author
    {
        return Author::with('books')->find($id);
    }

    /**
     * Retorna autores paginados sem filtros.
     *
     * @param int $perPage Quantidade de itens por página
     * @return LengthAwarePaginator Resultados paginados
     */
    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Author::with('books')
            ->latest()
            ->paginate($perPage)
        ;
    }

    /**
     * Busca autores por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Autores encontrados
     */
    public function search(string $term): Collection
    {
        return Author::with('books')
            ->where('nome', 'like', "%{$term}%")
            ->orWhere('biografia', 'like', "%{$term}%")
            ->get()
        ;
    }

    /**
     * Atualiza os dados de um autor.
     *
     * @param Author $author Autor a ser atualizado
     * @param array<string, mixed> $data Novos dados
     * @return bool True se atualizado com sucesso
     */
    public function update(Author $author, array $data): bool
    {
        return $author->update($data);
    }
}
