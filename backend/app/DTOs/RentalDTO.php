<?php

declare(strict_types=1);

namespace App\DTOs;

use App\Enums\RentalStatus;
use Carbon\Carbon;

/**
 * DTO (Data Transfer Object) para transferência de dados de aluguel.
 */
final readonly class RentalDTO
{
    /**
     * @param int $usuarioId ID do usuário que está alugando
     * @param int $livroId ID do livro sendo alugado
     * @param Carbon $alugadoEm Data e hora do aluguel
     * @param Carbon $dataDevolucao Data prevista para devolução
     * @param Carbon|null $devolvidoEm Data e hora da devolução (null se ainda não devolvido)
     * @param float $taxaAtraso Taxa de atraso aplicada
     * @param RentalStatus $status Status do aluguel
     */
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

    /**
     * Converte o DTO para array associativo.
     *
     * @return array<string, mixed> Dados do aluguel em formato array
     */
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
