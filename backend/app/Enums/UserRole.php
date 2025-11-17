<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case USUARIO = 'usuario';
    case ADMIN = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::USUARIO => 'Usuário',
            self::ADMIN => 'Administrador',
        };
    }

    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }
}
