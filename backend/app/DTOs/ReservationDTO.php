<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\ReservationStatus;
use Carbon\Carbon;

final readonly class ReservationDTO
{
    public function __construct(
        public int $usuarioId,
        public int $livroId,
        public Carbon $reservadoEm,
        public Carbon $expiraEm,
        public ReservationStatus $status = ReservationStatus::PENDENTE,
    ) {
    }

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
