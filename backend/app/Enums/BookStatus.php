<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Enum que representa os status possíveis de um livro no sistema.
 */
enum BookStatus: string
{
    case ALUGADO = 'alugado';
    case DISPONIVEL = 'disponivel';
    case RESERVADO = 'reservado';

    /**
     * Retorna a cor associada ao status para exibição na interface.
     *
     * @return string Nome da cor (green, yellow, red)
     */
    public function color(): string
    {
        return match ($this) {
            self::DISPONIVEL => 'green',
            self::RESERVADO => 'yellow',
            self::ALUGADO => 'red',
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
            self::DISPONIVEL => 'Disponível',
            self::RESERVADO => 'Reservado',
            self::ALUGADO => 'Alugado',
        };
    }
}
