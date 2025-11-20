<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Enum que representa os papéis (roles) de usuário no sistema.
 */
enum UserRole: string
{
    case ADMIN = 'admin';
    case USUARIO = 'usuario';

    /**
     * Verifica se o papel é de administrador.
     *
     * @return bool True se for administrador
     */
    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    /**
     * Retorna o label legível do papel.
     *
     * @return string Label do papel
     */
    public function label(): string
    {
        return match ($this) {
            self::USUARIO => 'Usuário',
            self::ADMIN => 'Administrador',
        };
    }
}
