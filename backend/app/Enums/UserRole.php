<?php

declare(strict_types=1);

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case USUARIO = 'usuario';

    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    public function label(): string
    {
        return match ($this) {
            self::USUARIO => 'Usuário',
            self::ADMIN => 'Administrador',
        };
    }
}
