<?php

declare(strict_types=1);

namespace App\Actions\Categories;

use App\DTOs\CategoryDTO;
use App\Models\Category;
use App\Services\CategoryService;

/**
 * Action responsável por atualizar uma categoria existente no sistema.
 */
final readonly class UpdateCategoryAction
{
    public function __construct(
        private CategoryService $categoryService,
    ) {
    }

    /**
     * Executa a atualização de uma categoria existente.
     *
     * @param Category $category Categoria a ser atualizada
     * @param CategoryDTO $dto Novos dados da categoria
     * @return Category Categoria atualizada
     */
    public function execute(Category $category, CategoryDTO $dto): Category
    {
        return $this->categoryService->update($category, $dto);
    }
}
