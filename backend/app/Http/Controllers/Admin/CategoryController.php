<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Categories\CreateCategoryAction;
use App\Actions\Categories\DeleteCategoryAction;
use App\Actions\Categories\UpdateCategoryAction;
use App\DTOs\CategoryDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller responsável pelo gerenciamento de categorias na área administrativa.
 */
class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly CreateCategoryAction $createCategoryAction,
        private readonly UpdateCategoryAction $updateCategoryAction,
        private readonly DeleteCategoryAction $deleteCategoryAction,
    ) {
    }

    /**
     * Exibe o formulário de criação de categoria.
     *
     * @return View Formulário de criação
     */
    public function create(): View
    {
        return view('admin.categorias.create');
    }

    /**
     * Remove uma categoria do sistema.
     *
     * @param Category $categoria Categoria a ser removida
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function destroy(Category $categoria): RedirectResponse
    {
        $this->deleteCategoryAction->execute($categoria);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria excluída com sucesso!')
        ;
    }

    /**
     * Exibe o formulário de edição de categoria.
     *
     * @param Category $categoria Categoria a ser editada
     * @return View Formulário de edição
     */
    public function edit(Category $categoria): View
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    /**
     * Lista todas as categorias com paginação e filtros.
     *
     * @param Request $request Requisição HTTP com parâmetros de busca
     * @return View Lista de categorias
     */
    public function index(Request $request): View
    {
        $categories = $this->categoryService->getAllPaginated(
            perPage: 15,
            search: $request->filled('search') ? $request->search : null,
        );

        return view('admin.categorias.index', compact('categories'));
    }

    /**
     * Exibe os detalhes de uma categoria específica.
     *
     * @param Category $categoria Categoria a ser exibida
     * @return View Detalhes da categoria
     */
    public function show(Category $categoria): View
    {
        $categoria->load('books');

        return view('admin.categorias.show', compact('categoria'));
    }

    /**
     * Armazena uma nova categoria no sistema.
     *
     * @param StoreCategoryRequest $request Dados validados da categoria
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new CategoryDTO(
            nome: $validated['nome'],
            descricao: $validated['descricao'] ?? null,
            icone: $validated['icone'] ?? null,
        );

        $this->createCategoryAction->execute($dto);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria criada com sucesso!')
        ;
    }

    /**
     * Atualiza os dados de uma categoria existente.
     *
     * @param UpdateCategoryRequest $request Dados validados da categoria
     * @param Category $categoria Categoria a ser atualizada
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function update(UpdateCategoryRequest $request, Category $categoria): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new CategoryDTO(
            nome: $validated['nome'],
            descricao: $validated['descricao'] ?? null,
            icone: $validated['icone'] ?? null,
        );

        $this->updateCategoryAction->execute($categoria, $dto);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria atualizada com sucesso!')
        ;
    }
}
