<?php

declare(strict_types=1);

namespace App\Enums;

enum BookStatus: string
{
    case DISPONIVEL = 'disponivel';
    case RESERVADO = 'reservado';
    case ALUGADO = 'alugado';

    public function label(): string
    {
        return match ($this) {
            self::DISPONIVEL => 'Disponível',
            self::RESERVADO => 'Reservado',
            self::ALUGADO => 'Alugado',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::DISPONIVEL => 'green',
            self::RESERVADO => 'yellow',
            self::ALUGADO => 'red',
        };
    }
}
