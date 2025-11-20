<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Books\CreateBookAction;
use App\Actions\Books\DeleteBookAction;
use App\Actions\Books\UpdateBookAction;
use App\DTOs\BookDTO;
use App\Enums\BookStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreBookRequest;
use App\Http\Requests\Admin\UpdateBookRequest;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Tag;
use App\Services\BookService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    public function __construct(
        private readonly BookService $bookService,
        private readonly CreateBookAction $createBookAction,
        private readonly UpdateBookAction $updateBookAction,
        private readonly DeleteBookAction $deleteBookAction,
    ) {
    }

    public function create(): View
    {
        $authors = Author::orderBy('nome')->get();
        $categories = Category::orderBy('nome')->get();
        $tags = Tag::orderBy('nome')->get();

        return view('admin.livros.create', compact('authors', 'categories', 'tags'));
    }

    public function destroy(Book $livro): RedirectResponse
    {
        $this->deleteBookAction->execute($livro);

        return redirect()->route('admin.livros.index')
            ->with('success', 'Livro excluído com sucesso!')
        ;
    }

    public function edit(Book $livro): View
    {
        $livro->load('tags');
        $authors = Author::orderBy('nome')->get();
        $categories = Category::orderBy('nome')->get();
        $tags = Tag::orderBy('nome')->get();

        return view('admin.livros.edit', compact('livro', 'authors', 'categories', 'tags'));
    }

    public function index(Request $request): View
    {
        $books = $this->bookService->getAllPaginated(
            perPage: 15,
            search: $request->filled('search') ? $request->search : null,
            categoryId: $request->filled('categoria_id') ? (int) $request->categoria_id : null,
            authorId: $request->filled('autor_id') ? (int) $request->autor_id : null,
        );

        $categories = Category::orderBy('nome')->get();
        $authors = Author::orderBy('nome')->get();

        return view('admin.livros.index', compact('books', 'categories', 'authors'));
    }

    public function show(Book $livro): View
    {
        $livro->load(['author', 'category', 'tags', 'reviews.user']);

        return view('admin.livros.show', compact('livro'));
    }

    public function store(StoreBookRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new BookDTO(
            titulo: $validated['titulo'],
            descricao: $validated['descricao'],
            autorId: isset($validated['autor_id']) ? (int) $validated['autor_id'] : null,
            categoriaId: (int) $validated['categoria_id'],
            isbn: $validated['isbn'],
            editora: $validated['editora'],
            anoPublicacao: (int) $validated['ano_publicacao'],
            paginas: (int) $validated['paginas'],
            preco: (float) $validated['preco'],
            status: BookStatus::from($validated['status']),
            quantidade: (int) $validated['quantidade'],
            imagemCapa: $validated['imagem_capa'] ?? null,
            tags: $request->has('tags') ? $request->tags : null,
        );

        $this->createBookAction->execute($dto);

        return redirect()->route('admin.livros.index')
            ->with('success', 'Livro criado com sucesso!')
        ;
    }

    public function update(UpdateBookRequest $request, Book $livro): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new BookDTO(
            titulo: $validated['titulo'],
            descricao: $validated['descricao'],
            autorId: isset($validated['autor_id']) ? (int) $validated['autor_id'] : null,
            categoriaId: (int) $validated['categoria_id'],
            isbn: $validated['isbn'],
            editora: $validated['editora'],
            anoPublicacao: (int) $validated['ano_publicacao'],
            paginas: (int) $validated['paginas'],
            preco: (float) $validated['preco'],
            status: BookStatus::from($validated['status']),
            quantidade: (int) $validated['quantidade'],
            imagemCapa: $validated['imagem_capa'] ?? null,
            tags: $request->has('tags') ? $request->tags : null,
        );

        $this->updateBookAction->execute($livro, $dto);

        return redirect()->route('admin.livros.index')
            ->with('success', 'Livro atualizado com sucesso!')
        ;
    }
}
