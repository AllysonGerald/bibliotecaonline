<?php

declare(strict_types=1);

namespace App\Actions\Authors;

use App\Models\Author;
use App\Services\AuthorService;

/**
 * Action responsável por remover um autor do sistema.
 */
final readonly class DeleteAuthorAction
{
    public function __construct(
        private AuthorService $authorService,
    ) {
    }

    /**
     * Executa a remoção de um autor.
     *
     * @param Author $author Autor a ser removido
     * @return bool True se removido com sucesso
     */
    public function execute(Author $author): bool
    {
        return $this->authorService->delete($author);
    }
}
