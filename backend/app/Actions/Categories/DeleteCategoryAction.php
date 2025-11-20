<?php

declare(strict_types=1);

namespace App\Actions\Categories;

use App\Models\Category;
use App\Services\CategoryService;

/**
 * Action responsável por remover uma categoria do sistema.
 */
final readonly class DeleteCategoryAction
{
    public function __construct(
        private CategoryService $categoryService,
    ) {
    }

    /**
     * Executa a remoção de uma categoria.
     *
     * @param Category $category Categoria a ser removida
     * @return bool True se removida com sucesso
     */
    public function execute(Category $category): bool
    {
        return $this->categoryService->delete($category);
    }
}
