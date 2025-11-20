<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\DTOs\RegisterUserDTO;
use App\Models\User;
use App\Services\AuthService;

/**
 * Action responsável por registrar um novo usuário no sistema.
 */
final readonly class RegisterUserAction
{
    public function __construct(
        private AuthService $authService,
    ) {
    }

    /**
     * Executa o registro de um novo usuário.
     *
     * @param RegisterUserDTO $dto Dados do usuário a ser registrado
     * @return User Usuário criado
     */
    public function execute(RegisterUserDTO $dto): User
    {
        return $this->authService->register($dto);
    }
}
