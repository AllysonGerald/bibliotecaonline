<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\Models\User;
use App\Services\UserService;

final readonly class DeleteUserAction
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    public function execute(User $user): bool
    {
        return $this->userService->delete($user);
    }
}
