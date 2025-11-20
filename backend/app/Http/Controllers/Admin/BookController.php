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
use App\Models\Book;
use App\Services\AuthorService;
use App\Services\BookService;
use App\Services\CategoryService;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller responsável pelo gerenciamento de livros na área administrativa.
 */
class BookController extends Controller
{
    public function __construct(
        private readonly BookService $bookService,
        private readonly AuthorService $authorService,
        private readonly CategoryService $categoryService,
        private readonly TagService $tagService,
        private readonly CreateBookAction $createBookAction,
        private readonly UpdateBookAction $updateBookAction,
        private readonly DeleteBookAction $deleteBookAction,
    ) {
    }

    /**
     * Exibe o formulário de criação de livro.
     *
     * @return View Formulário de criação
     */
    public function create(): View
    {
        $authors = $this->authorService->getAllOrdered();
        $categories = $this->categoryService->getAllOrdered();
        $tags = $this->tagService->getAllOrdered();

        return view('admin.livros.create', compact('authors', 'categories', 'tags'));
    }

    /**
     * Remove um livro do sistema.
     *
     * @param Book $livro Livro a ser removido
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function destroy(Book $livro): RedirectResponse
    {
        $this->deleteBookAction->execute($livro);

        return redirect()->route('admin.livros.index')
            ->with('success', 'Livro excluído com sucesso!')
        ;
    }

    /**
     * Exibe o formulário de edição de livro.
     *
     * @param Book $livro Livro a ser editado
     * @return View Formulário de edição
     */
    public function edit(Book $livro): View
    {
        $livro->load('tags');
        $authors = $this->authorService->getAllOrdered();
        $categories = $this->categoryService->getAllOrdered();
        $tags = $this->tagService->getAllOrdered();

        return view('admin.livros.edit', compact('livro', 'authors', 'categories', 'tags'));
    }

    /**
     * Lista todos os livros com paginação e filtros.
     *
     * @param Request $request Requisição HTTP com parâmetros de busca
     * @return View Lista de livros
     */
    public function index(Request $request): View
    {
        $books = $this->bookService->getAllPaginated(
            perPage: 15,
            search: $request->filled('search') ? $request->search : null,
            categoryId: $request->filled('categoria_id') ? (int) $request->categoria_id : null,
            authorId: $request->filled('autor_id') ? (int) $request->autor_id : null,
        );

        $categories = $this->categoryService->getAllOrdered();
        $authors = $this->authorService->getAllOrdered();

        return view('admin.livros.index', compact('books', 'categories', 'authors'));
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

        return view('admin.livros.show', compact('livro'));
    }

    /**
     * Armazena um novo livro no sistema.
     *
     * @param StoreBookRequest $request Dados validados do livro
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
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

    /**
     * Atualiza os dados de um livro existente.
     *
     * @param UpdateBookRequest $request Dados validados do livro
     * @param Book $livro Livro a ser atualizado
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
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
