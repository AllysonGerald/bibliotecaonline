<?php

declare(strict_types=1);

namespace App\Actions\Books;

use App\DTOs\BookDTO;
use App\Models\Book;
use App\Services\BookService;

/**
 * Action responsável por criar um novo livro no sistema.
 */
final readonly class CreateBookAction
{
    public function __construct(
        private BookService $bookService,
    ) {
    }

    /**
     * Executa a criação de um novo livro.
     *
     * @param BookDTO $dto Dados do livro a ser criado
     * @return Book Livro criado
     */
    public function execute(BookDTO $dto): Book
    {
        return $this->bookService->create($dto);
    }
}
