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

class CategoryController extends Controller
{
    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly CreateCategoryAction $createCategoryAction,
        private readonly UpdateCategoryAction $updateCategoryAction,
        private readonly DeleteCategoryAction $deleteCategoryAction,
    ) {
    }

    public function create(): View
    {
        return view('admin.categorias.create');
    }

    public function destroy(Category $categoria): RedirectResponse
    {
        $this->deleteCategoryAction->execute($categoria);

        return redirect()->route('admin.categorias.index')
            ->with('success', 'Categoria excluída com sucesso!')
        ;
    }

    public function edit(Category $categoria): View
    {
        return view('admin.categorias.edit', compact('categoria'));
    }

    public function index(Request $request): View
    {
        $categories = $this->categoryService->getAllPaginated(
            perPage: 15,
            search: $request->filled('search') ? $request->search : null,
        );

        return view('admin.categorias.index', compact('categories'));
    }

    public function show(Category $categoria): View
    {
        $categoria->load('books');

        return view('admin.categorias.show', compact('categoria'));
    }

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
