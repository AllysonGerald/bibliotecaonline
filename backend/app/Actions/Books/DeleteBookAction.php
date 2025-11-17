<?php

declare(strict_types=1);

namespace App\Actions\Books;

use App\Models\Book;
use App\Services\BookService;

final readonly class DeleteBookAction
{
    public function __construct(
        private BookService $bookService,
    ) {
    }

    public function execute(Book $book): bool
    {
        return $this->bookService->delete($book);
    }
}
