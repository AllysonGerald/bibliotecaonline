<?php

declare(strict_types=1);

namespace App\Actions\Categories;

use App\DTOs\CategoryDTO;
use App\Models\Category;
use App\Services\CategoryService;

final readonly class CreateCategoryAction
{
    public function __construct(
        private CategoryService $categoryService,
    ) {
    }

    public function execute(CategoryDTO $dto): Category
    {
        return $this->categoryService->create($dto);
    }
}
