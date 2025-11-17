<?php

declare(strict_types=1);

namespace App\Enums;

enum RentalStatus: string
{
    case ATIVO = 'ativo';
    case DEVOLVIDO = 'devolvido';
    case ATRASADO = 'atrasado';

    public function label(): string
    {
        return match ($this) {
            self::ATIVO => 'Ativo',
            self::DEVOLVIDO => 'Devolvido',
            self::ATRASADO => 'Atrasado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ATIVO => 'blue',
            self::DEVOLVIDO => 'green',
            self::ATRASADO => 'red',
        };
    }
}
