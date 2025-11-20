<?php

declare(strict_types=1);

namespace App\Actions\Authors;

use App\DTOs\AuthorDTO;
use App\Models\Author;
use App\Services\AuthorService;

/**
 * Action responsável por criar um novo autor no sistema.
 */
final readonly class CreateAuthorAction
{
    public function __construct(
        private AuthorService $authorService,
    ) {
    }

    /**
     * Executa a criação de um novo autor.
     *
     * @param AuthorDTO $dto Dados do autor a ser criado
     * @return Author Autor criado
     */
    public function execute(AuthorDTO $dto): Author
    {
        return $this->authorService->create($dto);
    }
}
