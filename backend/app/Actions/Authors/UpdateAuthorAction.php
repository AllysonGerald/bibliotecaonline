<?php

declare(strict_types=1);

namespace App\Actions\Authors;

use App\DTOs\AuthorDTO;
use App\Models\Author;
use App\Services\AuthorService;

/**
 * Action responsável por atualizar um autor existente no sistema.
 */
final readonly class UpdateAuthorAction
{
    public function __construct(
        private AuthorService $authorService,
    ) {
    }

    /**
     * Executa a atualização de um autor existente.
     *
     * @param Author $author Autor a ser atualizado
     * @param AuthorDTO $dto Novos dados do autor
     * @return Author Autor atualizado
     */
    public function execute(Author $author, AuthorDTO $dto): Author
    {
        return $this->authorService->update($author, $dto);
    }
}
