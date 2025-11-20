<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Services\AuthService;

/**
 * Action responsável por realizar logout de um usuário autenticado.
 */
final readonly class LogoutUserAction
{
    public function __construct(
        private AuthService $authService,
    ) {
    }

    /**
     * Executa o logout do usuário autenticado.
     */
    public function execute(): void
    {
        $this->authService->logout();
    }
}
