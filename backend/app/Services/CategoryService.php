<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\CategoryDTO;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

/**
 * Service responsável pela lógica de negócio relacionada a categorias.
 */
class CategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    /**
     * Cria uma nova categoria no sistema.
     *
     * @param CategoryDTO $dto Dados da categoria a ser criada
     * @return Category Categoria criada
     */
    public function create(CategoryDTO $dto): Category
    {
        return $this->categoryRepository->create($dto->toArray());
    }

    /**
     * Remove uma categoria do sistema.
     *
     * @param Category $category Categoria a ser removida
     * @return bool True se removida com sucesso
     */
    public function delete(Category $category): bool
    {
        return $this->categoryRepository->delete($category);
    }

    /**
     * Retorna todas as categorias ordenadas por nome.
     * Utilizado para preencher dropdowns em formulários.
     *
     * @return Collection Todas as categorias ordenadas
     */
    public function getAllOrdered(): Collection
    {
        return $this->categoryRepository->findAll()->sortBy('nome')->values();
    }

    /**
     * Retorna categorias paginadas com filtro opcional de busca.
     *
     * @param int $perPage Quantidade de itens por página
     * @param string|null $search Termo de busca (nome ou descrição)
     * @return LengthAwarePaginator Resultados paginados
     */
    public function getAllPaginated(
        int $perPage = 15,
        ?string $search = null,
    ): LengthAwarePaginator {
        return $this->categoryRepository->findAllPaginated(
            perPage: $perPage,
            search: $search,
        );
    }

    /**
     * Busca uma categoria por ID.
     *
     * @param int $id ID da categoria
     * @return Category|null Categoria encontrada ou null
     */
    public function getById(int $id): ?Category
    {
        return $this->categoryRepository->findById($id);
    }

    /**
     * Busca categorias por termo de pesquisa.
     *
     * @param string $term Termo a ser pesquisado
     * @return Collection Categorias encontradas
     */
    public function search(string $term): Collection
    {
        return $this->categoryRepository->search($term);
    }

    /**
     * Atualiza os dados de uma categoria existente.
     *
     * @param Category $category Categoria a ser atualizada
     * @param CategoryDTO $dto Novos dados da categoria
     * @return Category Categoria atualizada com relacionamentos carregados
     * @throws RuntimeException Se a atualização falhar
     */
    public function update(Category $category, CategoryDTO $dto): Category
    {
        $updated = $this->categoryRepository->update($category, $dto->toArray());

        if (!$updated) {
            throw new RuntimeException('Falha ao atualizar a categoria.');
        }

        return $category->fresh('books') ?? $category;
    }
}
