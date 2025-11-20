<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\ReservationStatus;
use Carbon\Carbon;

/**
 * DTO (Data Transfer Object) para transferência de dados de reserva.
 */
final readonly class ReservationDTO
{
    /**
     * @param int $usuarioId ID do usuário que está reservando
     * @param int $livroId ID do livro sendo reservado
     * @param Carbon $reservadoEm Data e hora da reserva
     * @param Carbon $expiraEm Data e hora de expiração da reserva
     * @param ReservationStatus $status Status da reserva
     */
    public function __construct(
        public int $usuarioId,
        public int $livroId,
        public Carbon $reservadoEm,
        public Carbon $expiraEm,
        public ReservationStatus $status = ReservationStatus::PENDENTE,
    ) {
    }

    /**
     * Converte o DTO para array associativo.
     *
     * @return array<string, mixed> Dados da reserva em formato array
     */
    public function toArray(): array
    {
        return [
            'usuario_id' => $this->usuarioId,
            'livro_id' => $this->livroId,
            'reservado_em' => $this->reservadoEm,
            'expira_em' => $this->expiraEm,
            'status' => $this->status,
        ];
    }
}
