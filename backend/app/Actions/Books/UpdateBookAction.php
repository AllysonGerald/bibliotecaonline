<?php

declare(strict_types=1);

namespace App\Actions\Books;

use App\DTOs\BookDTO;
use App\Models\Book;
use App\Services\BookService;

final readonly class UpdateBookAction
{
    public function __construct(
        private BookService $bookService,
    ) {
    }

    public function execute(Book $book, BookDTO $dto): Book
    {
        return $this->bookService->update($book, $dto);
    }
}
