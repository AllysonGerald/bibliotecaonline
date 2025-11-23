<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

/**
 * Controller responsável pelo envio de links de reset de senha.
 */
class ForgotPasswordController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    /**
     * Envia o link de reset de senha.
     *
     * @param ForgotPasswordRequest $request Requisição HTTP validada com email
     * @return RedirectResponse Redirecionamento com mensagem de status
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request): RedirectResponse
    {
        $status = $this->authService->sendPasswordResetLink($request->email);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Exibe o formulário de solicitação de reset de senha.
     *
     * @return View Formulário de solicitação
     */
    public function showLinkRequestForm(): View
    {
        return view('auth.passwords.email');
    }
}
