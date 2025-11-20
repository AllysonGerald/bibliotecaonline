<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use App\Services\UserService;

/**
 * Action responsável por remover um usuário do sistema.
 */
final readonly class DeleteUserAction
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    /**
     * Executa a remoção de um usuário.
     *
     * @param User $user Usuário a ser removido
     * @return bool True se removido com sucesso
     */
    public function execute(User $user): bool
    {
        return $this->userService->delete($user);
    }
}
