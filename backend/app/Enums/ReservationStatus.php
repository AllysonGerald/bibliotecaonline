<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Enum que representa os status possíveis de uma reserva no sistema.
 */
enum ReservationStatus: string
{
    case CANCELADA = 'cancelada';
    case CONFIRMADA = 'confirmada';
    case EXPIRADA = 'expirada';
    case PENDENTE = 'pendente';

    /**
     * Retorna a cor associada ao status para exibição na interface.
     *
     * @return string Nome da cor (yellow, green, red, gray)
     */
    public function color(): string
    {
        return match ($this) {
            self::PENDENTE => 'yellow',
            self::CONFIRMADA => 'green',
            self::CANCELADA => 'red',
            self::EXPIRADA => 'gray',
        };
    }

    /**
     * Retorna o label legível do status.
     *
     * @return string Label do status
     */
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
