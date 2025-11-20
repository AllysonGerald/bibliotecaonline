<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\DTOs\UserDTO;
use App\Models\User;
use App\Services\UserService;

/**
 * Action responsável por atualizar um usuário existente no sistema.
 */
final readonly class UpdateUserAction
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    /**
     * Executa a atualização de um usuário existente.
     *
     * @param User $user Usuário a ser atualizado
     * @param UserDTO $dto Novos dados do usuário
     * @return User Usuário atualizado
     */
    public function execute(User $user, UserDTO $dto): User
    {
        return $this->userService->update($user, $dto);
    }
}
