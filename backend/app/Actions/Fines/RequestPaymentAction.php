<?php

declare(strict_types=1);

namespace App\Actions\Fines;

use App\Models\Fine;
use App\Services\FineService;
use RuntimeException;

/**
 * Action responsável por solicitar o pagamento de uma multa (usuário solicita, admin confirma).
 */
final readonly class RequestPaymentAction
{
    public function __construct(
        private FineService $fineService,
    ) {
    }

    /**
     * Executa a ação de solicitar pagamento da multa.
     *
     * @param Fine $fine Multa a ter pagamento solicitado
     * @return Fine Multa atualizada
     * @throws RuntimeException Se a multa não puder ter pagamento solicitado
     */
    public function execute(Fine $fine): Fine
    {
        if ($fine->paga) {
            throw new RuntimeException('Esta multa já está marcada como paga.');
        }

        if ($fine->pagamento_solicitado) {
            throw new RuntimeException('O pagamento desta multa já foi solicitado. Aguarde a confirmação do administrador.');
        }

        $success = $this->fineService->requestPayment($fine->id);

        if (!$success) {
            throw new RuntimeException('Falha ao solicitar o pagamento da multa.');
        }

        return $fine->fresh(['rental', 'rental.book', 'rental.book.author', 'user']);
    }
}
