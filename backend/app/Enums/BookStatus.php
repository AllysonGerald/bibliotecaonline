<?php

declare(strict_types=1);

namespace App\Enums;

enum BookStatus: string
{
    case ALUGADO = 'alugado';
    case DISPONIVEL = 'disponivel';
    case RESERVADO = 'reservado';

    public function color(): string
    {
        return match ($this) {
            self::DISPONIVEL => 'green',
            self::RESERVADO => 'yellow',
            self::ALUGADO => 'red',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::DISPONIVEL => 'Disponível',
            self::RESERVADO => 'Reservado',
            self::ALUGADO => 'Alugado',
        };
    }
}
