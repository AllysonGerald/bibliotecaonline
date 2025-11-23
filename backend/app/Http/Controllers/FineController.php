<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Fines\RequestPaymentAction;
use App\Models\Fine;
use App\Services\FineService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use RuntimeException;

/**
 * Controller responsável pela exibição de multas do usuário.
 */
class FineController extends Controller
{
    public function __construct(
        private readonly FineService $fineService,
        private readonly RequestPaymentAction $requestPaymentAction,
    ) {
    }

    /**
     * Exibe a lista de multas do usuário autenticado.
     *
     * @param Request $request Requisição HTTP com parâmetros de filtro
     * @return View Lista de multas
     */
    public function index(Request $request): View
    {
        $user = Auth::user();

        if (!$user) {
            abort(401);
        }

        // Buscar multas através do service
        $fines = $this->fineService->getByUser(
            userId: $user->id,
            status: $request->filled('status') ? $request->status : null,
        );

        // Separar em grupos para estatísticas
        $unpaidFines = $this->fineService->getUnpaidByUser($user->id);
        $paidFines = $this->fineService->getPaidByUser($user->id);

        return view('user.multas', compact('fines', 'unpaidFines', 'paidFines'));
    }

    /**
     * Solicita o pagamento de uma multa (usuário solicita, admin confirma).
     *
     * @param Fine $multa Multa a ter pagamento solicitado
     * @return RedirectResponse Redirecionamento com mensagem
     */
    public function pay(Fine $multa): RedirectResponse
    {
        $user = Auth::user();

        if (!$user) {
            abort(401);
        }

        // Verificar se a multa pertence ao usuário
        if ($multa->usuario_id !== $user->id) {
            return redirect()->back()
                ->with('error', 'Você não tem permissão para solicitar o pagamento desta multa.')
            ;
        }

        try {
            $this->requestPaymentAction->execute($multa);

            return redirect()->route('minhas-multas')
                ->with('success', 'Solicitação de pagamento enviada! Aguarde a confirmação do administrador.')
            ;
        } catch (RuntimeException $e) {
            return redirect()->back()
                ->with('error', $e->getMessage())
            ;
        }
    }
}
