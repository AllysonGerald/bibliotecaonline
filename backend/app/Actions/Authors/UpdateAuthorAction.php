<?php

declare(strict_types=1);

namespace App\Actions\Authors;

use App\DTOs\AuthorDTO;
use App\Models\Author;
use App\Services\AuthorService;

final readonly class UpdateAuthorAction
{
    public function __construct(
        private AuthorService $authorService,
    ) {
    }

    public function execute(Author $author, AuthorDTO $dto): Author
    {
        return $this->authorService->update($author, $dto);
    }
}
