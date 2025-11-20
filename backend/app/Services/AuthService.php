<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\RegisterUserDTO;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function attemptLogin(string $email, string $password, bool $remember = false): bool
    {
        return auth()->attempt([
            'email' => $email,
            'password' => $password,
        ], $remember);
    }

    public function logout(): void
    {
        auth()->logout();
    }

    public function register(RegisterUserDTO $dto): User
    {
        $data = $dto->toArray();
        $data['password'] = Hash::make($dto->password);

        return User::create($data);
    }
}
