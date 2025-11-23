<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

/**
 * Controller responsável pelo reset de senha.
 */
class ResetPasswordController extends Controller
{
    public function __construct(
        private readonly AuthService $authService,
    ) {
    }

    /**
     * Reseta a senha do usuário.
     *
     * @param ResetPasswordRequest $request Requisição HTTP validada com dados de reset
     * @return RedirectResponse Redirecionamento com mensagem de status
     */
    public function reset(ResetPasswordRequest $request): RedirectResponse
    {
        $status = $this->authService->resetPassword(
            $request->only('email', 'password', 'password_confirmation', 'token'),
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Exibe o formulário de reset de senha.
     *
     * @param Request $request Requisição HTTP
     * @param string $token Token de reset
     * @return View Formulário de reset
     */
    public function showResetForm(Request $request, string $token): View
    {
        return view('auth.passwords.reset', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }
}
