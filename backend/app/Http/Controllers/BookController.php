<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Services\BookService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    public function __construct(
        private readonly BookService $bookService,
    ) {
    }

    public function index(Request $request): View
    {
        $books = $this->bookService->getAllPaginated(
            perPage: 12,
            search: $request->filled('search') ? $request->search : null,
            categoryId: $request->filled('categoria_id') ? (int) $request->categoria_id : null,
            authorId: $request->filled('autor_id') ? (int) $request->autor_id : null,
        );

        $categories = Category::orderBy('nome')->get();
        $authors = Author::orderBy('nome')->get();

        return view('livros.index', compact('books', 'categories', 'authors'));
    }

    public function show(Book $livro): View
    {
        $livro->load(['author', 'category', 'tags', 'reviews.user']);

        $averageRating = $livro->averageRating();
        $reviewsCount = $livro->reviews->count();

        return view('livros.show', compact('livro', 'averageRating', 'reviewsCount'));
    }
}

