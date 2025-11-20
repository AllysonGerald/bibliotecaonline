<?php

declare(strict_types=1);

namespace App\Actions\Categories;

use App\DTOs\CategoryDTO;
use App\Models\Category;
use App\Services\CategoryService;

/**
 * Action responsável por criar uma nova categoria no sistema.
 */
final readonly class CreateCategoryAction
{
    public function __construct(
        private CategoryService $categoryService,
    ) {
    }

    /**
     * Executa a criação de uma nova categoria.
     *
     * @param CategoryDTO $dto Dados da categoria a ser criada
     * @return Category Categoria criada
     */
    public function execute(CategoryDTO $dto): Category
    {
        return $this->categoryService->create($dto);
    }
}
