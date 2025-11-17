<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\RentalStatus;
use Carbon\Carbon;

final readonly class RentalDTO
{
    public function __construct(
        public int $usuarioId,
        public int $livroId,
        public Carbon $alugadoEm,
        public Carbon $dataDevolucao,
        public ?Carbon $devolvidoEm = null,
        public float $taxaAtraso = 0.0,
        public RentalStatus $status = RentalStatus::ATIVO,
    ) {
    }

    public function toArray(): array
    {
        return [
            'usuario_id' => $this->usuarioId,
            'livro_id' => $this->livroId,
            'alugado_em' => $this->alugadoEm,
            'data_devolucao' => $this->dataDevolucao,
            'devolvido_em' => $this->devolvidoEm,
            'taxa_atraso' => $this->taxaAtraso,
            'status' => $this->status,
        ];
    }
}
