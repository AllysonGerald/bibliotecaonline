<?php

declare(strict_types=1);

namespace App\Actions\Books;

use App\Models\Book;
use App\Services\BookService;

/**
 * Action responsável por remover um livro do sistema.
 */
final readonly class DeleteBookAction
{
    public function __construct(
        private BookService $bookService,
    ) {
    }

    /**
     * Executa a remoção de um livro.
     *
     * @param Book $book Livro a ser removido
     * @return bool True se removido com sucesso
     */
    public function execute(Book $book): bool
    {
        return $this->bookService->delete($book);
    }
}
