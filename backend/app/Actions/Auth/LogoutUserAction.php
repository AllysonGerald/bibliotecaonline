<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Services\AuthService;

final readonly class LogoutUserAction
{
    public function __construct(
        private AuthService $authService,
    ) {
    }

    public function execute(): void
    {
        $this->authService->logout();
    }
}
