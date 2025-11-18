<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\UserRole;

final readonly class UserDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password = null,
        public UserRole $papel = UserRole::USUARIO,
        public bool $ativo = true,
        public ?string $telefone = null,
    ) {
    }

    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'papel' => $this->papel,
            'ativo' => $this->ativo,
        ];

        if ($this->password !== null) {
            $data['password'] = $this->password; // Será hasheado no Repository
        }

        if ($this->telefone !== null) {
            $data['telefone'] = $this->telefone;
        }

        return $data;
    }
}
