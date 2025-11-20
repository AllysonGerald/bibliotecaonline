<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Repository responsável pelo acesso aos dados de categorias.
 */
class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * Cria um novo registro de categoria.
     *
     * @param array<string, mixed> $data Dados da categoria
     * @return Category Categoria criada
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Remove uma categoria do banco de dados.
     *
     * @param Category $category Categoria a ser removida
     * @return bool True se removida com sucesso
     */
    public function delete(Category $category): bool
    {
        return (bool) $category->delete();
    }

    /**
     * Retorna todas as categorias com relacionamentos carregados.
     *
     * @return Collection Todas as categorias
     */
    public function findAll(): Collection
    {
        return Category::with('books')->get();
    }

    /**
     * Retorna categorias paginadas com filtro opcional de busca.
     *
     * @param int $perPage Quantidade de itens por página
     * @param string|null $search Termo de busca (nome ou descrição)
     * @return LengthAwarePaginator Resultados paginados
     */
    public function findAllPaginated(
        int $perPage = 15,
        ?string $search = null,
    ): LengthAwarePaginator {
        $query = Category::with('books');

        if ($search !== null) {
            $query->where('nome', 'like', "%{$search}%")
                ->orWhere('descricao', 'like', "%{$search}%")
            ;
        }

        return $query->latest()->paginate($perPage);
    }

    /**
     * Busca uma categoria por ID com relacionamentos carregados.
     *
     * @param int $id ID da categoria
     * @return Category|null Categoria encontrada ou null
     */
    public function findById(int $id): ?Category
    {
        return Category::with('books')->find($id);
    }

    /**
     * Retorna categorias paginadas sem filtros.
     *
     * @param int $perPage Quantidade de itens por página
     * @return LengthAwarePaginator Resultados paginados
     */
    public function findPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return Category::with('books')
            ->latest()
            ->paginate($perPage)
        ;
    }

    /**
     * Busca categorias por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Categorias encontradas
     */
    public function search(string $term): Collection
    {
        return Category::with('books')
            ->where('nome', 'like', "%{$term}%")
            ->orWhere('descricao', 'like', "%{$term}%")
            ->get()
        ;
    }

    /**
     * Atualiza os dados de uma categoria.
     *
     * @param Category $category Categoria a ser atualizada
     * @param array<string, mixed> $data Novos dados
     * @return bool True se atualizada com sucesso
     */
    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }
}
