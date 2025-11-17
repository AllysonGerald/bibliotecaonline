<?php

declare(strict_types=1);

namespace App\Actions\Authors;

use App\DTOs\AuthorDTO;
use App\Models\Author;
use App\Services\AuthorService;

final readonly class CreateAuthorAction
{
    public function __construct(
        private AuthorService $authorService,
    ) {
    }

    public function execute(AuthorDTO $dto): Author
    {
        return $this->authorService->create($dto);
    }
}
