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

/**
 * Controller responsável pelo gerenciamento de autores na área administrativa.
 */
class AuthorController extends Controller
{
    public function __construct(
        private readonly AuthorService $authorService,
        private readonly CreateAuthorAction $createAuthorAction,
        private readonly UpdateAuthorAction $updateAuthorAction,
        private readonly DeleteAuthorAction $deleteAuthorAction,
    ) {
    }

    /**
     * Exibe o formulário de criação de autor.
     *
     * @return View Formulário de criação
     */
    public function create(): View
    {
        return view('admin.autores.create');
    }

    /**
     * Remove um autor do sistema.
     *
     * @param Author $autor Autor a ser removido
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function destroy(Author $autor): RedirectResponse
    {
        $this->deleteAuthorAction->execute($autor);

        return redirect()->route('admin.autores.index')
            ->with('success', 'Autor excluído com sucesso!')
        ;
    }

    /**
     * Exibe o formulário de edição de autor.
     *
     * @param Author $autor Autor a ser editado
     * @return View Formulário de edição
     */
    public function edit(Author $autor): View
    {
        return view('admin.autores.edit', compact('autor'));
    }

    /**
     * Lista todos os autores com paginação e filtros.
     *
     * @param Request $request Requisição HTTP com parâmetros de busca
     * @return View Lista de autores
     */
    public function index(Request $request): View
    {
        $authors = $this->authorService->getAllPaginated(
            perPage: 15,
            search: $request->filled('search') ? $request->search : null,
        );

        return view('admin.autores.index', compact('authors'));
    }

    /**
     * Exibe os detalhes de um autor específico.
     *
     * @param Author $autor Autor a ser exibido
     * @return View Detalhes do autor
     */
    public function show(Author $autor): View
    {
        $autor->load('books');

        return view('admin.autores.show', compact('autor'));
    }

    /**
     * Armazena um novo autor no sistema.
     * Suporta requisições AJAX para criação dinâmica de autores.
     *
     * @param StoreAuthorRequest $request Dados validados do autor
     * @return JsonResponse|RedirectResponse Redirecionamento ou resposta JSON
     */
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

    /**
     * Atualiza os dados de um autor existente.
     *
     * @param UpdateAuthorRequest $request Dados validados do autor
     * @param Author $autor Autor a ser atualizado
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
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
