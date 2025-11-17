<?php

declare(strict_types=1);

namespace App\Actions\Authors;

use App\Models\Author;
use App\Services\AuthorService;

final readonly class DeleteAuthorAction
{
    public function __construct(
        private AuthorService $authorService,
    ) {
    }

    public function execute(Author $author): bool
    {
        return $this->authorService->delete($author);
    }
}
