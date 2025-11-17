<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Services\AuthService;

final readonly class LoginUserAction
{
    public function __construct(
        private AuthService $authService,
    ) {
    }

    public function execute(string $email, string $password, bool $remember = false): bool
    {
        return $this->authService->attemptLogin($email, $password, $remember);
    }
}
