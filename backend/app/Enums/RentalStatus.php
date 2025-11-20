<?php

declare(strict_types=1);

namespace App\Enums;

enum RentalStatus: string
{
    case ATIVO = 'ativo';
    case ATRASADO = 'atrasado';
    case DEVOLVIDO = 'devolvido';

    public function color(): string
    {
        return match ($this) {
            self::ATIVO => 'blue',
            self::DEVOLVIDO => 'green',
            self::ATRASADO => 'red',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::ATIVO => 'Ativo',
            self::DEVOLVIDO => 'Devolvido',
            self::ATRASADO => 'Atrasado',
        };
    }
}
