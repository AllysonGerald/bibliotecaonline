<?php

declare(strict_types=1);

namespace App\Enums;

enum ReservationStatus: string
{
    case PENDENTE = 'pendente';
    case CONFIRMADA = 'confirmada';
    case CANCELADA = 'cancelada';
    case EXPIRADA = 'expirada';

    public function label(): string
    {
        return match ($this) {
            self::PENDENTE => 'Pendente',
            self::CONFIRMADA => 'Confirmada',
            self::CANCELADA => 'Cancelada',
            self::EXPIRADA => 'Expirada',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PENDENTE => 'yellow',
            self::CONFIRMADA => 'green',
            self::CANCELADA => 'red',
            self::EXPIRADA => 'gray',
        };
    }
}
