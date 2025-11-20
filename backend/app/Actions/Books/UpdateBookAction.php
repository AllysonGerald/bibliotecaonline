<?php

declare(strict_types=1);

namespace App\Actions\Books;

use App\DTOs\BookDTO;
use App\Models\Book;
use App\Services\BookService;

/**
 * Action responsável por atualizar um livro existente no sistema.
 */
final readonly class UpdateBookAction
{
    public function __construct(
        private BookService $bookService,
    ) {
    }

    /**
     * Executa a atualização de um livro existente.
     *
     * @param Book $book Livro a ser atualizado
     * @param BookDTO $dto Novos dados do livro
     * @return Book Livro atualizado
     */
    public function execute(Book $book, BookDTO $dto): Book
    {
        return $this->bookService->update($book, $dto);
    }
}
