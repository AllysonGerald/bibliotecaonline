<?php

declare(strict_types=1);

namespace App\Enums;

enum ReservationStatus: string
{
    case CANCELADA = 'cancelada';
    case CONFIRMADA = 'confirmada';
    case EXPIRADA = 'expirada';
    case PENDENTE = 'pendente';

    public function color(): string
    {
        return match ($this) {
            self::PENDENTE => 'yellow',
            self::CONFIRMADA => 'green',
            self::CANCELADA => 'red',
            self::EXPIRADA => 'gray',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::PENDENTE => 'Pendente',
            self::CONFIRMADA => 'Confirmada',
            self::CANCELADA => 'Cancelada',
            self::EXPIRADA => 'Expirada',
        };
    }
}
