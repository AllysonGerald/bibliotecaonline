<?php

declare(strict_types=1);

namespace App\Actions\Users;

use App\DTOs\UserDTO;
use App\Models\User;
use App\Services\UserService;

final readonly class UpdateUserAction
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    public function execute(User $user, UserDTO $dto): User
    {
        return $this->userService->update($user, $dto);
    }
}
