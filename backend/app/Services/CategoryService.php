<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\CategoryDTO;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class CategoryService
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function create(CategoryDTO $dto): Category
    {
        return $this->categoryRepository->create($dto->toArray());
    }

    public function delete(Category $category): bool
    {
        return $this->categoryRepository->delete($category);
    }

    public function getAllPaginated(
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

    public function getById(int $id): ?Category
    {
        return $this->categoryRepository->findById($id);
    }

    public function search(string $term): Collection
    {
        return $this->categoryRepository->search($term);
    }

    public function update(Category $category, CategoryDTO $dto): Category
    {
        $updated = $this->categoryRepository->update($category, $dto->toArray());

        if (!$updated) {
            throw new RuntimeException('Falha ao atualizar a categoria.');
        }

        return $category->fresh('books') ?? $category;
    }
}
