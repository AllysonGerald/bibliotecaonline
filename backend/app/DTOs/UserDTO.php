<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\UserRole;

/**
 * DTO (Data Transfer Object) para transferência de dados de usuário.
 */
final readonly class UserDTO
{
    /**
     * @param string $name Nome do usuário
     * @param string $email Email do usuário
     * @param string|null $password Senha do usuário (será hasheada no Repository)
     * @param UserRole $papel Papel do usuário (admin ou usuario)
     * @param bool $ativo Se o usuário está ativo
     * @param string|null $telefone Telefone do usuário
     */
    public function __construct(
        public string $name,
        public string $email,
        public ?string $password = null,
        public UserRole $papel = UserRole::USUARIO,
        public bool $ativo = true,
        public ?string $telefone = null,
    ) {
    }

    /**
     * Converte o DTO para array associativo.
     *
     * @return array<string, mixed> Dados do usuário em formato array
     */
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
