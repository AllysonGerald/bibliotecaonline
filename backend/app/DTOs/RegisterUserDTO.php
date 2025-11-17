<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\UserRole;

final readonly class RegisterUserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?string $telefone = null,
        public UserRole $role = UserRole::USUARIO,
        public bool $ativo = true,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'telefone' => $this->telefone,
            'papel' => $this->role,
            'ativo' => $this->ativo,
        ];
    }
}
