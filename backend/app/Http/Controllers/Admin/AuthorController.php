<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Authors\CreateAuthorAction;
use App\Actions\Authors\DeleteAuthorAction;
use App\Actions\Authors\UpdateAuthorAction;
use App\DTOs\AuthorDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAuthorRequest;
use App\Http\Requests\Admin\UpdateAuthorRequest;
use App\Models\Author;
use App\Services\AuthorService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function __construct(
        private readonly AuthorService $authorService,
        private readonly CreateAuthorAction $createAuthorAction,
        private readonly UpdateAuthorAction $updateAuthorAction,
        private readonly DeleteAuthorAction $deleteAuthorAction,
    ) {
    }

    public function create(): View
    {
        return view('admin.autores.create');
    }

    public function destroy(Author $autor): RedirectResponse
    {
        $this->deleteAuthorAction->execute($autor);

        return redirect()->route('admin.autores.index')
            ->with('success', 'Autor excluído com sucesso!')
        ;
    }

    public function edit(Author $autor): View
    {
        return view('admin.autores.edit', compact('autor'));
    }

    public function index(Request $request): View
    {
        $authors = $this->authorService->getAllPaginated(
            perPage: 15,
            search: $request->filled('search') ? $request->search : null,
        );

        return view('admin.autores.index', compact('authors'));
    }

    public function show(Author $autor): View
    {
        $autor->load('books');

        return view('admin.autores.show', compact('autor'));
    }

    public function store(StoreAuthorRequest $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        $dto = new AuthorDTO(
            nome: $validated['nome'],
            biografia: $validated['biografia'] ?? null,
            dataNascimento: $validated['data_nascimento'] ?? null,
            foto: $validated['foto'] ?? null,
        );

        $author = $this->createAuthorAction->execute($dto);

        // Se for requisição AJAX, retorna JSON
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Autor criado com sucesso!',
                'author' => [
                    'id' => $author->id,
                    'nome' => $author->nome,
                ],
            ], 201);
        }

        return redirect()->route('admin.autores.index')
            ->with('success', 'Autor criado com sucesso!')
        ;
    }

    public function update(UpdateAuthorRequest $request, Author $autor): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new AuthorDTO(
            nome: $validated['nome'],
            biografia: $validated['biografia'] ?? null,
            dataNascimento: $validated['data_nascimento'] ?? null,
            foto: $validated['foto'] ?? null,
        );

        $this->updateAuthorAction->execute($autor, $dto);

        return redirect()->route('admin.autores.index')
            ->with('success', 'Autor atualizado com sucesso!')
        ;
    }
}
