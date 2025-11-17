<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\DTOs\RegisterUserDTO;
use App\Models\User;
use App\Services\AuthService;

final readonly class RegisterUserAction
{
    public function __construct(
        private AuthService $authService,
    ) {
    }

    public function execute(RegisterUserDTO $dto): User
    {
        return $this->authService->register($dto);
    }
}
