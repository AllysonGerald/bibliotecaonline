<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Book;
use App\Services\AuthorService;
use App\Services\BookService;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller responsável pela exibição pública de livros.
 */
class BookController extends Controller
{
    public function __construct(
        private readonly BookService $bookService,
        private readonly AuthorService $authorService,
        private readonly CategoryService $categoryService,
    ) {
    }

    /**
     * Lista todos os livros disponíveis com paginação e filtros.
     *
     * @param Request $request Requisição HTTP com parâmetros de busca
     * @return View Lista de livros
     */
    public function index(Request $request): View
    {
        $books = $this->bookService->getAllPaginated(
            perPage: 12,
            search: $request->filled('search') ? $request->search : null,
            categoryId: $request->filled('categoria_id') ? (int) $request->categoria_id : null,
            authorId: $request->filled('autor_id') ? (int) $request->autor_id : null,
        );

        $categories = $this->categoryService->getAllOrdered();
        $authors = $this->authorService->getAllOrdered();

        return view('livros.index', compact('books', 'categories', 'authors'));
    }

    /**
     * Exibe os detalhes de um livro específico.
     *
     * @param Book $livro Livro a ser exibido
     * @return View Detalhes do livro
     */
    public function show(Book $livro): View
    {
        $livro->load(['author', 'category', 'tags', 'reviews.user']);

        $averageRating = $livro->averageRating();
        $reviewsCount = $livro->reviews->count();

        $userReview = null;
        if (auth()->check()) {
            $userReview = $livro->reviews()
                ->where('usuario_id', auth()->id())
                ->first()
            ;
        }

        return view('livros.show', compact('livro', 'averageRating', 'reviewsCount', 'userReview'));
    }
}
