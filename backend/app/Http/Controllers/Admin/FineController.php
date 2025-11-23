<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Fines\PayFineAction;
use App\Http\Controllers\Controller;
use App\Models\Fine;
use App\Services\FineService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

/**
 * Controller responsável pelo gerenciamento de multas na área administrativa.
 */
class FineController extends Controller
{
    public function __construct(
        private readonly FineService $fineService,
        private readonly PayFineAction $payFineAction,
    ) {
    }

    /**
     * Lista todas as multas com paginação e filtros.
     *
     * @param Request $request Requisição HTTP com parâmetros de filtro
     * @return View Lista de multas
     */
    public function index(Request $request): View
    {
        $fines = $this->fineService->getAllPaginated(
            perPage: 15,
            status: $request->filled('status') ? $request->status : null,
        );

        return view('admin.multas.index', compact('fines'));
    }

    /**
     * Marca uma multa como paga.
     *
     * @param Fine $multa Multa a ser marcada como paga
     * @return RedirectResponse Redirecionamento com mensagem de sucesso
     */
    public function pay(Fine $multa): RedirectResponse
    {
        try {
            $this->payFineAction->execute($multa);

            // Recarregar a multa com o aluguel
            $multa->refresh();
            $multa->load('rental');

            // Redirecionar de volta para a página de origem (show do aluguel ou index de multas)
            $redirectTo = request()->headers->get('referer');
            if ($redirectTo && str_contains($redirectTo, '/admin/alugueis/')) {
                // Extrair o ID do aluguel da URL ou usar o relacionamento
                if ($multa->rental) {
                    return redirect()->route('admin.alugueis.show', $multa->rental)
                        ->with('success', 'Multa marcada como paga com sucesso! A taxa de atraso foi zerada.')
                    ;
                }
            }

            return redirect()->route('admin.multas.index')
                ->with('success', 'Multa marcada como paga com sucesso! A taxa de atraso foi zerada.')
            ;
        } catch (RuntimeException $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
            ;
        }
    }

    /**
     * Lista multas com solicitação de pagamento pendente.
     *
     * @return View Lista de solicitações de pagamento
     */
    public function paymentRequests(): View
    {
        $paymentRequests = $this->fineService->getPaymentRequests();

        return view('admin.multas.payment-requests', compact('paymentRequests'));
    }

    /**
     * Exibe os detalhes de uma multa específica.
     *
     * @param Fine $multa Multa a ser exibida
     * @return View Detalhes da multa
     */
    public function show(Fine $multa): View
    {
        $multa->load(['rental.book.author', 'rental.book.category', 'user']);

        return view('admin.multas.show', compact('multa'));
    }
}
