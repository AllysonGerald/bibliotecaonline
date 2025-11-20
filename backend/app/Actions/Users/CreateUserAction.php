<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\DTOs\UserDTO;
use App\Models\User;
use App\Services\UserService;

/**
 * Action responsável por criar um novo usuário no sistema.
 */
final readonly class CreateUserAction
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    /**
     * Executa a criação de um novo usuário.
     *
     * @param UserDTO $dto Dados do usuário a ser criado
     * @return User Usuário criado
     */
    public function execute(UserDTO $dto): User
    {
        return $this->userService->create($dto);
    }
}
