<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Users\CreateUserAction;
use App\Actions\Users\DeleteUserAction;
use App\Actions\Users\UpdateUserAction;
use App\DTOs\UserDTO;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller responsável pelo gerenciamento de usuários na área administrativa.
 */
class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService,
        private readonly CreateUserAction $createUserAction,
        private readonly UpdateUserAction $updateUserAction,
        private readonly DeleteUserAction $deleteUserAction,
    ) {
    }

    /**
     * Exibe o formulário de criação de usuário.
     *
     * @return View Formulário de criação
     */
    public function create(): View
    {
        $roles = UserRole::cases();

        return view('admin.usuarios.create', compact('roles'));
    }

    /**
     * Remove um usuário do sistema.
     *
     * @param User $usuario Usuário a ser removido
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function destroy(User $usuario): RedirectResponse
    {
        $this->deleteUserAction->execute($usuario);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuário excluído com sucesso!')
        ;
    }

    /**
     * Exibe o formulário de edição de usuário.
     *
     * @param User $usuario Usuário a ser editado
     * @return View Formulário de edição
     */
    public function edit(User $usuario): View
    {
        $roles = UserRole::cases();

        return view('admin.usuarios.edit', compact('usuario', 'roles'));
    }

    /**
     * Lista todos os usuários com paginação e filtros.
     *
     * @param Request $request Requisição HTTP com parâmetros de busca
     * @return View Lista de usuários
     */
    public function index(Request $request): View
    {
        $users = $this->userService->getAllPaginated(
            perPage: 15,
            search: $request->filled('search') ? $request->search : null,
            role: $request->filled('papel') ? $request->papel : null,
            ativo: $request->filled('ativo') ? (bool) $request->ativo : null,
        );

        $roles = UserRole::cases();

        return view('admin.usuarios.index', compact('users', 'roles'));
    }

    /**
     * Exibe os detalhes de um usuário específico.
     *
     * @param User $usuario Usuário a ser exibido
     * @return View Detalhes do usuário
     */
    public function show(User $usuario): View
    {
        $usuario->load(['rentals', 'reservations', 'reviews', 'fines', 'wishlists']);

        return view('admin.usuarios.show', compact('usuario'));
    }

    /**
     * Armazena um novo usuário no sistema.
     *
     * @param StoreUserRequest $request Dados validados do usuário
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new UserDTO(
            name: $validated['name'],
            email: $validated['email'],
            password: $validated['password'],
            papel: UserRole::from($validated['papel']),
            ativo: isset($validated['ativo']) ? (bool) $validated['ativo'] : true,
            telefone: $validated['telefone'] ?? null,
        );

        $this->createUserAction->execute($dto);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuário criado com sucesso!')
        ;
    }

    /**
     * Atualiza os dados de um usuário existente.
     *
     * @param UpdateUserRequest $request Dados validados do usuário
     * @param User $usuario Usuário a ser atualizado
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function update(UpdateUserRequest $request, User $usuario): RedirectResponse
    {
        $validated = $request->validated();

        $dto = new UserDTO(
            name: $validated['name'],
            email: $validated['email'],
            password: $validated['password'] ?? null,
            papel: UserRole::from($validated['papel']),
            ativo: $request->has('ativo') ? (bool) $request->input('ativo') : false,
            telefone: $validated['telefone'] ?? null,
        );

        $this->updateUserAction->execute($usuario, $dto);

        return redirect()->route('admin.usuarios.index')
            ->with('success', 'Usuário atualizado com sucesso!')
        ;
    }
}
