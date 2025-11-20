<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Services\AuthService;

/**
 * Action responsável por autenticar um usuário no sistema.
 */
final readonly class LoginUserAction
{
    public function __construct(
        private AuthService $authService,
    ) {
    }

    /**
     * Executa a tentativa de login de um usuário.
     *
     * @param string $email Email do usuário
     * @param string $password Senha do usuário
     * @param bool $remember Se deve lembrar do usuário
     * @return bool True se autenticado com sucesso
     */
    public function execute(string $email, string $password, bool $remember = false): bool
    {
        return $this->authService->attemptLogin($email, $password, $remember);
    }
}
