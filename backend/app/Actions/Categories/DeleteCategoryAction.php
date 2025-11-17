<?php

declare(strict_types=1);

namespace App\Actions\Categories;

use App\Models\Category;
use App\Services\CategoryService;

final readonly class DeleteCategoryAction
{
    public function __construct(
        private CategoryService $categoryService,
    ) {
    }

    public function execute(Category $category): bool
    {
        return $this->categoryService->delete($category);
    }
}
