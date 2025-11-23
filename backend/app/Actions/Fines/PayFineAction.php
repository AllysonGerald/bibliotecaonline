<?php

declare(strict_types=1);

namespace App\Actions\Fines;

use App\Models\Fine;
use App\Services\FineService;
use RuntimeException;

/**
 * Action responsável por confirmar o pagamento de uma multa (apenas admin).
 */
final readonly class PayFineAction
{
    public function __construct(
        private readonly FineService $fineService,
    ) {
    }

    /**
     * Executa a ação de marcar multa como paga.
     *
     * @param Fine $fine Multa a ser marcada como paga
     * @return Fine Multa atualizada
     * @throws RuntimeException Se a multa não puder ser marcada como paga
     */
    /**
     * Executa a ação de confirmar pagamento da multa (apenas admin).
     *
     * @param Fine $fine Multa a ser confirmada como paga
     * @return Fine Multa atualizada
     * @throws RuntimeException Se a multa não puder ser confirmada como paga
     */
    public function execute(Fine $fine): Fine
    {
        if ($fine->paga) {
            throw new RuntimeException('Esta multa já está marcada como paga.');
        }

        $success = $this->fineService->markAsPaid($fine->id);

        if (!$success) {
            throw new RuntimeException('Falha ao confirmar o pagamento da multa.');
        }

        // Recarregar a multa para ter os dados atualizados
        $fine->refresh();
        $fine->load('rental');

        // Zerar a taxa de atraso do aluguel quando a multa for paga
        if ($fine->rental) {
            $fine->rental->update(['taxa_atraso' => 0]);
        }

        return $fine->fresh(['rental', 'rental.book', 'rental.book.author', 'user']);
    }
}
