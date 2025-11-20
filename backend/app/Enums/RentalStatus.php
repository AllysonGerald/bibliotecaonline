<?php

declare(strict_types=1);

namespace App\Enums;

/**
 * Enum que representa os status possíveis de um aluguel no sistema.
 */
enum RentalStatus: string
{
    case ATIVO = 'ativo';
    case ATRASADO = 'atrasado';
    case DEVOLVIDO = 'devolvido';

    /**
     * Retorna a cor associada ao status para exibição na interface.
     *
     * @return string Nome da cor (blue, green, red)
     */
    public function color(): string
    {
        return match ($this) {
            self::ATIVO => 'blue',
            self::DEVOLVIDO => 'green',
            self::ATRASADO => 'red',
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
            self::ATIVO => 'Ativo',
            self::DEVOLVIDO => 'Devolvido',
            self::ATRASADO => 'Atrasado',
        };
    }
}
