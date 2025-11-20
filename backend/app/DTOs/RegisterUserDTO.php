<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\UserRole;

/**
 * DTO (Data Transfer Object) para transferência de dados de registro de usuário.
 */
final readonly class RegisterUserDTO
{
    /**
     * @param string $name Nome do usuário
     * @param string $email Email do usuário
     * @param string $password Senha do usuário (será hasheada no Repository)
     * @param string|null $telefone Telefone do usuário
     * @param UserRole $role Papel do usuário (padrão: USUARIO)
     * @param bool $ativo Se o usuário está ativo (padrão: true)
     */
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?string $telefone = null,
        public UserRole $role = UserRole::USUARIO,
        public bool $ativo = true,
    ) {
    }

    /**
     * Converte o DTO para array associativo.
     *
     * @return array<string, mixed> Dados do usuário em formato array
     */
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
